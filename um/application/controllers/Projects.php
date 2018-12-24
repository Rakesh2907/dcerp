<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Projects extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        //$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        //$data = $this->global;
        //$data['page'] = "login/login";
        //$this->load->view('login/main_dashboard_template',$data);
        
        //$this->loadViews("dashboard", $this->global, NULL , NULL);
        $this->projectListing();
    }

    public function projectListing(){
    	if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
            echo $this->uri->segment(0);
            echo $this->uri->segment(1);
        }
    }

    public function add(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $data = $this->global;
            if($this->input->post('add_project')){
                $this->load->library('form_validation');
        
                $this->form_validation->set_rules('name','Project Name','trim|required');
                $this->form_validation->set_rules('project_url','Login URL','trim|required');
                //$this->form_validation->set_rules('add_user_url','User Registration URL','trim|required');

                if($this->form_validation->run() !== FALSE){
                    $name = trim($this->input->post('name'));//ucwords(strtolower($this->input->post('name')));
                    $key = str_replace(" ", "_", strtolower($name));
                    $project_url = trim($this->input->post('project_url'));
                    $add_user_url = trim($this->input->post('add_user_url'));
                    $insert_data = array();

                    $insert_data['name'] = $name;
                    $insert_data['key'] = $key;
                    $insert_data['project_url'] = addslashes($project_url);
                    $insert_data['add_user_url'] = addslashes($add_user_url);

                    if(!$this->checkProjectExist($insert_data)){
                        if(!empty($insert_data)){
                            $this->load->model("common_model");
                            $insert_data['created'] = date("Y-m-d H:i:s");
                            $insert_data['created_by'] = $data['userId'];

                            $this->common_model->insertData("project", $insert_data);
                            $this->session->set_flashdata('success', 'Project details added successfully');    
                        }
                        redirect('dashboard');
                    }else{
                        $data['project_details'] = (object)$insert_data;
                        $data["error_msg"] = "Project details already present";
                    }
                }else{                    
                    $this->session->set_flashdata('error', validation_errors());
                    redirect($this->uri->uri_string());
                }
            }

            $data['page'] = "dashboard/project/add";
            $this->load->view('dashboard/main_dashboard_template',$data);
        }
    }

    public function edit(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
            $data = $this->global;
            $project_id = $this->uri->segment(3);
            if(!empty($project_id)){
                $where = array('id'=>$project_id);
                $project_details = $this->project_model->projectDetails($where);
                //print_r($project_details);

                if($this->input->post('update_project')){
                    $this->load->library('form_validation');
            
                    $this->form_validation->set_rules('name','Project Name','trim|required');
                    $this->form_validation->set_rules('project_url','Login URL','trim|required');
                    //$this->form_validation->set_rules('add_user_url','User Registration URL','trim|required');

                    if($this->form_validation->run() !== FALSE){
                        $name = trim($this->input->post('name'));//ucwords(strtolower($this->input->post('name')));
                        $key = str_replace(" ", "_", strtolower($name));
                        $project_url = trim($this->input->post('project_url'));
                        $add_user_url = trim($this->input->post('add_user_url'));
                        $update_data = array();

                        if(strcmp($name, $project_details->name) !== 0){//($name !== $project_details->name){
                            $update_data['name'] = $name;
                        }

                        if(strcmp($key, $project_details->key) !== 0){//if($key !== $project_details->key){
                            $update_data['key'] = $key;
                        }

                        if(strcmp($project_url, $project_details->project_url) !== 0){//if($project_url !== $project_details->project_url){
                            $update_data['project_url'] = addslashes($project_url);
                        }

                        if(strcmp($add_user_url, $project_details->add_user_url) !== 0){//if($add_user_url !== $project_details->add_user_url){
                            $update_data['add_user_url'] = addslashes($add_user_url);
                        }

                        if(!empty($update_data)){
                            $this->load->model("common_model");
                            $update_data['updated'] = date("Y-m-d H:i:s");
                            $update_data['updated_by'] = $data['userId'];

                            $this->common_model->updateData("project", $where, $update_data);
                            $this->session->set_flashdata('success', 'Project details updated successfully');    
                        }
                        redirect('dashboard');
                    }else{                    
                        $this->session->set_flashdata('error', validation_errors());
                        //redirect($this->uri->uri_string());
                    }
                }
            }

            $data['project_details'] = $project_details;
            $data['page'] = "dashboard/project/edit";
            $this->load->view('dashboard/main_dashboard_template',$data);
        }
    }

    public function user(){
    	if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
        	$user_id = $this->uri->segment(3);
        	if(!empty($user_id)){
                $this->load->model('user_model');
                $userInfo = $this->user_model->getUserInfo($user_id);

        		$where = array("user_id"=>$user_id);
        		$projects = $this->project_model->usersProjectsList($where);
                //echo "<pre>";print_r($projects);echo "</pre>";exit;

        		$data = $this->global;
	    		$data['project_list'] = $projects;
		    	$data['page_title'] = "Projects assinged to ".$userInfo->name;
		    	$data['page'] = "dashboard/user/projects";
		        $this->load->view('dashboard/main_dashboard_template',$data);
        	}
        }
    }

    public function manageuser(){
    	if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
            $user_id = $this->uri->segment(3);
	    	$project_id = $this->uri->segment(4);

	    	if(!empty($user_id) && !empty($project_id)){
	    		$data = $this->global;
                $data['name'] = '';
                $data['login_user_name'] = '';
                $data['user_type'] = '';

                $user_details = $this->user_model->getUserInfo($user_id);
                //echo "<pre>";print_r($user_details);echo "</pre>";exit;

	    		$where = array("user_id"=>$user_id,"project_id"=>$project_id);
	        	$user_credentials = $this->project_model->usersProjectCredentials($where, true);
	        	//echo "<pre>";print_r($user_credentials->project_end_user_name);echo "</pre>";exit;

                if(isset($_POST) && !empty($_POST)){
                    if(!empty($user_credentials) && (in_array($user_credentials->key, array('lims','thyro_lims')))){
                        $result = $this->add_user_to_lims($user_credentials->add_user_url);
                        if($result){
                            $this->load->model("common_model");
                            $update_data = array("project_end_user_id"=>'',"project_end_user_name"=>$_POST['username'], "project_end_password"=>$_POST['password']);
                            $this->common_model->updateData("user_project_mapping", $where, $update_data);

                            //redirect(site_url('projects/user/'.$user_id));
                            redirect(site_url('user/userListing'));
                        }else{
                            redirect(site_url($this->uri->uri_string()));
                        }
                    }else{
                        $origin = '';
                        if(isset($_SERVER['HTTP_ORIGIN'])){
                            $origin = $_SERVER['HTTP_ORIGIN'];
                        }else{
                            $origin = 'http://'.$_SERVER['HTTP_HOST'];
                        }
                        $url = $origin."/".$user_credentials->add_user_url;
                        //echo "<pre>";print_r($_POST);echo "</pre>";exit;

                        $ch = curl_init($url);

                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        //print_r($result);exit;

                        curl_close($ch);

                        $validate_request = json_decode($result);
                        if(in_array('success', $validate_request)){
                            /*if($_POST['username'] != $user_details->login_user_name){
                                $userInfo['login_user_name'] = $_POST['username'];
                                $this->user_model->editUser($userInfo, $user_id);
                            }*/

                            $this->session->set_flashdata('success', $validate_request[1]);
                            $this->load->model("common_model");
                            $update_data = array("project_end_user_id"=>'',"project_end_user_name"=>$_POST['username'],"project_end_password"=>$_POST['password']);
                            $this->common_model->updateData("user_project_mapping", $where, $update_data);
                            redirect(site_url('projects/user/'.$user_id));
                        }else{
                            $this->session->set_flashdata('error', $validate_request[1]);
                            redirect(site_url($this->uri->uri_string()));
                        }
                    }
                }

	        	if(!empty($user_credentials)){
	        		if(!empty($user_credentials) && (in_array($user_credentials->key, array('lims','thyro_lims')))){
	        			$this->load->model("lims_model");

	        			$limsUserTypes = $this->lims_model->getUserTypesFromLims();
	        			$limsStaffTypes = $this->lims_model->getAllStaffTypesFromLims();

                        $limsUserTypeOptions = array(""=>"Select User Type");
                        foreach($limsUserTypes as $userType){
                            if($userType->id != 1){
                                $limsUserTypeOptions[$userType->id] = $userType->type;
                            }
                        }

	        			$data['limsUserTypes'] = $limsUserTypes;
                        $data['limsUserTypeOptions'] = $limsUserTypeOptions;
	        			$data['limsStaffTypes'] = $limsStaffTypes;
	        			$data['page_title'] = "Add New User to LIMS";
	        			//echo "<pre>";print_r($user_details);echo "</pre>";exit;
	        		}else{
                        $limsUserTypes = $this->user_model->getUserRoles();
                        $limsUserTypeOptions = array(""=>"Select User Type");
                        foreach($limsUserTypes as $userType){
                            if($userType->id != 1){
                                $limsUserTypeOptions[$userType->id] = $userType->role;
                            }
                        }

                        $data['limsUserTypeOptions'] = $limsUserTypeOptions;
                    }

                    $data['user_id'] = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : $user_details->id;
                    $data['name'] = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : $user_details->name;
                    $data['login_user_name'] = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : $user_details->login_user_name;
                    if(isset($user_credentials->project_end_user_name) && !empty($user_credentials->project_end_user_name)){
                        $data['login_user_name'] = $user_credentials->project_end_user_name;
                    }
                    $data['user_type'] = (isset($_POST['userType']) && !empty($_POST['userType'])) ? $_POST['userType'] : $user_details->role_id;
                    $data['staff_type'] = (isset($_POST['staffType']) && !empty($_POST['staffType'])) ? $_POST['staffType'] : $user_details->staff_type_id;
                    $data['email'] = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : $user_details->email_id;
                    $data['contactNo'] = (isset($_POST['contactNo']) && !empty($_POST['contactNo'])) ? $_POST['contactNo'] : '';
                    $data['gender'] = (isset($_POST['gender']) && !empty($_POST['gender'])) ? $_POST['gender'] : '';
                    //echo "<pre>";print_r($data);echo "</pre>";exit;
	        	}
	        	
	    		$data['projects'] = $user_credentials;
                $data['user_details'] = $user_details;
		    	$data['page'] = "dashboard/project/manage_user";
		        $this->load->view('dashboard/main_dashboard_template',$data);
	    	}
        }
    }

    private function add_user_to_lims($url_param){
        $origin = '';
        if(isset($_SERVER['HTTP_ORIGIN'])){
            $origin = $_SERVER['HTTP_ORIGIN'];
        }else{
            $origin = 'http://'.$_SERVER['HTTP_HOST'];
        }

        //$url = LIMS_ADD_USER_URL_API;
        //$url = $_SERVER['HTTP_ORIGIN']."/".$url_param;
        $url = $origin."/".$url_param;
        //echo "<pre>";print_r($url);echo "</pre>";exit;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);
        //echo "<pre>";print_r($result);echo "</pre>";exit;

        $validate_request = json_decode($result);
        //print_r($validate_request);exit;
        if(in_array('success', $validate_request)){
            /*if($_POST['username'] != $user_details->login_user_name){
                $userInfo['login_user_name'] = $_POST['username'];
                $this->user_model->editUser($userInfo, $user_id);
            }*/

            if(isset($validate_request[1]) && !empty($validate_request[1])){
                $this->session->set_flashdata('success', $validate_request[1]);  
            }else{
                $this->session->set_flashdata("success","User has been successfully created!");    
            }
            return true;
        }else{
            $this->session->set_flashdata('error', $validate_request[1]);
            return false;
        }
    }

    private function checkProjectExist($params){
        $pro = $this->project_model->checkProjectExist($params);
        if(!empty($pro)){
            return true;
        }else{
            return false;
        }
    }
}