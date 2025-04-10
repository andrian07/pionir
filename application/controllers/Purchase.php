<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Purchase extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->model('purchase_model');
		$this->load->library('session');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		
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

	// submission
	public function submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/submission', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_product_by_suplier()
	{	
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if($supplier_id == '' || $supplier_id == NULL){
			$result = ['success' => FALSE, 'message' => 'Masukan Nama Supplier Terlebih Dahulu'];
		}
		else if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product_by_supplier($keyword, $supplier_id);
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row->product_code.' - '.$row->product_name;
				$find_result[] = [
					'id'                  => $row->product_id,
					'value'               => $diplay_text,
					'product_code'        => $row->product_code
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function submission_list()
	{
		
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->submission_list($search, $length, $start)->result_array();
			$count_list = $this->purchase_model->submission_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['submission_status'] == 'Success'){
					$submission_status = '<span class="badge badge-success">Success</span>';
				}else if($field['submission_status'] == 'Pending'){
					$submission_status = '<span class="badge badge-primary multi-badge">Pending</span>';
				}else{
					$submission_status = '<span class="badge badge-danger multi-badge">Cancel</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailsubmission?id='.$field['submission_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['submission_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailsubmission?id='.$field['submission_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['submission_id'].'" data-name="'.$field['submission_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['submission_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['submission_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['submission_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['user_name'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['submission_qty'].' '.$field['unit_name'];
				$row[] 	= $field['last_stock'];
				$row[] 	= $field['submission_desc'];
				$row[] 	= $submission_status;
				$row[] 	= $field['submission_text'];
				$row[] 	= $detail.$edit.$delete;
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

	public function detailsubmission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id = $this->input->get('id');
			$submission_by_id['submission_by_id'] = $this->purchase_model->submission_by_id($id); 
			$this->load->view('Pages/Purchase/detailsubmission', $submission_by_id);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$submission_id  = $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->purchase_model->delete_submission($submission_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Pengajuan',
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

	public function save_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$submission_date 				= $this->input->post('submission_date');
			$submission_warehouse_name 		= $this->input->post('submission_warehouse_name');
			$submission_warehouse 			= $this->input->post('submission_warehouse');
			$submission_salesman 			= $this->input->post('submission_salesman');
			$submission_text 				= $this->input->post('submission_text');
			$submission_desc 				= $this->input->post('submission_desc');
			$submission_product_id 			= $this->input->post('submission_product_id');
			$submission_product_code 		= $this->input->post('submission_product_code');
			$submission_qty 				= $this->input->post('submission_qty');
			$submission_supplier 			= $this->input->post('submission_supplier');
			$user_id 						= $_SESSION['user_id'];

			$maxCode = $this->purchase_model->last_submission_inv();
			$inv_code = 'PJ/'.$submission_product_code.'/'.$submission_warehouse_name.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->submission_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$get_current_stock = $this->purchase_model->get_current_stock($submission_product_id);
			$last_stock = $get_current_stock[0]->total_last_stock;

			$data_insert = array(
				'submission_invoice'		=> $last_code,
				'submission_product_id'		=> $submission_product_id,
				'submission_product_code'	=> $submission_product_code,
				'submission_date'			=> $submission_date,
				'submission_warehouse'		=> $submission_warehouse,
				'submission_salesman'		=> $submission_salesman,
				'submission_qty'			=> $submission_qty,
				'last_stock'				=> $last_stock,
				'submission_supplier' 		=> $submission_supplier,
				'submission_desc'			=> $submission_desc,
				'submission_text'			=> $submission_text,
				'created_by'				=> $user_id,
			);	

			$this->purchase_model->insert_submission($data_insert);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Pengajuan Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function edit_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$submission_id 					= $this->input->post('submission_id');
			$submission_inv 				= $this->input->post('submission_inv');
			$submission_date 				= $this->input->post('submission_date');
			$submission_warehouse_name 		= $this->input->post('submission_warehouse_name');
			$submission_warehouse 			= $this->input->post('submission_warehouse');
			$submission_salesman 			= $this->input->post('submission_salesman');
			$submission_text 				= $this->input->post('submission_text');
			$submission_desc 				= $this->input->post('submission_desc');
			$submission_product_id 			= $this->input->post('submission_product_id');
			$submission_product_code 		= $this->input->post('submission_product_code');
			$submission_qty 				= $this->input->post('submission_qty');
			$submission_supplier 			= $this->input->post('submission_supplier');
			$user_id 						= $_SESSION['user_id'];

			$data_edit = array(
				'submission_product_id'		=> $submission_product_id,
				'submission_product_code'	=> $submission_product_code,
				'submission_date'			=> $submission_date,
				'submission_warehouse'		=> $submission_warehouse,
				'submission_salesman'		=> $submission_salesman,
				'submission_qty'			=> $submission_qty,
				'submission_supplier' 		=> $submission_supplier,
				'submission_desc'			=> $submission_desc,
				'submission_text'			=> $submission_text,
				'created_by'				=> $user_id,
			);	

			$check_status_submission = $this->purchase_model->submission_by_id($submission_id);
			if($check_status_submission[0]->submission_status == 'Cancel'){
				$msg = "Data Yang Sudah Di Cancel Tidak Bisa Di Edit";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}else{
				$this->purchase_model->edit_submission($data_edit, $submission_id);
				$data_insert_act = array(
					'activity_table_desc'	       => 'Edit Pengajuan '.$submission_inv,
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);
				$msg = "Succes Input";
				echo json_encode(['code'=>200, 'result'=>$msg]);
			}
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function submission_by_id()
	{
		$id = $this->input->post('id');
		$submission_by_id = $this->purchase_model->submission_by_id($id); 
		echo json_encode(['code'=>200, 'result'=>$submission_by_id]);
	} 

	// end submission



	// pruchase order

	public function po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$this->load->view('Pages/Purchase/purchaseorder', $supplier_list);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function po_list()
	{
		
		$modul = 'PO';
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
			$list = $this->purchase_model->po_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$count_list = $this->purchase_model->po_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_po_tax'] == 'Y'){
					$tax = '<span class="badge badge-success">BKP</span>';
				}else{
					$tax = '<span class="badge badge-danger">NON BKP</span>';
				}

				if($field['hd_po_status'] == 'Pending'){
					$hd_po_status = '<span class="badge badge-primary">Pending</span>';
				}else if($field['hd_po_status'] == 'Success'){
					$hd_po_status = '<span class="badge badge-success">Selesai</span>';
				}else{
					$hd_po_status = '<span class="badge badge-danger">Batal</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_po_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_po_id'].'" data-name="'.$field['hd_po_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_po_id'].'" data-name="'.$field['hd_po_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_po_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_po_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $tax;
				$row[] 	= $field['supplier_name'];
				$row[] 	= 'Rp. '.number_format($field['dt_po_price']);
				$row[] 	= 'Rp. '.number_format($field['hd_po_grand_total']);
				$row[] 	= $hd_po_status;
				$row[] 	= $field['hd_po_status_delivery'];
				$row[] 	= $detail.$edit.$delete;
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

	public function detailpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$po_id = $this->input->get('id');
			$header_po['header_po'] = $this->purchase_model->header_po($po_id);
			$detail_po['detail_po'] = $this->purchase_model->detail_po($po_id); 
			$data['data'] = array_merge($header_po, $detail_po);
			$this->load->view('Pages/Purchase/detailpo', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($supplier_list, $ekspedisi_list, $payment_list, $warehouse_list);
			$this->load->view('Pages/Purchase/purchaseorderadd', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_submission()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->purchase_model->search_submission($keyword)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_name'].'('.$row['submission_invoice'].')';
				$find_result[] = [
					'id'                  => $row['submission_id'],
					'value'               => $diplay_text,
					'code'                => $row['submission_invoice'],
					'product_name'        => $row['product_name'],
					'product_id'          => $row['product_id'],
					'product_price'       => $row['product_price'],
					'product_weight'      => $row['product_weight'],
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function add_temp_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$submission_id 				= $this->input->post('submission_id');
			$submission_code 			= $this->input->post('submission_code');
			$product_id 				= $this->input->post('product_id');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_weight 				= $this->input->post('temp_weight');
			$temp_delivery_price_val 	= $this->input->post('temp_delivery_price_val');
			$temp_total_weight 			= $this->input->post('temp_total_weight');
			$temp_ongkir_val 			= $this->input->post('temp_ongkir_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$user_id 					= $_SESSION['user_id'];

			$check_temp_po_input = $this->purchase_model->check_temp_po_input($product_id, $user_id);
			$data_insert = array(
				'temp_submission_id'	=> $submission_id,
				'temp_submission_inv'	=> $submission_code,
				'temp_product_id'		=> $product_id,
				'temp_po_price'			=> $temp_price_val,
				'temp_po_qty'			=> $temp_qty,
				'temp_po_weight'		=> $temp_weight,
				'temp_po_ongkir'		=> $temp_delivery_price_val,
				'temp_po_total_weight'	=> $temp_total_weight,
				'temp_po_total_ongkir'	=> $temp_ongkir_val,
				'temp_po_total'			=> $temp_total_val,
				'temp_user_id'			=> $user_id,
			);	
			$msg = 'Success Tambah';
			if($check_temp_po_input != null){
				$this->purchase_model->edit_temp_po($product_id, $user_id, $data_insert);
			}else{
				$this->purchase_model->insert_temp_po($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_po_list()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->temp_po_list($search, $length, $start)->result_array();
			$count_list = $this->purchase_model->temp_po_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['submission_invoice'];
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['temp_po_qty'];
				$row[] 	= $field['temp_po_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_po_total_ongkir']);
				$row[] 	= 'Rp. '.number_format($field['temp_po_total']);
				$row[] 	= $edit.$delete;
				$data[] = $row;
			}

			if($total_row == 0){
				//$supplier = "0";
			}else{
				//print_r($list);die();
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

	public function delete_temp_po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$temp_po_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->purchase_model->delete_temp_po($temp_po_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function check_temp_po()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_po = $this->purchase_model->check_temp_po($user_id)->result_array();;
		if($check_temp_po[0]['sub_total'] != null){
			$supplier 	 	 = $check_temp_po[0]['submission_supplier'];
			$supplier_code 	 = $check_temp_po[0]['supplier_code'];
			$product_tax 	 = $check_temp_po[0]['is_ppn'];
			$sub_total  	 = $check_temp_po[0]['sub_total'];
			$ongkir     	 = $check_temp_po[0]['ongkir'];
		}else{
			$supplier     = 0;
			$product_tax  = 0;
			$sub_total    = 0;
			$sub_total    = 0;
		}
		echo json_encode(['code'=>200, 'supplier'=>$supplier, 'supplier_code'=>$supplier_code, 'product_tax'=>$product_tax, 'sub_total'=>$sub_total, 'ongkir' => $ongkir]);
		die();
	}

	public function get_edit_temp_po()
	{
		$temp_po_id  = $this->input->post('id');
		$check_edit_temp_po = $this->purchase_model->check_edit_temp_po($temp_po_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_po]);
		die();
	}

	public function cal_due_date()
	{	
		$po_top = $this->input->post('po_top');
		if($po_top != 0){
			$po_top = $po_top - 1;
		}
		$due_date = date('Y-m-d', strtotime("+".$po_top." day"));
		echo json_encode(['code'=>200, 'result'=>$due_date]);
		die();
	}

	public function save_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$po_supplier 								= $this->input->post('po_supplier');
			$po_date 									= $this->input->post('po_date');
			$po_supplier								= $this->input->post('po_supplier');
			$po_tax 									= $this->input->post('po_tax');
			$po_ekspedisi 								= $this->input->post('po_ekspedisi');
			$po_top 									= $this->input->post('po_top');
			$purchase_order_due_date 					= $this->input->post('purchase_order_due_date');
			$po_payment_method 							= $this->input->post('po_payment_method');
			$po_warehouse 								= $this->input->post('po_warehouse');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_dpp_val 							= $this->input->post('footer_dpp_val');
			$footer_total_ppn_val 						= $this->input->post('footer_total_ppn_val');
			$footer_total_ongkir_val 					= $this->input->post('footer_total_ongkir_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_order_remark 						= $this->input->post('purchase_order_remark');
			
			$user_id 									= $_SESSION['user_id'];

			if($po_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_top == null){
				$msg = 'Silahkan Masukan Jatuh Tempo';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_payment_method == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}



			$warehouse_id = $po_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name = $get_warehouse_code[0]->warehouse_name;

			$supplier_id = $po_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;

			$maxCode  = $this->purchase_model->last_po();
			$inv_code = 'PO/'.$supplier_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_po_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_po_invoice'				=> $last_code,
				'hd_po_date'				=> $po_date,
				'hd_po_warehouse'			=> $po_warehouse,
				'hd_po_supplier'			=> $po_supplier,
				'hd_po_tax'					=> $po_tax,
				'hd_po_top'					=> $po_top,
				'hd_po_due_date'			=> $purchase_order_due_date,
				'hd_po_payment'				=> $po_payment_method,
				'hd_po_ekspedisi'			=> $po_ekspedisi,
				'hd_po_sub_total'			=> $footer_sub_total_submit,
				'hd_po_disc_percentage1'	=> $edit_footer_discount_percentage1_submit,
				'hd_po_disc_percentage2'	=> $edit_footer_discount_percentage2_submit,
				'hd_po_disc_percentage3'	=> $edit_footer_discount_percentage3_submit,
				'hd_po_disc_1'				=> $edit_footer_discount1_submit,
				'hd_po_disc_2'				=> $edit_footer_discount2_submit,
				'hd_po_disc_3'				=> $edit_footer_discount3_submit,
				'hd_po_total_discount'		=> $footer_total_discount_submit,
				'hd_po_dpp'					=> $footer_dpp_val,
				'hd_po_ppn'					=> $footer_total_ppn_val,
				'hd_po_ongkir'				=> $footer_total_ongkir_val,
				'hd_po_grand_total'			=> $footer_total_invoice_val,
				'hd_po_note'			    => $purchase_order_remark,
				'created_by'				=> $user_id
			);	
			
			$save_po = $this->purchase_model->save_po($data_insert);

			$get_temp_po = $this->purchase_model->get_temp_po($user_id)->result_array();
			foreach($get_temp_po  as $row){
				$data_insert_detail = array(
					'hd_po_id'				=> $save_po,
					'submission_id'			=> $row['temp_submission_id'],
					'submission_inv'		=> $row['temp_submission_inv'],
					'dt_product_id'			=> $row['temp_product_id'],
					'dt_po_price'			=> $row['temp_po_price'],
					'dt_po_qty'				=> $row['temp_po_qty'],
					'dt_po_weight'			=> $row['temp_po_weight'],
					'dt_po_ongkir'			=> $row['temp_po_ongkir'],
					'dt_po_total_weight'	=> $row['temp_po_total_weight'],
					'dt_po_total_ongkir'	=> $row['temp_po_total_ongkir'],
					'dt_po_total'			=> $row['temp_po_total'],
				);	

				$save_detail_po = $this->purchase_model->save_detail_po($data_insert_detail);

				if($row['temp_submission_id'] > 0 || $row['temp_submission_id'] != ''){
					$submission_id_val = $row['temp_submission_id'];
					$update_submission = $this->purchase_model->update_submission($submission_id_val);
				}
				
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah PO Cabang '.$warehouse_name,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->clear_temp_po($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function search_product_po()
	{	
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		/*if($supplier_id == '' || $supplier_id == NULL){
			$result = ['success' => FALSE, 'message' => 'Masukan Nama Supplier Terlebih Dahulu'];
		}*/
		if (!($keyword == '' || $keyword == NULL)) {
			if($supplier_id == null){
				$find = $this->global_model->search_product($keyword, $supplier_id);
			}else{
				$find = $this->global_model->search_product_by_supplier($keyword, $supplier_id);
			}
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row->product_code.' - '.$row->product_name;
				$find_result[] = [
					'id'                  => '',
					'value'               => $diplay_text,
					'product_name'        => $row->product_name,
					'product_id'          => $row->product_id,
					'product_price'       => $row->product_price,
					'product_weight'      => $row->product_weight
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function delete_po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$po_id  		= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->purchase_model->delete_po($po_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan PO',
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
	// end purchase order
}

?>