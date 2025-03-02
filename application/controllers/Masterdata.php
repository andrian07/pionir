<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Masterdata extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		if(isset($_SESSION['user_name']) != null){
			redirect('Dashboard/Admin', 'refresh');
		}else{
			$this->load->view('Pages/login');
		}
	}


	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Masterdata', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
		/*$access =  $this->uri->segment(2);
		$permissions = $access.'_'.$permission;
		print_r($permissions);die();*/
		
	}


	// brand //
	public function brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$brand_list['brand_list'] = $this->masterdata_model->brand_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $brand_list);
			$this->load->view('Pages/Masterdata/brand', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function save_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$brand_name = $this->input->post('brand_name');
			$brand_desc = $this->input->post('brand_desc');
			$user_id 	= $_SESSION['user_id'];
			if($brand_name == null){
				$msg = "Nama Brand Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'brand_name'	       => $brand_name,
				'brand_desc'	       => $brand_desc,
			);
			$this->masterdata_model->save_brand($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Brand Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function delete_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$brand_id  	= $this->input->post('id');
			$user_id 	= $_SESSION['user_id'];
			$this->masterdata_model->delete_brand($brand_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Brand',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function edit_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$brand_id   	   = $this->input->post('brand_id');
			$brand_name   	   = $this->input->post('brand_name_edit');
			$brand_desc        = $this->input->post('brand_desc_edit');
			$user_id 		   = $_SESSION['user_id'];

			if($brand_name == null){
				$msg = "Nama Brand Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$update = array(
				'brand_name'	       => $brand_name,
				'brand_desc'	       => $brand_desc,
			);

			$this->masterdata_model->update_brand($update, $brand_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Brand',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Update";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	/*public function brand_server()
	{
		$draw['draw'] = 1;
		$recordsTotal['recordsTotal'] = 2;
		$recordsFiltered['recordsFiltered'] = 2;
		$data['data'] = $this->masterdata_model->brand_list();
		$data = array_merge($draw, $recordsTotal, $recordsFiltered, $data);
		echo json_encode($data);
	}*/	

	// end brand //

	// customer //

	public function save_customer()
	{	
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$customer_name 				= $this->input->post('customer_name');
			$customer_dob 				= $this->input->post('customer_dob');
			$customer_gender	 		= $this->input->post('customer_gender');
			$customer_address 			= $this->input->post('customer_address');
			$customer_address_blok 		= $this->input->post('customer_address_blok');
			$customer_address_no 		= $this->input->post('customer_address_no');
			$customer_address_rt 		= $this->input->post('customer_address_rt');
			$customer_address_rw 		= $this->input->post('customer_address_rw');
			$customer_address_phone 	= $this->input->post('customer_address_phone');
			$customer_address_email 	= $this->input->post('customer_address_email');
			$customer_send_address 		= $this->input->post('customer_send_address');
			$customer_expedisi 			= $this->input->post('customer_expedisi');
			$customer_npwp 				= $this->input->post('customer_npwp');
			$customer_nik 				= $this->input->post('customer_nik');
			$customer_rate 				= $this->input->post('customer_rate');
			$customer_expedisi_text     = $this->input->post('customer_expedisi_text');
			$user_id 		   			= $_SESSION['user_id'];

			if($customer_name == null){
				$msg = "Nama Customer Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($customer_address_phone == null){
				$msg = "No Hp Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$customer_code = strtoupper(substr($customer_name, 0, 3));
			$maxCode = $this->masterdata_model->last_customer_code($customer_code);
			if ($maxCode == NULL) {
				$last_code = $customer_code.'001';
			} else {
				$maxCode = $maxCode[0]->customer_code;
				$last_code = substr($maxCode, -3);
				$last_code = $customer_code.substr('000' . strval(floatval($last_code) + 1), -3);
			}

			$data_insert = array(
				'customer_code'	       	=> $last_code,
				'customer_name'	       	=> $customer_name,
				'customer_dob'	       	=> $customer_dob,
				'customer_gender'	    => $customer_gender,
				'customer_address'	    => $customer_address,
				'customer_address_blok'	=> $customer_address_blok,
				'customer_address_no'	=> $customer_address_no,
				'customer_rt'	       	=> $customer_address_rt,
				'customer_rw'	       	=> $customer_address_rw,
				'customer_phone'	   	=> $customer_address_phone,
				'customer_email'	    => $customer_address_email,
				'customer_send_address'	=> $customer_send_address,
				'customer_npwp'	       	=> $customer_npwp,
				'customer_nik'	       	=> $customer_nik,
				'customer_rate'	       	=> $customer_rate,
				'customer_expedisi_tag' => $customer_expedisi_text

			);
			$this->masterdata_model->save_customer($data_insert);

			foreach($customer_expedisi as $row){
				$insert_exp = array(
					'customer_code'	       	=> $last_code,
					'expedisi_id'	       	=> $row,
				);
				$this->masterdata_model->save_customer_ekspedisi($insert_exp);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Customer',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);

			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function customer(){
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $ekspedisi_list, $check_auth);
			$this->load->view('Pages/Masterdata/customer', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function detailcustomer(){
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id = $this->input->get('id');
			$get_customer_by_id['get_customer_by_id'] = $this->masterdata_model->get_customer_by_id($id);
			$this->load->view('Pages/Masterdata/customer_detail', $get_customer_by_id);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}


	public function get_customer_id(){
		$id = $this->input->post('id');
		$get_customer_by_id['get_customer_by_id'] = $this->masterdata_model->get_customer_by_id($id);
		echo json_encode(['code'=>200, 'result'=>$get_customer_by_id]);
	}

	public function delete_customer()
	{
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$customer_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_customer($customer_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Customer',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}
	// end customer //

	// ekspedisi //
	public function ekspedisi(){
		$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
		$this->load->view('Pages/Masterdata/expedisi', $ekspedisi_list);
	}


	// end ekspedisi //
	public function warehouse(){
		$this->load->view('Pages/Masterdata/warehouse');
	}

	public function category(){
		$this->load->view('Pages/Masterdata/category');
	}

	public function product(){
		$this->load->view('Pages/Masterdata/product');
	}

	public function settingproduct(){
		$this->load->view('Pages/Masterdata/product_setting');
	}

	public function salesman(){
		$this->load->view('Pages/Masterdata/salesman');
	}

	public function detailsalesman(){
		$this->load->view('Pages/Masterdata/salesman_detail');
	}

	public function unit(){
		$this->load->view('Pages/Masterdata/unit');
	}

	public function supplier(){
		$this->load->view('Pages/Masterdata/supplier');
	}

}

?>