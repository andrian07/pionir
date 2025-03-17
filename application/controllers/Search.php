<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Search extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model('masterdata_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		$this->load->view('Pages/Search/search');
	}

	public function product_list(){
		$searchin_key = $this->input->post('key');
		$product_list = $this->masterdata_model->search_product_list($searchin_key)->result_array();
		echo json_encode($product_list);
	}

	public function detailsearch(){
		$id = $this->input->get('id');
		$get_product_by_id['get_product_by_id'] = $this->masterdata_model->settingproduct($id);
		$product_stock['product_stock'] = $this->masterdata_model->product_stock($id);
		$data['data'] = array_merge($get_product_by_id, $product_stock);
		$this->load->view('Pages/Search/detailsearch', $data);
	}

}

?>