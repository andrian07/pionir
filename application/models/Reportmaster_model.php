<?php

class Reportmaster_model extends CI_Model {

    public function brand_list()
    {
        $this->db->select('*');
        $this->db->from('ms_brand');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function customer_list()
    {
        $this->db->select('*');
        $this->db->from('ms_customer');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function ekspedisi_list()
    {
        $this->db->select('*');
        $this->db->from('ms_ekspedisi');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function warehouse_list()
    {
        $this->db->select('*');
        $this->db->from('ms_warehouse');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function category_list()
    {
        $this->db->select('*');
        $this->db->from('ms_category');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_report_product($brand_report, $category_report, $Supplier_report)
    {
        $this->db->select('*');
        $this->db->from('ms_category');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

}

?>