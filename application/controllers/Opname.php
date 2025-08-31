<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Opname extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->model('opname_model');
		$this->load->library('session');
		$this->load->helper(array('url', 'html'));
	}

	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}


	// opname 
	public function index(){
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$check_auth['check_auth'] = $check_auth;
			$this->load->view('Pages/Opname/opname', $check_auth);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function opname_list()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->opname_model->opname_list($search, $length, $start)->result_array();
			$count_list = $this->opname_model->opname_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Opname/detailopname?id='.$field['opname_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['opname_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Opname/detailopname?id='.$field['opname_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				$date = date_create($field['opname_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['opname_code'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['user_name'];
				$row[] 	= 'Rp. '.number_format($field['opname_total']);
				$row[] 	= $detail;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $total_row,
				"recordsFiltered" => $total_row,
				"data" => $data,
			);
			echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addopname()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$this->load->view('Pages/Opname/addopname', $warehouse_list);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_product_opname()
	{
		$warehouse = $this->input->get('warehouse');
		if($warehouse != null){
			$keyword = $this->input->get('term');
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->global_model->search_product($keyword)->result_array();
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$row['unit_name'];
					$find_result[] = [
						'id'                  => $row['product_id'],
						'value'               => $diplay_text,
						'product_code'        => $row['product_code'],
						'product_price'       => $row['product_price'],
						'product_weight'      => $row['product_weight'],
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
			echo json_encode($result);
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => '', 'message' => 'Silahkan Isi Gudang Terlebih Dahulu'];
			echo json_encode($result);
		}
		
	}

	public function temp_opname()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$warehouse 			= $this->input->get('warehouse');
			$user 				= $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->opname_model->temp_opname_list($search, $length, $start, $user, $warehouse)->result_array();
			$count_list = $this->opname_model->temp_opname_list_count($search, $user, $warehouse)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_name'];
				$row[] 	= $field['product_code'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['temp_purchase_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_total_ongkir']);
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_total']);
				$row[] 	= $field['temp_purchase_note'];
				$row[] 	= $edit.$delete;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $total_row,
				"recordsFiltered" => $total_row,
				"data" => $data
			);
			echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// end opname

}

?>