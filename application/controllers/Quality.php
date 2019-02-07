<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ERROR);

class Quality extends CI_Controller 
{
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
        $this->load->model('common_model');
        $this->load->model('purchase_model');	
        $this->load->model('store_model');
        $this->load->model('user/user_model');  
        $this->load->model('department_model');	
        $this->load->model('quality_model');	
        $this->scope = [];
        // Your own constructor code
    }

    public function index(){}

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

    public function grr_passing($from_grn_date=null, $to_grn_date=null, $vendor_id='0'){
    	    $suppliers = $this->purchase_model->get_supplier_listing();
            $data['suppliers'] = $suppliers;

            $from_date = date('Y-m-d',strtotime($from_grn_date));
            $to_date = date('Y-m-d',strtotime($to_grn_date));

            if(!empty($from_grn_date) && !empty($to_grn_date)){
                 $where = array('inward.inward_form' => 'material_inward_form', 'inward.is_deleted' => '0', 'inward.grn_date >=' => $from_date, 'inward.grn_date <=' => $to_date);

                if(!empty($vendor_id)){
                   $where['inward.vendor_id'] = $vendor_id; 
                }
            }else{
                $where = array('inward.inward_form' => 'material_inward_form', 'inward.is_deleted' => '0');
            }    

            $material_inward = $this->store_model->inward_items($where);

            $data['inward_materials'] = $material_inward;
            $data['fselected_from_grn_date'] = $from_grn_date;
            $data['fselected_to_grn_date'] = $to_grn_date;
            $data['vendor_id'] = $vendor_id;

    	  echo $this->load->view('quality/grr_passing_layout',$data,true);
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
                //echo "<pre>"; print_r($inward_material_details); echo "</pre>";
                $data['inward_material_details'] = $inward_material_details;


                $unit_details = $this->purchase_model->get_unit_listing();
                $data['unit_list'] = $unit_details; 

                echo $this->load->view('quality/sub_views/inward_view_material_details',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
    }

    public function view_inward_material_form($variable = 'inward_id', $inward_id = 0){
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
                
                //echo "<pre>"; print_r($inward_material); echo "</pre>";
                $data['inward_material_details'] = $inward_material_details;


                echo $this->load->view('quality/forms/view_inward_material_form',$data,true);
           }else{
                 echo $this->load->view('errors/html/error_404',$data,true);
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

                      if(isset($_POST['sub_mat_batch_list'])){ 
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

                      if(isset($_POST['mat_batch_list'])){
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
                            
                            if($entered_accepted_qty > $po_qty)
                            {
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
                  $inward_id = $_POST['myinward_id'];
                  $mat_id = $_POST['mymat_id'];
                  $po_id = $_POST['mypo_id'];
                  $inward_form_type = $_POST['inward_form_type'];

                  $result = array();
                  $batch_id = array();
                  $accepted_qty_count = array();

                  if(isset($_POST['sub_mat_batch_list']))
                  {     
                        if(isset($_POST['sub_mat_id']) && !empty($_POST['sub_mat_id']))
                        {    
                            foreach ($_POST['sub_mat_id'] as $sub_mat_id => $value) 
                            {
                                 $batch_number_array = array();

                                  $condition = array('mat_id'=>$_POST['mymat_id'], 'sub_mat_id'=> $sub_mat_id, 'inward_id'=>$_POST['myinward_id'], 'po_id' =>$_POST['mypo_id'], 'is_deleted'=>'0');

                                  if(sizeof($this->store_model->check_batch_number($condition)) > 0)
                                  {
                                         // echo "<pre>"; print_r($_POST); echo "</pre>"; die;
                                         foreach ($value as $row_batch_id => $val) 
                                         {
                                            //$batch_number_array['bar_code'] = trim($_POST['bar_code'][$sub_mat_id][$row_batch_id]);
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
                                               $batch_number_array['stored_in'] = trim($_POST['stored_in'][$sub_mat_id][$row_batch_id]);
                                               $batch_number_array['qc_batch_status'] = $_POST['qc_batch_status'][$sub_mat_id][$row_batch_id];
                                               $batch_number_array['qc_batch_remark'] = $_POST['qc_batch_remark'][$sub_mat_id][$row_batch_id];

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
                                  }     
                                       
                            }//end sub_mat_id loop
                        }      
                    //echo "<pre>"; print_r($_POST); echo "</pre>";
                  }

                 //echo "<pre>"; print_r($_POST); echo "</pre>"; die; 
                  if(isset($_POST['mat_batch_list']))
                  { 
                       $inward_id = $_POST['myinward_id'];
                       $batch_number = array();
                       foreach ($_POST['mat_bar_code'] as $batch_id => $value) {
                             $batch_number[$batch_id]['bar_code'] = trim($_POST['mat_bar_code'][$batch_id]);
                             $batch_number[$batch_id]['batch_number'] = trim($_POST['mat_batch_no'][$batch_id]);
                             $batch_number[$batch_id]['lot_number'] = trim($_POST['mat_lot_no'][$batch_id]);
                             $batch_number[$batch_id]['received_qty'] = trim($_POST['mat_batch_received_qty'][$batch_id]);
                             $batch_number[$batch_id]['accepted_qty'] = trim($_POST['mat_accepted_qty'][$batch_id]);

                             if(isset($_POST['mat_na'][$batch_id]) && $_POST['mat_na'][$batch_id] == 'on'){
                                $batch_number[$batch_id]['na_allowed'] = 'yes';
                                $batch_number[$batch_id]['expire_date'] = NULL;
                             }else{
                                $batch_number[$batch_id]['na_allowed'] = 'no';
                                $batch_number[$batch_id]['expire_date'] = date("Y-m-d",strtotime(trim($_POST['mat_expire_date'][$batch_id])));
                             }

                             
                             $batch_number[$batch_id]['shipping_temp'] = trim($_POST['mat_shipping_temp'][$batch_id]);
                             $batch_number[$batch_id]['storage_temp'] = trim($_POST['mat_storage_temp'][$batch_id]);
                             $batch_number[$batch_id]['stored_in'] = trim($_POST['mat_stored_in'][$batch_id]);
                             $batch_number[$batch_id]['qc_batch_status'] = $_POST['mat_qc_batch_status'][$batch_id];
                             $batch_number[$batch_id]['qc_batch_remark'] = $_POST['mat_qc_batch_remark'][$batch_id];

                             if(isset($_POST['mat_is_deleted'][$batch_id])){
                                $batch_number[$batch_id]['is_deleted'] = $_POST['mat_is_deleted'][$batch_id];
                             }else{
                                $batch_number[$batch_id]['is_deleted'] = '0';
                             }  
                       }
                       // echo "<pre>"; print_r($batch_number); echo "</pre>"; die;
                       /*$condtion1 = array(
                                'mat_id'=> $_POST['mymat_id'],
                                'sub_mat_id'=> NULL,
                                'inward_id'=> $_POST['myinward_id'],
                                'po_id'=> $_POST['mypo_id'],
                                'is_deleted'=>'0'
                       );*/

                      //$this->store_model->delete_batch_number($condtion1);
                      
                          foreach ($batch_number as $batch_id => $val) 
                          {
                                            $mat_batch_number_array = array(
                                                'accepted_qty' => trim($val['accepted_qty']),
                                                'expire_date' =>  trim($val['expire_date']),
                                                'na_allowed' =>  trim($val['na_allowed']),
                                                'shipping_temp' => trim($val['shipping_temp']),
                                                'storage_temp' => trim($val['storage_temp']),
                                                'stored_in' => trim($val['stored_in']),
                                                'qc_batch_status' => $val['qc_batch_status'],
                                                'qc_batch_remark' => $val['qc_batch_remark'],
                                                'updated' => date('Y-m-d H:i:s'),
                                                'updated_by' => $this->user_id
                                            );

                                   $condtion1 = array(
                                    'mat_id'=> $_POST['mymat_id'],
                                    'sub_mat_id'=> NULL,
                                    'inward_id'=> $_POST['myinward_id'],
                                    'po_id'=> $_POST['mypo_id'],
                                    'batch_id' => $batch_id,
                                    'is_deleted'=>'0'
                                  );          

                                    //$batch_id[] = $this->store_model->save_batch_number($mat_batch_number_array);
                                    $batch_id[] = $this->store_model->update_batch_number($mat_batch_number_array,$condtion1);

                                   if(!$val['is_deleted']){
                                          array_push($accepted_qty_count,$mat_batch_number_array['accepted_qty']);
                                   }     
                          } 
                           
                    } 

                    if(!empty($accepted_qty_count)){
                        $total_accepted_qty = array_sum($accepted_qty_count);

                        $where = array('inward_id'=>$inward_id, 'po_id'=>$po_id, 'mat_id'=>$mat_id);
                        $inward_details_update_data = array(
                            'qc_accepted_qty' => $total_accepted_qty
                        );
                        $accepted_qty_updated = $this->store_model->update_inward_items_details($inward_details_update_data,$where);
                    }
                    
                   if(count($batch_id) > 0){

                        $result = array(
                            'status' => 'success',
                            'message' => 'Batch/Lot Number quantity saved. After please click on Save button',
                            'redirect' => 'quality/view_inward_material_form/inward_id/'.$inward_id
                        );
                        add_users_activity('Quantity GRR Passing',$this->user_id,'Quantity checked Batch Number wise material. Inward ID'.$inward_id);  
                               
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


    public function get_sub_materials(){
       $data = $this->global;

      if($this->validate_request()){ 
        $entityBody = file_get_contents('php://input', 'r');
        $obj_arr = json_decode($entityBody);
        $mat_id = $obj_arr->mat_id;
        
        $condition = array('mat_id'=>$mat_id, 'is_deleted'=> '0');

        $sub_materials = $this->common_model->get_sub_materials($condition);
       
        $data['sub_materials'] = $sub_materials;
        echo $this->load->view('quality/modals/sub_views/sub_material_list',$data,true);   
      }else{
        echo $this->load->view('errors/html/error_404',$data,true);
      }  
  }

  
  public function get_batch_number(){
      $data = $this->global;
       if($this->validate_request()){
          $entityBody = file_get_contents('php://input', 'r');
          $obj_arr = json_decode($entityBody);

          $condition = array('mat_id'=>$obj_arr->mat_id,'inward_id'=>$obj_arr->inward_id,'po_id'=>$obj_arr->po_id, 'sub_mat_id'=>NULL, 'is_deleted' => '0');
          $mat_bath_number_details = $this->common_model->get_material_batch_number($condition); 
          
          $data['mat_id'] = $obj_arr->mat_id;
          $data['inward_id'] = $obj_arr->inward_id;
          $data['po_id'] = $obj_arr->po_id;
          $data['sess_dep_id'] = $this->dep_id;

          $condition1 = array('inward.inward_id' => $obj_arr->inward_id, 'inward.is_deleted' => '0');

          $inward_material = $this->store_model->inward_items($condition1);
          //echo "<pre>"; print_r($inward_material); echo "<pre>";
          $data['inward_form_type'] = $inward_material[0]['inward_form'];

          if(!empty($mat_bath_number_details)){
             $data['mat_bat_number'] = $mat_bath_number_details;
             echo $this->load->view('quality/modals/sub_views/edit_material_batch_list',$data,true);
          }
       }else{
          echo $this->load->view('errors/html/error_404',$data,true);
       }
  }

  public function sub_material_batch_mumber(){
      $data = $this->global;

      if($this->validate_request()){
          $entityBody = file_get_contents('php://input', 'r');
          $obj_arr = json_decode($entityBody);
          $mat_id = $obj_arr->mat_id;
          $sub_mat_id = $obj_arr->sub_mat_id;
          $inward_id = $obj_arr->inward_id;
          $po_id = $obj_arr->po_id;

          $condition = array('mat_id' => $mat_id,'sub_mat_id' => $sub_mat_id,'inward_id' => $inward_id,'po_id' => $po_id, 'is_deleted' => '0');
          $sub_mat_bath_number_details = $this->common_model->get_material_batch_number($condition);   

          $data['mat_id'] = $mat_id;
          $data['sub_mat_id'] = $sub_mat_id;
          $data['inward_id'] = $inward_id;
          $data['po_id'] = $po_id;

          $condition1 = array('inward.inward_id' => $obj_arr->inward_id, 'inward.is_deleted' => '0');

          $inward_material = $this->store_model->inward_items($condition1);
          //echo "<pre>"; print_r($inward_material); echo "<pre>";
          $data['inward_form_type'] = $inward_material[0]['inward_form'];


          if(!empty($sub_mat_bath_number_details)){
              $data['sub_mat_bath_number_details'] = $sub_mat_bath_number_details;
              echo $this->load->view('quality/modals/sub_views/edit_sub_material_batch_number_list',$data,true);
          }
      }else{
          echo $this->load->view('errors/html/error_404',$data,true);
      }
  }

  public function save_inward_material_qc(){
      if($this->validate_request()){
                  if(!empty($_POST))
                  {
                        $result = array(); 

                        //echo "<pre>"; print_r($_POST); echo "</pre>"; die;

                        $po_id = $_POST['po_id'];
                        $inward_id =  $_POST['inward_id'];
                               
                          $update_data['updated'] = date('Y-m-d H:i:s'); 
                          $update_data['updated_by'] = $this->user_id;
                          $update_data['total_amt'] = trim($_POST['total_amt']);
                          $update_data['total_cgst'] = trim($_POST['total_cgst']);
                          $update_data['total_sgst'] = trim($_POST['total_sgst']);
                          $update_data['total_igst'] = trim($_POST['total_igst']);
                          $update_data['freight_amt'] = trim($_POST['freight_amt']);
                          $update_data['other_amt'] = trim($_POST['other_amt']);
                          $update_data['total_bill_amt'] = trim($_POST['total_bill_amt']);
                          $update_data['quality_status'] = $_POST['quality_status'];
                          $update_data['rounded_amt'] = trim($_POST['rounded_amt']);
                         
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
                                                'qc_accepted_qty' => trim($_POST['qc_accepted_qty'][$mat_id]),
                                                'qc_remarks' => trim($_POST['qc_remarks'][$mat_id]),
                                                'discount_per' => trim($_POST['discount_per'][$mat_id]),
                                                'discount' => trim($_POST['discount'][$mat_id]),
                                                'mat_amount' => trim($_POST['mat_amount'][$mat_id]),
                                                'cgst_per' => trim($_POST['cgst_per'][$mat_id]),
                                                'cgst_amt' => trim($_POST['cgst_amt'][$mat_id]),
                                                'sgst_per' => trim($_POST['sgst_per'][$mat_id]),
                                                'sgst_amt' => trim($_POST['sgst_amt'][$mat_id]),
                                                'igst_per' => trim($_POST['igst_per'][$mat_id]),
                                                'igst_amt' => trim($_POST['igst_amt'][$mat_id]),
                                                'qc_debit_amt' => trim($_POST['qc_debit_amt'][$mat_id]),
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
                                        if($_POST['inward_form']=='material_inward_form')
                                        {
                                            $result = array(
                                                'status' => 'success',
                                                'message' => 'Saved Successfully.',
                                                'redirect' => 'quality/grr_passing',
                                                'myaction' => 'updated'
                                            );
                                           add_users_activity('QC Checked Inward Materials',$this->user_id,'Updated Material Inward. Inward ID '.$inward_id); 

                                          $user_details = $this->department_model->get_user_details(22);

                                          if(!empty($user_details)){
                                            if(empty($this->store_model->nofify_exist('inward_id',$inward_id,$this->user_id,'checked_inward_material'))){
                                                if($_POST['quality_status'] == 'check'){
                                                         foreach ($user_details as $key => $value) {
                                                                  $send_notification_array = array(
                                                                       'notify_from' => $this->user_id,
                                                                       'notify_to' => $value['id'],
                                                                       'message' => 'Material checked by Quality Manager',
                                                                       'modules' => 'material_inward_quality',
                                                                       'variable' => 'inward_id',
                                                                       'module_id' => $inward_id,
                                                                       'action' => 'checked_inward_material',
                                                                       'login_user_id' => $this->user_id,
                                                                       'redirect_url' => 'store/edit_inward_material_form/inward_id/'.$inward_id,
                                                                       'img_url' => $this->config->item("cdn_css_image").'dist/img/invoice.png'
                                                                  );
                                                                  set_new_notification($send_notification_array);   
                                                         }
                                                }        
                                              }   
                                          } 
                                           
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
                                    'myfunction' => 'quality/save_inward_material_qc' 
                             );
                          }   
                  }else{
                    $result = array(
                        'status' => 'error',
                        'message' => 'POST Data ERROR'
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


}