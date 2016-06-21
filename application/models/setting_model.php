<?php

class Setting_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_mail()
    {
        $this->db->select('value');
        $this->db->from('settings');
        $this->db->where('key', 'email');
        $data = $this->db->get()->result();
        if (!count($data)) {
            return array('smtp'=>'', 'email'=>'', 'password'=>'');
        } else {
            return unserialize($data[0]->value);
        }
    }

    function set_mail($smtp, $email, $password)
    {
        $data = array('smtp'=>$smtp, 'email'=>$email, 'password'=>$password);
        $data = serialize($data);

        $this->db->select('value');
        $this->db->from('settings');
        $this->db->where('key', 'email');
        $email = $this->db->get()->result();
        if (count($email)) {
            $this->db->where('key', 'email');
            $this->db->update('settings', array('key'=>'email',  'value'=>$data));
        } else {
            $this->db->insert('settings', array('key'=>'email',  'value'=>$data));
        }
    }
}
