<?php

class global_model extends CI_Model {

    public function save($data_insert_act)
    {
        $this->db->insert('activity_table', $data_insert_act);
    }

    public function check_access($user_role_id)
    {
        $query = $this->db->query("select * from ms_role_permision where role_id = '".$user_role_id."'");
        $result = $query->result();
        return $result;
    }

}

?>