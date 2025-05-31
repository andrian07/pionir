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
		$this->load->model('sales_model');
		$this->load->model('purchase_model');
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

	// search produk && Rate //

	public function search_product()
	{	
		$supplier_id = $this->input->get('id');
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
	} 

	public function get_rate()
	{
		$product_id = $this->input->post('product_id');
		$get_rate   = $this->sales_model->get_rate($product_id);
		echo json_encode(['code'=>200, 'result'=>$get_rate]);
	}

	public function get_customer_rate()
	{
		$customer_id = $this->input->post('customer_id');
		$get_customer_rate   = $this->sales_model->get_customer_rate($customer_id);
		echo json_encode(['code'=>200, 'result'=>$get_customer_rate]);
	}
	// end search produk && Rate//

	// sales order //

	public function salesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/salesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function sales_order_list()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->sales_order_list($search, $length, $start)->result_array();
			$count_list = $this->sales_model->sales_order_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_sales_order_status'] == 'Pending'){
					$hd_sales_order_status = '<span class="badge badge-info">Pending</span>';
				}else if($field['hd_sales_order_status'] == 'Success'){
					$hd_sales_order_status = '<span class="badge badge-success">Success</span>';
				}else{
					$hd_sales_order_status = '<span class="badge badge-danger">Cancel</span>';
				}

				if($field['hd_sales_order_remaining_debt'] > 0){
					$hd_sales_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_sales_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_sales_order_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id'].'" data-name="'.$field['hd_sales_order_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id'].'" data-name="'.$field['hd_sales_order_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_sales_order_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_sales_order_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_sales_order_date']); 
				$no++;
				$row = array();
				$row[] 	= $field['hd_sales_order_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['customer_name'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_so_rate'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_order_total']);
				$row[] 	= $hd_sales_remaining_debt;
				$row[] 	= $field['hd_sales_order_status'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_order_remaining_debt']);
				$row[] 	= $field['salesman_name'];
				$row[]  = $hd_sales_order_status;
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

	public function detailsalesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$hd_sales_order_id  = $this->input->get('id');
			$header_sales_order['header_sales_order'] = $this->sales_model->header_sales_order($hd_sales_order_id);
			$detail_sales_order['detail_sales_order'] = $this->sales_model->detail_sales_order($hd_sales_order_id); 
			$data['data'] = array_merge($header_sales_order, $detail_sales_order);
			$this->load->view('Pages/Sales/detailsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_sales_order()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$sales_order_id  	= $this->input->post('id');
			$header_sales_order = $this->sales_model->header_sales_order($sales_order_id);
			$inv 				= $header_sales_order[0]->hd_sales_order_inv;
			$user_id 			= $_SESSION['user_id'];

			$this->sales_model->delete_sales_order($sales_order_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Sales Order '.$inv,
				'activity_table_user'	       => $user_id
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

	public function addsalesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/addsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function save_salesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_order_customer 						= $this->input->post('sales_order_customer');
			$sales_order_payment						= $this->input->post('sales_order_payment');
			$sales_order_top 							= $this->input->post('sales_order_top');
			$sales_order_top_id 						= $this->input->post('sales_order_top_id');
			$sales_order_salesman 						= $this->input->post('sales_order_salesman');
			$sales_order_prepare 						= $this->input->post('sales_order_prepare');
			$sales_order_prepare_id 					= $this->input->post('sales_order_prepare_id');
			$sales_order_colly 							= $this->input->post('sales_order_colly');
			$sales_order_warehouse 						= $this->input->post('sales_order_warehouse');
			$sales_order_ekspedisi 						= $this->input->post('sales_order_ekspedisi');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$sales_order_due_date 						= $this->input->post('sales_order_due_date');
			$sales_order_date 							= $this->input->post('sales_order_date');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val 					    = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$footer_dp_val 					    		= $this->input->post('footer_dp_val');
			$footer_remaining_debt_val 					= $this->input->post('footer_remaining_debt_val');
			$sales_order_remark 						= $this->input->post('sales_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($sales_order_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id 		= $sales_order_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code 	= $get_warehouse_code[0]->warehouse_code;
			$warehouse_name 	= $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_order_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;
			

			$maxCode  = $this->sales_model->last_so_inv();
			$inv_code = 'J/'.$customer_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_sales_order_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_sales_order_inv'				=> $last_code,
				'hd_sales_order_customer'			=> $sales_order_customer,
				'hd_sales_order_payment'			=> $sales_order_payment,
				'hd_sales_order_ekspedisi'			=> $sales_order_ekspedisi,
				'hd_sales_order_top'				=> $sales_order_top,
				'hd_sales_order_top_id'				=> $sales_order_top_id,
				'hd_sales_order_salesman'			=> $sales_order_salesman,
				'hd_sales_order_prepare'			=> $sales_order_prepare,
				'hd_sales_order_prepare_id'			=> $sales_order_prepare_id,
				'hd_sales_order_colly'				=> $sales_order_colly,
				'hd_sales_order_date'				=> $sales_order_date,
				'hd_sales_order_warehouse'			=> $sales_order_warehouse,
				'hd_sales_order_sub_total'			=> $footer_sub_total_submit,
				'hd_sales_order_percentage1'		=> $edit_footer_discount_percentage1_submit,
				'hd_sales_order_percentage2'		=> $edit_footer_discount_percentage2_submit,
				'hd_sales_order_percentage3'		=> $edit_footer_discount_percentage3_submit,
				'hd_sales_order_disc1'				=> $edit_footer_discount1_submit,
				'hd_sales_order_disc2'				=> $edit_footer_discount2_submit,
				'hd_sales_order_disc3'				=> $edit_footer_discount3_submit,
				'hd_sales_order_total_discount'		=> $footer_total_discount_submit,
				'hd_sales_order_ppn'			    => $footer_total_ppn_val,
				'hd_sales_order_total'				=> $footer_total_invoice_val,
				'hd_sales_order_dp'					=> $footer_dp_val,
				'hd_sales_order_remaining_debt'		=> $footer_remaining_debt_val,
				'hd_sales_order_note'				=> $sales_order_remark,
				'created_by'						=> $user_id
			);	
			$save_purchase = $this->sales_model->save_sales_order($data_insert);

			$get_temp_sales_order = $this->sales_model->get_temp_sales_order($user_id)->result_array();
			foreach($get_temp_sales_order  as $row){
				$data_insert_detail = array(
					'hd_sales_order_id'		=> $save_purchase,
					'dt_so_product_id'		=> $row['temp_product_id'],
					'dt_so_rate'			=> $row['temp_so_rate'],
					'dt_so_price'			=> $row['temp_so_price'],
					'dt_so_qty'				=> $row['temp_so_qty'],
					'dt_so_discount'		=> $row['temp_so_discount'],
					'dt_so_total'			=> $row['temp_so_total']
				);

				$save_detail_sales_order = $this->sales_model->save_detail_sales_order($data_insert_detail);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Sales Order Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales_order($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_salesorder_list()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->temp_salesorder_list($search, $length, $start)->result_array();
			$count_list = $this->sales_model->temp_salesorder_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['temp_so_rate'];
				$row[] 	= $field['temp_so_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_so_price']);
				$row[] 	= 'Rp. '.number_format($field['temp_so_discount']);
				$row[] 	= 'Rp. '.number_format($field['temp_so_total']);
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

	public function add_temp_sales_order()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_id 				= $this->input->post('warehouse_id');
			$product_id 				= $this->input->post('product_id');
			$temp_rate 					= $this->input->post('temp_rate');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$user_id 					= $_SESSION['user_id'];

			if($warehouse_id == null){
				$msg = "Silahkan Pilih Gudang / Cabang Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$check_stock  = $this->sales_model->check_stock($product_id, $warehouse_id);
			if($check_stock == null){
				$msg = "Stock Tidak Ada Di Gudang";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}else if($check_stock[0]->stock < $temp_qty)
			{
				$msg = "Stock Tidak Cukup";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$check_temp_so_input = $this->sales_model->check_temp_so_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'		=> $product_id,
				'temp_so_rate'			=> $temp_rate,
				'temp_so_price'			=> $temp_price_val,
				'temp_so_qty'			=> $temp_qty,
				'temp_so_discount'		=> $temp_discount_val,
				'temp_so_total'			=> $temp_total_val,
				'temp_user_id'			=> $user_id
			);	
			$msg = 'Success Tambah';
			if($check_temp_so_input != null){
				$this->sales_model->edit_temp_so($product_id, $user_id, $data_insert);
			}else{
				$this->sales_model->add_temp_so($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_temp_so()
	{
		$temp_product_id  	= $this->input->post('id');
		$temp_user_id  	  	= $_SESSION['user_id'];
		$check_edit_temp_so = $this->sales_model->check_edit_temp_so($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_so]);
		die();
	}

	public function check_temp_so()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_so  = $this->sales_model->check_temp_so($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_so]);
		die();
	}

	public function clear_temp()
	{
		$user_id 		= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales_order($user_id);
		echo json_encode(['code'=>200, 'data'=>"Cler Success"]);
	}

	public function delete_temp_so()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->sales_model->delete_temp_so($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	// end sales order

	// sales

	public function salespage()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/sales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function sales_list()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->sales_list($search, $length, $start)->result_array();
			$count_list = $this->sales_model->sales_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_sales_status'] == 'Pending'){
					$hd_sales_status = '<span class="badge badge-info">Pending</span>';
				}else if($field['hd_sales_status'] == 'Success'){
					$hd_sales_status = '<span class="badge badge-success">Success</span>';
				}else{
					$hd_sales_status = '<span class="badge badge-danger">Cancel</span>';
				}

				if($field['hd_sales_remaining_debt'] > 0){
					$hd_sales_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_sales_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_sales_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id'].'" data-name="'.$field['hd_sales_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id'].'" data-name="'.$field['hd_sales_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_sales_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_sales_order_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_sales_date']); 
				$no++;
				$row = array();
				$row[] 	= $field['hd_sales_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['customer_name'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_sales_rate'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_total']);
				$row[] 	= $hd_sales_remaining_debt;
				$row[] 	= $field['hd_sales_status'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_remaining_debt']);
				$row[] 	= $field['salesman_name'];
				$row[]  = $hd_sales_status;
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


	public function addsales()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/addsales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_sales_list()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->temp_sales_list($search, $length, $start)->result_array();
			$count_list = $this->sales_model->temp_sales_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['temp_sales_rate'];
				$row[] 	= $field['temp_sales_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_sales_price']);
				$row[] 	= 'Rp. '.number_format($field['temp_sales_discount']);
				$row[] 	= 'Rp. '.number_format($field['temp_sales_total']);
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

	public function add_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_id 				= $this->input->post('warehouse_id');
			$product_id 				= $this->input->post('product_id');
			$temp_rate 					= $this->input->post('temp_rate');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$user_id 					= $_SESSION['user_id'];

			if($warehouse_id == null){
				$msg = "Silahkan Pilih Gudang / Cabang Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$check_stock  = $this->sales_model->check_stock($product_id, $warehouse_id);
			if($check_stock == null){
				$msg = "Stock Tidak Ada Di Gudang";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}else if($check_stock[0]->stock < $temp_qty)
			{
				$msg = "Stock Tidak Cukup";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$check_temp_sales_input = $this->sales_model->check_temp_sales_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'			=> $product_id,
				'temp_sales_rate'			=> $temp_rate,
				'temp_sales_price'			=> $temp_price_val,
				'temp_sales_qty'			=> $temp_qty,
				'temp_sales_discount'		=> $temp_discount_val,
				'temp_sales_total'			=> $temp_total_val,
				'temp_user_id'				=> $user_id
			);	
			$msg = 'Success Tambah';
			if($check_temp_sales_input != null){
				$this->sales_model->edit_temp_sales($product_id, $user_id, $data_insert);
			}else{
				$this->sales_model->add_temp_sales($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_temp_sales()
	{
		$temp_product_id  	   = $this->input->post('id');
		$temp_user_id  	  	   = $_SESSION['user_id'];
		$check_edit_temp_sales = $this->sales_model->check_edit_temp_sales($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_sales]);
		die();
	}

	public function check_temp_sales()
	{
		$user_id 			= $_SESSION['user_id'];
		$check_temp_sales   = $this->sales_model->check_temp_sales($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_sales]);
		die();
	}

	public function search_so()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->sales_model->search_so($keyword)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_sales_order_inv'];
				$find_result[] = [
					'id'                  => $row['hd_sales_order_id'],
					'value'               => $diplay_text
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function get_header_so()
	{
		$so_id 				= $this->input->post('id');
		$user_id 			= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($user_id);
		$get_dt_so = $this->sales_model->get_dt_so($so_id);
		foreach($get_dt_so as $row)
		{
			$data_insert = array(
				'temp_product_id'			=> $row->dt_so_product_id,
				'temp_so_id'				=> $so_id,
				'temp_sales_rate'			=> $row->dt_so_rate,
				'temp_sales_price'			=> $row->dt_so_price,
				'temp_sales_qty'			=> $row->dt_so_qty,
				'temp_sales_discount'		=> $row->dt_so_discount,
				'temp_sales_total'			=> $row->dt_so_total,
				'temp_user_id'				=> $user_id
			);
			$this->sales_model->add_temp_sales($data_insert);
		}
		$get_hd_so = $this->sales_model->get_hd_so($so_id);
		echo json_encode(['code'=>200, 'data'=>$get_hd_so]);
	}

	public function refresh_header_so()
	{
		$user_id 			  = $_SESSION['user_id'];
		$get_temp_sales_so_id = $this->sales_model->get_temp_sales_so_id($user_id);
		if($get_temp_sales_so_id != null){
			$so_id 		= $get_temp_sales_so_id[0]->temp_so_id; 
			$get_hd_so  = $this->sales_model->get_hd_so($so_id);
		}else{
			$get_hd_so = 0;
		}
		echo json_encode(['code'=>200, 'data'=>$get_hd_so]);
	}

	public function save_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_customer             			  = $this->input->post('sales_customer');
			$sales_order_id  						  = $this->input->post('sales_id');
			$sales_payment            				  = $this->input->post('sales_payment');
			$sales_top              				  = $this->input->post('sales_top');
			$sales_top_id             				  = $this->input->post('sales_top_id');
			$sales_salesman             			  = $this->input->post('sales_salesman');
			$sales_prepare            				  = $this->input->post('sales_prepare');
			$sales_prepare_id           			  = $this->input->post('sales_prepare_id');
			$sales_colly              				  = $this->input->post('sales_colly');
			$sales_warehouse            			  = $this->input->post('sales_warehouse');
			$sales_ekspedisi            			  = $this->input->post('sales_ekspedisi');
			$footer_sub_total_submit          		  = $this->input->post('footer_sub_total_submit');
			$sales_due_date             			  = $this->input->post('sales_due_date');
			$sales_date               				  = $this->input->post('sales_date');
			$footer_total_discount_submit        	  = $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit  = $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit  = $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit  = $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit         	  = $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit         	  = $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit         	  = $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val                     = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val           	  = $this->input->post('footer_total_invoice_val');
			$footer_dp_val                  		  = $this->input->post('footer_dp_val');
			$footer_remaining_debt_val          	  = $this->input->post('footer_remaining_debt_val');
			$sales_remark             				  = $this->input->post('sales_remark');
			$user_id                  			      = $_SESSION['user_id'];

			if($sales_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id     = $sales_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code   = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name   = $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;


			$maxCode  = $this->sales_model->last_sales_inv();
			$inv_code = 'PJ/'.$customer_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_sales_order_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_sales_inv'            	=> $last_code,
				'hd_sales_order_id'     	=> $sales_customer,
				'hd_sales_customer'     	=> $sales_customer,
				'hd_sales_payment'      	=> $sales_payment,
				'hd_sales_ekspedisi'      	=> $sales_ekspedisi,
				'hd_sales_top'        		=> $sales_top,
				'hd_sales_salesman'     	=> $sales_salesman,
				'hd_sales_prepare'      	=> $sales_prepare,
				'hd_sales_colly'        	=> $sales_colly,
				'hd_sales_date'       		=> $sales_date,
				'hd_sales_warehouse'      	=> $sales_warehouse,
				'hd_sales_sub_total'      	=> $footer_sub_total_submit,
				'hd_sales_percentage1'    	=> $edit_footer_discount_percentage1_submit,
				'hd_sales_percentage2'    	=> $edit_footer_discount_percentage2_submit,
				'hd_sales_percentage3'    	=> $edit_footer_discount_percentage3_submit,
				'hd_sales_disc1'        	=> $edit_footer_discount1_submit,
				'hd_sales_disc2'        	=> $edit_footer_discount2_submit,
				'hd_sales_disc3'        	=> $edit_footer_discount3_submit,
				'hd_sales_total_discount'   => $footer_total_discount_submit,
				'hd_sales_ppn'          	=> $footer_total_ppn_val,
				'hd_sales_total'        	=> $footer_total_invoice_val,
				'hd_sales_dp'         		=> $footer_dp_val,
				'hd_sales_remaining_debt'   => $footer_remaining_debt_val,
				'hd_sales_note'       		=> $sales_remark,
				'created_by'            	=> $user_id
			);  
			$save_sales = $this->sales_model->save_sales($data_insert);

			$get_temp_sales = $this->sales_model->get_temp_sales($user_id)->result_array();
			foreach($get_temp_sales  as $row){
				$data_insert_detail = array(
					'hd_sales_id'   	     => $save_sales,
					'dt_sales_product_id'    => $row['temp_product_id'],
					'dt_sales_rate'          => $row['temp_sales_rate'],
					'dt_sales_price'         => $row['temp_sales_price'],
					'dt_sales_qty'           => $row['temp_sales_qty'],
					'dt_sales_discount'      => $row['temp_sales_discount'],
					'dt_sales_total'         => $row['temp_sales_total']
				);
				$save_detail_sales = $this->sales_model->save_detail_sales($data_insert_detail);

				if($warehouse_id != 1){
					$product_id 	= $row['temp_product_id'];
					$qty 			= $row['temp_sales_qty'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Penjualan',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $sales_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}

			$data_insert_act = array(
				'activity_table_desc'        => 'Tambah Penjualan Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'        => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->sales_model->delete_temp_sales($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	// end sales
}	

?>