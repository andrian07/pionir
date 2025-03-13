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

	public function submission(){
		$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
		$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
		$data['data'] = array_merge($warehouse_list, $salesman_list);
		$this->load->view('Pages/Purchase/submission', $data);
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

				if($field['is_ppn'] == 'PPN'){
					$prodcut_ppn = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$prodcut_ppn = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($field['is_package'] == 'Y'){
					$product_package = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$product_package = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($check_auth[0]->edit == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['product_id'].'" data-name="'.$field['product_name'].'"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn btnprice" onclick="setprice('.$field['product_id'].')""><i class="fas fa-cog sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-cog sizing-fa"></i></button> ';
				}

				if($check_auth[0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$url_image = base_url().'assets/products/'.$field['product_image'];
				$no++;
				$row = array();
				$row[] = '<h2 class="table-product">'.$field['product_code'].'</h3><p>'.$field['product_name'].'</p>';
				$row[] = $field['brand_name'];
				$row[] = $field['category_name'];
				$row[] = $field['product_supplier_tag'];
				$row[] = $product_package;
				$row[] = $prodcut_ppn;
				$row[] = '<img src="'.$url_image.'" width="50%">';
				$row[] = $edit.$delete;
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

}

?>