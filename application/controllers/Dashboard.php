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
            $dep_access = access_department();
        	$this->global['access'] = json_decode(get_permissions($this->user_id));//json_decode($user_details['permissions']);
        	$this->global['token'] = $user_details['token'];
            $this->global['access_dep'] = $dep_access;
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
        $data['access_dep'] = $this->global['access_dep'];
	    //echo "<pre>"; print_r($data);  echo "<pre>";
		$this->template->load('layouts/default_layout.php','dashboard/dashboard_layout.php',$data); 
	}
    
	private function dashboard_panel(){
		$sess_dep_id = $this->dep_id;

        $data['sess_dep_id'] = $sess_dep_id;

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

        $condition = array('approval_flag' => 'pending');
        $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
        $req_pending_po_count = sizeof($po_pending_listing);

        $condition = array('approval_flag' => 'approved');
        $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
        $req_approved_po_count = sizeof($po_approved_listing);

        $condition = array('approval_flag' => 'approved', 'status' => 'completed');
        $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
        $req_completed_po_count = sizeof($po_completed_listing);

         $data['pending_po'] = $req_pending_po_count;
         $data['approved_po'] = $req_approved_po_count;
         $data['completed_po'] = $req_completed_po_count;

         $data['po_count'] = ($data['pending_po'] + $data['approved_po'] + $data['completed_po']);

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

    public function get_po_details(){
        $data = $this->global;

        $data['today'] = $today = date('Y-m-d'); 
        $condition = array("po_date"=> $today);
        $today_po_list =$this->purchase_model->purchase_order_listing($condition);

        //echo "<pre>"; print_r($today_po_list); echo "</pre>";

        $data['today_po_list'] = $today_po_list; 
        $data['today_po_count'] = sizeof($today_po_list);


         $condition = array('approval_flag' => 'pending');
         $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_pending_po_count = sizeof($po_pending_listing);

         $condition = array('approval_flag' => 'approved');
         $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_approved_po_count = sizeof($po_approved_listing);

         $condition = array('approval_flag' => 'approved', 'status' => 'completed');
         $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_completed_po_count = sizeof($po_completed_listing);

         $data['pending_po'] = $req_pending_po_count;
         $data['approved_po'] = $req_approved_po_count;
         $data['completed_po'] = $req_completed_po_count;

         echo $this->load->view('dashboard/sub_views/purchase_order_dashboard.php',$data,true);
    }
}
