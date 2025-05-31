<?php

class sales_model extends CI_Model {


    public function get_rate($product_id)
    {
        $query = $this->db->query("select product_sell_price_1 as Umum, product_sell_price_2 as Toko, product_sell_price_3 as Sales, product_sell_price_4 as Khusus from ms_product where product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_rate($customer_id)
    {
        $query = $this->db->query("select customer_rate from ms_customer where customer_id = '".$customer_id."'");
        $result = $query->result();
        return $result;
    }
    // sales order

    public function add_temp_so($data_insert)
    {
        $this->db->insert('temp_sales_order', $data_insert);
    }


    public function save_sales_order($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_sales_order', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_detail_sales_order($data_insert_detail)
    {
        $this->db->insert('dt_sales_order', $data_insert_detail);
    }

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
        $this->db->select('sum(temp_so_total) as sub_total, temp_so_id');
        $this->db->from('temp_sales_order');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function last_so_inv()
    {
        $query = $this->db->query("select hd_sales_order_inv from hd_sales_order  order by hd_sales_order_id   desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales_order($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_sales_order($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales_order');
    }

    public function header_sales_order($hd_sales_order_id)
    {
        $query = $this->db->query("select * from hd_sales_order a, ms_warehouse b, ms_customer c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_sales_order_warehouse = b.warehouse_id and a.hd_sales_order_customer = c.customer_id and a.hd_sales_order_payment = f.payment_id and a.created_by = d.user_id and a.hd_sales_order_ekspedisi = e.ekspedisi_id and hd_sales_order_id = '".$hd_sales_order_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_sales_order($hd_sales_order_id)
    {
        $query = $this->db->query("select * from dt_sales_order a, hd_sales_order b, ms_product c, ms_unit d, ms_user e where a.hd_sales_order_id  = b.hd_sales_order_id  and a.dt_so_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_sales_order_id  = '".$hd_sales_order_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_sales_order($hd_sales_order_id )
    {
        $this->db->set('hd_sales_order_status', 'Cancel');
        $this->db->where('hd_sales_order_id  ', $hd_sales_order_id );
        $this->db->update('hd_sales_order');
    }

    public function check_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product_stock where product_id = '".$product_id."' and '".$warehouse_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_temp_so($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales_order');
    }

    //end sales order



    // start sales

    public function sales_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales.hd_sales_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $this->db->order_by('hd_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function sales_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales.hd_sales_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
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

    public function temp_sales_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_sales_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_sales_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_sales($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_sales');
    }   

    public function add_temp_sales($data_insert)
    {
        $this->db->insert('temp_sales', $data_insert);
    }

    public function check_edit_temp_sales($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_sales($user_id)
    {
        $this->db->select('sum(temp_sales_total) as sub_total');
        $this->db->from('temp_sales');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function search_so($keyword)
    {
        $this->db->select('*');
        $this->db->from('hd_sales_order');
        $this->db->where('hd_sales_order_status', 'Pending');
        if($keyword != null){
            $this->db->where('hd_sales_order.hd_sales_order_inv like "%'.$keyword.'%"');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_sales($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }

    public function get_dt_so($so_id)
    {
        $query = $this->db->query("select * from dt_sales_order where hd_sales_order_id = '".$so_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_hd_so($so_id)
    {
        $query = $this->db->query("select * from hd_sales_order a, ms_warehouse b, ms_customer c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_sales_order_warehouse = b.warehouse_id and a.hd_sales_order_customer = c.customer_id and a.hd_sales_order_payment = f.payment_id and a.created_by = d.user_id and a.hd_sales_order_ekspedisi = e.ekspedisi_id and hd_sales_order_id = '".$so_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales_so_id($user_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_sales_inv()
    {
        $query = $this->db->query("select hd_sales_order_inv from hd_sales_order order by hd_sales_order_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_sales($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_sales', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function get_temp_sales($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function save_detail_sales($data_insert_detail)
    {
        $this->db->insert('dt_sales', $data_insert_detail);
    }

    public function delete_temp_sales($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }
    // end sales
}   

?>