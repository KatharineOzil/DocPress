<?php

class Homework_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function create($title, $hwid, $content, $creator_id)
	{
		//$homework_type = $this->input->post('type');
		$hid_list = explode('/' , $hwid);
		$responses = array();

		$this->db->from('homework');
		$this->db->where('title',$title);
		$query = $this->db->get()->result();
		if($query[0]->creator_id == $this->session->userdata['id'])
		{
			die('<meta charset="utf-8"><script>alert("您已布置过相同名称的作业，请检查作业名后重新布置");history.back(-1);</script>');
		}

		// fetch student lists from jwzx and check
		foreach ($hid_list as $hid) {
			if (!preg_match('/^(SJ|A|SK|R)\d{5,12}$/', $hid, $type)) {
				die('<meta charset="utf-8"><script>alert("教学班号不正确");history.back(-1);</script>');
			}
			$sjk_url = "http://jwzx.cqupt.edu.cn/new/labkebiao/showjxbStuList.php?jxb=$hid";
			$llk_url = "http://jwzx.cqupt.edu.cn/showJxbStuList.php?jxb=$hid";
			$url = $type[1] == 'A' ? $llk_url : $sjk_url;
			$str = file_get_contents($url);

			if(!preg_match('/(20[\d]{8})<\/td>\s*?<td\s*?>(.*?)<\/td>/', $str)){
				die('<meta charset="utf-8"><script>alert("教学班没有选课学生，请检查教学班号！");history.back(-1);</script>');
			} else {
				$responses[$hid] = $str;
			}
		}

		// save student lists to database
		foreach($hid_list as $hid) {
			$str = $responses[$hid];
			$this->db->where('hid', $hid);
			if(!$this->db->count_all_results('stu_list')){
				preg_match_all('/(20[\d]{8})<\/td>\s*?<td\s*?>(.*?)<\/td>/', $str, $data);
				$result = array_map(null, $data[1], $data[2]);

				foreach ($result as $key => $value) {
					$value[1] = iconv("GBK", "UTF-8", $value[1]);
					$list = array(
							'hid' => $hid,
							'sid' => $value[0],
							'name' => $value[1]
						    );
					$this->db->insert('stu_list', $list);
				}
			}
		}

		// create homework row
		if (!empty($_FILES["the_file"]["tmp_name"]))
		{
			$original_name = $_FILES["the_file"]["name"];
			$extension = "." . pathinfo($original_name, PATHINFO_EXTENSION);
			if (!in_array($extension, array(".doc", ".docx", ".pdf"))) {
				die('<meta charset="utf-8"><script>alert("不是符合的文件类型（.doc、.docx、.pdf）");history.go(-1);</script>');
			}
			$rand_num = rand(100000, 999999);
			$file_name = "$title-$rand_num$extension";
			move_uploaded_file($_FILES["the_file"]["tmp_name"], "attachment/" .$file_name);
		} else {
			$file_name = NULL;
		}

        $ddl = $this->input->post('ddl');
        if (!$ddl) {
            $ddl = 0;
        }
		if (!preg_match('/^20[\d]{2}-[\d]{2}-[\d]{2}$/', $ddl) && $ddl != 0)
		{
			die('<meta charset="utf-8"><script>alert("请检查截止日期格式");history.go(-1);</script>');
		}
		$ddl = strtotime($ddl);
		$data = array(
			'title' => $title,
			'content' => $content,
			'creator_id' => $creator_id,
			'attachment' => $file_name,
			'create_time' => date('Y-m-d H:i:s'),
			'ddl' => $ddl
		);

		$this->db->insert('homework', $data);
		$insert_id = $this->db->insert_id();
		foreach($hid_list as $hid) {
			$data = array(
				'homework_id' => $insert_id,
				'hid' => $hid
			);
			$this->db->insert('homework_hid', $data);
		}
		return $insert_id;
	}

	function getHomeworks($user_id = 0, $level='student', $old=false)
	{
		if ($level === 'student') {
			$hid = array();
			$this->db->select('hid');
			$this->db->from('stu_list');
			$this->db->where('sid', $user_id);
			$result = $this->db->get()->result();
			foreach($result as $k => $v) {
				array_push($hid, $v->hid);
			}
			if (empty($hid)) {
				return array();
			}
		}
        $this->db->select('H.id as id, H.title as title, H.create_time as create_time ,H.attachment as attachment, H.content as content, group_concat(homework_hid.hid) as hid, H.ddl as ddl, teacher_user.name as name');
		$this->db->from('homework as H');
		$this->db->order_by('H.id desc');
		$this->db->join('teacher_user', 'teacher_user.id = H.creator_id');
		$this->db->join('homework_hid', 'homework_hid.homework_id = H.id');
		$this->db->group_by('H.id');
		if ($level === 'student') {
			foreach ($hid as $h) {
				$this->db->or_where('homework_hid.hid', $h);
			}
		} else if ($level === 'teacher') {
			$this->db->where('H.creator_id', $user_id);
		}
        $works = $this->db->get()->result();

        function ddl_filter_new($var) {
            return $var->ddl > time() || $var->ddl == 0;
        }

        function ddl_filter_old($var) {
            return $var->ddl < time() && $var->ddl != 0;
        }

        $works = $old ? array_filter($works, "ddl_filter_old") : array_filter($works, "ddl_filter_new");

		foreach ($works as $key => $work) {
			$work->done = false;
			if ($level === 'student') {
				$this->db->from('homework_submission');
				$this->db->where('homework_id', $work->id);
				$this->db->where('user_id', $user_id);
				$query = $this->db->get()->result();
				if (count($query)) {
					$query = $query[0];
					$work->done = true;
					$work->feedback_file = $query->feedback_file;
				}
			}
			$this->db->from('homework_submission');
			$this->db->where('homework_id', $work->id);
			$query = $this->db->get()->result();
			$work->count = count($query);

			$hid_list = explode(',' , $work->hid);
			$this->db->from('stu_list');
			$this->db->where_in('hid', $hid_list);
			$query = $this->db->get()->result();
			$work->total_count = count($query);
		}
		return $works;
	}

	function getHomework($id)
	{
		$this->db->from('homework');
		$this->db->select('homework.*, group_concat(homework_hid.hid) as hid');
		$this->db->join('homework_hid', 'homework_hid.homework_id = homework.id');
		$this->db->where('homework.id', $id);
		$work = $this->db->get()->result();
		if (count($work)) {
			$work = $work[0];
			$this->db->from('homework_submission');
			$this->db->where('homework_id', $id);
			$submissions = $this->db->get()->result();
			$submissions_users = array();
			$this->load->model('User_model', 'user', TRUE);
			foreach ($submissions as $key => $value) {
				$user = $this->user->getStuUser($value->user_id);
				if (!$user) {
					continue;
				}
				$value->user = $user;
				array_push($submissions_users, $value->user->id);
			}
			$work->submissions = $submissions;
			$hid_list = explode(',', $work->hid);
			$this->db->select('id, sid, name');
			$this->db->from('stu_list');
			$this->db->where_in('hid', $hid_list);

			if ($submissions_users) {
				$this->db->where_not_in('sid', $submissions_users);
			}
			$work->not_submissions = $this->db->get()->result();
			return $work;
		}
		return false;
	}

	function get_homework_detail($id)
	{
		$this->db->from('homework');
		$this->db->select('homework.*, group_concat(homework_hid.hid) as hid');
		$this->db->join('homework_hid', 'homework_hid.homework_id = homework.id');
		$this->db->where('homework.id', $id);
		$work = $this->db->get()->result();
		if ($work) {
			$work = $work[0];
		} else {
			return false;
		}
		return $work;
	}

	function delete($id, $uid)
	{
		if (empty($id))
			return;

		$this->db->where('id', $id);
		$this->db->where('creator_id', $uid);
		$this->db->from('homework');
		$r = $this->db->get()->result();
		foreach($r as $k => $v){
			$hid = $v->hid;
			$title = $v->title;
		}
		foreach ($title as $key => $value) {
			$title = $value->title;
		}
		$this->db->where('id', $id);
		$this->db->where('creator_id', $uid);
		$this->db->delete('homework');
	
//		$this->db->where('hid', $hid);
//		$this->db->delete('stu_list');
		$this->db->where('homework_id', $id);
		$this->db->delete('homework_submission');

		$this->db->where('homework_id',$id);
		$this->db->delete('homework_hid');
	}

	function get_homework_submitted_detail($id) {
		$this->db->from('homework_submission');
		$this->db->where('id', $id);
		$query = $this->db->get()->result();
		if ($query) {
			$query = $query[0];
		} else {
			return false;
		}
		return $query;
	}

	function submit($homework_id, $user_id, $file_name)
	{
		//$file_name = iconv("GBK", "UTF-8", $file_name);
		$this->db->from('homework');
		$this->db->where('id', $homework_id);
		$homework = $this->db->get()->result();
		if (!count($homework)) {
		    die('作业不存在');
		}
		$data = array(
				'homework_id' => $homework_id,
				'user_id' => $user_id,
				'file_name' => $file_name,
				'submit_time' => date('Y-m-d H:i:s')
			     );
		$this->db->from('homework_submission');
		$this->db->where('homework_id', $homework_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get()->result();
		if (count($query)) {
			$query = $query[0];
			@unlink('upload/' . $homework[0]->id . '/' . $query->file_name);
			$this->db->where('id', $query->id);
			$this->db->update('homework_submission', $data);
		} else {
			$this->db->insert('homework_submission', $data);
		}
		move_uploaded_file($_FILES["the_file"]["tmp_name"], "upload/" . $homework[0]->id .  '/' . $file_name);
	}

	function reply($id, $file_name)
	{
		$data = array(
			'feedback_file'=>$file_name
		);
		$this->db->from('homework_submission');
		$this->db->where('id', $id);
		$this->db->update('homework_submission', $data);
	}

	function check_homework($homework_id)
	{
		$value = $this->input->get('range');
		$value = intval($value);
		$homework_id = escapeshellarg($homework_id);
		$file = $homework_id;
		$handle = popen("/usr/bin/python compare.py '$file' '$value' 2>&1 ", "r");
		$data = '';
		while ($temp = fread($handle, 1024)) {
			$data .= $temp;
		}
		pclose($handle);
		return $data;
	}

	function homework_tree($homework_id)
	{
		$file = 'upload/'.$homework_id.'/infile';
		$homework_id = intval($homework_id);
		$file_all=$homework_id;
		$stuNum = exec("head -n 1 'upload/$file_all/$file_all.txt'");
		exec("./dist2matrix.pl 'upload/$file_all/$file_all.txt' '$stuNum' 2>&1 >$file");
		exec("./plagiarism_check.sh '$file_all'");
        }

        function get_class($id) {
    	    $this->db->from('tid_hid');
	    $this->db->select("hid, title");
	    $this->db->where('tid', $id);
	    return $this->db->get()->result();
    }

    function mark_as($method, $id) {
        if ($method == "new") {
            $this->db->where('id', $id);
            $this->db->update('homework', array('ddl' => 0));
        } else if ($method == "old") {
            $this->db->where('id', $id);
            $this->db->update('homework', array('ddl' => time()));
        }
    }
}
