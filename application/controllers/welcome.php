<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Homework_model', 'homework', TRUE);
		$this->load->model('User_model', 'user', TRUE);
		$this->load->model('Setting_model', 'setting', TRUE);
	}

	public function index()
	{
		if (!isset($this->session->userdata['id'])) {
			redirect('login');
		}
        $data['works'] = $this->homework->getHomeworks($this->session->userdata['id'], $this->session->userdata['level']);
        $data['email'] = $this->setting->get_mail();
		if ($this->session->userdata['level'] == 'student') {
			$this->load->view('student', $data);
		} else if ($this->session->userdata['level'] == 'teacher') {
			$this->load->view('teacher', $data);
        } else if ($this->session->userdata['level'] == 'admin'){
			$this->load->view('add_list', $data);
		} else {
			$this->load->view('index');
		}
	}

	public function register()
	{
		$data['title'] = '注册';
		$this->load->view('register');
	}

	public function reset()
	{
		$this->load->view('reset');
	}

	public function change_password()
	{
		$this->load->view('change_password');
	}

	public function add_list()
	{
        $data['email'] = $this->setting->get_mail();
		if ($this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}

		$this->load->view('add_list', $data);
	}

	public function edit_list()
	{
		if ($this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}

		$data['list'] = $this->user->edit_list();
        $data['email'] = $this->setting->get_mail();
		$this->load->view('edit_list', $data);
	}

	public function admin()
	{
		if (isset($this->session->userdata['id'])) {
			redirect();
		}
		$data['title'] = '登录';
		$this->load->view('admin', $data);
	}

	public function reset_password()
	{
		if (empty($this->session->userdata['token'])) {
			redirect();
		}
		if ($_GET['token'] === $this->session->userdata['token']) {
			$this->load->view('reset_password');
		}
	}

	public function login()
	{
		//if (isset($this->session->userdata['id'])) {
			//redirect();
		//}
		$data['title'] = '登录';
		$this->load->view('login');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}

	public function ajax_check_homework($id) {
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
        $work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }
		$result = $this->homework->check_homework($work->id);
		echo $result;
	}

	public function check_homework($id)
	{
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }
		$data['work'] = $work;
		$this->load->view('check_homework', $data);
	}

	public function ajax_homework_tree($id) {
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }
		$this->homework->homework_tree($id);
		echo '转换成功';
	}

	public function homework_tree($id)
	{
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }
		$data['work'] = $work;
		$data['result'] = $this->homework->homework_tree($work->id);
		$this->load->view('homework_tree', $data);
	}

	public function new_homework()
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}

		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$hid = $this->input->post('hid');

		if (!empty($title)) {
			$id = $this->homework->create($title, $hid, $content, $this->session->userdata['id']);
			redirect();
        } else {
            $data['hid'] = $this->homework->get_class($this->session->userdata['id']);
			$this->load->view('new', $data);
		}
	}

	public function delete_homework($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}

		$this->homework->delete($id, $this->session->userdata['id']);
		redirect();
	}

	public function submit_homework($id)
	{
		if (!isset($this->session->userdata['id'])) {
			redirect('login');
		}
		$user = $this->user->getStuUser($this->session->userdata['id']);
		$original_name = $_FILES["the_file"]["name"];
		$extension = "." . pathinfo($original_name, PATHINFO_EXTENSION);
		if (!in_array($extension, array(".doc", ".docx", ".pdf"))) {
			die('<meta charset="utf-8"><script>alert("不是符合的文件类型（.doc、.docx、.pdf）");history.go(-1);</script>');
		}
		$homework = $this->homework->get_homework_detail($id);
		if (!$homework) {
			redirect();
        }

        if ($homework->ddl < time() && $homework->ddl != 0) {
			die('<meta charset="utf-8"><script>alert("已经到截止时间，不能提交作业，请联系教师");history.go(-1);</script>');
        }
		$hwid = $homework->hid;
		$hid_list = explode(',' , $hwid);
		foreach ($hid_list as $hid) {
			$this->db->from('stu_list');
			$this->db->where('hid',$hid);
			$this->db->where('sid', $this->session->userdata['id']);
			$result = $this->db->get()->result();
			if(count($result)){
				$stu_hid = $hid;
			}
		}
		$file_name = $stu_hid . "_" . $user->id . "_" . $user->name . $extension;

		if (!is_dir('upload/' . $homework->id)){
			mkdir('upload/' . $homework->id);
		}
		$this->homework->submit($id, $this->session->userdata['id'], $file_name);
		//if($_FILES["file"]["error"] == 0){
			die('<meta charset="utf-8"><script>alert("上交成功");location.href = "' . site_url('/') . '";</script>');
		//}else{
		//	die('<meta charset="utf-8"><script>alert("上交失败，请重新上传");</script>')
		//}
	}

	public function old_homework()
	{
		if (!isset($this->session->userdata['id'])) {
			redirect('login');
		}
		$data['works'] = $this->homework->getHomeworks($this->session->userdata['id'], $this->session->userdata['level'], true);
		if ($this->session->userdata['level'] == 'teacher') {
		    $this->load->view('teacher', $data);
		} else if ($this->session->userdata['level'] == 'student') {
		    $this->load->view('student', $data);
		}
	}

	public function homework_detail($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}
        $data['work'] = $this->homework->getHomework($id);
        if ($data['work']->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }
		$this->load->view('detail', $data);
	}

	public function download($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$this->load->library('zip');
		$work = $this->homework->getHomework($id);
		$homework = $this->homework->get_homework_detail($id);
		foreach ($work->submissions as $key => $value) {
			$this->zip->read_file('upload/' . $homework->id . '/' . $value->file_name );
		}
		$this->zip->download($homework->title . '作业打包.zip');
	}

	public function delete_teacher($name)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'admin') {
			redirect();
		}
		$this->user->delete_teacher($name);
		redirect('/edit_list');
	}

	public function submit_feedback($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}
		$work = $this->homework->get_homework_submitted_detail($id);
		$original_name = $_FILES["the_file"]["name"];
		$extension = "." . pathinfo($original_name, PATHINFO_EXTENSION);
		if (!in_array($extension, array(".doc", ".docx", ".pdf"))) {
			die('<meta charset="utf-8"><script>alert("不是符合的文件类型（.doc、.docx、.pdf）");history.go(-1);</script>');
		}
		$homework = $this->homework->get_homework_detail($work->homework_id);
		if (!$homework) {
			redirect();
		}
		$file_name = $homework->title . "_作业批改反馈" . rand(100000, 999999) . $extension;
		if (!is_dir('reply/' . $work->homework_id))
			mkdir('reply/' . $work->homework_id);
		move_uploaded_file($_FILES["the_file"]["tmp_name"], "reply/" . $work->homework_id . '/' .$file_name);
		$this->homework->reply($id, $file_name);
		redirect('homework_detail/' . $homework->id);
    	}

	public function mark_as($method, $id) {
		$this->homework->mark_as($method, $id);
		echo '修改完成';
	}

	public function visitor()
	{
		$this->load->view('visitor');
	}

	public function down_score($id)
	{
		$this->load->dbutil();
		$this->load->helper('file');
        $this->load->helper('download');

		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
			redirect('login');
        }

		$query = $this->db->query("SELECT user_id as student_id, SUBSTRING_INDEX(`file_name`, '_', 1) as hid, SUBSTRING_INDEX(SUBSTRING_INDEX(`file_name`, '.', '1'), '_', -1) as name, submit_time, score FROM homework_submission WHERE homework_id=$work->id");
		$delimiter = ",";
		$newline = "\r\n";
		$enclosure = '"';
        $csv_data = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
        $download_data = iconv("UTF-8", "GBK", $csv_data);
        force_download("$work->title" . "_score.csv", $download_data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
