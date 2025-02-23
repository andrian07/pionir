<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Search extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		$this->load->view('Pages/Search/search');
	}

	public function detailsearch(){
		$this->load->view('Pages/Search/detailsearch');
	}

}

?>