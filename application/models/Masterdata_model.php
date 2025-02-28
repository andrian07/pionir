<?php

class masterdata_model extends CI_Model {


    //group
    public function save_role($data_insert)
    {
        $this->db->insert('ms_role', $data_insert);
    }

    public function save_permision($data_insert_permision)
    {
        $this->db->insert('ms_role_permision', $data_insert_permision);
    }
    
    public function group_role()
    {
        $query = $this->db->query("select * from ms_role where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function update_role($data_update, $role_id)
    {
        $this->db->set($data_update);
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function delete_role($role_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function check_role($role_name)
    {
        $query = $this->db->query("select * from ms_role where role_name = '".$role_name."' and is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    //end group
    
    //brand
    public function save_brand($data_insert)
    {
        $this->db->insert('ms_brand', $data_insert);
    }

    public function update_brand($data_update, $brand_id)
    {
        $this->db->set($data_update);
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function delete_brand($brand_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function brand_list()
    {
        $query = $this->db->query("select * from ms_brand where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    //end brand

    //customer
    public function customer_list()
    {
        $query = $this->db->query("select * from ms_customer where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    //end customer



    //customer

    public function save_customer($data_insert)
    {
        $this->db->insert('ms_customer', $data_insert);
    }

    public function save_customer_ekspedisi($insert_exp)
    {
        $this->db->insert('ms_customer_expedisi', $insert_exp);
    }

    public function last_customer_code($customer_code)
    {
        $query = $this->db->query("select customer_code from ms_customer where customer_code like '".$customer_code."%' order by customer_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function ekspedisi_list()
    {
        $query = $this->db->query("select * from ms_ekspedisi where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    //end customer



}

?>