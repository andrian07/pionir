<?php

class transferstock_model extends CI_Model {


    public function transferstock_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_transfer_stock');
        $this->db->join('dt_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id = dt_transfer_stock.hd_transfer_stock_id');
        $this->db->join('ms_product', 'dt_transfer_stock.dt_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_warehouse AS from', 'dt_transfer_stock.dt_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'dt_transfer_stock.dt_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'hd_transfer_stock.user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_transfer_stock.hd_transfer_stock_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $this->db->order_by('hd_transfer_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function transferstock_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_transfer_stock');
        $this->db->join('dt_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id = dt_transfer_stock.hd_transfer_stock_id');
        $this->db->join('ms_product', 'dt_transfer_stock.dt_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_warehouse AS from', 'dt_transfer_stock.dt_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'dt_transfer_stock.dt_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'hd_transfer_stock.user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_transfer_stock.hd_transfer_stock_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_transfer_stock($user_id)
    {
        $this->db->select('sum(temp_transfer_stock_qty) as total');
        $this->db->from('temp_transfer_stock');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function temp_transfer_stock_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_transfer_stock');
        $this->db->join('ms_product', 'temp_transfer_stock.temp_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse AS from', 'temp_transfer_stock.temp_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'temp_transfer_stock.temp_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'temp_transfer_stock.user_id = ms_user.user_id');
        $this->db->where('temp_transfer_stock.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_transfer_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_transfer_stock_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_transfer_stock');
        $this->db->join('ms_product', 'temp_transfer_stock.temp_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse AS from', 'temp_transfer_stock.temp_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'temp_transfer_stock.temp_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'temp_transfer_stock.user_id = ms_user.user_id');
        $this->db->where('temp_transfer_stock.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_transfer_stock.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_transfer_stock_input($product_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_transfer_stock');
        $this->db->where('user_id', $user_id);
        $this->db->where('temp_transfer_stock_product_id', $product_id);
        $query = $this->db->get();
        return $query;
    }

    public function add_temp_transfer_stock($data_insert)
    {
        $this->db->insert('temp_transfer_stock', $data_insert);
    }

    public function edit_temp_transfer_stock($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_transfer_stock_product_id ', $product_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('temp_transfer_stock');
    }
}   

?>