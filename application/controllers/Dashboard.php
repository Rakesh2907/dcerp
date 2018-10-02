<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $user_id;
	protected $global = array ();
	public function __construct()
    {
        parent::__construct();
        $user_details = is_logged_in();

        if($user_details == 0){
        	header('Location: /um/index.php/login');
        }else{
        	$this->user_id =  $user_details['userId'];
        	$this->dep_id = get_department($this->user_id);
        	$this->global['access'] = json_decode(get_permissions($this->user_id));//json_decode($user_details['permissions']);
        	$this->global['token'] = $user_details['token'];
        }
        
        $this->load->model('dashboard_model');	
        $this->load->model('store_model');
        $this->load->model('purchase_model');
        $this->scope = [];
    }

    private function validate_request(){        
        $headers=array();
        foreach (getallheaders() as $name => $value) {
            $headers[$name] = $value;
        }
        //echo "<pre>";print_r($headers);echo "</pre>";exit;
        if(isset($headers['Authorization']) && !empty($headers['Authorization'])){

            //echo "<pre>";print_r($user_data);echo "</pre>"; exit;
            if(isset($this->global['token']) && ($this->global['token'] == $headers['Authorization'])){
                $this->scope['user_id'] = $this->user_id;
              
                $this->scope['access'] = json_encode($this->global['access']); 
                $this->scope['request_method'] = $_SERVER['REQUEST_METHOD']; 
                return true; 
            }else{ 
                return false;
            }
        }else{
            return false;
        }
    }

	public function index() 
	{
		$data = $this->dashboard_panel();
	    $data['token'] = $this->global['token'];
	    $data['access'] = $this->global['access'];
	    //echo "<pre>"; print_r($data);  echo "<pre>";
		$this->template->load('layouts/default_layout.php','dashboard/dashboard_layout.php',$data); 
	}
    
	private function dashboard_panel(){
		$sess_dep_id = $this->dep_id;

		$data['today'] = $today = date('Y-m-d'); 
		$condition = array("req_date"=> $today);
		$today_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['today_rquisation_count'] = sizeof($today_material_requisation_list);

		$condition = array("approval_flag"=>'pending');
        $pending_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['pending_rquisation_count'] = sizeof($pending_material_requisation_list);

        $condition = array("approval_flag"=>'approved');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['approved_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition = array("approval_flag"=>'completed');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['completed_requisation_count'] = sizeof($completed_material_requisation_list);

        $total_requisation = ($data['pending_rquisation_count'] + $data['approved_requisation_count'] + $data['completed_requisation_count']);

        $data['total_requisation'] = $total_requisation;

        $condition = array('is_deleted' => '0');
        $quotations = $this->purchase_model->get_supplier_quotation($condition);

        $data['quotation_count'] = sizeof($quotations);

        $suppliers = $this->purchase_model->get_supplier_listing();

        $data['vendor_count'] = sizeof($suppliers);

        return $data;
	}


	public function content(){
		$data = [];
		$data = $this->dashboard_panel();
		$data['token'] = $this->global['token'];
	    $data['access'] = $this->global['access'];
		echo $this->load->view('dashboard/dashboard_layout.php',$data,true);
	}

    public function get_requisation_details(){
        $data = $this->global;

        $sess_dep_id = $this->dep_id;

        $data['today'] = $today = date('Y-m-d'); 
        $condition = array("req_date"=> $today);
        $today_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['today_requisation_list'] = $today_material_requisation_list; 
        $data['today_rquisation_count'] = sizeof($today_material_requisation_list);

        $condition = array("approval_flag"=>'pending');
        $pending_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['pending_rquisation_count'] = sizeof($pending_material_requisation_list);

        $condition = array("approval_flag"=>'approved');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['approved_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition = array("approval_flag"=>'completed');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['completed_requisation_count'] = sizeof($completed_material_requisation_list);

        echo $this->load->view('dashboard/sub_views/requisation_dashboard.php',$data,true);
    }
}
