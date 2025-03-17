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
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('submission.submission_invoice like "%'.$search.'%"');
            $this->db->or_where('submission.submission_desc like "%'.$search.'%"');
        }
        $this->db->order_by('created_at', 'desc');
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
    // end submission

}

?>