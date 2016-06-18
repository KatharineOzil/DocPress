<?php

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function change_password($level, $sid, $old_password, $new_password)
    {
	if($level == 'student')
	{
	    $this->db->from('stu_user');
	    $this->db->where('id',$sid);
	    $query = $this->db->get()->result();
	    if($query[0]->password != sha1($old_password))
	    {
	         return false;
	    } else {
		$this->db->from('stu_user');
		$this->db->where('id',$sid);
	        $this->db->update('stu_user',array('password'=>sha1($new_password))); 
	        //echo  $this->db->last_query();
		//die();
		return true;
	    }
	}
	
	if($level == 'teacher')
	{
	    $this->db->from('teacher_user');
	    $this->db->where('id',$sid);
	    $query = $this->db->get()->result();
	    if($query[0]->password != sha1($old_password))
	    {
		return false;
	    } else {
	        $this->db->from('teacher_user');
	        $this->db->where('id',$sid);
            $this->db->update('teacher_user',array('password'=>sha1($new_password)));
		return true;
	    }
	}
    }

    function check_student($sid)
    {
        if (empty($sid))
            return false;
        $this->db->from('stu_user');
        $this->db->where('id', $sid);
        $user = $this->db->get()->result();
        if (count($user) > 0)
            return false;
        return true;
    }

    function modify_password($sid, $password)
    {
        if (is_numeric($sid)) {
	        $this->db->from('stu_user');
	        $this->db->where('id', $sid);
	        $this->db->update('stu_user', array('password'=>sha1($password)));
        } else {
	    $this->db->from('teacher_user');
            $this->db->where('id', $sid);
            $this->db->update('teacher_user', array('password'=>sha1($password)));
	};
    }

    function check_teacher_id($name)
    {
        if (empty($name))
            return false;
        $this->db->from('teacher_user');
        $this->db->where('prefix', $name);
        $user = $this->db->get()->result();
        if (count($user) == 0)
            return false;
        return true;
    }

    function check_teacher($name)
    {
        if (empty($name))
            return false;
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        $user = $this->db->get()->result();
        if (count($user) == 0)
            return false;
        return true;
    }

    function create_student($sid, $password, $class, $name)
    {
        if (!isset($sid) || !isset($password))
            return false;
        $data = array(
                'id' => $sid,
                'password' => sha1($password),
                'class' => $class,
                'name' => $name
            );
        $this->db->insert('stu_user', $data);
        return true;
    }

    function create_teacher($tid, $prefix, $name, $password)
    {
        if (!isset($name) || !isset($password) || !isset($tid))
            return false;
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        $user = $this->db->get()->result_array();
        //die($user[0]['status']);
        if (($user[0]['status']) == 'done')
            return false;
        $data = array(
            'password' => sha1($password),
            'id' => $tid,
            'status' => 'done',
            'prefix' => $prefix
        );
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        //$user = $this->db->get()->result();
        $this->db->update('teacher_user', $data);

        $url = 'http://jwzx.cqupt.edu.cn/new/labkebiao/showteakebiao2.php?tid=' . $tid;
        $str = file_get_contents($url);
        $str = str_replace(array("\r\n"), "", $str);
        $str = iconv("GBK", "UTF-8", $str);
        preg_match_all("/(<td >&nbsp;|<\/font><br>)(.*?)<br>.*?<br>.*?<br><font color=#ff0000>.*?<\/font>\s+<BR>.*?<br>.*?<br><a href='showStuList\.php\?jxb=((SK|A|SJ|R)\d{5,12})/", $str, $data);

        if (!$data) {
            $result = array();
        } else {
            foreach($data[2] as $_ => $value) {
                $value = str_replace(array("<td >", "&nbsp;", "</td>", "<tr>", "</tr>", "<td class='title'>"), "", $value);
                $value = preg_replace("/^.*?节/", "", $value);
                $data[2][$_] = $value;
            }
            $result = array_map(null, $data[3], $data[2]);
            $result = array_map("unserialize", array_unique(array_map("serialize", $result)));
        }
        foreach($result as $_ => $value) {
            $data = array(
                'hid' => $value[0],
                'tid' => $tid,
                'title' => $value[1]
            );

            $this->db->insert('tid_hid', $data);
        }

        return true;
    }

    function login_student($sid, $password)
    {
        if (!$sid || !$password) {
            return false;
        }
        $this->db->from('stu_user');
        $this->db->where('id', $sid);
        $this->db->where('password', sha1($password));
        $user = $this->db->get()->result();
        //echo $this->db->last_query();
        //die();
        if (count($user) <= 0)
            return false;
        return $user[0];
    }

    function login_teacher($name, $password)
    {  
        if (!$name || !$password) {
            return false;
        }
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        $this->db->where('password', sha1($password));
	$user = $this->db->get()->result();
        //echo $this->db->last_query();
        if (count($user) <= 0)
            return false;
        return $user[0];
    }

    function login_admin($id, $password)
    {
        if (!isset($id) || !isset($password))
            return false;
        $this->db->from('admin_user');
        $this->db->where('id', $id);
        $this->db->where('password', sha1($password));
        $user = $this->db->get()->result();
        if (count($user) <= 0)
            return false;
        return $user[0];
    }

    function getStuUser($id)
    {
        $this->db->from('stu_user');
        $this->db->where('id', $id);
        $user = $this->db->get()->result();
        if (count($user))
            return $user[0];
    }

    function delete_teacher($name)
    {
        if (empty($name))
            return;
	    $name = urldecode($name);
        $this->db->where('name', $name);
        $this->db->delete('teacher_user');
        //echo $this->db->last_query();
    }

    function edit_list()
    {
        $this->db->from('teacher_user');
        $list = $this->db->get()->result();
        return $list;
    }

}
