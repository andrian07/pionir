<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Masterdata extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		$this->load->view('Pages/dashboard');
	}

	public function brand(){
		$this->load->view('Pages/Masterdata/brand');
	}

	public function customer(){
		$this->load->view('Pages/Masterdata/customer');
	}

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

	public function detailproduct()
	{

		$this->load->view('Pages/Masterdata/product_detail');
	}
}

?>