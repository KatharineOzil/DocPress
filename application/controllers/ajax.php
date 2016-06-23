<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('User_model', 'user', TRUE);
		$this->load->model('Homework_model', 'homework', TRUE);
		$this->load->model('Setting_model', 'setting', TRUE);

	}

	public function index()
	{
		redirect();
	}

	public function change_password()
	{
		$old_password = $this->input->post('old_password');
		$password = $this->input->post('new_password');
		$con_password = $this->input->post('confirm');
		if($password != $con_password){
			echo "两次输入的密码不同，请检查后重新输入";
		} else {
			if($this->user->change_password($this->session->userdata['level'], $this->session->userdata['id'], $old_password, $password)){
				echo "密码修改成功，请重新登录";
			} else {
				echo "旧密码输入错误，请检查后重新输入";
			}
		}
	}

	public function reset_password()
	{
		$password1 = $this->input->post('password');
		$password2 = $this->input->post('password_confirm');
		//print_r($this->session->userdata);
		if($password1 != $password2){
			echo "两次输入的密码不同，请检查后重新输入";
		}else{
			if (isset($this->session->userdata['sid']) && isset($this->session->userdata['token']) && $this->session->userdata['token'] === $this->input->post('token')) {
				$this->user->modify_password($this->session->userdata['sid'], $password1);
				//$this->session->userdata['token'] = '123';
				echo '密码重置成功！';
			} else {
				die('token 过期或不正确，请重新获取。');
			}
		}
	}

	public function reset()
	{
		$sid = $this->input->post('sid');
		if (!$sid) {
			die('请输入信息');
		}
		if (preg_match('/^\d{10}$/', $sid)){
			$ret = $this->user->check_student($sid);
		} else {
			$ret = $this->user->check_teacher_id($sid);
		}
		if ($ret) {
			die('用户不存在！');
		}
		$token = md5(md5(rand()) . rand());
		$this->session->set_userdata('token', $token);
		$this->session->set_userdata('sid', $sid);
		$mail_body = "点击如下 URL 重置密码：" . site_url("welcome/reset_password?token=" . $token);
        	$this->load->library('mailer');

        $email = $this->setting->get_mail();
        $this->mailer->mail->Host = $email['smtp'];
        $this->mailer->mail->Username = $email['email'];
        $this->mailer->mail->Password = $email['password'];
        $this->mailer->mail->SetFrom($email['email'], 'DocPress 找回密码');

		if (preg_match('/^\d{10}$/', $sid)){
			$this->mailer->sendmail(
				"$sid@stu.cqupt.edu.cn",
				"$sid",
				'作业提交系统重置密码',
				$mail_body
		);
			echo('找回密码相关邮件发送成功，请登录 stu.cqupt.edu.cn 查看');
		}
        else{
			$this->mailer->sendmail(
				"$sid@cqupt.edu.cn",
				"$sid",
				'作业提交系统重置密码',
				$mail_body
			);
			echo('找回密码相关邮件发送成功，请登录 mail.cqupt.edu.cn 查看');
		}

		die();
	}

	public function register()
	{
		$sid = $this->input->post('username');
		$password = $this->input->post('password');
		$password2 = $this->input->post('password2');
		if ($password !== $password2) {
			die("两次输入的密码不同");
		}
		$class = $this->input->post('class');
		$name = $this->input->post('name');
		$level = $this->input->post('level');
		if ($level === 'student') {
			if (strlen($sid) != 10 || strlen($class) < 7) {
				die("请输入正确的信息！");
			}
		}
		if ($level == 'student') {
			if ($this->user->check_student($sid)) {
				$user_id = $this->user->create_student($sid, $password, $class, $name);
				if ($user_id) {
					//$this->session->set_userdata('id', $user_id);
					$this->session->set_userdata('id', $sid);
					$this->session->set_userdata('name', $name);
					$this->session->set_userdata('level', $level);
					echo 'success';
				} else {
					echo '注册失败';
				}
			} else {
				echo '学号已被注册';
			}
        } else if ($level == 'teacher') {
            if ($this->user->check_teacher_nid($name)) {
				$user_id = $this->user->create_teacher($sid, $class, $name, $password);
				if ($user_id) {
					$this->session->set_userdata('id', $sid);
					$this->session->set_userdata('name', $name);
					$this->session->set_userdata('level', $level);
					$this->session->set_userdata('prefix', $class);
					echo 'success';
				} else {
					echo '该用户已被注册';
				}
			} else {
				echo '该用户未被授权，请联系管理员';
			}
		}
	}

	public function login()
	{
		$password = $this->input->post('password');
        $username = $this->input->post('username');
        if (!preg_match('/^\d+$/', $username)) {
            die('用户名或密码错误');
        }
		$level = $this->input->post('level');
		if ($level == 'student') {
			$user = $this->user->login_student($username, $password);
			if ($user) {
				//$this->session->set_userdata('id', $user->id);
				$this->session->set_userdata('id', $user->id);
				$this->session->set_userdata('name', $user->name);
				$this->session->set_userdata('level', $level);
				$this->session->set_userdata('class', $user->class);
				echo 'success';
			} else {
				echo '用户名或密码错误';
			}
		} else if ($level == 'teacher') {
			$user = $this->user->login_teacher($username, $password);
			if ($user) {
				$this->session->set_userdata('id', $user->id);
				$this->session->set_userdata('name', $user->name);
				$this->session->set_userdata('level', $level);
				echo 'success';
			} else {
				echo '用户名或密码错误';
			}
		}
	}

	public function admin()
	{
		$id = $this->input->post('id');
		$password = $this->input->post('password');
		if (isset($id) && isset($password)){
			$user = $this->user->login_admin($id, $password);
			$level = 'admin';
			//print_r($user);
			//die();
			if($user) {
				$this->session->set_userdata('id',$user->id);
				$this->session->set_userdata('password',$user->password);
				$this->session->set_userdata('level', $level);
				echo 'success';
				//print_r($this->session->userdata);
				//die();
			} else {
				echo '账户或密码错误';
			}
		}
	}

	public function teacher_list()
	{
		if ($this->session->userdata['level'] != 'admin') {
			redirect('admin');
		}

		$teacher_list = $this->input->post('user_list');

		if($teacher_list) {
			$this->session->set_userdata('teacher_list', $teacher_list);
			//echo '成功添加'.$this->session->userdata['teacher_list'];
			$user_list = explode(' ', $teacher_list);
			foreach ($user_list as $value) {
				$passwd = md5(md5(rand()) . rand());
				$id = rand();
				$list = array(
						'name' => $value,
						'password' => $passwd,
						//'create_time' => date('Y-m-d H:i:s'),
						'id' => $id
					);
				$this->db->insert('teacher_user', $list);
			}
			echo '成功添加' . $teacher_list;
		} else {
			$this->load->view('add');
		}
	}

    public function save_score($id)
    {
        if ($this->session->userdata['level'] != 'teacher') {
            redirect();
        }
        $work = $this->homework->get_homework_detail($id);
        if ($work->creator_id != $this->session->userdata['id']) {
            redirect();
        }
        $score = $this->input->post('score');
        foreach ($score as $k => $v){
            $data = array(
                'score' => $v
            );
            $limit = array(
                'homework_id' => $id,
                'user_id' => $k
            );
            $this->db->from('homework_submission');
            $this->db->where($limit);
            $this->db->update('homework_submission', $data);
        }
        echo '成绩评定成功';
    }

    public function set_email()
    {
        $smtp = $this->input->post('smtp');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->setting->set_mail($smtp, $email, $password);
        echo '修改成功';
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
