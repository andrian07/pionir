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
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->where('ms_product.is_active', 'y');
        if($keyword != null){
            $this->db->where('ms_product.product_name like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$keyword.'%"');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_purchase_inv($keyword, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->where('hd_purchase.hd_purchase_supplier', $supplier_id);
        if($keyword != null){
            $this->db->where('hd_purchase.hd_purchase_invoice like "%'.$keyword.'%"');
        }
        $this->db->group_by('hd_purchase_invoice');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_sales_inv($keyword, $customer_id)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales.hd_sales_customer', $customer_id);
        if($keyword != null){
            $this->db->where('hd_sales.hd_sales_inv like "%'.$keyword.'%"');
        }
        $this->db->group_by('hd_sales_inv');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_sales_inv_ref($keyword)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        if($keyword != null){
            $this->db->where('hd_sales.hd_sales_inv like "%'.$keyword.'%"');
        }
        $this->db->group_by('hd_sales_inv');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_product_by_supplier($keyword)
    {
        $query = $this->db->query("select * from ms_product a, ms_product_supplier b, ms_unit c  where a.product_id = b.product_id and a.product_unit = b.unit_id and(product_name like '%".$keyword."%' or product_code like '%".$keyword."%') and  a.is_active = 'Y' group by a.product_id" );
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

    public function insert_master_stock($insert_master_stock)
    {
        $this->db->insert('ms_product_stock', $insert_master_stock);
    }

}

?>