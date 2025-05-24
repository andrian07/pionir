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
			$user_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
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

				if($field['hd_sales_order_remaining_debt'] > 0){
					$hd_sales_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_sales_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_sales_order_id '].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id '].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_sales_order_id '].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id '].'" data-name="'.$field['hd_sales_order_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_sales_order_id'].'" data-name="'.$field['hd_sales_order_inv'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
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
				$row[] 	= number_format($field['hd_sales_order_total']);
				$row[] 	= $hd_sales_remaining_debt;
				$row[] 	= $field['hd_sales_order_status'];
				$row[] 	= number_format($field['hd_sales_order_remaining_debt']);
				$row[] 	= $field['salesman_name'];
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

	public function add_temp_sales()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id 				= $this->input->post('product_id');
			$temp_rate 					= $this->input->post('temp_rate');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$user_id 					= $_SESSION['user_id'];

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

	// end sales order
}	

?>