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

    public function search_product_by_supplier($keyword)
    {
        $query = $this->db->query("select * from ms_product a, ms_product_supplier b where a.product_id = b.product_id and (product_name like '%".$keyword."%' or product_code like '%".$keyword."%') and  a.is_active = 'Y' group by a.product_id" );
        $result = $query->result();
        return $result;
    }

    public function update_stock($product_id, $warehouse_id, $new_stock)
    {
        $this->db->set('stock', $new_stock);
        $this->db->where('product_id ', $product_id);
        $this->db->where('warehouse_id ', $warehouse_id);
        $this->db->update('ms_product_stock');
    }

    public function insert_movement_stock($movement_stock)
    {
        $this->db->insert('stock_movement', $movement_stock);
    }

    public function insert_product_stock($insert_product_stock)
    {
        $this->db->insert('ms_product_stock', $insert_product_stock);
    }

}

?>