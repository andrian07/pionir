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
			$customer_expedisi_tag_id 	= implode(",",$customer_expedisi);

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
				'customer_code'	       		=> $last_code,
				'customer_name'	       		=> $customer_name,
				'customer_dob'	       		=> $customer_dob,
				'customer_gender'	    	=> $customer_gender,
				'customer_address'	    	=> $customer_address,
				'customer_address_blok'		=> $customer_address_blok,
				'customer_address_no'		=> $customer_address_no,
				'customer_rt'	       		=> $customer_address_rt,
				'customer_rw'	       		=> $customer_address_rw,
				'customer_phone'	   		=> $customer_address_phone,
				'customer_email'	    	=> $customer_address_email,
				'customer_send_address'		=> $customer_send_address,
				'customer_npwp'	       		=> $customer_npwp,
				'customer_nik'	       		=> $customer_nik,
				'customer_rate'	       		=> $customer_rate,
				'customer_expedisi_tag' 	=> $customer_expedisi_text,
				'customer_expedisi_tag_id' 	=> $customer_expedisi_tag_id

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

	public function edit_customer()
	{
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$customer_id   				= $this->input->post('customer_id');
			$customer_code 				= $this->input->post('customer_code');
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
			$customer_expedisi_tag_id 	= implode(",",$customer_expedisi);

			if($customer_name == null){
				$msg = "Nama Customer Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($customer_address_phone == null){
				$msg = "No Hp Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'customer_name'	       		=> $customer_name,
				'customer_dob'	       		=> $customer_dob,
				'customer_gender'	    	=> $customer_gender,
				'customer_address'	    	=> $customer_address,
				'customer_address_blok'		=> $customer_address_blok,
				'customer_address_no'		=> $customer_address_no,
				'customer_rt'	       		=> $customer_address_rt,
				'customer_rw'	       		=> $customer_address_rw,
				'customer_phone'	   		=> $customer_address_phone,
				'customer_email'	    	=> $customer_address_email,
				'customer_send_address'		=> $customer_send_address,
				'customer_npwp'	       		=> $customer_npwp,
				'customer_nik'	       		=> $customer_nik,
				'customer_rate'	       		=> $customer_rate,
				'customer_expedisi_tag' 	=> $customer_expedisi_text,
				'customer_expedisi_tag_id' 	=> $customer_expedisi_tag_id
			);


			$this->masterdata_model->edit_customer($data_edit, $customer_code);


			$this->masterdata_model->delete_customer_expedisi($customer_code);

			foreach($customer_expedisi as $row){
				$insert_exp = array(
					'customer_code'	       	=> $customer_code,
					'expedisi_id'	       	=> $row,
				);
				$this->masterdata_model->save_customer_ekspedisi($insert_exp);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Customer',
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
		$modul = 'Ekspedisi';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $ekspedisi_list);
			$this->load->view('Pages/Masterdata/expedisi', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_ekspedisi()
	{
		$modul = 'Ekspedisi';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$expedisi_name 		= $this->input->post('expedisi_name');
			$expedisi_address 	= $this->input->post('expedisi_address');
			$expedisi_phone 	= $this->input->post('expedisi_phone');
			$expedisi_desc 		= $this->input->post('expedisi_desc');
			$user_id 			= $_SESSION['user_id'];

			if($expedisi_name == null){
				$msg = "Nama Ekspedisi Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'ekspedisi_name'	=> $expedisi_name,
				'ekspedisi_phone'	=> $expedisi_address,
				'ekspedisi_address'	=> $expedisi_phone,
				'ekspedisi_desc'	=> $expedisi_desc
			);
			$this->masterdata_model->save_ekspedisi($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Ekspedisi Baru',
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


	public function edit_ekspedisi()
	{
		$modul = 'Ekspedisi';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$expedisi_id 		= $this->input->post('expedisi_id');
			$expedisi_name 		= $this->input->post('expedisi_name');
			$expedisi_address 	= $this->input->post('expedisi_address');
			$expedisi_phone 	= $this->input->post('expedisi_phone');
			$expedisi_desc 		= $this->input->post('expedisi_desc');
			$user_id 			= $_SESSION['user_id'];

			if($expedisi_name == null){
				$msg = "Nama Ekspedisi Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'ekspedisi_name'	=> $expedisi_name,
				'ekspedisi_phone'	=> $expedisi_address,
				'ekspedisi_address'	=> $expedisi_phone,
				'ekspedisi_desc'	=> $expedisi_desc
			);
			$this->masterdata_model->edit_ekspedisi($data_edit, $expedisi_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Ekspedisi Baru',
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


	public function delete_ekspedisi()
	{
		$modul = 'Ekspedisi';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$expedisi_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_ekspedisi($expedisi_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Ekspedisi',
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

	// end ekspedisi //

	// warehouse
	public function warehouse(){
		$modul = 'Warehouse';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $warehouse_list);
			$this->load->view('Pages/Masterdata/warehouse', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_warehouse()
	{
		$modul = 'Warehouse';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_code 	= $this->input->post('warehouse_code');
			$warehouse_name 	= $this->input->post('warehouse_name');
			$warehouse_address 	= $this->input->post('warehouse_address');
			$user_id 			= $_SESSION['user_id'];

			if($warehouse_code == null){
				$msg = "Kode Gudang Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($warehouse_name == null){
				$msg = "Nama Gudang Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'warehouse_code'	=> $warehouse_code,
				'warehouse_name'	=> $warehouse_name,
				'warehouse_address'	=> $warehouse_address
			);
			$this->masterdata_model->save_warehouse($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Gudang Baru',
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

	public function edit_warehouse()
	{
		$modul = 'Warehouse';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$warehouse_id 	 	= $this->input->post('warehouse_id');
			$warehouse_code 	= $this->input->post('warehouse_code');
			$warehouse_name 	= $this->input->post('warehouse_name');
			$warehouse_address 	= $this->input->post('warehouse_address');
			$user_id 			= $_SESSION['user_id'];

			if($warehouse_code == null){
				$msg = "Kode Gudang Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($warehouse_name == null){
				$msg = "Nama Gudang Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'warehouse_code'	=> $warehouse_code,
				'warehouse_name'	=> $warehouse_name,
				'warehouse_address'	=> $warehouse_address
			);
			$this->masterdata_model->edit_warehouse($data_edit, $warehouse_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Gudang',
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
	public function delete_warehouse()
	{
		$modul = 'Warehouse';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$warehouse_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_warehouse($warehouse_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Gudang',
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

	// end warehouse


	// category
	public function category(){
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $category_list);
			$this->load->view('Pages/Masterdata/category', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$category_name 	= $this->input->post('category_name');
			$category_desc 	= $this->input->post('category_desc');
			$user_id 			= $_SESSION['user_id'];

			if($category_name == null){
				$msg = "Nama Kategori Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'category_name'	=> $category_name,
				'category_desc'	=> $category_desc
			);
			$this->masterdata_model->save_category($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Kategori Baru',
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

	public function edit_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$category_id 	= $this->input->post('category_id');
			$category_name 	= $this->input->post('category_name');
			$category_desc 	= $this->input->post('category_desc');
			$user_id 			= $_SESSION['user_id'];

			if($category_name == null){
				$msg = "Nama Kategori Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'category_name'	=> $category_name,
				'category_desc'	=> $category_desc
			);
			$this->masterdata_model->edit_category($data_edit, $category_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Kategori',
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

	public function delete_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$category_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_category($category_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Kategori',
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
	// end category

	// salesman
	public function salesman(){
		$modul = 'Salesman';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $salesman_list, $warehouse_list);
			$this->load->view('Pages/Masterdata/salesman', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_salesman()
	{
		$modul = 'Salesman';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$salesman_name 		= $this->input->post('salesman_name');
			$salesman_phone 	= $this->input->post('salesman_phone');
			$salesman_address 	= $this->input->post('salesman_address');
			$salesman_branch 	= $this->input->post('salesman_branch');
			$user_id 			= $_SESSION['user_id'];

			if($salesman_name == null){
				$msg = "Nama Salesman Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'salesman_name'		=> $salesman_name,
				'salesman_address'	=> $salesman_address,
				'salesman_phone'	=> $salesman_phone,
				'salesman_branch'	=> $salesman_branch
			);
			$this->masterdata_model->save_salesman($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Salesman Baru',
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

	public function edit_salesman()
	{

		$modul = 'Salesman';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$salesman_id	 	= $this->input->post('salesman_id');
			$salesman_name 		= $this->input->post('salesman_name');
			$salesman_phone 	= $this->input->post('salesman_phone');
			$salesman_address 	= $this->input->post('salesman_address');
			$salesman_branch 	= $this->input->post('salesman_branch');
			$user_id 			= $_SESSION['user_id'];

			if($salesman_name == null){
				$msg = "Nama Salesman Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'salesman_name'		=> $salesman_name,
				'salesman_address'	=> $salesman_address,
				'salesman_phone'	=> $salesman_phone,
				'salesman_branch'	=> $salesman_branch
			);
			$this->masterdata_model->edit_salesman($data_edit, $salesman_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Salesman',
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

	public function delete_salesman()
	{
		$modul = 'Salesman';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$salesman_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_salesman($salesman_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Salesman',
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


	public function detailsalesman(){
		$modul = 'Salesman';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id = $this->input->get('id');
			$salesman_detail['salesman_detail'] = $this->masterdata_model->salesman_detail($id);
			$this->load->view('Pages/Masterdata/salesman_detail', $salesman_detail);
		}
	}

	// end salesman

	//unit
	public function unit(){
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$unit_list['unit_list'] = $this->masterdata_model->unit_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $unit_list);
			$this->load->view('Pages/Masterdata/unit', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_unit()
	{
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$unit_name 	= $this->input->post('unit_name');
			$unit_desc 	= $this->input->post('unit_desc');
			$user_id 	= $_SESSION['user_id'];

			if($unit_name == null){
				$msg = "Nama Unit Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'unit_name'		=> $unit_name,
				'unit_desc'		=> $unit_desc
			);
			$this->masterdata_model->save_unit($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Satuan Baru',
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

	public function edit_unit()
	{
		
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$unit_id 	= $this->input->post('unit_id');
			$unit_name 	= $this->input->post('unit_name');
			$unit_desc 	= $this->input->post('unit_desc');
			$user_id 	= $_SESSION['user_id'];

			if($unit_name == null){
				$msg = "Nama Unit Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$data_edit = array(
				'unit_name'		=> $unit_name,
				'unit_desc'		=> $unit_desc
			);

			$this->masterdata_model->edit_unit($data_edit, $unit_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Satuan',
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

	public function delete_unit()
	{
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$unit_id  		= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_unit($unit_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Satuan',
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
	// end unit

	//supplier
	public function supplier(){
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $supplier_list);
			$this->load->view('Pages/Masterdata/supplier', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_supplier()
	{
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_name 		= $this->input->post('supplier_name');
			$supplier_telp 		= $this->input->post('supplier_telp');
			$supplier_address 	= $this->input->post('supplier_address');
			$user_id 			= $_SESSION['user_id'];

			if($supplier_name == null){
				$msg = "Nama Supplier Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$maxCode = $this->masterdata_model->get_last_supplier();
			if ($maxCode == NULL) {
				$last_code = 'S-00001';
			} else {
				$maxCode = $maxCode[0]->supplier_code;
				$last_code = substr($maxCode, -5);
				$last_code = 'S-'.substr('00000' . strval(floatval($last_code) + 1), -5);
			}

			$insert = array(
				'supplier_code'		=> $last_code,
				'supplier_name'		=> $supplier_name,
				'supplier_address'	=> $supplier_address,
				'supplier_phone'	=> $supplier_telp
			);
			$this->masterdata_model->save_supplier($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Supplier Baru',
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

	public function edit_supplier()
	{
		
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$supplier_id 		= $this->input->post('supplier_id');
			$supplier_name 		= $this->input->post('supplier_name');
			$supplier_telp 		= $this->input->post('supplier_telp');
			$supplier_address 	= $this->input->post('supplier_address');
			$user_id 			= $_SESSION['user_id'];

			if($supplier_name == null){
				$msg = "Nama Supplier Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'supplier_name'		=> $supplier_name,
				'supplier_address'	=> $supplier_address,
				'supplier_phone'	=> $supplier_telp
			);

			$this->masterdata_model->edit_supplier($data_edit, $supplier_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Supplier',
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

	public function delete_supplier()
	{
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$supplier_id  		= $this->input->post('id');
			$user_id 			= $_SESSION['user_id'];
			$this->masterdata_model->delete_supplier($supplier_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Supplier',
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
	//end supplier


	//product
	public function product(){
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$brand_list['brand_list'] 		= $this->masterdata_model->brand_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] 		= $check_auth;
			$data['data'] = array_merge($check_auth, $category_list, $brand_list, $supplier_list);
			$this->load->view('Pages/Masterdata/product', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}	

	public function product_list()
	{
		
		$search = $this->input->post('search');
		$length = $this->input->post('length');
		$start = $this->input->post('start');
		if($search != null){
			$search = $search['value'];
		}
		$list = $this->masterdata_model->product_list($search, $length, $start)->result_array();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {

			if($field['product_ppn'] == 'PPN'){
				$prodcut_ppn = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
			}else{
				$prodcut_ppn = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
			}

			if($field['product_package'] == 'PPN'){
				$product_package = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
			}else{
				$product_package = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
			}

			if($field['product_supplier_tag'] != null){
				$product_supplier_tag = explode(",",$field['product_supplier_tag']) ;
				foreach ($product_supplier_tag as $field_tag) {
					$filed_tag_row[] = '<span class="badge badge-primary" style="margin-right:5px;">'.$field_tag.'</span>';
				}
			}
			$no++;
			$row = array();
			$row[] = '<h2 class="table-product">'.$field['product_code'].'</h3><p>'.$field['product_name'].'</p>';
			$row[] = $field['brand_name'];
			$row[] = $field['category_name'];
			if($field['product_supplier_tag'] != null){
				$row[] = $filed_tag_row;
			}else{
				$row[] = '';
			}
			$row[] = $product_package;
			$row[] = $prodcut_ppn;
			$row[] = $field['product_ppn'];
			$row[] = '
			<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn"><i class="fas fa-edit sizing-fa"></i></button> 
			<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn delete" data-id="'.$field['product_id'].'" data-name="AKAKO"><i class="fas fa-trash-alt sizing-fa"></i></button> 
			<button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="fas fa-cog sizing-fa"></i></button>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => '12',
			"recordsFiltered" => '12',
			"data" => $data,
		);
		echo json_encode($output);
		
		/*
		$search = $this->input->post('search');
		if($search != null){
			$search = $search['value'];
		}
		$draws	= $this->input->post('draw');
		$data['data']							= $this->masterdata_model->product_list($search)->result_array();
		$draw['draw']							= $draws;
		$recordsTotal['recordsTotal']			= 12;
		$recordsFiltered['recordsFiltered'] 	= 12;
		$product_data 							= array_merge($data, $draw, $recordsTotal, $recordsFiltered);
		echo json_encode($product_data);die();
		*/
		
	}

	public function settingproduct(){
		$this->load->view('Pages/Masterdata/product_setting');
	}

	//end product
}	

?>