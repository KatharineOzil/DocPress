<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Homework_model', 'homework', TRUE);
		$this->load->model('User_model', 'user', TRUE);
	}

	public function index()
	{
		if (!isset($this->session->userdata['id'])) {
			redirect('login');
		}
		$data['works'] = $this->homework->getHomeworks($this->session->userdata['id'], $this->session->userdata['level']);
		if ($this->session->userdata['level'] == 'student') {
			$this->load->view('student', $data);
		} else if ($this->session->userdata['level'] == 'teacher') {
			$this->load->view('teacher', $data);
		} else if ($this->session->userdata['level'] == 'admin'){
			$this->load->view('add');
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

	public function add_list()
	{
		if ($this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}

		$this->load->view('add_list');
	}

	public function edit_list()
	{
		if ($this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}

		$data['list'] = $this->user->edit_list();
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

	public function check_homework($id)
	{
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
		$data['work'] = $work;
		$data['result'] = $this->homework->check_homework($work->title);
		$this->load->view('check_homework', $data);
	}

	public function homework_tree($id)
	{
		if ($this->session->userdata['level'] != 'teacher') {
			redirect();
		}
		$work = $this->homework->get_homework_detail($id);
		$data['work'] = $work;
		$data['result'] = $this->homework->homework_tree($work->title);
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
//			$original_name = $_FILES["the_file"]["name"];
//			$extension = "." . pathinfo($original_name, PATHINFO_EXTENSION);
//			if (!in_array($extension, array(".doc", ".docx", ".pdf", ".zip"))) {
//				die('<script>alert("不是符合的文件类型（.doc、.docx、.pdf、.zip）");history.go(-1);</script>');
//			}
//			$file_name = $title . "_" . rand(100000, 999999) . $extension;
//			move_uploaded_file($_FILES["the_file"]["tmp_name"], "attachment/" .$file_name);
			$this->homework->create($title, $hid, $content, $this->session->userdata['id']);
			redirect();
		} else {
			$this->load->view('new');
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
		$hwid = $homework->hid;
		$hid_list = explode(',' , $hwid);		
		foreach ($hid_list as $hid) {
			$this->db->from('stu_list');
			$this->db->where('hid',$hid);
			$result = $this->db->get()->result();
			if(count($result)){
				$stu_hid = $hid;
			}
		}
		$file_name = $stu_hid . "_" . $user->id . "_" . $user->name . $extension;

		if (!is_dir('upload/' . $homework->title)){
			mkdir('upload/' . $homework->title);
		}
		move_uploaded_file($_FILES["the_file"]["tmp_name"], "upload/" . $homework->title .  '/' . $file_name);
		$this->homework->submit($id, $this->session->userdata['id'], $file_name);
		redirect();
	}

	public function homework_detail($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}

		$data['work'] = $this->homework->getHomework($id);
		$this->load->view('detail', $data);
	}

	public function download($id)
	{
		$this->load->library('zip');
		$work = $this->homework->getHomework($id);
		$homework = $this->homework->get_homework_detail($id);
		foreach ($work->submissions as $key => $value) {
			$this->zip->read_file('upload/' . $homework->title . '/' . $value->file_name);
		}
		$this->zip->download($homework->title . '作业打包.zip');
	}

	public function delete_teacher($name)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}
		$this->user->delete_teacher($name);
		redirect();
	}

	public function submit_feedback($id)
	{
		if (!isset($this->session->userdata['level']) || $this->session->userdata['level'] != 'teacher') {
			redirect('login');
		}
		$work = $this->homework->get_homework_submitted_detail($id);
		$original_name = $_FILES["the_file"]["name"];
		$extension = "." . pathinfo($original_name, PATHINFO_EXTENSION);
		if (!in_array($extension, array(".doc", ".docx", ".pdf", ".zip"))) {
			die('<meta charset="utf-8"><script>alert("不是符合的文件类型（.doc、.docx、.pdf、.zip）");history.go(-1);</script>');
		}
		$homework = $this->homework->get_homework_detail($work->homework_id);
		if (!$homework) {
			redirect();
		}
		$file_name = $homework->title . "_作业批改反馈" . rand(100000, 999999) . $extension;
		if (!is_dir('reply/' . $id))
			mkdir('reply/' . $id);
		move_uploaded_file($_FILES["the_file"]["tmp_name"], "reply/" . $id . '/' .$file_name);
		$this->homework->reply($id, $file_name);
		redirect('homework_detail/' . $homework->id);
	}

	public function visitor()
	{
		$this->load->view('visitor');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
