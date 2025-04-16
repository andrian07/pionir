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


    public function save_po($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_po', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function po_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier','"'.$supplier_filter_val.'"');
        }
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

    public function po_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier','"'.$supplier_filter_val.'"');
        }
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

    public function header_po($po_id)
    {
        $query = $this->db->query("select * from hd_po a, ms_warehouse b, ms_supplier c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_po_warehouse = b.warehouse_id and a.hd_po_supplier = c.supplier_id and a.hd_po_payment = f.payment_id and a.created_by = d.user_id and a.hd_po_ekspedisi = e.ekspedisi_id and hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_po($po_id)
    {
        $query = $this->db->query("select * from dt_po a, hd_po b, ms_product c, ms_unit d, ms_user e where a.hd_po_id = b.hd_po_id and a.dt_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function search_submission($search)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id  = ms_product.product_id');
        $this->db->where('submission_status','Pending');
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

    public function save_detail_po($data_insert_detail)
    {
        $this->db->insert('dt_po', $data_insert_detail);
    }

    public function update_submission($submission_id_val)
    {
        $this->db->set('submission_status', 'Success');
        $this->db->where('submission_id  ', $submission_id_val);
        $this->db->update('submission');
    }

    public function edit_temp_po($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_po');
    }

    public function get_temp_po($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    
    public function temp_po_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
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

    public function delete_temp_po($temp_po_id)
    {
        $this->db->where('temp_po_id', $temp_po_id);
        $this->db->delete('temp_po');
    }

    public function check_temp_po($user_id)
    {
        $this->db->select('supplier_code, sum(temp_po_total) as sub_total, sum(temp_po_total_ongkir) as ongkir, submission_supplier, is_ppn');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->join('ms_supplier', 'submission.submission_supplier = ms_supplier.supplier_id', 'left');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }


    public function check_edit_temp_po($temp_po_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->where('temp_po_id', $temp_po_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_po_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_po where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_po()
    {
        $query = $this->db->query("select hd_po_invoice from hd_po  order by hd_po_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function clear_temp_po($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_po');
    }

    public function delete_po($po_id)
    {
        $this->db->set('hd_po_status', 'Cancel');
        $this->db->where('hd_po_id  ', $po_id);
        $this->db->update('hd_po');
    }
    // end po

    // start warehouse input 

    public function search_po($search)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->where('hd_po_status','Pending');
        if($search != null){
            $this->db->where('hd_po_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function temp_input_stock_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_input_stock.temp_is_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_input_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_input_stock_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_input_stock.temp_is_user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_input_stock.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function copy_temp_po($data_copy_temp_po)
    {
        $this->db->insert('temp_input_stock', $data_copy_temp_po);
    }

    public function clear_temp_input_stock($user_id)
    {
        $this->db->where('temp_is_user_id', $user_id);
        $this->db->delete('temp_input_stock');
    }

    public function check_temp_input_stock($user_id)
    {
        $this->db->select('temp_is_supplier, sum(temp_is_qty) as total_item, temp_is_warehouse, temp_is_po_code, temp_is_po_id');
        $this->db->from('temp_input_stock');
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_temp_input_stock($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_edit_temp_input_stock($product_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->where('temp_is_product_id', $product_id);
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_input_stock($product_id, $user_id)
    {
        $this->db->where('temp_is_product_id', $product_id);
        $this->db->where('temp_is_user_id', $user_id);
        $this->db->delete('temp_input_stock');
    }

    public function edit_temp_input_stock($product_id, $user_id, $data_edit)
    {
        $this->db->set($data_edit);
        $this->db->where('temp_is_product_id ', $product_id);
        $this->db->where('temp_is_user_id ', $user_id);
        $this->db->update('temp_input_stock');
    }

    public function last_save_input()
    {
        $query = $this->db->query("select hd_input_stock_inv from hd_input_stock order by hd_input_stock_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_input_stock($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_input_stock', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function insert_detail_input_stock($data_insert)
    {
        $this->db->insert('dt_input_stock', $data_insert);
    }

    public function get_last_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and b.warehouse_id = '".$warehouse_id."'");
        $result = $query->result();
        return $result;
    }

    public function warehouseinput_list($search, $length, $start, $start_date_val, $end_date_val, $warehouse_filter_val)
    {
        $this->db->select('*');
        $this->db->from('hd_input_stock');
        $this->db->join('dt_input_stock', 'hd_input_stock.hd_input_stock_id   = dt_input_stock.hd_is_id ');
        $this->db->join('ms_warehouse', 'hd_input_stock.hd_input_stock_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_input_stock.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_input_stock_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($warehouse_filter_val != null){
            $this->db->where('hd_input_stock_warehouse','"'.$warehouse_filter_val.'"');
        }
        if($search != null){
            $this->db->or_where('hd_input_stock.hd_input_stock_inv like "%'.$search.'%"');
        }
        $this->db->order_by('hd_input_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function warehouseinput_list_count($search, $start_date_val, $end_date_val, $warehouse_filter_val)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_input_stock');
        $this->db->join('dt_input_stock', 'hd_input_stock.hd_input_stock_id   = dt_input_stock.hd_is_id ');
        $this->db->join('ms_warehouse', 'hd_input_stock.hd_input_stock_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_input_stock.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_input_stock_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($warehouse_filter_val != null){
            $this->db->where('hd_input_stock_warehouse','"'.$warehouse_filter_val.'"');
        }
        if($search != null){
            $this->db->or_where('hd_input_stock.hd_input_stock_inv like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }
    // end warehouse input 

}

?>