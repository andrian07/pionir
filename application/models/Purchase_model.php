<?php

class purchase_model extends CI_Model {

    public function product_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_brand.brand_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_tag like "%'.$search.'%"');
        }
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function product_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_brand.brand_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_tag like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

}

?>