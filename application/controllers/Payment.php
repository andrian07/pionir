<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Payment extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->model('payment_model');
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


	// payment 
	public function index(){
		
	}

	// end payment

	// debt
	public function debt()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $supplier_list);
			$this->load->view('Pages/Payment/debt', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function debt_list()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}

			$list = $this->payment_model->debt_list($search, $length, $start)->result_array();
			$count_list = $this->payment_model->debt_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($check_auth[0]->add == 'Y'){
					$add = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="payment('.$field['supplier_id'].')"><i class="fas fa-money-bill-wave sizing-fa"></i></button> ';
				}else{
					$add = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-money-bill-wave sizing-fa"></i></button> ';
				}

				$no++;
				$row = array();
				$row[] 	= $field['supplier_code'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= $field['supplier_address'];
				$row[] 	= $field['supplier_phone'];
				$row[] 	= number_format($field['total_nota']);
				$row[] 	= 'Rp. '.number_format($field['total_hutang']);
				$row[] 	= $add;
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

	public function history_debt_list()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}

			$list = $this->payment_model->history_debt_list($search, $length, $start)->result_array();
			$count_list = $this->payment_model->history_debt_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['status'] == 'Success'){
					$status = '<span class="badge badge-success">Success</span>';
				}else{
					$status = '<span class="badge badge-danger">Cancel</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'payment/detaildebt?id='.$field['payment_debt_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['payment_debt_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'payment/detaildebt?id='.$field['payment_debt_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_purchase_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}


				$date = date_create($field['payment_debt_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['payment_debt_invoice'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['payment_name'];
				$row[] 	= $field['payment_debt_total_nota'];
				$row[] 	= number_format($field['payment_debt_total_pay']);
				$row[] 	= $status;
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

	public function copy_debt_to_temp()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_id	   = $this->input->get('id');
			$user_id 		   = $_SESSION['user_id'];
			$get_purchase_debt = $this->payment_model->get_purchase_debt($supplier_id)->result_array();
			$this->payment_model->clear_temp_debt($user_id);
			foreach($get_purchase_debt as $row){
				$purchase_id = $row['hd_purchase_id'];
				$get_retur_purchase_total = $this->payment_model->get_retur_purchase_total($purchase_id)->result_array();

				$total_retur = $get_retur_purchase_total[0]['total_retur'];
				if($total_retur == null){
					$total_retur = 0;
				}
				$data_insert = array(
					'temp_purchase_nominal'				=> $row['hd_purchase_grand_total'],
					'temp_payment_debt_purchase_id'		=> $purchase_id,
					'temp_payment_debt_discount'		=> 0,
					'temp_payment_debt_nominal'			=> 0,
					'temp_payment_debt_retur'			=> $total_retur,
					'temp_payment_debt_new_remaining'   => $row['hd_purchase_grand_total'] - $total_retur,
					'temp_payment_debt_user_id'			=> $user_id
				);
				$save_temp_debt = $this->payment_model->save_temp_debt($data_insert);
			}
			$this->debtpayview();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function debtpayview()
	{
		$payment_list['payment_list'] = $this->masterdata_model->payment_list();
		$this->load->view('Pages/Payment/debtpay', $payment_list);
	}

	public function get_header_debt_pay()
	{
		$supplier_id 	= $this->input->post('supplier_id');
		$get_header_debt_pay = $this->payment_model->get_header_debt_pay($supplier_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$get_header_debt_pay]);
		die();
	}

	public function get_footer_debt_pay()
	{
		$user_id 	= $_SESSION['user_id'];
		$get_footer_debt_pay = $this->payment_model->get_footer_debt_pay($user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$get_footer_debt_pay]);
		die();
	}

	public function temp_debt_list(){
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 				= $_SESSION['user_id'];

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->payment_model->temp_debt_list($search, $length, $start, $user)->result_array();
			$count_list = $this->payment_model->temp_debt_list_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($check_auth[0]->add == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit('.$field['hd_purchase_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->add == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_purchase_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_purchase_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_purchase_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= number_format($field['hd_purchase_remaining_debt']);
				$row[] 	= number_format($field['temp_payment_debt_discount']);
				$row[] 	= number_format($field['temp_payment_debt_retur']);
				$row[] 	= number_format($field['temp_payment_debt_nominal']);
				$row[] 	= number_format($field['hd_purchase_remaining_debt'] - $field['temp_payment_debt_nominal'] - $field['temp_payment_debt_retur']);
				$row[] 	= $edit.$delete;
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

	public function get_debt_temp_by_id()
	{
		$id   = $this->input->post('id');
		$user = $_SESSION['user_id'];
		$get_debt_temp_by_id = $this->payment_model->get_debt_temp_by_id($id, $user)->result_array();
		echo json_encode(['code'=>200, 'result'=>$get_debt_temp_by_id]);die();

	}

	public function add_temp_debt()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$purchase_id 				= $this->input->post('purchase_id');
			$purchase_invoice_date 		= $this->input->post('purchase_invoice_date');
			$debt_desc 					= $this->input->post('debt_desc');
			$debt_payment_val 			= $this->input->post('debt_payment_val');
			$debt_disc_val 				= $this->input->post('debt_disc_val');
			$new_remaining_debt_val 	= $this->input->post('new_remaining_debt_val');
			$user_id 					= $_SESSION['user_id'];

			$data_update = array(
				'temp_payment_debt_discount'		=> $debt_disc_val,
				'temp_payment_debt_nominal'			=> $debt_payment_val,
				'temp_payment_debt_desc'			=> $debt_desc,
				'temp_payment_debt_new_remaining'	=> $new_remaining_debt_val,
				'temp_payment_debt_is_edited'		=> 'Y'
			);	
			$msg = 'Success Tambah';
			$this->payment_model->edit_temp_debt($purchase_id, $user_id, $data_update);
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function save_debt()
	{
		$modul = 'DebtPayment';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_id 			= $this->input->post('supplier_id');
			$repayment_date 		= $this->input->post('repayment_date');
			$payment_method_id 		= $this->input->post('payment_method_id');
			$footer_total_pay_val 	= $this->input->post('footer_total_pay_val');
			$footer_total_nota 		= $this->input->post('footer_total_nota');
			$user_id 				= $_SESSION['user_id'];

			if($payment_method_id == null){
				$msg = "Silahkan Pilih Jenis Pembayaran";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;

			$maxCode  = $this->payment_model->last_debt();
			$inv_code = 'PH/'.$supplier_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->payment_debt_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'payment_debt_invoice'			=> $last_code,
				'payment_debt_supplier_id'		=> $supplier_id,
				'payment_debt_total_pay'		=> $footer_total_pay_val,
				'payment_debt_total_nota'		=> $footer_total_nota,
				'payment_debt_method_id'		=> $payment_method_id,
				'payment_debt_date'				=> $repayment_date,
				'user_id'						=> $user_id,
			);	
			$save_debt = $this->payment_model->save_debt($data_insert);

			$get_temp_debt = $this->payment_model->get_temp_debt($user_id);
			foreach($get_temp_debt  as $row){
				$data_insert_detail = array(
					'payment_debt_id'				=> $save_debt,
					'dt_payment_debt_purchase_id'	=> $row->temp_payment_debt_purchase_id,
					'dt_payment_debt_discount'		=> $row->temp_payment_debt_discount,
					'dt_payment_debt_retur'			=> $row->temp_payment_debt_retur,
					'dt_payment_debt_desc'			=> $row->temp_payment_debt_desc,
					'dt_payment_debt_nominal'		=> $row->temp_payment_debt_nominal,
				);

				$save_detail_debt = $this->payment_model->save_detail_debt($data_insert_detail);
				$purchase_id = $row->temp_payment_debt_purchase_id;
				if($row->temp_payment_debt_retur > 0){
					$update_retur_purchase = $this->payment_model->update_retur_purchase($purchase_id);
				}
				
				$new_remaining_debt =  $row->temp_payment_debt_new_remaining;
				$update_remaining_debt = $this->payment_model->update_remaining_debt($purchase_id, $new_remaining_debt); 
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Pelunasan Hutang Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->payment_model->clear_temp_debt($user_id);	

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	//end debt

}

?>