<?php

class global_model extends CI_Model {

    public function save($data_insert_act)
    {
        $this->db->insert('activity_table', $data_insert_act);
    }

    public function check_access($user_role_id, $modul){
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$user_role_id."' and module_name = '".$modul."';");
        $result = $query->result();
        return $result;
    }

    public function search_product($keyword)
    {
        $query = $this->db->query("select * from ms_product where (product_name like '%".$keyword."%' or product_code like '%".$keyword."%') and is_active = 'Y'" );
        $result = $query->result();
        return $result;
    }

    public function search_product_by_supplier($keyword, $supplier_id)
    {
        $query = $this->db->query("select * from ms_product a, ms_product_supplier b where a.product_id = b.product_id and (product_name like '%".$keyword."%' or product_code like '%".$keyword."%') and  a.is_active = 'Y' and b.supplier_id = '".$supplier_id."'" );
        $result = $query->result();
        return $result;
    }

}

?>