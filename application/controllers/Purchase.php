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
			$data['data'] = array_merge($warehouse_list, $salesman_list);
			$this->load->view('Pages/Purchase/submission', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_product()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product($keyword); 
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
			$user_id 						= $_SESSION['user_id'];

			$data_edit = array(
				'submission_product_id'		=> $submission_product_id,
				'submission_product_code'	=> $submission_product_code,
				'submission_date'			=> $submission_date,
				'submission_warehouse'		=> $submission_warehouse,
				'submission_salesman'		=> $submission_salesman,
				'submission_qty'			=> $submission_qty,
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

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->po_list($search, $length, $start)->result_array();
			$count_list = $this->purchase_model->po_list_count($search)->result_array();
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
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id '].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_po_id '].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_po_id'].'" data-name="'.$field['hd_po_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
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
				$row[] 	= 'Rp. '.number_format($field['dt_purchase_price']);
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

	// end purchase order
}

?>