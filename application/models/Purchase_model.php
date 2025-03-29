<?php

class purchase_model extends CI_Model {


    // submission
    public function insert_submission($data_insert)
    {
        $this->db->insert('submission', $data_insert);
    }

    public function last_submission_inv()
    {
        $query = $this->db->query("select submission_invoice from submission  order by submission_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function submission_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'submission.submission_salesman = ms_salesman.salesman_id');
        $this->db->join('ms_user', 'submission.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('submission.submission_invoice like "%'.$search.'%"');
            $this->db->or_where('submission.submission_desc like "%'.$search.'%"');
        }
        $this->db->order_by('submission.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function submission_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'submission.submission_salesman = ms_salesman.salesman_id');
        $this->db->join('ms_user', 'submission.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('submission.submission_invoice like "%'.$search.'%"');
            $this->db->or_where('submission.submission_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function submission_by_id($id)
    {
        $query = $this->db->query("select * from submission a, ms_product b, ms_salesman c, ms_warehouse d, ms_user e where a.submission_product_id = b.product_id and a.submission_salesman = c.salesman_id and a.created_by = e.user_id and a.submission_warehouse = d.warehouse_id and submission_id  = '".$id."' ");
        $result = $query->result();
        return $result;
    }

    public function edit_submission($data_edit, $submission_id)
    {
        $this->db->set($data_edit);
        $this->db->where('submission_id ', $submission_id);
        $this->db->update('submission');
    }

    public function delete_submission($submission_id)
    {
        $this->db->set('submission_status', 'Cancel');
        $this->db->where('submission_id ', $submission_id);
        $this->db->update('submission');
    }

    public function get_current_stock($submission_product_id)
    {
        $query = $this->db->query("select sum(stock) as total_last_stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and a.product_id = '".$submission_product_id."'");
        $result = $query->result();
        return $result;
    }
    // end submission

    // start po


    public function po_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_po.hd_po_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('hd_po.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function po_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_po.hd_po_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function search_submission($search)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id  = ms_product.product_id');
        if($search != null){
            $this->db->where('submission_invoice like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_name like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function insert_temp_po($data_insert)
    {
        $this->db->insert('temp_po', $data_insert);
    }

    public function temp_po_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id ');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_po.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_po_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id ');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_po.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }
    // end po

}

?>