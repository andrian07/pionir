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
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		$this->load->view('Pages/dashboard');
	}


	// brand //
	public function brand()
	{
		$brand_list['brand_list'] = $this->masterdata_model->brand_list();
		$this->load->view('Pages/Masterdata/brand', $brand_list);
	}

	public function save_brand()
	{
		$brand_name = $this->input->post('brand_name');
		$brand_desc = $this->input->post('brand_desc');
		if($brand_name == null){
			$msg = "Nama Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'brand_name'	       => $brand_name,
			'brand_desc'	       => $brand_desc,
		);
		$this->masterdata_model->save_brand($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function delete_brand()
	{
		$brand_id  = $this->input->post('id');
		$this->masterdata_model->delete_brand($brand_id);
		$msg = "Succes Delete";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function edit_brand()
	{
		$brand_id   	   = $this->input->post('brand_id');
		$brand_name   	   = $this->input->post('brand_name_edit');
		$brand_desc        = $this->input->post('brand_desc_edit');

		if($brand_name == null){
			$msg = "Nama Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

		$update = array(
			'brand_name'	       => $brand_name,
			'brand_desc'	       => $brand_desc,
		);

		$this->masterdata_model->update_brand($update, $brand_id);
		$msg = "Succes Update";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
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
		print_r($_POST);die();
		$brand_name = $this->input->post('brand_name');
		$brand_desc = $this->input->post('brand_desc');
		if($brand_name == null){
			$msg = "Nama Brand Harus Di isi";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
		$insert = array(
			'brand_name'	       => $brand_name,
			'brand_desc'	       => $brand_desc,
		);
		$this->masterdata_model->save_brand($insert);
		$msg = "Succes Input";
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function customer(){
		$customer_list['customer_list'] = $this->masterdata_model->customer_list();
		$this->load->view('Pages/Masterdata/customer', $customer_list);
	}

	// end customer //

	public function detailcustomer(){
		$this->load->view('Pages/Masterdata/customer_detail');
	}

	public function expedisi(){
		$this->load->view('Pages/Masterdata/expedisi');
	}

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