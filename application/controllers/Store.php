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
    public function add_requisation_form($req_id = 0, $req_given_by = 0, $approval_assign_by = 0, $req_date = '', $dep_id = '0'){
    	$data = $this->global;
        $sess_dep_id = $this->dep_id;
        $material_requisation_number = $this->store_model->get_material_requisation_number();
        $material_requisation_number = $material_requisation_number[0]->material_requisation_number + 1;
        $material_requisation_number = "0000{$material_requisation_number}";
        $departments = $this->department_model->get_department_listing();
        $data['requisation_given_by'] = $dep_user_details = $this->department_model->get_user_details($sess_dep_id);    
        $data['approval_assign_to'] = $dep_user_details = $this->department_model->get_user_details(21);
        $selected_material = array();
        //echo $dep_id; //die;
        if($dep_id > 0){
             $data['dep_id'] = $dep_id;
        }else{
             $data['dep_id'] = $dep_id = $sess_dep_id;
        }
        $selected_materials = $this->store_model->get_selected_materials_draft(array('rdm.dep_id' => $dep_id));
        $data['selected_material_count'] = 0;
        if(!empty($selected_materials)){
            foreach ($selected_materials as $key => $value) {
                        array_push($selected_material, $value['mat_id']);
            }

           $data['selected_material_count'] = sizeof($selected_material); 
        }

        $data['req_id'] = $req_id;
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
        $data['approval_assign_by'] = $approval_assign_by;
    	echo $this->load->view('store/forms/add_requisation_form',$data,true);
    }

    // Assign materials to requisation.
    public function selected_material_requisation(){
        if($this->validate_request()){  
             if(isset($_POST)){
                    $mat_id = explode(',', $_POST['mat_ids']);
                    $dep_id = $_POST['dep_id'];
                    $action = $_POST['action'];
                    $req_id = $_POST['req_id'];
                    $req_given_by = $_POST['req_given_by'];
                    $approval_assign_by = $_POST['approval_assign_by'];
                    $req_date = $_POST['req_date'];

                    if($action == 'edit' && $req_id > 0){
                        $assigned = $this->store_model->selected_material_requisation_details($mat_id,$dep_id,$req_id);
                    }else{
                        $assigned = $this->store_model->selected_material_requisation($mat_id,$dep_id);
                    }    
                    if(!empty($assigned))
                    {
                        if($action == 'edit' && $req_id > 0){
                            $redirect = 'store/edit_requisation_form/req_id/'.$req_id;
                        }else{
                            $redirect = 'store/add_requisation_form/'.$req_id.'/'.$req_given_by.'/'.$approval_assign_by.'/'.$req_date.'/'.$dep_id.'/';
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

                $req_given_by = $_POST['req_given_by'];
                $approval_assign_by = $_POST['approval_assign_by'];
                $req_date = $_POST['req_date'];

                $removed = $this->store_model->remove_selected_material($dep_id,$material_id);
                $result = array(
                    'status' => 'success',
                    'dep_id' => $dep_id,
                    'material_id' => $material_id,
                    'message' => 'Removed Selected Material',
                    'redirect' => 'store/add_requisation_form/0/'.$req_given_by.'/'.$approval_assign_by.'/'.$req_date.'/'.$dep_id
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

    public function save_batch_number(){
            $data = $this->global;
            if($this->validate_request()){
               if(!empty($_POST)){
                  if(isset($_POST['sub_mat_id']) && count($_POST['sub_mat_id']) > 0)
                  {     
                        foreach ($_POST['sub_mat_id'] as $sub_mat_id => $value) {

                                $batch_number_array['mat_id'] = $_POST['mymat_id'];
                                $batch_number_array['sub_mat_id'] = $sub_mat_id;
                                $batch_number_array['inward_id'] = $_POST['myinward_id'];
                                $batch_number_array['po_id'] = $_POST['mypo_id'];

                                foreach ($value as $row_id => $val) {
                                     $batch_number_array['bar_code'] = trim($_POST['sub_mat_bar_code'][$sub_mat_id][$row_id]);
                                     $batch_number_array['batch_number'] = trim($_POST['sub_mat_batch_no'][$sub_mat_id][$row_id]);
                                     $batch_number_array['lot_number'] = trim($_POST['sub_mat_lot_no'][$sub_mat_id][$row_id]);
                                     $batch_number_array['received_qty'] = trim($_POST['sub_mat_received_qty'][$sub_mat_id][$row_id]);
                                     $batch_number_array['accepted_qty'] = trim($_POST['sub_mat_accepted_qty'][$sub_mat_id][$row_id]);
                                     $batch_number_array['expire_date '] = date('Y-m-d',strtotime(trim($_POST['sub_mat_expire_date'][$sub_mat_id][$row_id])));
                                     $batch_number_array['shipping_temp'] = trim($_POST['sub_mat_shipping_temp'][$sub_mat_id][$row_id]);
                                     $batch_number_array['storage_temp'] = trim($_POST['sub_mat_storage_temp'][$sub_mat_id][$row_id]);
                                     $batch_number_array['created'] = date('Y-m-d H:i:s');
                                     $batch_number_array['created_by'] = $this->user_id;
                                }      
                        }


                        echo "<pre>"; print_r($batch_number_array); echo "</pre>";
                        echo "<pre>"; print_r($_POST); echo "</pre>";
                  }else{

                  }   
                
               }
            }else{
               echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));  
            }
       }

    public function save_inward_material(){
             if($this->validate_request()){
                  if(!empty($_POST))
                  {
                      if($_POST['submit_type'] == 'insert')
                      {
                          $insert_data['created'] = date('Y-m-d H:i:s'); 
                          $insert_data['created_by'] = $this->user_id;
                          $insert_data['invoice_date'] = date("Y-m-d",strtotime(trim($_POST['invoice_date'])));
                          $insert_data['invoice_number'] = trim($_POST['invoice_number']);
                          $insert_data['chalan_date'] = date("Y-m-d",strtotime(trim($_POST['chalan_date'])));
                          $insert_data['chalan_number'] = trim($_POST['chalan_number']);
                          $insert_data['gate_entry_date'] = date("Y-m-d",strtotime(trim($_POST['gate_entry_date'])));
                          $insert_data['gate_entry_number'] = trim($_POST['gate_entry_no']);
                          $insert_data['grn_date'] = date("Y-m-d", strtotime(trim($_POST['grn_date'])));
                          $insert_data['grn_number'] = trim($_POST['grn_number']);
                          $insert_data['vendor_id'] = $_POST['po_vendor_id'];
                          $insert_data['po_id'] = $_POST['po_id'];
                          $insert_data['state_code'] = trim($_POST['state_code']);
                          $insert_data['currency'] = trim($_POST['currency']);
                          $insert_data['total_amt'] = trim($_POST['total_amt']);
                          $insert_data['total_cgst'] = trim($_POST['total_cgst']);
                          $insert_data['total_sgst'] = trim($_POST['total_sgst']);
                          $insert_data['total_igst'] = trim($_POST['total_igst']);
                          $insert_data['freight_amt'] = trim($_POST['freight_amt']);
                          $insert_data['other_amt'] = trim($_POST['other_amt']);
                          $insert_data['total_bill_amt'] = trim($_POST['total_bill_amt']);
                          $insert_data['rounded_amt'] = trim($_POST['rounded_amt']);
                          $insert_data['inward_form'] = trim($_POST['inward_form']);

                          if(isset($_POST['cat_id']) && $_POST['cat_id'] > 0){
                                $insert_data['cat_id'] = $_POST['cat_id'];
                          }

                         if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0)
                         {
                             $inward_id =  $this->store_model->insert_inward($insert_data);

                             if($inward_id >0)
                             {
                                $added_material = array();
                                foreach ($_POST['mat_code'] as $mat_id => $val) 
                                {
                                    $insert_inward_detail = array(
                                        'inward_id' => $inward_id,
                                        'po_id' => $_POST['po_id'],
                                        'mat_id' => $mat_id,
                                        'hsn_code' => trim($_POST['hsn_code'][$mat_id]),
                                        'unit_id' => trim($_POST['unit_id'][$mat_id]),
                                        'rate' => trim($_POST['rate'][$mat_id]),
                                        'po_qty' => trim($_POST['po_qty'][$mat_id]),
                                        'pre_rec_qty' => trim($_POST['pre_rec_qty'][$mat_id]),
                                        'received_qty' => trim($_POST['received_qty'][$mat_id]),
                                        'rejected_qty' => 0,
                                        'discount_per' => trim($_POST['discount_per'][$mat_id]),
                                        'discount' => trim($_POST['discount'][$mat_id]),
                                        'mat_amount' => trim($_POST['mat_amount'][$mat_id]),
                                        'cgst_per' => trim($_POST['cgst_per'][$mat_id]),
                                        'cgst_amt' => trim($_POST['cgst_amt'][$mat_id]),
                                        'sgst_per' => trim($_POST['sgst_per'][$mat_id]),
                                        'sgst_amt' => trim($_POST['sgst_amt'][$mat_id]),
                                        'igst_per' => trim($_POST['igst_per'][$mat_id]),
                                        'igst_amt' => trim($_POST['igst_amt'][$mat_id]),
                                        'created' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->user_id
                                    );

                                    $added_material[] = $this->store_model->insert_inward_items_details($insert_inward_detail,$mat_id);   
                                }

                                if(count($added_material) > 0){
                                        $deleted = $this->store_model->delete_inward_details_drafts($added_material, $_POST['po_id']);
                                        $this->purchase_model->update_purchase_order_inward_material_flag($_POST['po_id']);
                                        $result = array(
                                            'status' => 'success',
                                            'message' => 'Items Inserted Successfully.',
                                            'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                            'myaction' => 'inserted'
                                        );
                                }else{
                                    $result = array(
                                        'status' => 'error',
                                        'message' => 'Error! items not inserted'
                                    );
                                }
                             }else{
                                $result = array(
                                    'status' => 'error',
                                    'message' => 'Error! Inward not saved'
                                );
                             }

                         }else{
                             $result = array(
                                    'status' => 'warning',
                                    'message' => 'Please Browse materials.',
                                    'myfunction' => 'store/save_inward_material' 
                             );
                         } 
                      }else{
                        
                            $result = array(); 

                            $inward_id = $_POST['inward_id'];
                            $uploadPath = 'upload/invoice';
                            $allowed = array(
                                    'pdf' => 'application/pdf',
                                    'jpeg' => 'image/jpeg',
                                    'png' => 'image/png'
                            );  
                            $files_obj = $_FILES["invoice_file"];
                            if(isset($files_obj["error"]) && empty($files_obj["error"])){
                                    $ext = pathinfo($files_obj['name'], PATHINFO_EXTENSION);
                                    if(!array_key_exists($ext, $allowed)){
                                        $result = array(
                                                'status' => 'error',
                                                'message' => "Error [".$files_obj['name']."]: only PDF,PNG and JPEG files are allowed."
                                        );
                                    }else{
                                         $file_name = "invoice_inward_id_".$inward_id.'.'.$ext;
                                         $file = $uploadPath."/".$file_name;

                                            $_FILES['invoiceFile']['name'] = $file_name;
                                            $_FILES['invoiceFile']['type'] = $files_obj['type'];
                                            $_FILES['invoiceFile']['tmp_name'] = $files_obj['tmp_name'];
                                            $_FILES['invoiceFile']['error'] = $files_obj['error'];
                                            $_FILES['invoiceFile']['size'] = $files_obj['size'];

                                            $config['upload_path'] = $uploadPath;
                                            $config['allowed_types'] = '*';//'gif|jpg|png'; 
                                            $this->load->library('upload', $config);

                                            $this->upload->initialize($config);

                                            if($this->upload->do_upload('invoiceFile')){
                                                $fileData = $this->upload->data(); 
                                                $update_data['invoice_file'] = $this->config->item("upload_path").$file;
                                            }
                                    }
                            }

                        if(!empty($result)){  
                        }else{    
                          $update_data['updated'] = date('Y-m-d H:i:s'); 
                          $update_data['updated_by'] = $this->user_id;
                          $update_data['invoice_date'] = date("Y-m-d",strtotime(trim($_POST['invoice_date'])));
                          $update_data['invoice_number'] = trim($_POST['invoice_number']);
                          $update_data['chalan_date'] = date("Y-m-d",strtotime(trim($_POST['chalan_date'])));
                          $update_data['chalan_number'] = trim($_POST['chalan_number']);
                          $update_data['gate_entry_date'] = date("Y-m-d",strtotime(trim($_POST['gate_entry_date'])));
                          $update_data['gate_entry_number'] = trim($_POST['gate_entry_no']);
                          $update_data['grn_date'] = date("Y-m-d", strtotime(trim($_POST['grn_date'])));
                          $update_data['grn_number'] = trim($_POST['grn_number']);
                          $update_data['state_code'] = trim($_POST['state_code']);
                          $update_data['currency'] = trim($_POST['currency']);
                          $update_data['total_amt'] = trim($_POST['total_amt']);
                          $update_data['total_cgst'] = trim($_POST['total_cgst']);
                          $update_data['total_sgst'] = trim($_POST['total_sgst']);
                          $update_data['total_igst'] = trim($_POST['total_igst']);
                          $update_data['freight_amt'] = trim($_POST['freight_amt']);
                          $update_data['other_amt'] = trim($_POST['other_amt']);
                          $update_data['total_bill_amt'] = trim($_POST['total_bill_amt']);
                          $update_data['rounded_amt'] = trim($_POST['rounded_amt']);
                          $update_data['remark'] = trim($_POST['remark']);

                          if(isset($_POST['cat_id']) && $_POST['cat_id'] > 0){
                                $update_data['cat_id'] = $_POST['cat_id'];
                          }

                          if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0){
                                $iwd = $this->store_model->update_inward($update_data,$inward_id);
                                if($iwd > 0){
                                    $edit_material = array();
                                    foreach ($_POST['mat_code'] as $mat_id => $val) 
                                    {
                                            $update_inward_detail = array(
                                                'hsn_code' => trim($_POST['hsn_code'][$mat_id]),
                                                'unit_id' => trim($_POST['unit_id'][$mat_id]),
                                                'rate' => trim($_POST['rate'][$mat_id]),
                                                'received_qty' => trim($_POST['received_qty'][$mat_id]),
                                                'discount_per' => trim($_POST['discount_per'][$mat_id]),
                                                'discount' => trim($_POST['discount'][$mat_id]),
                                                'mat_amount' => trim($_POST['mat_amount'][$mat_id]),
                                                'cgst_per' => trim($_POST['cgst_per'][$mat_id]),
                                                'cgst_amt' => trim($_POST['cgst_amt'][$mat_id]),
                                                'sgst_per' => trim($_POST['sgst_per'][$mat_id]),
                                                'sgst_amt' => trim($_POST['sgst_amt'][$mat_id]),
                                                'igst_per' => trim($_POST['igst_per'][$mat_id]),
                                                'igst_amt' => trim($_POST['igst_amt'][$mat_id]),
                                                'updated' => date('Y-m-d H:i:s'),
                                                'updated_by' => $this->user_id
                                            );

                                            $edit_material[] = $this->store_model->update_inward_items_details($update_inward_detail,$mat_id,$inward_id);
                                    }

                                    if(count($edit_material) > 0){
                                        $this->purchase_model->update_purchase_order_inward_material_flag($_POST['po_id']);

                                        $result = array(
                                            'status' => 'success',
                                            'message' => 'Items Update Successfully.',
                                            'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                            'myaction' => 'updated'
                                        );

                                    }else{
                                        $result = array(
                                            'status' => 'error',
                                            'message' => 'Error! items not inserted'
                                        );
                                    }
                                }else{
                                    $result = array(
                                            'status' => 'error',
                                            'message' => 'Error! Inward not saved'
                                    );
                                }
                          }else{
                             $result = array(
                                    'status' => 'warning',
                                    'message' => 'Please Browse materials.',
                                    'myfunction' => 'store/save_inward_material' 
                             );
                          }
                        }  
                      } 
                  }else{
                    $result = array(
                        'status' => 'error',
                        'message' => 'POST ERROR'
                    );
                  }
                  echo json_encode($result);
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
                  // echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
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

                            if($req_id >0)
                            {
                                foreach ($_POST['mat_code'] as $mat_id => $val) {
                                    $req_mat[$mat_id]['mat_code'] = $val;
                                    $req_mat[$mat_id]['material_note'] = $_POST['mat_note'][$mat_id];
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
                                        'material_note' => $value['material_note'],
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
                                    $deleted = $this->store_model->delete_requisation_drafts($added_material);
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
                                        $req_mat[$mat_id]['material_note'] = $_POST['mat_note'][$mat_id];
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
                                            'material_note' => $value['material_note'],
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
                $dep_id = $_POST['dep_id'];
                if($table === 'draft')
                {
                    $mat_id = $_POST['id'];
                    $sess_dep_id = $this->dep_id;
                    $selected_materials = $this->store_model->get_selected_materials_draft(array('rdm.dep_id' => $dep_id,'rdm.mat_id' => $mat_id));
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
                  $dep_id = $_POST['dep_id'];

                  if(isset($_POST['detail_id']) && $_POST['detail_id'] > 0){
                      $id = $_POST['detail_id'];
                      $update_note = $this->store_model->update_note_material_req_details($material_note,$id);
                  }else{
                      $update_note = $this->store_model->update_note_material_draft($material_note,$mat_id,$dep_id);
                  }
                 
                  if($update_note){
                    $result = array(
                        'status' => 'success',
                        'mat_id' => $mat_id,
                        'material_note' => $material_note,
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

       public function material_inward(){
            $data = $this->global;
            $where = array('inward.inward_form' => 'material_inward_form', 'inward.is_deleted' => '0');

            $material_inward = $this->store_model->inward_items($where);

            $data['inward_materials'] = $material_inward;
            //echo "<pre>"; print_r($material_inward); echo "</pre>";
            echo $this->load->view('store/material_inward_layout',$data,true);
       }

       public function general_inward(){
             $data = $this->global;
             echo $this->load->view('store/general_inward_layout',$data,true);
       }

       public function add_inward_material_form($po_id = 0, $invoice_date = '', $invoice_number = 'INVOICE-', $chalan_date = '', $chalan_number = 'CHALAN-', $gate_entry_date = '', $gate_entry_no = 'GATE-', $grn_date = '', $grn_number = 'GRN-', $po_vendor_id = 0, $state_code = 0){
            $data = $this->global;

            /*$condition = array('po_type' => 'material_po', 'approval_flag' => 'approved');
            $po_list = $this->store_model->po_listing($condition);
            $data['po_list'] = $po_list;*/
            $suppliers = $this->purchase_model->get_supplier_listing();
            $data['suppliers'] = $suppliers;
            $data['submit_type'] = 'insert';
            $data['inward_id'] = 0;

            $data['invoice_date'] = $invoice_date;
            if(empty($invoice_date)){
                $data['invoice_date'] = date('d-m-Y');
            }

            $data['invoice_number'] = $invoice_number;
            $data['chalan_date'] = $chalan_date;

            if(empty($chalan_date)){
                $data['chalan_date'] = date('d-m-Y');
            }

            $data['chalan_number'] = $chalan_number;
            $data['gate_entry_date'] = $gate_entry_date;

            if(empty($gate_entry_date)){
                 $data['gate_entry_date'] = date('d-m-Y');
            }

            $data['gate_entry_no'] = $gate_entry_no;
            $data['grn_date'] = $grn_date;

            if(empty($grn_date)){
                $data['grn_date'] = date('d-m-Y');
            }


            $data['material_type'] = 'material_inward';
            $data['grn_number'] = $grn_number;
            $data['po_vendor_id'] = $po_vendor_id;
            $data['state_code'] = $state_code;
            $data['po_id'] = $po_id;
            $data['vendor_name'] = '';
            $data['purchase_order_list'] = '';
            if($po_vendor_id > 0){
                 $supplier_details = $this->purchase_model->get_supplier_details($po_vendor_id);    
                 $data['vendor_name'] = $supplier_details[0]['supp_firm_name'];

                 $where = array('supplier_id' => $po_vendor_id, 'approval_flag' => 'approved');
                 $purchase_orders = $this->purchase_model->get_purchase_order($where);
                 if(!empty($purchase_orders)){
                         $data['purchase_order_list'] = $purchase_orders;
                 }        
            }


            $unit_details = $this->purchase_model->get_unit_listing();
            $data['unit_list'] = $unit_details;

            $where = array('imd.po_id' => $po_id);
            $selected_purchase_order = $this->store_model->get_inward_material_details_draft($where);
            $data['purchase_order_details'] = $selected_purchase_order;

            echo $this->load->view('store/forms/add_inward_material_form',$data,true); 
       }


       public function edit_inward_material_form($variable = 'inward_id', $inward_id = 0){
           $data = $this->global;
           if($inward_id > 0){
                
                $data['inward_id'] = $inward_id;

                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details;

                $condition = array('inward.inward_id' => $inward_id, 'inward.is_deleted' => '0');
                $inward_material = $this->store_model->inward_items($condition);

                $data['inward_material'] = $inward_material;
                $data['submit_type'] = 'edit';

                $condition = array('inward_id' => $inward_id);
                $inward_material_details = $this->store_model->material_inward_details($condition);
               
                $data['inward_material_details'] = $inward_material_details;


                echo $this->load->view('store/forms/edit_inward_material_form',$data,true);
           }else{
                 echo $this->load->view('errors/html/error_404',$data,true);
           }
       }

       public function add_inward_general_form($po_id = 0, $invoice_date = '', $invoice_number = 'INVOICE-', $chalan_date = '', $chalan_number = 'CHALAN-', $gate_entry_date = '', $gate_entry_no = 'GATE-', $grn_date = '', $grn_number = 'GRN-', $po_vendor_id = 0, $state_code = 0, $po_cat_id = 0){
            $data = $this->global;

            $condition = array('po_type' => 'general_po', 'approval_flag' => 'approved', 'material_inward_po' => 'no');
            $po_list = $this->store_model->po_listing($condition);
            $data['po_list'] = $po_list;
            $data['material_type'] = 'general_inward';
            $data['submit_type'] = 'insert';
            $data['inward_id'] = 0;
           
            
            $data['invoice_date'] = $invoice_date;
            if(empty($invoice_date)){
                $data['invoice_date'] = date('d-m-Y');
            }

            $data['invoice_number'] = $invoice_number;
            $data['chalan_date'] = $chalan_date;

            if(empty($chalan_date)){
                $data['chalan_date'] = date('d-m-Y');
            }

            $data['chalan_number'] = $chalan_number;
            $data['gate_entry_date'] = $gate_entry_date;

            if(empty($gate_entry_date)){
                 $data['gate_entry_date'] = date('d-m-Y');
            }

            $data['gate_entry_no'] = $gate_entry_no;
            $data['grn_date'] = $grn_date;

            if(empty($grn_date)){
                $data['grn_date'] = date('d-m-Y');
            }

            $data['grn_number'] = $grn_number;
            $data['po_vendor_id'] = $po_vendor_id;
            $data['state_code'] = $state_code;
            $data['po_id'] = $po_id;
            $data['vendor_name'] = '';
            $data['po_cat_id'] = $po_cat_id;

            if($po_vendor_id > 0){
                 $supplier_details = $this->purchase_model->get_supplier_details($po_vendor_id);    
                 $data['vendor_name'] = $supplier_details[0]['supp_firm_name'];
            }
            $data['category_name'] = '';

            if($po_cat_id > 0){
                $category_details = $this->purchase_model->get_categories_details(array("cat_id"=>$po_cat_id));
                $data['category_name'] = $category_details[0]['cat_name'];
            }     

            $unit_details = $this->purchase_model->get_unit_listing();
            $data['unit_list'] = $unit_details;

            $where = array('imd.po_id' => $po_id);
            $selected_purchase_order = $this->store_model->get_inward_material_details_draft($where);

            //echo "<pre>"; print_r($selected_purchase_order); echo "</pre>";

            $data['purchase_order_details'] = $selected_purchase_order;

            echo $this->load->view('store/forms/add_inward_general_form',$data,true); 
       }

       public function get_vendor_assign_purchase_order(){
            if($this->validate_request()){
                if(!empty($_POST)){
                    $supplier_id = $_POST['vendor_id'];
                    $material_type = $_POST['material_type'];

                    if($material_type == 'material_inward'){
                        $where = array('supplier_id' => $supplier_id, 'po_type' => 'material_po', 'approval_flag' => 'approved', 'status' => 'non_completed');    
                    }else{
                        $where = array('supplier_id' => $supplier_id, 'approval_flag' => 'approved', 'status' => 'non_completed');
                    }

                    $purchase_orders = $this->purchase_model->get_purchase_order($where);

                    if(!empty($purchase_orders)){
                         $data['purchase_order_list'] = $purchase_orders;
                         echo $this->load->view('store/sub_views/purchase_order_options',$data,true); 
                    }else{
                        echo '';
                    }
                }
            }else{
                echo '';
            }
       }

       public function general_inward_vendor_details(){
                if($this->validate_request()){
                    if(!empty($_POST)){
                        $po_id = $_POST['po_id'];
                        $po_type = $_POST['po_type'];

                         $where = array('po_id' => $po_id, 'po_type' => $po_type, 'approval_flag' => 'approved');
                         $purchase_orders = $this->purchase_model->get_purchase_order($where);

                         //echo "<pre>"; print_r($purchase_orders); echo "</pre>";

                         $supplier_id = $purchase_orders[0]['supplier_id'];
                         $supplier_details = $this->purchase_model->get_supplier_details($supplier_id);

                         $cat_id = $purchase_orders[0]['cat_id'];
                         $category_details = $this->purchase_model->get_categories_details(array("cat_id"=>$cat_id));


                         $result = array(
                            'status' => 'success',
                            'supplier_id' => $supplier_details[0]['supplier_id'],
                            'supp_firm_name' => $supplier_details[0]['supp_firm_name'],
                            'cat_id' => $category_details[0]['cat_id'],
                            'cat_name' => $category_details[0]['cat_name']
                         );
                         echo json_encode($result);
                    }
                }else{
                     echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));   
                }
       }

       public function get_purchase_order(){
            $data = $this->global;
            if($this->validate_request()){
                if(!empty($_POST)){

                    $po_id = $_POST['po_id'];
                    $vendor_id = $_POST['vendor_id'];
                    $po_type = $_POST['po_type'];
                    $form_type = $_POST['form_type'];

                    $where = array('po_id' => $po_id, 'po_type' => $po_type, 'supplier_id' => $vendor_id, 'approval_flag' => 'approved');
                    $purchase_orders = $this->purchase_model->get_purchase_order($where);
                    $draft_material = array();
                    
                    $data['purchase_order_details'] = array();
                    if($form_type == 'edit'){
                        $where = array('iwd.po_id' => $purchase_orders[0]['po_id']);
                        $draft_materials = $this->store_model->material_inward_details($where);
                        if(!empty($draft_materials)){
                            foreach ($draft_materials as $key => $value) {
                                        array_push($draft_material, $value['mat_id']);
                            }
                        }
                    }else{
                        $where = array('imd.po_id' => $purchase_orders[0]['po_id']);
                        $draft_materials = $this->store_model->get_inward_material_details_draft($where);
                        if(!empty($draft_materials)){
                            foreach ($draft_materials as $key => $value) {
                                        array_push($draft_material, $value['mat_id']);
                            }
                        }
                    }

                    $condition = array('po.po_id' => $purchase_orders[0]['po_id']);
                    $purchase_order_details = $this->store_model->get_selected_po_material_details($condition, $draft_material);
                    //echo "<pre>"; print_r($purchase_order_details); echo "</pre>";

                    $data['purchase_order_details'] = $purchase_order_details;
                    echo $this->load->view('store/modals/sub_views/purchase_order_material_list',$data,true); 
                }else{
                   echo $this->load->view('errors/html/error_404',$data,true);  
                }
            }else{
               echo $this->load->view('errors/html/error_404',$data,true); 
            }
       }

       public function selected_purchase_order_details(){
            $data = $this->global;
            if($this->validate_request()){
                

                    $entityBody = file_get_contents('php://input', 'r');
                    $obj_arr = json_decode($entityBody);

                    $mat_id = explode(',', $obj_arr->mat_ids);
                    $action = $obj_arr->mat_ids;
                    $inward_id = $obj_arr->inward_id;
                    $po_id = $obj_arr->po_id;

                    $invoice_date = trim($obj_arr->invoice_date);

                    if(empty($obj_arr->invoice_number)){
                        $invoice_number = 'INVOICE-'; 
                    }else{
                        $invoice_number = str_replace('/','-',trim($obj_arr->invoice_number));
                    }

                    $chalan_date = trim($obj_arr->chalan_date);

                    if(empty($obj_arr->chalan_number)){
                         $chalan_number = 'CHALAN-';
                    }else{
                         $chalan_number = str_replace('/','-',trim($obj_arr->chalan_number));  
                    }

                    $gate_entry_date = trim($obj_arr->gate_entry_date);

                    if(empty($obj_arr->gate_entry_no)){
                         $gate_entry_no = 'GATE-';
                    }else{
                        $gate_entry_no = str_replace('/', '-', trim($obj_arr->gate_entry_no)); 
                    }
                    $grn_date = trim($obj_arr->grn_date);

                    if(empty($obj_arr->grn_number)){
                        $grn_number = 'GRN-';
                    }else{
                        $grn_number = str_replace('/', '-', trim($obj_arr->grn_number)); 
                    }

                    
                    $vendor_name = trim($obj_arr->vendor_name);
                    $po_vendor_id = $obj_arr->po_vendor_id;
                    $state_code = trim($obj_arr->state_code);


                    if($obj_arr->po_type == 'general_po'){
                           $category_name = trim($obj_arr->category_name);
                           $po_cat_id = trim($obj_arr->po_cat_id);
                    }

                     if($action == 'edit' && $inward_id > 0){

                     }else{
                         $purchase_order_details = $this->store_model->get_purchase_order_material_details($po_id,$mat_id);

                         $inward_draft_id = array();
                         foreach ($purchase_order_details as $key => $po_items) {
                                $inward_material_draft = array(
                                    'po_id' => $po_items->po_id,
                                    'mat_id' => $po_items->mat_id,
                                    'hsn_code' => $po_items->hsn_code,
                                    'unit_id' => $po_items->unit_id,
                                    'rate' => $po_items->rate,
                                    'po_qty' => $po_items->qty,
                                    'pre_rec_qty' => $po_items->received_qty,
                                    'received_qty' => 0,
                                    'rejected_qty' => 0,
                                    'discount_per' => $po_items->discount_per,
                                    'discount' => $po_items->discount,
                                    'mat_amount' => $po_items->mat_amount,
                                    'cgst_per' => $po_items->cgst_per,
                                    'cgst_amt' => $po_items->cgst_amt,
                                    'sgst_per' => $po_items->sgst_per,
                                    'sgst_amt' => $po_items->sgst_amt,
                                    'igst_per' => $po_items->igst_per,
                                    'igst_amt' => $po_items->igst_amt,
                                );
                              $inward_draft_id[] =  $this->store_model->insert_inward_material_draft($inward_material_draft);   
                         }
                     }

                      if(sizeof($inward_draft_id) > 0){

                        if($obj_arr->po_type == 'general_po'){
                            $result = array(
                                'status' => 'success',
                                'redirect' => 'store/add_inward_general_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'.$po_cat_id.'/'
                            );    
                        }else{
                            $result = array(
                                'status' => 'success',
                                'redirect' => 'store/add_inward_material_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'
                            );
                        }           
                      }
                echo json_encode($result);
            }else{
                echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
            }
       }

       public function load_purchase_order_details(){
             $data = $this->global;
             if($this->validate_request()){
                    $entityBody = file_get_contents('php://input', 'r');
                    $obj_arr = json_decode($entityBody);

                    $po_id = $obj_arr->po_id;

                    $invoice_date = trim($obj_arr->invoice_date);

                    if(empty($obj_arr->invoice_number)){
                        $invoice_number = 'INVOICE-'; 
                    }else{
                        $invoice_number = str_replace('/','-',trim($obj_arr->invoice_number));
                    }

                    $chalan_date = trim($obj_arr->chalan_date);

                    if(empty($obj_arr->chalan_number)){
                         $chalan_number = 'CHALAN-';
                    }else{
                         $chalan_number = str_replace('/','-',trim($obj_arr->chalan_number));  
                    }

                    $gate_entry_date = trim($obj_arr->gate_entry_date);

                    if(empty($obj_arr->gate_entry_no)){
                         $gate_entry_no = 'GATE-';
                    }else{
                        $gate_entry_no = str_replace('/', '-', trim($obj_arr->gate_entry_no)); 
                    }
                    $grn_date = trim($obj_arr->grn_date);

                    if(empty($obj_arr->grn_number)){
                        $grn_number = 'GRN-';
                    }else{
                        $grn_number = str_replace('/', '-', trim($obj_arr->grn_number)); 
                    }

                    $po_vendor_id = $obj_arr->po_vendor_id;
                    $state_code = trim($obj_arr->state_code);

                    if($obj_arr->po_type == 'general_po'){

                        $po_cat_id = $obj_arr->po_cat_id;

                        $result = array(
                                    'status' => 'success',
                                    'redirect' => 'store/add_inward_general_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'.$po_cat_id.'/'
                        );

                    }else{

                        $result = array(
                                    'status' => 'success',
                                    'redirect' => 'store/add_inward_material_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'
                        );

                   }

                    echo json_encode($result);
             }else{
                    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
             }
       }


       function remove_purchase_order_material(){
                if($this->validate_request()){
                    $entityBody = file_get_contents('php://input', 'r');
                    $obj_arr = json_decode($entityBody);

                    $po_id = $obj_arr->po_id;
                    $mat_id = $obj_arr->mat_id;

                    $invoice_date = trim($obj_arr->invoice_date);

                    if(empty($obj_arr->invoice_number)){
                        $invoice_number = 'INVOICE-'; 
                    }else{
                        $invoice_number = str_replace('/','-',trim($obj_arr->invoice_number));
                    }

                    $chalan_date = trim($obj_arr->chalan_date);

                    if(empty($obj_arr->chalan_number)){
                         $chalan_number = 'CHALAN-';
                    }else{
                         $chalan_number = str_replace('/','-',trim($obj_arr->chalan_number));  
                    }

                    $gate_entry_date = trim($obj_arr->gate_entry_date);

                    if(empty($obj_arr->gate_entry_no)){
                         $gate_entry_no = 'GATE-';
                    }else{
                        $gate_entry_no = str_replace('/', '-', trim($obj_arr->gate_entry_no)); 
                    }
                    $grn_date = trim($obj_arr->grn_date);

                    if(empty($obj_arr->grn_number)){
                        $grn_number = 'GRN-';
                    }else{
                        $grn_number = str_replace('/', '-', trim($obj_arr->grn_number)); 
                    }

                    $po_vendor_id = $obj_arr->po_vendor_id;
                    $state_code = trim($obj_arr->state_code);

                    if($this->store_model->remove_material_inward_draft($po_id,$mat_id)){

                        if($obj_arr->po_type == 'general_po'){

                            $po_cat_id = $obj_arr->po_cat_id;

                            $result = array(
                                'status' => 'success',
                                'redirect' => 'store/add_inward_general_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'.$po_cat_id.'/'
                            );
                        }else{
                            $result = array(
                                'status' => 'success',
                                'redirect' => 'store/add_inward_material_form/'.$po_id.'/'.$invoice_date.'/'.$invoice_number.'/'.$chalan_date.'/'.$chalan_number.'/'.$gate_entry_date.'/'.$gate_entry_no.'/'.$grn_date.'/'.$grn_number.'/'.$po_vendor_id.'/'.$state_code.'/'
                            );
                       }     
                    }else{
                             $result = array(
                                'status' => 'error',
                                'message' => 'Error in deletion'
                             );
                    }

                    echo json_encode($result);

                }else{
                    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
                }
       }

       public function set_quantity_requisation(){
            if(!empty($_POST)){
                  $quantity = $_POST['qty'];
                  $mat_id = $_POST['mat_id'];
                  $table = $_POST['table'];
                  $dep_id = $_POST['dep_id'];

                  $updated_qty = $this->store_model->set_quantity_requisation($quantity,$mat_id,$dep_id,$table);
                  if($updated_qty)
                  {
                    $result = array(
                      'status' => 'success',
                      'qty' => $quantity,
                      'mat_id' => $mat_id
                    );
                  }
         }else{

         }
            echo json_encode($result);  
       }

       public function update_units_requisation(){
            if(!empty($_POST)){
                  $unit_id = $_POST['unit_id'];
                  $mat_id = $_POST['mat_id'];
                  $table = $_POST['table'];
                  $dep_id = $_POST['dep_id'];
                  $unit = $this->store_model->update_units_requisation($unit_id,$mat_id,$dep_id,$table);

                  if($unit){
                     $result = array(
                        'status' => 'success'
                     ); 
                  }  
            }
               echo json_encode($result);
       }

       public function get_inward_material_details(){
            $data = $this->global;
            if($this->validate_request()){
                $entityBody = file_get_contents('php://input', 'r');
                $obj_arr = json_decode($entityBody);
                $inward_id = $obj_arr->inward_id;

                $condition = array('inward.inward_id' => $inward_id, 'inward.is_deleted' => '0');
                $inward_material = $this->store_model->inward_items($condition);

                $data['inward_material'] = $inward_material;

                $condition = array('inward_id' => $inward_id);
                $inward_material_details = $this->store_model->material_inward_details($condition);
               // echo "<pre>"; print_r($inward_material_details); echo "</pre>";
                $data['inward_material_details'] = $inward_material_details;


                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details; 

                echo $this->load->view('store/sub_views/inward_view_material_details',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
       }
}

?>