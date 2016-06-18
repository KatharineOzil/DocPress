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
//                'create_time' => date('Y-m-d H:i:s'),
                'name' => $name
            );
        $this->db->insert('stu_user', $data);
        //return $this->db->insert_id();
        return true;
    }

    function create_teacher($sid, $name, $password)
    {
        if (!isset($name) || !isset($password) || !isset($sid))
            return false;
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        $user = $this->db->get()->result_array();
        //die($user[0]['status']);
        if (($user[0]['status']) == 'done')
            return false;
        $data = array(
                'password' => sha1($password),
//                'create_time' => date('Y-m-d H:i:s'),
                'id' => $sid,
                'status' => 'done'
            );
        $this->db->from('teacher_user');
        $this->db->where('name', $name);
        //$user = $this->db->get()->result();
        $this->db->update('teacher_user', $data);
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
