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

        $pending_material_requisation_list = $this->store_model->pending_material_requisation_listing($sess_dep_id,$condition);
        $data['pending_material_requisation_list'] = $pending_material_requisation_list;

        $condition = array("approval_flag"=>'approved');
        $approved_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['approved_material_requisation_list'] = $approved_material_requisation_list;

        $condition = array("approval_flag"=>'completed');
        $completed_material_requisation_list = $this->store_model->material_requisation_listing($sess_dep_id,$condition);
        $data['completed_material_requisation_list'] = $completed_material_requisation_list;
        $data['form_type'] = 'material_req_form';
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

        $approval_assign = array(21,$sess_dep_id);
        $data['approval_assign_to'] = $dep_user_details = $this->department_model->get_user_details($approval_assign);
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


    public function compare_batch_po_qty(){
             if($this->validate_request()){
                if(!empty($_POST)){
                     $po_id = $_POST['mypo_id'];
                     $mat_id = $_POST['mymat_id'];
                     $where = array('po.po_id'=>$po_id, 'po.mat_id'=>$mat_id);
                     $selected_materials = $this->purchase_model->get_selected_po_material_details($where);
                     $po_qty = $selected_materials[0]['qty'];
                     $pre_rec_qty = $selected_materials[0]['received_qty'];

                     $calulated_qty = ($selected_materials[0]['qty'] - $selected_materials[0]['received_qty']);

                    // echo "<pre>";print_r($selected_materials);echo"</pre>"; //die;

                     $accepted_qty_count = array();

                      if($_POST['sub_mat_batch_list']){ 
                            if(isset($_POST['sub_mat_id']) && !empty($_POST['sub_mat_id']))
                            {
                                foreach ($_POST['sub_mat_id'] as $sub_mat_id => $value){
                                    $batch_number_array = array();
                                    foreach ($value as $row_batch_id => $val){
                                            if(isset($_POST['sub_mat_is_deleted'][$sub_mat_id][$row_batch_id])){
                                                   if(!$_POST['sub_mat_is_deleted'][$sub_mat_id][$row_batch_id]){
                                                        array_push($accepted_qty_count,$_POST['accepted_qty'][$sub_mat_id][$row_batch_id]);
                                                   }  
                                            }else{
                                                array_push($accepted_qty_count,$_POST['accepted_qty'][$sub_mat_id][$row_batch_id]);
                                            }
                                    }
                                }
                            }
                      }

                      if($_POST['mat_batch_list']){
                            $batch_number = array();
                            if(!empty($_POST['mat_bar_code'])){
                                foreach ($_POST['mat_bar_code'] as $key => $value) {
                                    if(isset($_POST['mat_is_deleted'][$key])){
                                        if(!$_POST['mat_is_deleted'][$key]){
                                            array_push($accepted_qty_count,$_POST['mat_accepted_qty'][$key]);
                                        }
                                    }else{
                                        array_push($accepted_qty_count,$_POST['mat_accepted_qty'][$key]);
                                    } 
                                }    
                            }   
                      }

                      if(!empty($accepted_qty_count)){
                            $entered_accepted_qty = array_sum($accepted_qty_count); 
                            
                            //echo $entered_accepted_qty.' > '.$calulated_qty; die;

                            if($entered_accepted_qty > $po_qty)
                            {

                                /*if($calulated_qty > 0){
                                    $msg = 'Error! Only '.$calulated_qty.' quantity required, for complete this material...!';
                                }else{
                                    $msg = 'This material PO quantity recieved';
                                }*/

                                $msg = 'Error!Accepted quantity greater then PO quantity.';

                                $result = array(
                                    'status' => 'error',
                                    'message'=> $msg
                                );
                            }/*else if($po_qty == $pre_rec_qty){
                                $msg = 'Error! this material accepted quantity match with PO quantity.';
                                $result = array(
                                    'status' => 'error',
                                    'message'=> $msg
                                );
                            }*/else{
                                 $result = array(
                                    'status' => 'success'
                                 );
                            }
                      }else{
                        $result = array(
                            'status'=>'error',
                            'message'=>'Error! Accepted quantity not found'
                        );
                      } 
                }else{
                    $result = array(
                            'status'=>'error',
                            'message'=> 'POST data not found'
                    );        
                }
                    echo json_encode($result);
             }else{
                    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));  
             }
    }
    public function save_batch_number(){
            $data = $this->global;
            if($this->validate_request()){
               if(!empty($_POST))
               {
                    //echo "<pre>"; print_r($_POST); echo "</pre>"; die;
                  $inward_id = $_POST['myinward_id'];
                  $mat_id = $_POST['mymat_id'];
                  $po_id = $_POST['mypo_id'];
                  $inward_form_type = $_POST['inward_form_type'];

                  $result = array();
                  $batch_id = array();
                  $accepted_qty_count = array();

                  if($_POST['sub_mat_batch_list']){     
                        if(isset($_POST['sub_mat_id']) && !empty($_POST['sub_mat_id']))
                        {    
                            foreach ($_POST['sub_mat_id'] as $sub_mat_id => $value) 
                            {
                                 $batch_number_array = array();

                                  $condition = array('mat_id'=>$_POST['mymat_id'], 'sub_mat_id'=> $sub_mat_id, 'inward_id'=>$_POST['myinward_id'], 'po_id' =>$_POST['mypo_id'], 'is_deleted'=>'0');

                                  if(sizeof($this->store_model->check_batch_number($condition)) > 0)
                                  {
                                         foreach ($value as $row_batch_id => $val) 
                                         {
                                            $batch_number_array['bar_code'] = trim($_POST['bar_code'][$sub_mat_id][$row_batch_id]);
                                            $batch_number_array['batch_number'] = trim($_POST['batch_no'][$sub_mat_id][$row_batch_id]);
                                            $batch_number_array['lot_number'] = trim($_POST['lot_no'][$sub_mat_id][$row_batch_id]);
                                            $batch_number_array['received_qty'] = trim($_POST['batch_received_qty'][$sub_mat_id][$row_batch_id]);
                                            $batch_number_array['accepted_qty'] = trim($_POST['accepted_qty'][$sub_mat_id][$row_batch_id]);

                                               if(!empty($_POST['expire_date'][$sub_mat_id][$row_batch_id])){
                                                    $batch_number_array['expire_date'] = date('Y-m-d',strtotime(trim($_POST['expire_date'][$sub_mat_id][$row_batch_id])));
                                               }else{
                                                    $batch_number_array['expire_date'] = NULL;
                                               }
                                               
                                               $batch_number_array['shipping_temp'] = trim($_POST['shipping_temp'][$sub_mat_id][$row_batch_id]);
                                               $batch_number_array['storage_temp'] = trim($_POST['storage_temp'][$sub_mat_id][$row_batch_id]);
                                               $batch_number_array['updated'] = date('Y-m-d H:i:s');
                                               $batch_number_array['updated_by'] = $this->user_id;
                                               $batch_number_array['is_deleted'] = $_POST['sub_mat_is_deleted'][$sub_mat_id][$row_batch_id];

                                               $where = array('batch_id'=> $row_batch_id, 'mat_id'=>$_POST['mymat_id'], 'sub_mat_id'=> $sub_mat_id, 'inward_id'=>$_POST['myinward_id'], 'po_id' =>$_POST['mypo_id'], 'is_deleted'=>'0');   

                                               $batch_id[] = $this->store_model->update_batch_number($batch_number_array,$where);

                                               if(!$_POST['sub_mat_is_deleted'][$sub_mat_id][$row_batch_id]){
                                                     array_push($accepted_qty_count,$batch_number_array['accepted_qty']);
                                               }
                                              
                                         } 
                                       // echo "<pre>"; print_r($batch_number_array);
                                  }else{

                                        $batch_number_array['mat_id'] = $_POST['mymat_id'];
                                        $batch_number_array['sub_mat_id'] = $sub_mat_id;
                                        $batch_number_array['inward_id'] = $_POST['myinward_id'];
                                        $batch_number_array['po_id'] = $_POST['mypo_id'];

                                        foreach ($value as $row_id => $val) {
                                               $batch_number_array['bar_code'] = trim($_POST['bar_code'][$sub_mat_id][$row_id]);
                                               $batch_number_array['batch_number'] = trim($_POST['batch_no'][$sub_mat_id][$row_id]);
                                               $batch_number_array['lot_number'] = trim($_POST['lot_no'][$sub_mat_id][$row_id]);
                                               $batch_number_array['received_qty'] = trim($_POST['batch_received_qty'][$sub_mat_id][$row_id]);
                                               $batch_number_array['accepted_qty'] = trim($_POST['accepted_qty'][$sub_mat_id][$row_id]);
                                               if(!empty($_POST['expire_date'][$sub_mat_id][$row_id])){
                                                  $batch_number_array['expire_date'] = date('Y-m-d',strtotime(trim($_POST['expire_date'][$sub_mat_id][$row_id])));
                                               }else{
                                                  $batch_number_array['expire_date'] = NULL;
                                               }
                                               
                                               $batch_number_array['shipping_temp'] = trim($_POST['shipping_temp'][$sub_mat_id][$row_id]);
                                               $batch_number_array['storage_temp'] = trim($_POST['storage_temp'][$sub_mat_id][$row_id]);
                                               $batch_number_array['created'] = date('Y-m-d H:i:s');
                                               $batch_number_array['created_by'] = $this->user_id;

                                               array_push($accepted_qty_count,$batch_number_array['accepted_qty']);
                                        }

                                        $batch_id[] = $this->store_model->save_batch_number($batch_number_array);
                                  }     
                                       
                            }//end sub_mat_id loop
                        }      
                    //echo "<pre>"; print_r($_POST); echo "</pre>";
                  }
                  if($_POST['mat_batch_list'])
                  { 
                       $inward_id = $_POST['myinward_id'];
                       $batch_number = array();
                       foreach ($_POST['mat_bar_code'] as $key => $value) {
                             $batch_number[$key]['bar_code'] = trim($_POST['mat_bar_code'][$key]);
                             $batch_number[$key]['batch_number'] = trim($_POST['mat_batch_no'][$key]);
                             $batch_number[$key]['lot_number'] = trim($_POST['mat_lot_no'][$key]);
                             $batch_number[$key]['received_qty'] = trim($_POST['mat_batch_received_qty'][$key]);
                             $batch_number[$key]['accepted_qty'] = trim($_POST['mat_accepted_qty'][$key]);
                             $batch_number[$key]['expire_date'] = date("Y-m-d",strtotime(trim($_POST['mat_expire_date'][$key])));
                             $batch_number[$key]['shipping_temp'] = trim($_POST['mat_shipping_temp'][$key]);
                             $batch_number[$key]['storage_temp'] = trim($_POST['mat_storage_temp'][$key]);
                             if(isset($_POST['mat_is_deleted'][$key])){
                                $batch_number[$key]['is_deleted'] = $_POST['mat_is_deleted'][$key];
                             }else{
                                $batch_number[$key]['is_deleted'] = '0';
                             }
                             
                       }

                       $condtion1 = array(
                                'mat_id'=> $_POST['mymat_id'],
                                'sub_mat_id'=> NULL,
                                'inward_id'=> $_POST['myinward_id'],
                                'po_id'=> $_POST['mypo_id'],
                                'is_deleted'=>'0'
                       );

                      $this->store_model->delete_batch_number($condtion1);
                      
                      foreach ($batch_number as $key => $val) 
                      {
                                        $mat_batch_number_array = array(
                                            'mat_id' => trim($_POST['mymat_id']),
                                            'inward_id' => trim($_POST['myinward_id']),
                                            'po_id' => trim($_POST['mypo_id']),
                                            'bar_code' => trim($val['bar_code']),
                                            'batch_number' => trim($val['batch_number']),
                                            'lot_number' => trim($val['lot_number']),
                                            'received_qty' => trim($val['received_qty']),
                                            'accepted_qty' => trim($val['accepted_qty']),
                                            'expire_date' =>  trim($val['expire_date']),
                                            'shipping_temp' => trim($val['shipping_temp']),
                                            'storage_temp' => trim($val['storage_temp']),
                                            'created' => date('Y-m-d H:i:s'),
                                            'created_by' => $this->user_id,
                                            'is_deleted' => $val['is_deleted']
                                        );
                                 $batch_id[] = $this->store_model->save_batch_number($mat_batch_number_array);

                                 if(!$val['is_deleted']){
                                      array_push($accepted_qty_count,$mat_batch_number_array['accepted_qty']);
                                 }     
                      } 
                           
                    } 

                    if(!empty($accepted_qty_count)){
                        $total_accepted_qty = array_sum($accepted_qty_count);

                        $where = array('inward_id'=>$inward_id, 'po_id'=>$po_id, 'mat_id'=>$mat_id);
                        $inward_details_update_data = array(
                          'received_qty' => $total_accepted_qty
                        );
                        $accepted_qty_updated = $this->store_model->update_inward_items_details($inward_details_update_data,$where);
                    }
                    
                   if(count($batch_id) > 0){

                      if($inward_form_type=='general_inward_form'){
                            $result = array(
                                     'status' => 'success',
                                     'message' => 'Batch/Lot Number Saved. Please Save Inward',
                                     'redirect' => 'store/edit_inward_general_form/inward_id/'.$inward_id
                            );
                          add_users_activity('General Inward',$this->user_id,'Saved Batch Number. Inward ID'.$inward_id);   
                      }else{
                            $result = array(
                                     'status' => 'success',
                                     'message' => 'Batch/Lot Number Saved. Please Save Inward',
                                     'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id
                            );
                          add_users_activity('Material Inward',$this->user_id,'Saved Batch Number. Inward ID'.$inward_id);  
                      }          
                   }else{
                             $result = array(
                               'status' => 'error',
                               'message' => 'Batch Number not saved..!'
                             ); 
                   } 
               }else{
                  $result = array(
                    'status' => 'error',
                    'message' => 'Post data not found'
                  );
               }
               echo json_encode($result);
            }else{
               echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));  
            }
       }

    
    public function update_stock_quantity($mat_id){
            $this->purchase_model->update_stock_quantity($mat_id);
    }   

    public function save_outward_material(){
        if($this->validate_request()){
            if(!empty($_POST))
            {   
                if($_POST['submit_type'] == 'insert'){
                    //echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

                    $outward_array = array(
                        'outward_date' => date('Y-m-d',strtotime(trim($_POST['outward_date']))),
                        'outward_number' => trim($_POST['outward_number']),
                        'dep_id' => $_POST['dep_id'],
                        'req_id' => $_POST['req_id'],
                        'raised_by' => $_POST['raised_by'],
                        'issued_by' => $_POST['issue_by'],
                        'form_type' => $_POST['outward_form'],
                        'created' => date("Y-m-d H:i:s"),
                        'created_by' => $this->user_id
                    );

                    $out_mat = array();
                    foreach ($_POST['mat_bar_code'] as $mat_id => $val) {
                        foreach ($val as $key => $value) {
                           $out_mat[$mat_id][$key]['bar_code'] = $_POST['mat_bar_code'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['batch_no'] = $_POST['mat_batch_no'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['lot_no'] = $_POST['mat_lot_no'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['pack_size'] = $_POST['mat_pack_size'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['outward_qty'] = $_POST['mat_outward_qty'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['expire_date'] = $_POST['mat_expire_date'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['remark'] = $_POST['mat_remark'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['stock_qty'] = $_POST['mat_stock_qty'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['batch_id'] = $_POST['mat_batch_id'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['sub_mat_id'] = $_POST['sub_mat_id'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['inward_id'] = $_POST['mat_inward_id'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['po_id'] = $_POST['mat_po_id'][$mat_id][$key];
                           $out_mat[$mat_id][$key]['inward_qty'] = $_POST['mat_inward_qty'][$mat_id][$key];
                        }
                    }

                    //echo "<pre>"; print_r($out_mat); echo "</pre>";

                    if(!empty($out_mat))
                    {
                        $outward_id = $this->store_model->insert_outward($outward_array);
                        if($outward_id > 0)
                        {
                            $add_mat = array();
                            $mat_ids = array();
                            foreach ($out_mat as $mat_id => $values)
                            {
                                 $outward_detail_array = array(
                                    'outward_id' => $outward_id,
                                    'mat_id' => $mat_id,
                                    'req_id' => $_POST['req_id'], 
                                    'quantity' => $_POST['mat_req_quantity'][$mat_id],
                                    'created' => date("Y-m-d H:i:s"),
                                    'created_by' => $this->user_id
                                 );
                                 $outward_detail_id =  $this->store_model->insert_outward_item_details($outward_detail_array);
                                 if($outward_detail_id > 0)
                                 {
                                     $today = strtotime(date('Y-m-d'));
                                     foreach ($values as $key => $outward_val) {
                                         $outward_mat_array = array(
                                            'outward_id' => $outward_id,
                                            'batch_id' => $outward_val['batch_id'],
                                            'mat_id' => $mat_id,
                                            'sub_mat_id' => $outward_val['sub_mat_id'],
                                            'inward_id' => $outward_val['inward_id'],
                                            'po_id' => $outward_val['po_id'],
                                            'req_id' => $_POST['req_id'],
                                            'bar_code' => trim($outward_val['bar_code']),
                                            'batch_number' => trim($outward_val['batch_no']),
                                            'lot_number' => trim($outward_val['lot_no']),
                                            'outward_qty' => trim($outward_val['outward_qty']),
                                            'expire_date' => date('Y-m-d',strtotime($outward_val['expire_date'])),
                                            'pack_size' => trim($outward_val['pack_size']),
                                            'remark' => trim($outward_val['remark']),
                                            'stock_qty'=> trim($outward_val['stock_qty']),
                                            'inward_qty' =>trim($outward_val['inward_qty']),
                                            'created' => date("Y-m-d H:i:s"),
                                            'created_by' => $this->user_id
                                         );

                                         $add_mat[] = $this->store_model->insert_outward_items_details_batchwise($outward_mat_array);

                                        $this->store_model->update_outward_quantity($outward_val['outward_qty'],$outward_val['inward_id'],$mat_id,$outward_val['batch_id']);
                                     }
                               }
                               $mat_ids[] = $mat_id;
                               $this->update_stock_quantity($mat_id); 
                            }

                            if(sizeof($mat_ids) > 0){
                                $this->update_outward_pre_received_qty($mat_ids,$_POST['req_id']);
                            }
                            if(sizeof($add_mat) > 0){
                                $outward_number = explode('/', $_POST['outward_number']);
                                $outward_number = $outward_number[2]+1;
                                $outward_number = 'Outward/'.date('Y').'/'.$outward_number;
                                $this->store_model->update_outward_number($outward_number);

                                $result = array(
                                    'status' => 'success',
                                    'message' => 'Outward items saved successfully',
                                    'redirect' => 'store/edit_batch_wise_outward_form/outward_id/'.$outward_id
                                );
                            }
                       }else{
                             $result = array(
                                'status' => 'error',
                                'message' => 'Outward records not saved. Please try again...!'
                             );
                       } 
                    }
                }else{
                    //echo 'edit';
                     //echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
                     $outward_id = $_POST['outward_id'];
                     $req_id = $_POST['req_id'];
                     $outward_array = array(
                        'raised_by' => $_POST['raised_by'],
                        'issued_by' => $_POST['issue_by'],
                        'updated' => date("Y-m-d H:i:s"),
                        'updated_by' => $this->user_id
                     );

                      $out_mat = array();
                      foreach ($_POST['mat_bar_code'] as $mat_id => $val) {
                            foreach ($val as $key => $value) {
                               $out_mat[$mat_id][$key]['bar_code'] = $_POST['mat_bar_code'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['batch_no'] = $_POST['mat_batch_no'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['lot_no'] = $_POST['mat_lot_no'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['pack_size'] = $_POST['mat_pack_size'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['outward_qty'] = $_POST['mat_outward_qty'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['expire_date'] = $_POST['mat_expire_date'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['remark'] = $_POST['mat_remark'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['stock_qty'] = $_POST['mat_stock_qty'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['batch_id'] = $_POST['mat_batch_id'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['sub_mat_id'] = $_POST['sub_mat_id'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['inward_id'] = $_POST['mat_inward_id'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['po_id'] = $_POST['mat_po_id'][$mat_id][$key];
                               $out_mat[$mat_id][$key]['inward_qty'] = $_POST['mat_inward_qty'][$mat_id][$key];


                               if(isset($_POST['mat_is_deleted'][$mat_id][$key])){
                                    $out_mat[$mat_id][$key]['is_deleted'] = $_POST['mat_is_deleted'][$mat_id][$key];
                               }else{
                                    $out_mat[$mat_id][$key]['is_deleted'] = '0';
                               }                               
                            }
                      }

                      if(!empty($out_mat))
                      {
                        $outward_id = $this->store_model->update_outward($outward_array,$outward_id);
                        if($outward_id > 0 && $this->store_model->delete_outward_item_details($outward_id))
                        {
                            $add_mat = array();
                            $mat_ids = array();
                            foreach ($out_mat as $mat_id => $values) 
                            {
                                 $outward_detail_array = array(
                                    'outward_id' => $outward_id,
                                    'mat_id' => $mat_id,
                                    'req_id' => $req_id,
                                    'quantity' => $_POST['mat_req_quantity'][$mat_id],
                                    'created' => date("Y-m-d H:i:s"),
                                    'created_by' => $this->user_id
                                 );
                                 $outward_detail_id =  $this->store_model->insert_outward_item_details($outward_detail_array);
                                 if($outward_detail_id > 0)
                                 {
                                     foreach ($values as $key => $outward_val) {
                                         $outward_mat_array = array(
                                            'outward_id' => $outward_id,
                                            'batch_id' => $outward_val['batch_id'],
                                            'mat_id' => $mat_id,
                                            'sub_mat_id' => $outward_val['sub_mat_id'],
                                            'inward_id' => $outward_val['inward_id'],
                                            'po_id' => $outward_val['po_id'],
                                            'req_id' => $req_id,
                                            'bar_code' => trim($outward_val['bar_code']),
                                            'batch_number' => trim($outward_val['batch_no']),
                                            'lot_number' => trim($outward_val['lot_no']),
                                            'outward_qty' => trim($outward_val['outward_qty']),
                                            'expire_date' => date('Y-m-d',strtotime($outward_val['expire_date'])),
                                            'pack_size' => trim($outward_val['pack_size']),
                                            'remark' => trim($outward_val['remark']),
                                            'stock_qty'=> trim($outward_val['stock_qty']),
                                            'inward_qty' =>trim($outward_val['inward_qty']),
                                            'created' => date("Y-m-d H:i:s"),
                                            'created_by' => $this->user_id,
                                            'is_deleted' => $outward_val['is_deleted']
                                         );

                                        // echo "<pre>"; print_r($outward_mat_array); echo "</pre>";
                                         $add_mat[] = $this->store_model->insert_outward_items_details_batchwise($outward_mat_array);

                                         if($outward_val['is_deleted']){
                                             $this->store_model->update_outward_quantity('0',$outward_val['inward_id'],$mat_id,$outward_val['batch_id']);
                                         }else{
                                             $this->store_model->update_outward_quantity($outward_val['outward_qty'],$outward_val['inward_id'],$mat_id,$outward_val['batch_id']);
                                         }
                                     }
                               }
                               $mat_ids[] = $mat_id;
                               $this->update_stock_quantity($mat_id); 
                            }
                            if(sizeof($mat_ids) > 0){
                                $this->update_outward_pre_received_qty($mat_ids,$req_id);
                            }

                            if(sizeof($add_mat) > 0){
                                $result = array(
                                    'status' => 'success',
                                    'message' => 'Outward items updated successfully',
                                    'redirect' => 'store/outward_batch_wise'
                                );
                            }
                       }else{
                             $result = array(
                                'status' => 'error',
                                'message' => 'Outward records not saved. Please try again...!'
                             );
                       } 
                    }

                }
            }else{
                $result = array(
                        'status' => 'error',
                        'message' => 'POST ERROR! POST Data not found'
                );
            }
            echo json_encode($result);
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
                             $result = array(); 
                             $files_obj = $_FILES["invoice_file"];
                             $uploadPath = 'upload/invoice';
                             $allowed = array(
                                      'pdf' => 'application/pdf',
                                      'jpeg' => 'image/jpeg',
                                      'png' => 'image/png'
                             );  
                             
                            // echo "<pre>"; print_r($files_obj); die;
                              if(isset($files_obj["error"]) && empty($files_obj["error"])){
                                      $ext = pathinfo($files_obj['name'], PATHINFO_EXTENSION);
                                      if(!array_key_exists($ext, $allowed)){
                                          $result = array(
                                                  'status' => 'error',
                                                  'message' => "Error [".$files_obj['name']."]: only PDF,PNG and JPEG files are allowed."
                                          );
                                         
                                      }else{
                                           $file_name = "invoice_".strtotime(date('Y-m-d')).'.'.$ext;
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
                                                  $insert_data['invoice_file'] = $this->config->item("upload_path").$file;
                                              }
                                      }
                              }else{
                                   $result = array(
                                                'status' => 'error',
                                                'message' => "Error! Need to upload invoice/bill file."
                                   );
                              }   


                       if(!empty($result)){  
                       }else{
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

                          if(isset($_POST['po_cat_id']) && !empty($_POST['po_cat_id']) && $_POST['inward_form']=='general_inward_form'){
                                $insert_data['cat_id'] = $_POST['po_cat_id'];
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

                                    $added_material[] = $this->store_model->insert_inward_items_details($insert_inward_detail);   
                                }

                                if(count($added_material) > 0){
                                        $deleted = $this->store_model->delete_inward_details_drafts($_POST['po_id']);
                                        $this->purchase_model->update_purchase_order_inward_material_flag($_POST['po_id']);
                                        if(isset($_POST['po_cat_id']) && !empty($_POST['po_cat_id']) && $_POST['inward_form']=='general_inward_form'){
                                            $result = array(
                                                'status' => 'success',
                                                'message' => 'Items Inserted Successfully.',
                                                'redirect' => 'store/edit_inward_general_form/inward_id/'.$inward_id,
                                                'myaction' => 'inserted'
                                             );
                                            add_users_activity('General Inward',$this->user_id,'Saved General Inward. Inward ID '.$inward_id);  
                                        }else if($_POST['inward_form']=='material_inward_form'){
                                            $result = array(
                                              'status' => 'success',
                                              'message' => 'Items Inserted Successfully.',
                                              'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                              'myaction' => 'inserted'
                                           );
                                            add_users_activity('Material Inward',$this->user_id,'Saved Material Inward. Inward ID '.$inward_id);
                                        }
                                        
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
                      }else{
                        
                            $result = array(); 

                            $po_id = $_POST['po_id'];
                            $inward_id =  $_POST['inward_id'];
                            $files_obj = $_FILES["invoice_file"];
                            //echo "<pre>"; print_r($_POST); echo "</pre>"; die;
                            
                            if(empty($_POST['inward_bill_file'])){
                                  $result = array(
                                                'status' => 'error',
                                                'message' => "Error! Need to upload invoice/bill file."
                                   );
                            }else{                            

                              $uploadPath = 'upload/invoice';
                              $allowed = array(
                                      'pdf' => 'application/pdf',
                                      'jpeg' => 'image/jpeg',
                                      'png' => 'image/png'
                              );  
                              //$files_obj = $_FILES["invoice_file"];

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

                          if(isset($_POST['po_cat_id']) && !empty($_POST['po_cat_id']) && $_POST['inward_form']=='general_inward_form'){
                                $update_data['cat_id'] = $_POST['po_cat_id'];
                          }

                          if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0){
                                $iwd = $this->store_model->update_inward($update_data,$inward_id);
                                if($iwd > 0)
                                {
                                    $mat_ids = array();
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

                                            $where = array('mat_id'=>$mat_id,'inward_id'=>$inward_id);
                                            $edit_material[] = $this->store_model->update_inward_items_details($update_inward_detail,$where);    
                                            $mat_ids[] = $mat_id;
                                            $this->update_stock_quantity($mat_id);    
                                    }
                                    if(sizeof($mat_ids) > 0){
                                        $this->update_pre_received_qty($mat_ids,$po_id);
                                    }

                                    if(count($edit_material) > 0)
                                    {
                                        $this->purchase_model->update_purchase_order_inward_material_flag($_POST['po_id']);
                                        if(isset($_POST['po_cat_id']) && !empty($_POST['po_cat_id']) && $_POST['inward_form']=='general_inward_form'){
                                              $result = array(
                                                'status' => 'success',
                                                'message' => 'Items Updated Successfully.',
                                                'redirect' => 'store/edit_inward_general_form/inward_id/'.$inward_id,
                                                'myaction' => 'inserted'
                                              );
                                              add_users_activity('General Inward',$this->user_id,'Updated General Inward. Inward ID '.$inward_id);
                                        }else if($_POST['inward_form']=='material_inward_form'){
                                            $result = array(
                                                'status' => 'success',
                                                'message' => 'Items Updated Successfully.',
                                                'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                                'myaction' => 'updated'
                                            );
                                           add_users_activity('Material Inward',$this->user_id,'Updated Material Inward. Inward ID '.$inward_id); 
                                       }  
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
                                    add_users_activity('Requisation',$this->user_id,'Requisation Records Inserted. Requisation ID '.$req_id); 
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
                                            add_users_activity('Requisation',$this->user_id,'Requisation Records Updated. Requisation ID '.$req_id);
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
                    $where1 = array($dep_id);
                    $data['requisation_given_by'] = $dep_user_details = $this->department_model->get_user_details($where1);   


                    $where2 = array($dep_id,21);
                    $data['approval_assign_to'] = $dep_user_details = $this->department_model->get_user_details($where2);
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
                    $data['login_user_id'] = $this->user_id;
                    $data['form_type'] = 'material_req_form';
                    if($sess_dep_id == 21){
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
                add_users_activity('Requisation',$this->user_id,'Requisation Status Changed. Requisation ID '.$req_id.' AND Status '.$status);
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
                $data['req_id'] = $req_id;
                $data['form_type'] = 'material_req_form';
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
                    add_users_activity('Requisation',$this->user_id,'Material Note Added. Material ID '.$mat_id);
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

             $where = array('inward.inward_form' => 'general_inward_form', 'inward.is_deleted' => '0');

             $general_inward = $this->store_model->inward_items($where);
             $data['general_materials'] = $general_inward;
             //echo "<pre>"; print_r($general_inward); echo "</pre>";
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
                $data['form_type'] = $inward_material[0]['inward_form'];
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

            $condition = array('po_type' => 'general_po', 'approval_flag' => 'approved', 'is_deleted' => '0');
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

       public function edit_inward_general_form($variable = 'inward_id', $inward_id = 0){
          $data = $this->global;

          if($inward_id > 0){
                $data['inward_id'] = $inward_id;

                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details;

                $condition = array('inward.inward_id' => $inward_id,'inward.is_deleted' => '0');
                $inward_material = $this->store_model->inward_items($condition);

                $data['inward_material'] = $inward_material;
                $data['submit_type'] = 'edit';
                $data['form_type'] = $inward_material[0]['inward_form'];
                if(isset($inward_material[0]['cat_id']) && !empty($inward_material[0]['cat_id'])){
                    $data['po_cat_id'] = $inward_material[0]['cat_id'];
                    $category_details = $this->purchase_model->get_categories_details(array("cat_id"=>$inward_material[0]['cat_id']));
                    $data['category_name'] = $category_details[0]['cat_name'];
                    //echo "<pre>"; print_r($category_details); die;
                }

                $condition = array('inward_id' => $inward_id);
                $inward_gmaterial_details = $this->store_model->material_inward_details($condition);
               
                $data['inward_material_details'] = $inward_gmaterial_details;
                echo $this->load->view('store/forms/edit_inward_general_form',$data,true);
          }else{
                echo $this->load->view('errors/html/error_404',$data,true);
          }

       }

       public function get_vendor_assign_purchase_order(){
            if($this->validate_request()){
                if(!empty($_POST)){
                    $supplier_id = $_POST['vendor_id'];
                    $material_type = $_POST['material_type'];

                    if($material_type == 'material_inward'){
                        $where = array('supplier_id' => $supplier_id, 'po_type' => 'material_po', 'approval_flag' => 'approved', 'status' => 'non_completed');    
                    }else{
                        $where = array('supplier_id' => $supplier_id, 'po_type' => 'general_po', 'approval_flag' => 'approved', 'status' => 'non_completed');
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
                    $inward_id = $_POST['inward_id'];

                    $where = array('po_id' => $po_id, 'po_type' => $po_type, 'supplier_id' => $vendor_id, 'approval_flag' => 'approved');
                    $purchase_orders = $this->purchase_model->get_purchase_order($where);
                    $draft_material = array();
                    
                    $data['purchase_order_details'] = array();
                    if($form_type == 'edit' && $inward_id > 0)
                    {
                        $where = array('iwd.po_id' => $purchase_orders[0]['po_id'], 'iwd.inward_id' => $inward_id);
                        $draft_materials = $this->store_model->material_inward_details($where);

                        //echo "<pre>"; print_r($draft_materials); echo "</pre>";

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
                    
                    if(!empty($purchase_order_details)){
                            foreach ($purchase_order_details as $key => $value) {
                                $mat_ids[] = $value['mat_id'];
                            }
                        $this->update_pre_received_qty($mat_ids,$po_id);
                    }

                    $data['purchase_order_details'] = $purchase_order_details;
                    echo $this->load->view('store/modals/sub_views/purchase_order_material_list',$data,true); 
                }else{
                   echo $this->load->view('errors/html/error_404',$data,true);  
                }
            }else{
               echo $this->load->view('errors/html/error_404',$data,true); 
            }
       }

       public function update_pre_received_qty($material=array(),$po_id){
            
            if(!empty($material))
            {
               foreach ($material as $key => $m_id) {
                         $condition = array('mat_id'=>$m_id, 'po_id'=>$po_id, 'accepted_qty !='=> 0,'is_deleted'=>'0');
                         $accepted_qty_count = $this->store_model->check_batch_number($condition);
                         if(!empty($accepted_qty_count)){
                              $count_acc_qty = 0;
                              foreach ($accepted_qty_count as $batch_key => $val){
                                if(is_numeric($val['accepted_qty'])){
                                    $count_acc_qty += $val['accepted_qty'];
                                }
                              }
                              if($count_acc_qty > 0){
                                  $this->purchase_model->purchase_order_details_update_pre_rec_qty($count_acc_qty,$po_id,$m_id);
                              }
                         }
               }
           }     

           $this->update_purchse_order_status($po_id); 
       } 

       public function update_outward_pre_received_qty($material=array(),$req_id){
            if(!empty($material)){
                foreach ($material as $key => $m_id) {
                     $condition = array('mat_id'=>$m_id, 'req_id'=>$req_id, 'outward_qty !='=> 0,'is_deleted'=>'0');
                     $outward_qty_count = $this->store_model->outward_batch_details($condition);

                     if(!empty($outward_qty_count)){
                         $count_owd_qty = 0;
                         foreach ($outward_qty_count as $batch_key => $val){
                             if(is_numeric($val['outward_qty'])){
                                 $count_owd_qty += $val['outward_qty'];
                             }
                         }

                         if($count_owd_qty > 0){
                             $this->store_model->material_requisition_details_update_pre_rec_qty($count_owd_qty,$req_id,$m_id);
                         }
                     }
                }
            }

           $this->update_material_requisation_status($req_id); 
       }

       public function update_purchse_order_status($po_id){
              $condition = array('po.po_id' => $po_id);
              $purchase_order_details = $this->purchase_model->get_selected_po_material_details($condition);
              $po_materials_count = sizeof($purchase_order_details);
              $po_material_rec_count = $this->purchase_model->compare_po_received_qunatity($po_id);

              if($po_materials_count == $po_material_rec_count){
                    $update_data = array('status' => 'completed');
                    $this->purchase_model->update_purchase_order($update_data,$po_id);
                    add_users_activity('Purchase Order',$this->user_id,'Purchase Status Updated. PO ID '.$po_id.' Status Completed');
              }else{
                    $update_data = array('status' => 'non_completed');
                    $this->purchase_model->update_purchase_order($update_data,$po_id);
              }
       }

       public function update_material_requisation_status($req_id){
            $condition = array('rdm.req_id' => $req_id);
            $requisation_details = $this->store_model->get_selected_req_material_details($condition);
            $req_material_count = sizeof($requisation_details);

            $req_material_rec_count = $this->store_model->compare_req_received_qunatity($req_id);

            if($req_material_count == $req_material_rec_count){
                $update_data = array('approval_flag' => 'completed');
                $this->store_model->update_material_requisation($update_data,$req_id);
                add_users_activity('Material Requisation',$this->user_id,'Material Requisation Status Updated. REQ ID '.$req_id.' Status Completed');
            }else{
                $update_data = array('approval_flag' => 'approved');
                $this->store_model->update_material_requisation($update_data,$req_id);
            }
       }

       public function selected_purchase_order_details(){
            $data = $this->global;
            if($this->validate_request()){
                

                    $entityBody = file_get_contents('php://input', 'r');
                    $obj_arr = json_decode($entityBody);

                   // echo "<pre>"; print_r($obj_arr); die;
                    $mat_id = explode(',', $obj_arr->mat_ids);
                    $action = $obj_arr->action;
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

                    $this->update_pre_received_qty($mat_id,$po_id);

                    if($action=='edit' && $inward_id > 0){
                         $purchase_order_details = $this->store_model->get_purchase_order_material_details($po_id,$mat_id);

                         $inward_details_id = array();
                         foreach ($purchase_order_details as $key => $po_items) {
                            $inward_details = array(
                               'inward_id' => $inward_id,
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

                            $inward_details_id[] = $this->store_model->insert_inward_items_details($inward_details);   
                         }

                         if(sizeof($inward_details_id) > 0){
                            if($obj_arr->po_type=='general_po'){
                                  $result = array(
                                      'status' => 'success',
                                      'redirect' => 'store/edit_inward_general_form/inward_id/'.$inward_id,
                                  );    
                            }else{
                                 $result = array(
                                      'status' => 'success',
                                      'redirect' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                 );
                            }
                         }else{}
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
                                    'igst_amt' => $po_items->igst_amt
                                );
                              $inward_draft_id[] =  $this->store_model->insert_inward_material_draft($inward_material_draft);   
                         }

                         if(sizeof($inward_draft_id) > 0){
                              if($obj_arr->po_type=='general_po')
                              {
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
                         }else{}
                     }

                echo json_encode($result); exit;
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

       public function department_material_requisition(){
            $data = $this->global;
            $entityBody = file_get_contents('php://input', 'r');
            $obj_arr = json_decode($entityBody);
            $dep_id = $obj_arr->dep_id;

            $condition = array("mr.approval_flag"=>'approved', "mr.dep_id" => $dep_id);
            $approved_material_requisation_list = $this->purchase_model->material_requisation_listing($condition);
            $data['approved_material_requisation_list'] = $approved_material_requisation_list;
            echo $this->load->view('store/sub_views/requisition_list',$data,true);
       }

       public function get_outward_requisation_materials_list(){
            $data = $this->global; 
            if(!empty($_POST))
            {
                $req_id = $_POST['req_id'];
                $submit_type = $_POST['form_type'];
                $outward_id = $_POST['outward_id'];

                $sess_dep_id = $this->dep_id;
                $dep_id = $this->store_model->requisation_departments($req_id);
                $dep_id = $dep_id[0]->dep_id;
                $departments = $this->department_model->get_department_listing();
                $req_details = $this->store_model->material_requisation_details($req_id);
                $data['requisation_details'] = $req_details;

                if($submit_type == 'edit'){
                    $where = array('owd.outward_id' => $outward_id, 'owd.is_deleted' => '0');
                    $outward_materials = $this->store_model->get_outward_material($where);
                    $selected_outward_material = array();
                    foreach ($outward_materials as $key => $value){
                        array_push($selected_outward_material, $value['mat_id']);
                    }
                    $where2 = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where2,array(),$selected_outward_material);
                    $data['selected_materials'] = $selected_materials;

                }else{
                    $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where);
                    $data['selected_materials'] = $selected_materials;
                } 

                $data['departments'] = $departments;
                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details; 
                $require_users = $this->user_model->get_all_users();
                $data['require_users'] = $require_users;
                $data['sess_dep_id'] = $sess_dep_id;
                $data['dep_id'] = $dep_id;

                echo $this->load->view('store/sub_views/outward_view_requisation_material_list',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
    }

       public function outward_batch_wise(){
             $data = $this->global;
             if($this->validate_request()){

                $outwards = $this->store_model->outward_listing();
                $data['outwards'] = $outwards;
                echo $this->load->view('store/outward_batch_wise_layout',$data,true);
             }else{
                echo $this->load->view('errors/html/error_404',$data,true);
             }
       }

       public function add_batch_wise_outward_form(){
            $data = $this->global;
            if($this->validate_request()){
                $sess_dep_id = $this->dep_id;
                $material_outward_number = $this->store_model->get_material_outward_number();

                //echo "<pre>"; print_r($material_outward_number); echo "</pre>";
                $data['outward_number'] = $material_outward_number[0]->outward_number;
                $departments = $this->department_model->get_department_listing();
                $data['departments'] = $departments;
                $data['submit_type'] = 'insert';
                $data['outward_id'] = 0;
                $data['issue_by'] = $dep_user_details = $this->department_model->get_user_details($sess_dep_id);
                $require_users = $this->user_model->get_all_users();
                $data['require_users'] = $require_users;
                $data['form_type'] = 'bachwise_outward_form';
                //echo "<pre>"; print_r($require_users); echo "</pre>";
                echo $this->load->view('store/forms/add_batch_wise_outward_form',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
       }

       public function edit_batch_wise_outward_form($variable='outward_id', $outward_id = 0){
                $data = $this->global;
                if($this->validate_request()){
                    $sess_dep_id = $this->dep_id;
                    $data['submit_type'] = 'edit';
                    $data['outward_id'] = $outward_id;
                    $where = array('outward_id' => $outward_id);
                    $outward_data = $this->store_model->outward_listing($where);
                    $data['outward_data'] = $outward_data;
                    $data['issue_by'] = $dep_user_details = $this->department_model->get_user_details($sess_dep_id);

                    $where = array('owd.outward_id' => $outward_id, 'owd.is_deleted' => '0');
                    $outward_materials = $this->store_model->get_outward_material($where);
                    $data['outward_materials'] = $outward_materials; 
                    $require_users = $this->user_model->get_all_users();
                    $data['require_users'] = $require_users;
                    $data['form_type'] = 'bachwise_outward_form';
                    echo $this->load->view('store/forms/edit_batch_wise_outward_form',$data,true);
                }else{
                    echo $this->load->view('errors/html/error_404',$data,true);
                } 
       }

       public function add_requisation_material_details(){
                $data = $this->global;
                if($this->validate_request()){
                    $entityBody = file_get_contents('php://input', 'r');
                    $obj_arr = json_decode($entityBody);

                    $req_id = $obj_arr->req_id;
                    $mat_id = $obj_arr->mat_ids;
                    $outward_id = $obj_arr->outward_id;

                    $dep_id = $this->store_model->requisation_departments($req_id);
                    $dep_id = $dep_id[0]->dep_id;

                    $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                    $where_in = explode(',', $mat_id);
                    $selected_materials = $this->store_model->get_selected_req_material_details($where,$where_in); 
                    if(!empty($selected_materials)){
                        foreach ($selected_materials as $key => $value) {
                                $insert_material = array(
                                    'outward_id' => $outward_id,
                                    'mat_id' => $value['mat_id'],
                                    'quantity'=> $value['require_qty'],
                                    'created' => date("Y-m-d H:i:s"),
                                    'created_by' => $this->user_id
                                );
                            $outward_detail_id[] = $this->store_model->insert_outward_item_details($insert_material);    
                        }

                        if(sizeof($outward_detail_id) > 0){
                            $result = array(
                                "status" => "success",
                                "redirect" => "store/edit_batch_wise_outward_form/outward_id/".$outward_id
                            );
                        }
                    }
                    echo json_encode($result);
                }else{
                    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
                }
       }

       public function get_requisation_material_details(){
             $data = $this->global;
             if($this->validate_request()){
                 $entityBody = file_get_contents('php://input', 'r');
                 $obj_arr = json_decode($entityBody);
                 $req_id = $obj_arr->req_id;
                 $mat_id = $obj_arr->mat_ids;

                 $dep_id = $this->store_model->requisation_departments($req_id);
                 $dep_id = $dep_id[0]->dep_id;

                 $departments = $this->department_model->get_department_listing();
                 $data['departments'] = $departments;

                 $unit_details = $this->purchase_model->get_unit_listing();
                 $data['unit_list'] = $unit_details; 
                 
                 $require_users = $this->user_model->get_all_users();
                 $data['require_users'] = $require_users;

                 $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                 $where_in = explode(',', $mat_id);
                 $selected_materials = $this->store_model->get_selected_req_material_details($where,$where_in); 
                 $data['selected_materials'] = $selected_materials; 

                //echo "<pre>"; print_r($selected_materials);echo "</pre>"; //die;
                 if($obj_arr->for_material == 'purchase'){  
                    $data['form_type'] = $obj_arr->form_type;    
                    echo $this->load->view('store/modals/sub_views/requisation_selected_material_list',$data,true);   
                 }else if($obj_arr->for_material == 'outward'){
                    echo $this->load->view('store/sub_views/add_outward_materials_details',$data,true);  
                 }
             }else{
                    echo $this->load->view('errors/html/error_404',$data,true);
             }
       }

       public function save_purchase_requisation(){
             $data = $this->global;
             if($this->validate_request()){
                if(!empty($_POST)){
                   $store_req_id = $_POST['store_req_id'];
                   $req_mat = array();
                   if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0)
                   {
                         foreach ($_POST['mat_code'] as $mat_id => $val) {
                                        $req_mat[$mat_id]['mat_code'] = $val;
                                        $req_mat[$mat_id]['dep_id'] = $_POST['dep_id'][$mat_id];
                                        $req_mat[$mat_id]['material_note'] = $_POST['material_note'][$mat_id];
                                        $req_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
                                        $req_mat[$mat_id]['require_date'] = date("Y-m-d",strtotime($_POST['require_date'][$mat_id]));
                                        $req_mat[$mat_id]['require_qty'] = $_POST['require_qty'][$mat_id];
                                        $req_mat[$mat_id]['require_users'] = $_POST['require_users'][$mat_id];         
                         }

                         //echo "<pre>"; print_r($req_mat); die;
                         $add_material = array();

                        $insert_purchase_requisation = array(
                            'req_id' => $store_req_id,
                            'purchase_approval_flag' => 'pending',
                            'created' => date('Y-m-d'),
                            'created_by' => $this->user_id
                        );

                         $pur_req_id = $this->store_model->insert_material_purchase_requisation($insert_purchase_requisation);

                         if($pur_req_id > 0){
                                foreach ($req_mat as $mat_id => $value) {
                                    $where = array('req_id'=> $store_req_id, 'mat_id'=> $mat_id, 'dep_id'=> $value['dep_id'], 'is_deleted' => '0');
                                    $this->store_model->update_requisation_send_purchase_flag($where);
                                }
                                $result = array(
                                       'status' => 'success',
                                       'message' => 'Material Requisation send to Purchase.',
                                       'myaction' => 'inserted'
                                );

                                add_users_activity('Material Outward',$this->user_id,'Material Requisation send to Purchase.');
                         }
                   }else{
                       $result = array(
                            "status" => "error",
                            "message" => "Material not found."
                       );  
                   }

                }else{
                    $result = array(
                        "status" => "error",
                        "message" => "Post value not found."
                    );
                }
                echo json_encode($result);
             }else{
                 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 
             }
       }

       public function get_batch_material_details(){
            $data = $this->global;
             if($this->validate_request()){
                 $entityBody = file_get_contents('php://input', 'r');
                 $obj_arr = json_decode($entityBody);
                
                
                 $mat_id = $obj_arr->mat_id;

                 if(isset($obj_arr->bar_code)){
                     $bar_code = $obj_arr->bar_code;
                     $condition = array('mat_id'=>$mat_id, 'bar_code'=>$bar_code, 'is_deleted'=>'0');
                 }

                 if(isset($obj_arr->batch_number)){
                     $batch_number = $obj_arr->batch_number;
                     $condition = array('mat_id'=>$mat_id, 'batch_number'=>$batch_number, 'is_deleted'=>'0');
                 }

                 if(isset($obj_arr->lot_number)){
                     $lot_number = $obj_arr->lot_number;
                     $condition = array('mat_id'=>$mat_id, 'lot_number'=>$lot_number, 'is_deleted'=>'0');
                 }

                
                 $batch_details = $this->store_model->check_batch_number($condition);
                 $mat_data = array();
                 if(!empty($batch_details)){
                    $today = date('Y-m-d');
                    $error = 0;
                    foreach ($batch_details as $key => $batch_val) 
                    {
                       
                            $mat_data[$key]['batch_id'] = $batch_val['batch_id'];
                            $mat_data[$key]['mat_id'] = $batch_val['mat_id'];
                            $mat_data[$key]['sub_mat_id'] = $batch_val['sub_mat_id'];
                            $mat_data[$key]['inward_id'] = $batch_val['inward_id'];
                            $mat_data[$key]['po_id'] = $batch_val['po_id'];
                            $mat_data[$key]['bar_code'] = $batch_val['bar_code'];
                            $mat_data[$key]['batch_number'] = $batch_val['batch_number'];
                            $mat_data[$key]['lot_number'] = $batch_val['lot_number'];
                            $mat_data[$key]['received_qty'] = $batch_val['received_qty'];
                            $mat_data[$key]['accepted_qty'] = $batch_val['accepted_qty'];
                            $mat_data[$key]['expire_date'] = date("d-m-Y",strtotime($batch_val['expire_date']));
                            if(strtotime($today) < strtotime($batch_val['expire_date'])){
                                $mat_data[$key]['expired_material'] = 'false';
                            }else{
                                $mat_data[$key]['expired_material'] = 'true';
                            }
                        
                    }
                         $result = array(
                            'status' => 'success',
                            'batch_data' => $mat_data
                         );
                   
                 }else{
                    $result = array(
                        'status' => 'error',
                        'message' => 'Material details not found. Please try again with another value...!'
                    );
                 }
                 echo json_encode($result);
             }else{
                echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
             }
       }

       public function remove_outward_material(){
             $data = $this->global;

             if($this->validate_request())
             {
                 $entityBody = file_get_contents('php://input', 'r');
                 $obj_arr = json_decode($entityBody);

                 $mat_id = $obj_arr->mat_id;
                 $outward_id = $obj_arr->outward_id;

                 $update_data = array('is_deleted' => '1');
                 $where = array('outward_id' => $outward_id, 'mat_id' => $mat_id);
                 $removed = $this->store_model->update_outward_material($update_data,$where);

                 if($removed){
                    $result = array(
                        'status' => 'success',
                        'redirect' => 'store/edit_batch_wise_outward_form/outward_id/'.$outward_id
                    );
                 }else{
                    $result = array(
                        'status' => 'error',
                        'message' => 'Error in deletion. Please try again.'
                    );
                 }
                 echo json_encode($result);
             }else{
                 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
             }
       }

       public function download_material_indent_form(){
             $data = $this->global;
             error_reporting(0);
             if($this->validate_request()){
                 $entityBody = file_get_contents('php://input', 'r');
                 $obj_arr = json_decode($entityBody);
                 $req_id = $obj_arr->req_id;
                
                 if($req_id > 0)
                 {
                        $dep_id = $this->store_model->requisation_departments($req_id);
                        $dep_id = $dep_id[0]->dep_id;

                        $req_details = $this->store_model->material_requisation_details($req_id);

                        $data['req_number'] = $req_number = $req_details[0]->req_number;
                        $data['req_date'] = date('d/m/Y',strtotime($req_details[0]->req_date));

                        $req_given_by = $this->user_model->get_user_details($req_details[0]->req_given_by);
                        $data['req_raised_by'] = $req_given_by[0]['name'];

                        $approval_assign_to = $this->user_model->get_user_details($req_details[0]->approval_assign_to);

                        $data['authorized_by'] = $approval_assign_to[0]['name'];

                        $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                        $selected_materials = $this->store_model->get_selected_req_material_details($where);
                        $data['indent_material'] = $selected_materials; 
                         //echo "<pre>"; print_r($selected_materials); echo "</pre>"; die;

                        $this->load->library('m_pdf');

                        $html=$this->load->view('store/templates/material_indent_form',$data, true);
                       // echo $html;
                        //die;
                        $req_number = str_replace("/", "_", strtolower($req_number));

                        $pdfFilePath = $req_number."-download.pdf";

                        $pdf = $this->m_pdf->load('A4-L');
                        //$pdf->SetHTMLHeader($this->load->view('store/templates/material_indent_header',$data, true),'OE');
                        $pdf->AddPage('L','', 1, 'i', 'on', 10, 10, 10, 10, 8, 2);
                        $pdf->SetHTMLFooter($this->load->view('store/templates/material_indent_footer',$data, true),'OE');
                        $pdf->WriteHTML($html,2);
                        //$pdf->WriteFixedPosHTML($html, 10, 50, 277, 210, 'auto');
                        $download_path = FCPATH.'download/'.$pdfFilePath;

                        $upload_path = $this->config->item("upload_path").'download/'.$pdfFilePath;
                        
                        $pdf->Output($download_path, "F");

                        $result = array(
                            "status"=>"success",
                            "path" => $upload_path
                        );
                        echo json_encode($result);
                 }
                
             }else{
                 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
             }
       }

}

?>