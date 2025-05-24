<?php

class sales_model extends CI_Model {

    public function add_temp_so($data_insert)
    {
        $this->db->insert('temp_sales_order', $data_insert);
    }

    public function get_rate($product_id)
    {
        $query = $this->db->query("select product_sell_price_1 as Umum, product_sell_price_2 as Toko, product_sell_price_3 as Sales, product_sell_price_4 as Khusus from ms_product where product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_rate($product_id)
    {
        $query = $this->db->query("select * from ");
        $result = $query->result();
        return $result;
    }
    // sales order

    public function sales_order_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_sales_order');
        $this->db->join('dt_sales_order', 'hd_sales_order.hd_sales_order_id = dt_sales_order.hd_sales_order_id');
        $this->db->join('ms_customer', 'hd_sales_order.hd_sales_order_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales_order.dt_so_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales_order.hd_sales_order_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales_order.hd_sales_order_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales_order.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $this->db->order_by('hd_sales_order.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function sales_order_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_sales_order');
        $this->db->join('dt_sales_order', 'hd_sales_order.hd_sales_order_id = dt_sales_order.hd_sales_order_id');
        $this->db->join('ms_customer', 'hd_sales_order.hd_sales_order_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales_order.dt_so_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales_order.hd_sales_order_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales_order.hd_sales_order_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales_order.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }


    public function temp_salesorder_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales_order.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_salesorder_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales_order.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_so_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_sales_order where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_so($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_sales_order');
    }   

    public function check_edit_temp_so($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

     public function check_temp_so($user_id)
    {
        $this->db->select('sum(temp_so_total) as sub_total');
        $this->db->from('temp_sales_order');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }


    //end sales order

}

?>