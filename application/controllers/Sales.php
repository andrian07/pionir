<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Sales extends CI_Controller {

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
			redirect('Sales', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}


	// sales order //
	public function sales_order_list()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($this->input->post('start_date_val') != null){
				$start_date_val 	 = $this->input->post('start_date_val');
				$end_date_val 		 = $this->input->post('end_date_val');
				$supplier_filter_val = $this->input->post('supplier_filter_val');
			}else{
				$start_date_val 	 = "";
				$end_date_val 		 = "";
				$supplier_filter_val = "";
			}

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->purchase_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$count_list = $this->purchase_model->purchase_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				if($field['hd_purchase_tax'] == 'Y'){
					$tax = '<span class="badge badge-success">BKP</span>';
				}else{
					$tax = '<span class="badge badge-danger">NON BKP</span>';
				}

				if($field['hd_purchase_remaining_debt'] > 0){
					$hd_purchase_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_purchase_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_purchase_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_purchase_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_purchase_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_purchase_invoice'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $tax;
				$row[] 	= $hd_purchase_remaining_debt;
				$row[] 	= $field['dt_purchase_qty'];
				$row[] 	= number_format($field['dt_purchase_price']);
				$row[] 	= number_format($field['dt_purchase_total']);
				$row[] 	= $detail.$delete;
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
	// end sales order
}	

?>