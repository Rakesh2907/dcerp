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
		$today_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['today_rquisation_count'] = sizeof($today_material_requisation_list);

		$condition = array("pmr.purchase_approval_flag"=>'pending', "mr.is_deleted"=>'0');
        $pending_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['pending_rquisation_count'] = sizeof($pending_material_requisation_list);

        $condition = array("pmr.purchase_approval_flag"=>'approved', "mr.is_deleted"=>'0');
        $approved_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['approved_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition = array("pmr.purchase_approval_flag"=>'completed', "mr.is_deleted"=>'0');
        $completed_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['completed_requisation_count'] = sizeof($completed_material_requisation_list);

        $total_requisation = ($data['pending_rquisation_count'] + $data['approved_requisation_count'] + $data['completed_requisation_count']);

        $data['total_requisation'] = $total_requisation;



        $condition2 = array("approval_flag"=>'pending', "mr.is_deleted"=>'0');

        $pending_material_requisation_list = $this->store_model->pending_material_requisation_listing($sess_dep_id,$condition2);
        $data['store_pending_material_requisation_count'] = sizeof($pending_material_requisation_list);

        $condition2 = array("approval_flag"=>'approved', "mr.is_deleted"=>'0');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition2);
        $data['store_approved_material_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition2 = array("approval_flag"=>'completed', "mr.is_deleted"=>'0');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition2);
        $data['store_completed_material_requisation_count'] = sizeof($completed_material_requisation_list);

        $store_total_requisation =  ($data['store_pending_material_requisation_count'] + $data['store_approved_material_requisation_count'] + $data['store_completed_material_requisation_count']);

        $data['store_total_requisation'] = $store_total_requisation;


        $where = array('inward.inward_form' => 'material_inward_form', 'inward.is_deleted' => '0');

        $material_inward = $this->store_model->inward_items($where);

        $data['inward_materials'] = sizeof($material_inward);


        $where = array('inward.inward_form' => 'general_inward_form', 'inward.is_deleted' => '0');

        $general_inward = $this->store_model->inward_items($where);
        $data['general_materials'] = sizeof($general_inward);


        $data['total_inwards'] = ($data['inward_materials'] + $data['general_materials']);
 

        $outwards = $this->store_model->outward_listing();
        $data['total_outwards'] = sizeof($outwards);


        $stock_qty = $this->purchase_model->material_stocks_quantity();
        $data['total_material_stocks'] = $stock_qty;

        $condition = 'last_quotation_id = 0';
        $pending_quotations = $this->purchase_model->quotation_listing($condition);
        $data['count_quotation_request'] = sizeof($pending_quotations);


         $mycondtion = "approval_status_purchase != 'approved' AND approval_status_account != 'approved' AND last_quotation_id > 0";
         $my_quotations = $this->purchase_model->quotation_listing($mycondtion);
         $data['count_quotation'] = sizeof($my_quotations);

        
         $condition =  "approval_status_purchase = 'approved' AND approval_status_account = 'approved' AND last_quotation_id > 0";
         $approved_quotations = $this->purchase_model->quotation_listing($condition);
         $data['count_approved_quotation'] = sizeof($approved_quotations);

         $data['quotation_count'] = ($data['count_quotation_request'] + $data['count_quotation'] + $data['count_approved_quotation']); 


        $suppliers = $this->purchase_model->get_supplier_listing();
        $data['vendor_count'] = sizeof($suppliers);

        $condition = array('po.approval_flag' => 'pending', 'po.is_deleted' => '0', 'po.status' => 'non_completed');
        $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
        $req_pending_po_count = sizeof($po_pending_listing);

        $condition = array('po.approval_flag' => 'approved', 'po.is_deleted' => '0', 'po.status' => 'non_completed');
        $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
        $req_approved_po_count = sizeof($po_approved_listing);

        $condition = array('po.approval_flag' => 'approved', 'po.status' => 'completed', 'po.is_deleted' => '0');
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

        $condition = array("approval_flag"=>'pending', "mr.is_deleted"=>'0');
        $pending_material_requisation_list = $this->store_model->pending_material_requisation_listing($sess_dep_id,$condition);
        $data['pending_rquisation_count'] = sizeof($pending_material_requisation_list);

        $condition = array("approval_flag"=>'approved', "mr.is_deleted"=>'0');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['approved_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition = array("approval_flag"=>'completed', "mr.is_deleted"=>'0');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['completed_requisation_count'] = sizeof($completed_material_requisation_list);


        $created_date = date('Y-m-d');

        $condition = array("pmr.created"=> $created_date, "pmr.is_deleted"=>"0");
        $today_purchase_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['today_purchase_requisation_list'] = $today_purchase_material_requisation_list;

        $condition = array("pmr.purchase_approval_flag"=>'pending', "mr.is_deleted"=>'0');
        $pending_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['purchase_pending_rquisation_count'] = sizeof($pending_material_requisation_list);

        $condition = array("pmr.purchase_approval_flag"=>'approved', "mr.is_deleted"=>'0');
        $approved_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['purchase_approved_requisation_count'] = sizeof($approved_material_requisation_list);

        $condition = array("pmr.purchase_approval_flag"=>'completed', "mr.is_deleted"=>'0');
        $completed_material_requisation_list = $this->purchase_model->purchase_material_requisation_listing($sess_dep_id,$condition);
        $data['purchase_completed_requisation_count'] = sizeof($completed_material_requisation_list);


        $stock_qty = $this->purchase_model->material_stocks_quantity();
        $data['total_material_stocks'] = $stock_qty;

        $stock_qty = $this->purchase_model->material_stocks_quantity($today);

        if(empty($stock_qty)){
           $data['total_expire_stocks'] = '0';  
        }else{
           $data['total_expire_stocks'] = $stock_qty; 
        }
        

        $data['remaining_stocks'] =  ($data['total_material_stocks'] - $data['total_expire_stocks']);


        $batch_wise_list = $this->dashboard_model->batch_wise_listing();
        $data['batch_wise_listing'] = $batch_wise_list;

        echo $this->load->view('dashboard/sub_views/requisation_dashboard.php',$data,true);
    }

    public function get_po_details(){
        $data = $this->global;

        $data['today'] = $today = date('Y-m-d'); 
        $condition = array("po.po_date"=> $today, "po.is_deleted" => '0');
        $today_po_list =$this->purchase_model->purchase_order_listing($condition);

        //echo "<pre>"; print_r($today_po_list); echo "</pre>";

        $data['today_po_list'] = $today_po_list; 
        $data['today_po_count'] = sizeof($today_po_list);


         $condition = array('po.approval_flag' => 'pending', 'po.is_deleted' => '0', 'po.status' => 'non_completed');
         $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_pending_po_count = sizeof($po_pending_listing);

         $condition = array('po.approval_flag' => 'approved', 'po.is_deleted' => '0', 'po.status' => 'non_completed');
         $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_approved_po_count = sizeof($po_approved_listing);

         $condition = array('po.approval_flag' => 'approved', 'po.status' => 'completed', 'po.is_deleted' => '0');
         $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
         $req_completed_po_count = sizeof($po_completed_listing);

         $data['pending_po'] = $req_pending_po_count;
         $data['approved_po'] = $req_approved_po_count;
         $data['completed_po'] = $req_completed_po_count;

         echo $this->load->view('dashboard/sub_views/purchase_order_dashboard.php',$data,true);
    }


    public function get_quotation_details(){
        $data = $this->global;


         $data['today'] = $today = date('Y-m-d');
         $condition = array("po_date"=> $today);


         $where = array('bid_date' => $today, 'is_deleted' => '0');
         $quo_req_id = $this->dashboard_model->get_distinct_quotation_request_number($where);

         $quo_request_id = array();
         $data['quotation_req_details'] = '';
         foreach ($quo_req_id as $key => $id) {
             $quo_request_id[] = $id['quo_req_id'];
         }

        
         if(!empty($quo_request_id)){
            $quotation_req_details = $this->dashboard_model->quotation_listing($quo_request_id);
            $data['quotation_req_details'] = $quotation_req_details;   
         }
         

         $condition = 'last_quotation_id = 0';
         $pending_quotations = $this->purchase_model->quotation_listing($condition);
         $data['count_quotation_request'] = sizeof($pending_quotations);


         $mycondtion = "approval_status_purchase != 'approved' AND approval_status_account != 'approved' AND last_quotation_id > 0";
         $my_quotations = $this->purchase_model->quotation_listing($mycondtion);
         $data['count_quotation'] = sizeof($my_quotations);

        
         $condition =  "approval_status_purchase = 'approved' AND approval_status_account = 'approved' AND last_quotation_id > 0";
         $approved_quotations = $this->purchase_model->quotation_listing($condition);
         $data['count_approved_quotation'] = sizeof($approved_quotations);

         echo $this->load->view('dashboard/sub_views/quotation_dashboard.php',$data,true);

    }
}
