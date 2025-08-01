	<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, OPTIONS");

	class User extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('masterdata_model');
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


		private function check_auth(){
			if(isset($_SESSION['user_name']) == null){
				redirect('Dashboard', 'refresh');
			}
		}

		public function role(){
			$this->check_auth();
			$group_role['group_role'] = $this->masterdata_model->group_role();
			$this->load->view('Pages/User/group', $group_role);
		}

		public function get_setting_permission()
		{
			$this->check_auth();
			$id = $this->input->post('id');
			$get_setting_permission = $this->masterdata_model->get_setting_permission($id);
			echo json_encode($get_setting_permission);
		}

		public function save_role(){
			$role_name = $this->input->post('role_name');
			$user_id   = $_SESSION['user_id'];

			if($role_name == null){
				$msg = "Nama Group Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$check_role = $this->masterdata_model->check_role($role_name);
			if($check_role != null){
				$msg = "Nama Group Sudah Ada";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}


			$insert = array(
				'role_name'	       => $role_name
			);
			$this->masterdata_model->save_role($insert);
			$role_id = $this->db->insert_id();

			$data_insert_permision = array(
				'role_id'	       => $role_id
			);
			$this->masterdata_model->save_permision($data_insert_permision);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Group Baru '. $role_name,
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}

		public function edit_role()
		{
			$role_id   	       = $this->input->post('role_id');
			$role_name   	   = $this->input->post('role_name_edit');
			$user_id   		   = $_SESSION['user_id'];

			if($role_name == null){
				$msg = "Nama Group Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$update = array(
				'role_name'	       => $role_name
			);

			$this->masterdata_model->update_role($update, $role_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Update Group Menjadi '. $role_name,
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);

			$msg = "Succes Update";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}


		public function delete_role()
		{
			$role_id  	= $this->input->post('id');
			$role_name  = $this->input->post('role_name');
			$user_id   	= $_SESSION['user_id'];

			$this->masterdata_model->delete_role($role_id);
			$msg = "Succes Delete";


			$data_insert_act = array(
				'activity_table_desc'	       => 'Delete Group '. $role_name,
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);

			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}

	}

?>