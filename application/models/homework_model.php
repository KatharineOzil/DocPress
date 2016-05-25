<?php

class Homework_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function create($title, $hwid, $content, $creator_id, $attachment)
	{
		$homework_type = $this->input->post('type');
		$hid_list = explode('/' , $hwid);
		$responses = array();

		// fetch student lists from jwzx and check
		foreach ($hid_list as $hid) {
			if (!preg_match('/(SJ|A|SK)\d{5,12}/', $hid, $type)) {
				die('<meta charset="utf-8"><script>alert("教学班号不正确");history.back(-1);</script>');
			}
			$sjk_url = "http://jwzx.cqupt.edu.cn/new/labkebiao/showjxbStuList.php?jxb=$hid";
			$llk_url = "http://jwzx.cqupt.edu.cn/showJxbStuList.php?jxb=$hid";
			$url = $type[1] == 'A' ? $llk_url : $sjk_url;
			$str = file_get_contents($url);
			//die($str);
			//die(preg_match('/没有找到该教学班的选课学生名单/', $str));

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
		$data1 = array(
			'title' => $title,
			'hid' => $hwid,
			'content' => $content,
			'create_time' => date('Y-m-d H:i:s'),
			'creator_id' => $creator_id,
			'attachment' => $attachment,
			'type' => $homework_type
			);
		$this->db->insert('homework', $data1);
	}

	function getHomeworks($user_id = 0, $level='student')
	{
		if ($level === 'student') {
			$hid = array();
			//$this->db->select('sid');
			//$this->db->from('stu_user');
			//$this->db->where('id', $user_id);
			//$sid = $this->db->get()->result();
			//$sid = $sid[0]->sid;

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
		//print_r($hid);
		$this->db->select('homework.id as id, homework.title as title, homework.content as content, homework.hid as hid, homework.create_time as create_time, homework.attachment as attachment, teacher_user.name as name, homework.type as type');
		$this->db->from('homework');
		$this->db->order_by('homework.id desc');
		$this->db->join('teacher_user', 'teacher_user.id = homework.creator_id');
		//$this->db->join('homeworkTohid', '')
		if ($level === 'student') {
			foreach ($hid as $h) {
				$this->db->like('homework.hid', $h);
			}
		} else if ($level === 'teacher') {
			$this->db->where('homework.creator_id', $user_id);
		}
		$works = $this->db->get()->result();
		//print_r($works);
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
					$work->submit_time = $query->time;
					$work->feedback_file = $query->feedback_file;
				}
			}
			$this->db->from('homework_submission');
			$this->db->where('homework_id', $work->id);
			$query = $this->db->get()->result();
			$work->count = count($query);

			$hid_list = explode('/' , $work->hid);
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
		$this->db->where('id', $id);
		$work = $this->db->get()->result();
		if (count($work)) {
			$work = $work[0];
			$this->db->from('homework_submission');
			$this->db->where('homework_id', $id);
			$submissions = $this->db->get()->result();
			$submissions_users = array();

			$this->load->model('User_model', 'user', TRUE);
			foreach ($submissions as $key => $value) {
				$value->user = $this->user->getStuUser($value->user_id);
				if (!isset($value->user)) {
					return array();
				}
				//print_r($value);
				array_push($submissions_users, $value->user->id);
			}
			$work->submissions = $submissions;

			$hid_list = explode('/', $work->hid);
			$this->db->select('id, sid, name');
			$this->db->from('stu_list');
			$this->db->where_in('hid', $hid_list);
	
			if ($submissions_users) {
				$this->db->where_not_in('id', $submissions_users);
			}
			$work->not_submissions = $this->db->get()->result();

			return $work;
		}
		return false;
	}

	function get_homework_detail($id)
	{
		$this->db->from('homework');
		$this->db->where('id', $id);
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
		//$title = $this->db->get()->result();
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

		$this->db->where('hid', $hid);
		$this->db->delete('stu_list');

		//$this->db->where('title', $title);
		//$this->db->delete('homeworkTohid');
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
		$data = array(
				'homework_id' => $homework_id,
				'user_id' => $user_id,
				'file_name' => $file_name,
				'time' => date('Y-m-d H:i:s')
			     );
		$this->db->from('homework_submission');
		$this->db->where('homework_id', $homework_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get()->result();
		if (count($query)) {
			$query = $query[0];
			$this->db->where('id', $query->id);
			$this->db->update('homework_submission', $data);
		} else {
			$this->db->insert('homework_submission', $data);
		}
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
}
