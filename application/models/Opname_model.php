<?php

class opname_model extends CI_Model {


    public function opname_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_opname');
        $this->db->join('ms_user', 'hd_opname.opname_user = ms_user.user_id');
        if($search != null){
            $this->db->or_where('hd_opname.opname_code like "%'.$search.'%"');
        }
        $this->db->order_by('hd_opname.opname_id', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function opname_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_opname');
        $this->db->join('ms_user', 'hd_opname.opname_user = ms_user.user_id');
        if($search != null){
            $this->db->or_where('hd_opname.opname_code like "%'.$search.'%"');
        }
        $this->db->order_by('hd_opname.opname_id', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function temp_opname_list($search, $length, $start, $user, $warehouse)
    {
        $this->db->select('*');
        $this->db->from('temp_opname');
        $this->db->join('ms_product', 'temp_opname.temp_opname_product_id  = ms_product.product_id');
        $this->db->join('ms_user', 'temp_opname.user_id = ms_user.user_id');
        $this->db->join('ms_product_stock', 'ms_product.product_id  = ms_product_stock.product_id');
        $this->db->where('temp_opname.user_id', $user);
        if($warehouse != null){
            $this->db->where('ms_product_stock.product_id', $warehouse);
        }
        if($search != null){
            $this->db->where('ms_product.user_id like "%'.$search.'%"');
        }
        $this->db->order_by('temp_opname.temp_opname_product_id ', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_opname_list_count($search, $user, $warehouse)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_opname');
        $this->db->join('ms_product', 'temp_opname.temp_opname_product_id  = ms_product.product_id');
        $this->db->join('ms_user', 'temp_opname.user_id = ms_user.user_id');
        $this->db->join('ms_product_stock', 'ms_product.product_id  = ms_product_stock.product_id');
        $this->db->where('temp_opname.user_id', $user);
        if($warehouse != null){
            $this->db->where('ms_product_stock.product_id', $warehouse);
        }
        if($search != null){
            $this->db->where('ms_product.user_id like "%'.$search.'%"');
        }
        $this->db->order_by('temp_opname.temp_opname_product_id ', 'desc');
        $query = $this->db->get();
        return $query;
    }

}

?>