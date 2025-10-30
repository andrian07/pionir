<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Search extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('global_model');
		$this->load->model('masterdata_model');
		$this->load->helper(array('url', 'html'));
	}


	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Masterdata', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
		/*$access =  $this->uri->segment(2);
		$permissions = $access.'_'.$permission;
		print_r($permissions);die();*/
	}

	public function index(){
		$modul = 'Search';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$this->load->view('Pages/Search/search');
		}else{
			print_r('Tidak Ada Akses');die();
		}
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
		if($get_product_by_id['get_product_by_id'] == null){
			print_r("Barang Tidak Ada Di Gudang");die();
		}else{
			$this->load->view('Pages/Search/detailsearch', $data);
		}
		
	}

}

?>