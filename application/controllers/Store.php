<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

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
        $this->load->model('store_model');	
        $this->load->model('department_model');
        $this->load->model('purchase_model');
        $this->load->model('common_model'); 
        $this->load->model('user/user_model');    
        // Your own constructor code
    }

    public function index(){

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

    // Material requisation listing. Purchase department showing all requisation.
    public function material_requisation($tab = 'tab_1', $date = 0){
    	$data = $this->global;
        $sess_dep_id = $this->dep_id;
        $data['sess_dep_id'] = $sess_dep_id;

        if(!empty($date)){
             $condition = array("approval_flag"=>'pending', "req_date" => date('Y-m-d'));
        }else{
             $condition = array("approval_flag"=>'pending');
        }

        $pending_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['pending_material_requisation_list'] = $pending_material_requisation_list;

        $condition = array("approval_flag"=>'approved');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['approved_material_requisation_list'] = $approved_material_requisation_list;

        $condition = array("approval_flag"=>'completed');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['completed_material_requisation_list'] = $completed_material_requisation_list;

        $data['tabs'] = $tab;
		echo $this->load->view('store/material_requisation_layout',$data,true);
    }

    // Add new requisation
    public function add_requisation_form(){
    	$data = $this->global;
        $sess_dep_id = $this->dep_id;
        $material_requisation_number = $this->store_model->get_material_requisation_number();
        $material_requisation_number = $material_requisation_number[0]->material_requisation_number + 1;
        $material_requisation_number = "0000{$material_requisation_number}";
        $departments = $this->department_model->get_department_listing();
        $data['requisation_given_by'] = $dep_user_details = $this->department_model->get_user_details($sess_dep_id);    
        $data['approval_assign_to'] = $dep_user_details = $this->department_model->get_user_details(21);
        $selected_material = array();
        $selected_materials = $this->store_model->get_selected_materials_draft(array('rdm.dep_id' => $sess_dep_id));
        if(!empty($selected_materials)){
            foreach ($selected_materials as $key => $value) {
                        array_push($selected_material, $value['mat_id']);
            }
        }
        $data['dep_id'] = $sess_dep_id;
        $data['req_id'] = 0;
        $data['submit_type'] = 'insert';
        $data['material_requisation_number'] = 'Req/'.date('Y').'/'.$material_requisation_number;
        $data['hidden_req_number'] = $material_requisation_number;
 
        $data['selected_materials'] = $selected_materials;
        $material_listing = $this->purchase_model->get_material_listing_pop_up($selected_material);
        $data['material_list'] = $material_listing;
        $unit_details = $this->purchase_model->get_unit_listing();
        $data['unit_list'] = $unit_details;
        //echo "<pre>"; print_r($material_requisation_number); echo "</pre>";
        $data['departments'] = $departments;
        $require_users = $this->user_model->get_all_users();
        $data['require_users'] = $require_users;
        $data['user_id'] = $this->user_id;
    	echo $this->load->view('store/forms/add_requisation_form',$data,true);
    }

    // Assign materials to requisation.
    public function selected_material_requisation(){
        if($this->validate_request()){  
             if(isset($_POST)){
                    $mat_id = explode(',', $_POST['mat_ids']);
                    $sess_dep_id = $this->dep_id;
                    $action = $_POST['action'];
                    $req_id = $_POST['req_id'];

                    if($action == 'edit' && $req_id > 0){
                        $assigned = $this->store_model->selected_material_requisation_details($mat_id,$sess_dep_id,$req_id);
                    }else{
                        $assigned = $this->store_model->selected_material_requisation($mat_id,$sess_dep_id);
                    }    
                    if(!empty($assigned))
                    {
                        if($action == 'edit' && $req_id > 0){
                            $redirect = 'store/edit_requisation_form/req_id/'.$req_id;
                        }else{
                            $redirect = 'store/add_requisation_form';
                        }

                        $result = array(
                            'status' => 'success',
                            'mat_id' => implode(',', $assigned), 
                            'redirect' => $redirect,
                            'message' => 'Done'
                        );
                    }else{
                        $result = array(
                            'status' => 'error',
                            'message' => 'Error!'
                        );
                    }
             }else{
                $result = array(
                    'status' => 'error',
                    'message' => 'Error! Post value not found'
                );
             }
             echo json_encode($result); exit;
        }else{
             echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }  
    }

    // Removed assign material to add requisation.
    public function remove_selected_material(){
        if($this->validate_request()){ 
         if(isset($_POST)){
                $dep_id = trim($_POST['dep_id']);
                $material_id = trim($_POST['mat_id']);
                $removed = $this->store_model->remove_selected_material($dep_id,$material_id);
                $result = array(
                    'status' => 'success',
                    'dep_id' => $dep_id,
                    'material_id' => $material_id,
                    'message' => 'Removed Selected Material',
                    'redirect' => 'store/add_requisation_form'
                );
               echo json_encode($result); exit; 
         }
       }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
       }         
    }

    // Removed assign material from pending requisation. 
    public function remove_selected_material_details(){
        if($this->validate_request()){ 
            if(isset($_POST)){
                $id = trim($_POST['id']);
                $req_id = trim($_POST['req_id']);
                $removed = $this->store_model->remove_selected_material_details($id,$req_id);
                $result = array(
                        'status' => 'success',
                        'id' => $id,
                        'message' => 'Removed Selected Material',
                        'redirect' => 'store/edit_requisation_form/req_id/'.$req_id
                );
                echo json_encode($result); exit; 
            }
        }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
        }    
    }


    // Add and Update material requisation.
    public function save_material_requisation(){
        if($this->validate_request()){
            if(!empty($_POST))
            {
                if($_POST['submit_type'] == 'insert')
                {
                   //echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
                     $dep_id = $_POST['dep_id'];
                     $hidden_req_number = trim($_POST['hidden_req_number']);
                     $insert_data['created'] = date('Y-m-d H:i:s');
                     $insert_data['created_by'] = $this->user_id;
                     $insert_data['req_number'] = trim($_POST['req_number']);
                     $insert_data['req_date'] = date("Y-m-d H:i:s", strtotime(trim($_POST['req_date'])));
                     $insert_data['req_given_by'] = $_POST['req_given_by'];
                     $insert_data['approval_assign_to'] = $_POST['approval_assign_by'];
                     $insert_data['approval_flag'] = 'pending';
                     $insert_data['dep_id'] = $_POST['dep_id'];

                        $req_mat = array();
                        if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0)
                        {   
                            $req_id = $this->store_model->insert_material_requisation($insert_data);

                            if($req_id >0){
                                foreach ($_POST['mat_code'] as $mat_id => $val) {
                                    $req_mat[$mat_id]['mat_code'] = $val;
                                    $req_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
                                    $req_mat[$mat_id]['require_date'] = date("Y-m-d",strtotime($_POST['require_date'][$mat_id]));
                                    $req_mat[$mat_id]['require_qty'] = $_POST['require_qty'][$mat_id];
                                    if(isset($_POST['user_mgm_user'][$mat_id])){
                                        $req_mat[$mat_id]['require_users'] = $_POST['user_mgm_user'][$mat_id];  
                                    }
                                }

                                $added_material = array();
                                foreach ($req_mat as $mat_id => $value) {
                                    $use_mgm_id = array();
                                    $users_mgm_ids = '';
                                    if(!empty($value['require_users'])){
                                        foreach ($value['require_users'] as $key => $val) {
                                            array_push($use_mgm_id, $val);
                                        }
                                    }
                                    $users_mgm_ids = implode(',', $use_mgm_id);
                                    $insert_data = array(
                                        'req_id' => $req_id,
                                        'mat_id' => $mat_id,
                                        'unit_id' => $value['unit_id'],
                                        'dep_id' => $dep_id,
                                        'require_qty' => $value['require_qty'],
                                        'require_date' => $value['require_date'],
                                        'require_users' => $users_mgm_ids,
                                        'created' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->user_id
                                    );
                                    $added_material[] = $this->store_model->insert_selected_material($insert_data,$mat_id);
                                }

                                if(count($added_material) > 0){
                                    $deleted = $this->store_model->delete_requisation_drafts($added_material,$dep_id);
                                    $result = array(
                                        'status' => 'success',
                                        'message' => 'Requisation Records Inserted Successfully.',
                                        'redirect' => 'store/edit_requisation_form/req_id/'.$req_id,
                                        'myaction' => 'inserted'
                                    );

                                    $update_req_number = $this->store_model->update_requisation_number($hidden_req_number);
                                }else{
                                    $result = array(
                                        'status' => 'error',
                                        'message' => 'Error ! Materials not Inserted.',
                                    );
                                }
                            }else{
                                $result = array(
                                    'status' => 'error', 
                                    'message' => 'Error ! Requisation Records not Inserted.',
                                ); 
                            }    

                        }else{
                              $result = array(
                                    'status' => 'warning',
                                    'message' => 'Please Browse materials.',
                                    'myfunction' => 'store/save_material_requisation' 
                              );
                        }
                     
                }else{  
                    $dep_id = $_POST['dep_id'];
                    $req_id = $_POST['req_id'];
                    $update_data['updated'] = date('Y-m-d H:i:s');
                    $update_data['updated_by'] = $this->user_id;
                    $update_data['req_date'] = date("Y-m-d H:i:s", strtotime(trim($_POST['req_date'])));
                    $update_data['req_given_by'] = $_POST['req_given_by'];
                    $update_data['approval_assign_to'] = $_POST['approval_assign_by'];
                    $update_data['approval_flag'] = 'pending';
                    $update_data['dep_id'] = $_POST['dep_id'];

                        $req_mat = array();
                        if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0)
                        {
                            $req_id = $this->store_model->update_material_requisation($update_data,$req_id);

                            if($this->store_model->delete_requisation_details($req_id,$dep_id))
                            {

                                    foreach ($_POST['mat_code'] as $mat_id => $val) {
                                        $req_mat[$mat_id]['mat_code'] = $val;
                                        $req_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
                                        $req_mat[$mat_id]['require_date'] = date("Y-m-d",strtotime($_POST['require_date'][$mat_id]));
                                        $req_mat[$mat_id]['require_qty'] = $_POST['require_qty'][$mat_id];
                                        if(isset($_POST['user_mgm_user'][$mat_id])){
                                            $req_mat[$mat_id]['require_users'] = $_POST['user_mgm_user'][$mat_id];  
                                        }
                                    }

                                    $added_material = array();
                                    foreach ($req_mat as $mat_id => $value) {
                                            $use_mgm_id = array();
                                            $users_mgm_ids = '';
                                            if(!empty($value['require_users'])){
                                                foreach ($value['require_users'] as $key => $val) {
                                                    array_push($use_mgm_id, $val);
                                                }
                                            }
                                            $users_mgm_ids = implode(',', $use_mgm_id);
                                        $insert_data = array(
                                            'req_id' => $req_id,
                                            'mat_id' => $mat_id,
                                            'unit_id' => $value['unit_id'],
                                            'dep_id' => $dep_id,
                                            'require_qty' => $value['require_qty'],
                                            'require_date' => $value['require_date'],
                                            'require_users' => $users_mgm_ids,
                                            'created' => date('Y-m-d H:i:s'),
                                            'created_by' => $this->user_id
                                        );
                                        $added_material[] = $this->store_model->insert_selected_material($insert_data,$mat_id);
                                    }

                                       if(count($added_material) > 0){
                                           
                                            $result = array(
                                                'status' => 'success',
                                                'message' => 'Requisation Records Updated Successfully.',
                                                'redirect' => 'store/edit_requisation_form/req_id/'.$req_id,
                                                'myaction' => 'inserted'
                                            );

                                        }else{
                                            $result = array(
                                                'status' => 'error',
                                                'message' => 'Error ! Materials not Inserted.',
                                            );
                                        }
                             }

                        }else{
                              $result = array(
                                    'status' => 'warning',
                                    'message' => 'Please Browse Materials.',
                                    'myfunction' => 'store/save_material_requisation' 
                              );
                        }
                }
            }else{
                   $result = array(
                            'status' => 'error', 
                            'message' => 'Error ! Post Records not found.',
                   ); 
            }
            echo json_encode($result); //exit;
        }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
        }      
    }


    // Requisation edit form.   
    public function edit_requisation_form($variable = 'req_id', $requisation_id = 0){
               $data = $this->global; 
               if($requisation_id > 0)
               { 

                    $sess_dep_id = $this->dep_id;

                    $dep_id = $this->store_model->requisation_departments($requisation_id);
                    $dep_id = $dep_id[0]->dep_id;
                   
                    $data['dep_id'] = $dep_id;
                    $data['req_id'] = $requisation_id;
                    $departments = $this->department_model->get_department_listing();
                    $req_details = $this->store_model->material_requisation_details($requisation_id);
                    $data['requisation_given_by'] = $dep_user_details = $this->department_model->get_user_details($dep_id);    
                    $data['approval_assign_to'] = $dep_user_details = $this->department_model->get_user_details(21);
                    $data['sess_dep_id'] = $sess_dep_id;
                    $selected_material = array();
                    $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $requisation_id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where);
                    if(!empty($selected_materials)){
                        foreach ($selected_materials as $key => $value) {
                            array_push($selected_material, $value['mat_id']);
                        }
                    }

                    $data['submit_type'] = 'edit';
                    $data['requisation_details'] = $req_details;
                    $data['departments'] = $departments;
                    $data['selected_materials'] = $selected_materials;
                    $material_listing = $this->purchase_model->get_material_listing_pop_up($selected_material);
                    $data['material_list'] = $material_listing;
                    $unit_details = $this->purchase_model->get_unit_listing();
                    $data['unit_list'] = $unit_details;
                    $require_users = $this->user_model->get_all_users();
                    $data['require_users'] = $require_users;
                    if($sess_dep_id == $dep_id){
                         echo $this->load->view('store/forms/edit_purchase_requisation_form',$data,true);
                    }else{
                        echo $this->load->view('store/forms/edit_requisation_form',$data,true);
                    }
               }else{
                    echo $this->load->view('errors/html/error_404',$data,true);
               }  

       }

       // Changed requisation approval status.
       public function change_approval_status(){
           if($this->validate_request())
           { 
             if(!empty($_POST)){
                $req_id = $_POST['req_id'];
                $status = $_POST['approval_status'];
                $updated_status = $this->store_model->upadate_status($req_id,$status);
                $result = array(
                            'status' => 'success', 
                            'message' => 'Status Changed.',
                            'redirect' => 'store/edit_requisation_form/req_id/'.$req_id,
                            'myfunction' => 'store/change_approval_status'
                );
             }else{
                 $result = array(
                            'status' => 'error', 
                            'message' => 'Error ! Post Records not found.',
                 );
             }
                echo json_encode($result); exit;
           }else{
                echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
           }   
       }


       // Materials showing when click on requisation listing.
       public function get_requisation_materials_list(){
            $data = $this->global; 
            if(!empty($_POST))
            {
                $req_id = $_POST['req_id'];
                $data['status'] = $_POST['status'];
                $sess_dep_id = $this->dep_id;
                $dep_id = $this->store_model->requisation_departments($req_id);
                $dep_id = $dep_id[0]->dep_id;
                $departments = $this->department_model->get_department_listing();
                $req_details = $this->store_model->material_requisation_details($req_id);
                $data['requisation_details'] = $req_details;
                $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                $selected_materials = $this->store_model->get_selected_req_material_details($where);
                $data['selected_materials'] = $selected_materials;
                $data['departments'] = $departments;
                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details; 
                $require_users = $this->user_model->get_all_users();
                $data['require_users'] = $require_users;
                $data['sess_dep_id'] = $sess_dep_id;
                $data['dep_id'] = $dep_id;
                echo $this->load->view('store/sub_views/view_requisation_selected_material_list',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
       }

       public function send_quotation_request(){
                if($this->validate_request()){
                    if(!empty($_POST))
                    {
                        $req_id = $_POST['req_id'];
                        $dep_id = $this->store_model->requisation_departments($req_id);
                        $dep_id = $dep_id[0]->dep_id;
                        $mat_id = $_POST['mat_id'];

                        $quotation_request_num = $this->purchase_model->get_quotation_request_number();
                        $quotation_request_number = $quotation_request_num[0]->quotation_request_number + 1;
                        $quotation_request_number1 = "0000{$quotation_request_number}";
                        $quotation_request_number = 'Quo/'.date('Y').'/'.$quotation_request_number1;

                        $assign_supplier = $this->common_model->get_supplier_assign_department($dep_id);

                        if(!empty($assign_supplier)){

                            foreach ($assign_supplier as $key => $val) {
                                $supplier_id[] = $val['supplier_id'];
                            }

                            $quo_insert_data = array(
                                'created' => date('Y-m-d H:i:s'),
                                'created_by' => $this->user_id,
                                'quotation_request_number' => $quotation_request_number,
                                'request_date' => date('Y-m-d'),
                                'dep_id' => $dep_id,
                                'supplier_id' => implode(',', $supplier_id),
                            );

                            $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                            $where_in = explode(',', $mat_id);
                            $selected_materials = $this->store_model->get_selected_req_material_details($where,$where_in);  

                            if(count($selected_materials) > 0){
                                   $quo_req_id = $this->purchase_model->insert_quotation_request($quo_insert_data);
                                   if($quo_req_id > 0){
                                       $added_material = array();
                                        foreach ($selected_materials as $key => $value) {
                                            $insert_data = array(
                                                'quo_req_id' => $quo_req_id,
                                                'mat_id' => $value['mat_id'],
                                                'unit_id' => $value['unit_id'],
                                                'require_qty' => $value['require_qty'],
                                                'dep_id' => $value['dep_id'],
                                                'mat_req_id' => $req_id,
                                                'created' => date("Y-m-d H:i:s"),
                                                'created_by' => $this->user_id,
                                            );

                                            $added_material[] = $this->purchase_model->insert_selected_material_quotation($insert_data,$value['mat_id']);
                                        }

                                        if(count($added_material) > 0){
                                            $result = array(
                                                'status' => 'success',
                                                'message' => 'Quotation Request Set Successfully.',
                                                'redirect' => 'purchase/quotations',
                                                'myaction' => 'inserted'
                                            );

                                            $update_req_number = $this->purchase_model->update_quotation_number($quotation_request_number1);

                                            send_quotation_notification($quo_req_id,$supplier_id);
                                        }else{
                                             $result = array(
                                                'status' => 'error',
                                                'message' => 'Error ! Materials not Inserted.',
                                             );
                                        }

                                   }else{
                                       $result = array(
                                            'status' => 'error', 
                                            'message' => 'Error ! Quotation Request not Inserted.',
                                       ); 
                                   }
                            }else{
                                    $result = array(
                                                    'status' => 'warning',
                                                    'message' => 'Please select material rows',
                                                    'myfunction' => 'store/send_quotation_request' 
                                    );
                            }
                        }else{
                             $result = array("status"=>"error", "message"=>"Please assign this department to Vendors section."); 
                        }
                    }
                }else{
                     $result = array("status"=>"error", "message"=>"Access Denied, Please re-login."); 
                }

               echo json_encode($result);
       }

       // Send new quotation when requisation approval.
       public function generate_quotation_request()
       {
          if($this->validate_request()){
                if(!empty($_POST))
                {
                    $sess_dep_id = $this->dep_id;
                    $req_id = $_POST['req_id'];
                    $dep_id = $this->store_model->requisation_departments($req_id);
                    $dep_id = $dep_id[0]->dep_id;
                    $mat_id = $_POST['mat_id'];
                    $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                    $where_in = explode(',', $mat_id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where,$where_in);
                    $quotation_draft_id = array();
                    foreach ($selected_materials as $key => $value) {

                        $insert_data = array(
                            'mat_id' => $value['mat_id'],
                            'unit_id' => $value['unit_id'],
                            'require_qty' => $value['require_qty'],
                            'dep_id' => $dep_id,
                            'mat_req_id' => $req_id
                        );
                        
                       $quo_draft_id = $this->store_model->insert_material_quotation_draft($insert_data);
                       array_push($quotation_draft_id, $quo_draft_id);
                    }

                    if(count($quotation_draft_id) > 0){
                         $result = array(
                                'status' => 'success', 
                                'message' => 'Requisation materials added in quotation list',
                                'redirect' => 'purchase/add_quotations_form/dep_id/'.$dep_id
                         ); 
                    }
                    
                }else{
                    $result = array(
                                'status' => 'error', 
                                'message' => 'Error ! Post Records not found.',
                     ); 
                }
                echo json_encode($result); exit;
          }else{
              echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
          }  
       }

       public function get_materials_notes(){
        if($this->validate_request()){
            if(!empty($_POST)){
                $table = $_POST['table'];
                if($table === 'draft')
                {
                    $mat_id = $_POST['id'];
                    $sess_dep_id = $this->dep_id;
                    $selected_materials = $this->store_model->get_selected_materials_draft(array('rdm.dep_id' => $sess_dep_id,'rdm.mat_id' => $mat_id));
                }else{
                    $id = $_POST['id'];
                    $where = array('rdm.id' => $id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where);
                }
                
                $result = array(
                    'status' => 'success',
                    'result_data' => $selected_materials,
                    'sess_dep_id' => $this->dep_id,
                );

            }else{
                $result = array(
                    'status' => 'error'
                );
            }
            echo json_encode($result);
          }else{
              echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
          }   
       }

       public function save_notes(){
         if($this->validate_request()){
            if(!empty($_POST)){
                  $material_note = $_POST['material_note'];
                  $mat_id = $_POST['note_mat_id'];
                  if(isset($_POST['detail_id']) && $_POST['detail_id'] > 0){
                      $id = $_POST['detail_id'];
                      $update_note = $this->store_model->update_note_material_req_details($material_note,$id);
                  }else{
                      $update_note = $this->store_model->update_note_material_draft($material_note,$mat_id);
                  }
                 
                  if($update_note){
                    $result = array(
                        'status' => 'success',
                        'message' => 'Note Added'
                    );
                  }else{
                      $result = array(
                        'status' => 'error',
                      );
                  }
            }else{
                 $result = array(
                        'status' => 'error',
                 );
            }
                echo json_encode($result);
          }else{
               echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
          }   
       }
}

?>