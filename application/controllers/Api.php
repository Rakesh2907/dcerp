<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user/user_model');		
    }

	/**
     * This function is used to check whether email already exist or not
     */
    private function checkEmailExists($email, $userId=null){
        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ return true; }
        else { return false; }
    }

    private function checkUsernameExist($username, $userId=null){
        if(empty($userId)){
            $result = $this->user_model->checkUsernameExist($username);
        } else {
            $result = $this->user_model->checkUsernameExist($username, $userId);
        }

        if(empty($result)){ return true; }
        else { return false; }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('password','Password','required|max_length[20]');
		$this->form_validation->set_rules('passwordC','Confirm Password','trim|required|matches[password]|max_length[20]');

		if($this->form_validation->run() == FALSE){
			//validation_errors();
		}else{
			$this->vendorId = 1;			
			$name = ucwords(strtolower($this->input->post('name')));
			$email = $this->input->post('email');
			$username = strtolower($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$roleId = $this->input->post('userType');
			$mobile = $this->input->post('contactNo');
			$hashPassword = getHashedPassword($password);
			
			$validate_username = $this->checkUsernameExist($username);
			if($validate_username){
				$validate_email = $this->checkEmailExists($email);
				if($validate_email){
					$userInfo = array('user_name'=>$username,'email'=>$email, 'password'=>$hashPassword, 'role_id'=>$roleId, 'name'=> $name,'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'created'=>date('Y-m-d H:i:s'));
					
					$result = $this->user_model->addNewUser($userInfo);

					if($result > 0){
						echo json_encode(array("success","New User created successfully"));
					}else{
						echo json_encode(array("error","User creation failed"));
					}
				}else{
					echo json_encode(array("error","Email already exists! Please try some other email!"));
				}
			}else{
				echo json_encode(array("error","Username already exists! Please try some other username!"));
			}
		}
    }

    function login(){
		$post = $_POST;
		if(!empty($post)){
			$post['user_id'];$post['username'];$post['password'];
			if((isset($post['username']) && !empty($post['username'])) && (isset($post['password']) && !empty($post['password']))){
				$this->load->model('login_model');
				$result = $this->login_model->loginMeThroughAPI(null, $post['username'], $post['password']);
				if(count($result) > 0)
				{
					$this->load->model("usermanagement_model");
					$project_id = NULL;
					$project_details = $this->usermanagement_model->getProjectDetails();
					if(!empty($project_details)){
						$project_id = $project_details->id;
					}
					
					foreach($result as $res)
					{
						$sessionArray = array('userId'=>$res->id,'role'=>$res->role_id,'ip'=>get_client_ip());
						$token = base64_encode(serialize($sessionArray));
						
						$insert_data = array("user_id"=>$res->id, "user_name"=>$res->user_name, "project"=>$project_id, "token"=>$token, "is_enabled"=>1);
						$result = $this->usermanagement_model->projectSignIn($insert_data);
						if($result){
							echo json_encode(array("success", $res->id));
						}else{
							echo json_encode(array("error","Loging failed"));
						}
					}
				}else{
					echo json_encode(array("error", "Ivalid credentials"));
				}
			}
			
		}
	}

	function update_data(){
		$this->load->model("common_model");
		$sql = "SELECT id, report_url FROM `patient_indication_report` WHERE is_deleted = 'true'";
		$res_obj = $this->common_model->getDataFromQuery($sql);

		foreach($res_obj as $obj){
			if(!empty($obj['report_url'])){
				$pos = strpos($obj['report_url'], "datargene.com");				
				if($pos === false){
					//echo "<pre>";print_r($obj['report_url']);echo "</pre>";
					$url_path = explode("/",$obj['report_url']);
					unset($url_path[0]);
					unset($url_path[1]);
					unset($url_path[2]);
					$url = "http://datargene.com/resilient/".implode("/", $url_path);

					$update_data = array("report_url"=>addslashes($url));
					$where = array("id"=>$obj['id']);
					//echo "<pre>";print_r($url);echo "</pre>";
					if($this->common_model->updateData("patient_indication_report",$where,$update_data)){
						echo "<pre>";print_r($url);echo "</pre>";
					}else{
						echo "Update Failed";
					}
				}
			}
		}
	}

	function vender_details($supplier_id = 0)
	{
			$this->load->model('purchase_model');
			$supplier_details = $this->purchase_model->get_supplier_details($supplier_id);	

			if(!empty($supplier_details)){
				$result = array(
					'status' => 'success',
					'vendor' => $supplier_details
				); 
			}else{
				$result = array(
					'status' => 'error',
				);
			}
		 echo json_encode($result);
	}
}
?>