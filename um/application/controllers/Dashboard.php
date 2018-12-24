<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController {
	function __construct() {
        parent::__construct();
        $this->isLoggedIn();

        $this->load->model('user_model');
        $this->load->model('project_model');
        
    }

    public function index(){
        //print_r($_SESSION);exit;
        //echo ord("M").ord("U").ord("Q").ord("E").ord("E").ord("T");exit;
    	$user_id = $this->global['userId'];
        $role_id = $this->global['role_id'];
    	if(!empty($user_id) && ($role_id!=ROLE_ADMIN)){
    		$project_list = $this->project_model->usersProjectsList(array("user_id"=>$user_id));
    	}else{
            $project_list = $this->project_model->allProjectsList();
        }
        //echo "<pre>";print_r($project_list);echo "</pre>";exit;
        $data = $this->global;
        $data['project_list'] = $project_list;
        if($data['role_id'] === ROLE_ADMIN){
            $data['page_title'] = "Projects <a href='".site_url('projects/add')."' class='btn btn-xs btn-primary'><i class='fa fa-plus'></i></a>";
        }else{
            $data['page_title'] = "Projects";
        }
        
        $data['page'] = "dashboard/user/projects";
        $this->load->view('dashboard/main_dashboard_template',$data);
    }
}
