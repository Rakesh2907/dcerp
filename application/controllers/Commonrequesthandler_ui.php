<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Commonrequesthandler_ui extends CI_Controller {
  protected $global = array ();
	function __construct() {
      parent::__construct();
      $user_details = is_logged_in();

        if($user_details == 0){
          header('Location: /um/index.php/login');
        }else{
          $this->user_id =  $user_details['userId'];
          $this->dep_id = get_department($this->user_id);
          $this->global['access'] = json_decode($user_details['permissions']);
          $this->global['token'] = $user_details['token'];
        }
		  $this->load->model('common_model');	
      $this->load->model('purchase_model'); 
      $this->load->model('store_model');
      $this->load->model('user/user_model'); 
      $this->load->model('department_model');  
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

	public function sub_menu($parent_id,$sub_menu_id = null){
    $data = $this->global;
		$sub_menu_details = $this->common_model->get_sub_menu_details($parent_id);
		$menu_data = array();
		if(!empty($sub_menu_details)){
			foreach ($sub_menu_details as $key => $menu_val) {
				$menu_data[$key]['menu_id'] = $menu_val['menu_id'];
				$menu_data[$key]['parent_menu_id'] = $menu_val['parent_menu_id'];
				$menu_data[$key]['menu_name'] = $menu_val['menu_name'];
				$menu_data[$key]['menu_links'] = $menu_val['menu_links'];
				$menu_data[$key]['menu_icon'] = $menu_val['menu_icon'];
				$menu_data[$key]['sub_menu'] = $menu_val['sub_menu'];
			}
		}	
		$data['parent_id'] = $parent_id;
		$data['menu_details'] = $menu_data;
		echo $this->load->view('common/sub_views/sub_menu',$data,true);
	}

	//Get sub-categories using cat_id
	public function get_sub_categories(){
		 $entityBody = file_get_contents('php://input', 'r');
         $obj_arr = json_decode($entityBody);
         $this->load->model('purchase_model');
         $data = $this->global;
         $cat_id =  $obj_arr->cat_id;
         $sub_categories = $this->purchase_model->get_sub_categories_details(array("cat_id"=>$cat_id));
         if(!empty($sub_categories)){
         	$data['sub_cat'] = $sub_categories;
         	$data['cat_id'] = $cat_id;
         	echo $this->load->view('common/sub_views/sub_categories_options',$data,true);	
         }else{
         	echo '<option value="-1">Sub Categories</option>';//<option data-id="'.$cat_id.'">(+) Add New</option>';
         }

	}

	//Get category using cat_id
	public function get_category(){
		 $entityBody = file_get_contents('php://input', 'r');
         $obj_arr = json_decode($entityBody);
         $this->load->model('purchase_model');
         $cat_id =  $obj_arr->cat_id;
         $data = $this->global;
         $category_details = $this->purchase_model->get_categories_details(array("cat_id"=>$cat_id));
         if(!empty($category_details)){
         	$category = array(
         		'cat_id' => $cat_id,
         		'cat_code' => $category_details[0]['cat_code'],
         		'cat_name' => strtoupper($category_details[0]['cat_name']),
         		'cat_for' => $category_details[0]['cat_for'],
         		'cat_stockable' => $category_details[0]['cat_stockable'] 
         	);
         	echo json_encode($category);
         }else{

         }
    } 

    // get material code using autocomple
   public function get_mat_code(){
      if(!empty($_POST["keyword"])) {
          $keyword = $_POST["keyword"];
          $field = $_POST['field'];
          $this->load->model('purchase_model');
          $data = $this->global;
          $mat_code = $this->purchase_model->get_mat_code($keyword,$field);
          $data['mat_code'] = $mat_code; 
          echo $this->load->view('common/sub_views/mat_code_autocomplete',$data,true);   
      }
   }

   public function get_mat_name(){
        if(!empty($_POST["keyword"])) {
          $keyword = $_POST["keyword"];
          $field = $_POST['field'];
          $this->load->model('purchase_model');
          $data = $this->global;
          $mat_name = $this->purchase_model->get_mat_code($keyword,$field);
          $data['mat_name'] = $mat_name; 
          echo $this->load->view('common/sub_views/mat_name_autocomplete',$data,true);   
       }
   }


   public function get_mat_code_requisition(){
       if(!empty($_POST["keyword"])) {
          $keyword = $_POST["keyword"];
          $row_id = $_POST["row_id"];
          $mat_field = $_POST['field'];
          $this->load->model('purchase_model');
          $data = $this->global;
          $mat_code = $this->purchase_model->get_mat_code_name($keyword,$mat_field);
          if(!empty($mat_code)){
             $data['mat_code'] = $mat_code;
             $data['row_id'] = $row_id;
             echo $this->load->view('common/sub_views/mat_code_autocomplete_requisition',$data,true);   
          }else{

          } 
       }
   }

   public function get_mat_name_requisition(){
        if(!empty($_POST["keyword"])) {
          $keyword = $_POST["keyword"];
          $row_id = $_POST["row_id"];
          $mat_field = $_POST['field'];
          $this->load->model('purchase_model');
          $data = $this->global;
          $mat_name = $this->purchase_model->get_mat_code_name($keyword,$mat_field);
          if(!empty($mat_name)){
             $data['mat_name'] = $mat_name;
             $data['row_id'] = $row_id;
             echo $this->load->view('common/sub_views/mat_name_autocomplete_requisition',$data,true);   
          }else{

          } 
       }
   }


   // update drafts units
   public function update_units(){
       if(!empty($_POST)){
          $unit_id = $_POST['unit_id'];
          $mat_id = $_POST['mat_id'];
          $table = $_POST['table'];
          $dep_id = $this->dep_id;
          $unit = $this->common_model->update_unit($unit_id,$mat_id,$table);
          if($unit){
             $result = array(
                'status' => 'success'
             ); 
          }  
       }
       echo json_encode($result);
   }

   public function set_quantity(){
      if(!empty($_POST)){
          $quantity = $_POST['qty'];
          $mat_id = $_POST['mat_id'];
          $table = $_POST['table'];

          $updated_qty = $this->common_model->set_quantity($quantity,$mat_id,$table);
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

  public function set_require_date()
  {
       if(!empty($_POST)){
          $mat_id = $_POST['mat_id'];
          $dep_id = $_POST['dep_id'];

          $require_date = date('Y-m-d',strtotime(trim($_POST['require_date'])));
          $table = $_POST['table'];

          $update_date = $this->common_model->set_require_date($require_date,$mat_id,$dep_id,$table);
          if($update_date){
             $result = array(
               'status' => 'success',
               'require_date' => $require_date,
               'mat_id' => $mat_id
             );
          }
       }else{

       }
     echo json_encode($result);
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
        echo $this->load->view('store/modals/sub_views/sub_material_list',$data,true);
          
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
          $data['inward_data'] = $inward_material;

          if(!empty($sub_mat_bath_number_details)){
              $data['sub_mat_bath_number_details'] = $sub_mat_bath_number_details;
              echo $this->load->view('store/modals/sub_views/edit_sub_material_batch_number_list',$data,true);
          }else{
             echo $this->load->view('store/modals/sub_views/sub_material_batch_number_list',$data,true);
          }
      }else{
          echo $this->load->view('errors/html/error_404',$data,true);
      }
  }

  public function add_new_row(){
      $data = $this->global;

      if($this->validate_request()){
         $entityBody = file_get_contents('php://input', 'r');
         $obj_arr = json_decode($entityBody);
         $inward_id = $obj_arr->inward_id;
         $data['i'] = $row_id = $obj_arr->row;
         $data['inward_form_type'] = '';
         
           if(isset($inward_id)){
               $condition1 = array('inward.inward_id' => $inward_id, 'inward.is_deleted' => '0');
               $inward_material = $this->store_model->inward_items($condition1);
              //echo "<pre>"; print_r($inward_material); echo "<pre>";
               $data['inward_form_type'] = $inward_material[0]['inward_form'];
           }

         echo $this->load->view('store/modals/sub_views/add_new_row',$data,true);
      }else{
         echo $this->load->view('errors/html/error_404',$data,true);
      }
  }

  public function add_new_row_outward(){
      $data = $this->global;

       if($this->validate_request()){
           $entityBody = file_get_contents('php://input', 'r');
           $obj_arr = json_decode($entityBody);

           $form_type = $obj_arr->form_type;
           $data['mat_id'] = $mat_id = $obj_arr->mat_id;  
           $data['i'] = $row_id = $obj_arr->row;
           if($form_type == 'edit'){
              echo $this->load->view('store/sub_views/edit_new_row_outward',$data,true);
           }else{
              echo $this->load->view('store/sub_views/add_new_row_outward',$data,true);
           }   
       }else{
           echo $this->load->view('errors/html/error_404',$data,true);
       }
  }

 public function add_new_row_requisition(){
      $data = $this->global;
      if($this->validate_request()){
           $entityBody = file_get_contents('php://input', 'r');
           $obj_arr = json_decode($entityBody);

           $data['i'] = $obj_arr->row;
           $data['dep_id'] = $this->dep_id;

           $unit_details = $this->purchase_model->get_unit_listing();
           $data['unit_list'] = $unit_details;

           echo $this->load->view('store/sub_views/add_new_row_requisition',$data,true);           
      }else{
         echo $this->load->view('errors/html/error_404',$data,true);
      }
 }

  public function remove_batch_number(){
      if($this->validate_request()){
          $entityBody = file_get_contents('php://input', 'r');
          $obj_arr = json_decode($entityBody);

          if(isset($obj_arr->sub_mat_id) && $obj_arr->sub_mat_id > 0){
                $condition = array('batch_id'=>$obj_arr->batch_id,'sub_mat_id'=>$obj_arr->sub_mat_id,'mat_id'=>$obj_arr->mat_id,'inward_id'=>$obj_arr->inward_id,'po_id'=>$obj_arr->po_id, 'is_deleted'=> '0');
          }else{
                $condition = array('batch_id'=>$obj_arr->batch_id,'mat_id'=>$obj_arr->mat_id,'inward_id'=>$obj_arr->inward_id,'po_id'=>$obj_arr->po_id, 'is_deleted' => '0');
          }

          $remove_id = $this->common_model->remove_batch_number($condition);
          if($remove_id > 0){
                  $result = array(
                    'status' => 'success',
                    'message' => 'Removed',
                  );
              }
           echo json_encode($result);
      }else{
           echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
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
          //echo "<pre>"; print_r($inward_material); echo "</pre>";
          $data['inward_form_type'] = $inward_material[0]['inward_form'];
          $data['inward_data'] = $inward_material;

          if(!empty($mat_bath_number_details)){
             $data['mat_bat_number'] = $mat_bath_number_details;
             echo $this->load->view('store/modals/sub_views/edit_material_batch_list',$data,true);
          }else{
             echo $this->load->view('store/modals/sub_views/material_batch_list',$data,true);
          }
       }else{
          echo $this->load->view('errors/html/error_404',$data,true);
       }
  }

  public function session_expire_timeout(){
        if($this->validate_request()){
            $sess_expiration = $this->config->item("sess_expiration");
            $result = array('status' => 'success', 'sess_expire' => $sess_expiration);
            echo json_encode($result);
        }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }
  }

  public function check_notification(){
        if($this->validate_request()){
            $login_user_id = $this->user_id;
            $where = array('not.notify_to' => $login_user_id, 'not.notify_check' => 'unseen');
            $notifications = $this->common_model->get_notifications($where);
            if(!empty($notifications)){
                 $data['count_notification'] = sizeof($notifications);
                 $data['notifications_list'] = $notifications;
                 $data['login_user_id'] = $login_user_id; 
                 echo $this->load->view('common/sub_views/notifications_panal',$data,true);
            }else{
                echo '';
            }
        }else{
           echo $this->load->view('errors/html/error_404',$data,true);
        }
  }

  public function update_notifications(){
        if($this->validate_request()){
             $entityBody = file_get_contents('php://input', 'r');
             $obj_arr = json_decode($entityBody);

             $notify_id = $obj_arr->notify_id;

             $update_data = array(
                'notify_check' => 'seen'
             );

             $notify = $this->common_model->update_notifications($update_data,$notify_id);
             $result = array(
                'status' => 'success',
                'notify_id' => $notify
             );
             echo json_encode($result);
        }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }
  }


  public function under_maintenance(){
        if($this->validate_request()){
            $login_user_id = $this->user_id;
            $users = $this->user_model->get_user_details($login_user_id);

            $result = array(
              'status' => 'success',
              'under_maintenance' => $users[0]['under_maintenance'],
              'name' => $users[0]['name']
            ); 
           echo json_encode($result);
        }else{
           echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }
  }

  public function check_date_differance(){
        if($this->validate_request()){
             $entityBody = file_get_contents('php://input', 'r');
             $obj_arr = json_decode($entityBody);
             $from_date = strtotime($obj_arr->from_date);
             $to_date = strtotime($obj_arr->to_date);

          if(!empty($from_date) && !empty($to_date))
          {   
             if($from_date > $to_date){
                $result = array(
                    'status' => 'error',
                    'message' => "Error ! 'From' date should be less than 'To' date."
                );
             }else{
                $result = array(
                  'status' => 'success',
                );
             }
          }else{
              $result = array(
                      'status' => 'error',
                      'message' => "Error ! 'From date' and 'To date' is mandatory."
              );
          }   
             echo json_encode($result);
        }else{
             echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }
  }

  public function get_mat_details(){
        if($this->validate_request()){
             $entityBody = file_get_contents('php://input', 'r');
             $obj_arr = json_decode($entityBody);


             $mat_id = $obj_arr->mat_id;
             $material_details = $this->purchase_model->get_material_details(array("mat_id"=>$mat_id));

             if(!empty($material_details)){
                foreach ($material_details as $key => $value) {
                   $mat_val['mat_id'] = $value['mat_id'];
                   $mat_val['mat_code'] = $value['mat_code'];
                   $mat_val['mat_name'] = $value['mat_name'];
                }
                  $result = array(
                    "status" => "success",
                    "mat_data" => $mat_val
                  );
             }else{
                 $result = array(
                  "status" => "error",
                  "message" => "Material not found add in material master"
                 );
             }
             echo json_encode($result);
        }else{
            echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }
  }

  public function export_inward_excel_sheet(){
         $this->load->library('PHPExcel');
         $objPHPExcel = new PHPExcel();
         if(isset($_REQUEST))
         {
               $from_date = date('Y-m-d',strtotime($_REQUEST['from_date']));
               $to_date = date('Y-m-d',strtotime($_REQUEST['to_date']));

                if(!empty($from_date) && !empty($to_date))
                {
                      $where = array('inward.grn_date >=' => $from_date, 'inward.grn_date <=' => $to_date, 'iw.is_deleted' => '0');


                      $inward_list = $this->store_model->inward_details_listing_excel($where);

                     // echo "<pre>"; print_r($inward_list); echo "</pre>"; die;
                      $material_list = array();
                      if(!empty($inward_list))
                      {
                            foreach ($inward_list as $ikey => $list){

                                //echo "<pre>"; print_r($list); echo "</pre>";

                                $where1 = array('iwb.inward_id' => $list['inward_id'], 'iwb.mat_id' => $list['mat_id'], 'iwb.is_deleted' => '0');

                                $batch_list = $this->store_model->inward_batch_wise_listing($where1);

                                if(!empty($batch_list))
                                {
                                  foreach ($batch_list as $mykey => $batch) 
                                  {
                                      
                                      $mat_amount[$mykey] =  ($batch['accepted_qty'] * $list['rate']);

                                      if(isset($list['discount']) && !empty($list['discount'])){
                                           $mat_amount[$mykey] =  ($mat_amount[$mykey] - $list['discount']);  
                                      }

                                      if(isset($list['discount_per']) && !empty($list['discount_per'])){
                                          $minus_amt[$mykey] = (($list['discount_per']/100) * $mat_amount[$mykey]);
                                          $mat_amount[$mykey] = (float)$mat_amount[$mykey] - (float)$minus_amt[$mykey];
                                      }


                                      $cgst_amt[$mykey] = (($list['cgst_per']/100) * $mat_amount[$mykey]);
                                      $sgst_amt[$mykey] = (($list['sgst_per']/100) * $mat_amount[$mykey]);
                                      $igst_amt[$mykey] = (($list['igst_per']/100) * $mat_amount[$mykey]);

                                      $total_amount[$mykey] =  ($mat_amount[$mykey] + $cgst_amt[$mykey] + $sgst_amt[$mykey] + $igst_amt[$mykey]);

                                      if($batch['na_allowed'] == 'yes'){
                                          $batch['expire_date'] = 'NA';
                                      }else{
                                          $batch['expire_date'] = date('d-m-Y', strtotime($batch['expire_date']));
                                      }

                                        $material_list[$ikey][$mykey] = array(
                                          'grn_date' => date('d-m-Y', strtotime($list['grn_date'])),
                                          'mat_name' => $batch['mat_name'],
                                          'lot_number' => $batch['lot_number'],
                                          'batch_number' => $batch['batch_number'],
                                          'unit' => $list['unit'],
                                          'accepted_qty' => $batch['accepted_qty'],
                                          'expire_date' => $batch['expire_date'],
                                          'po_number' => $list['po_number'],
                                          'grn_number' => $list['grn_number'],
                                          'invoice_number' => $list['invoice_number'],
                                          'supp_firm_name' => $list['supp_firm_name'],
                                          'chalan_number' => $list['chalan_number'],
                                          'rate' => $list['rate'],
                                          'unit_amount' => $mat_amount[$mykey],
                                          'discount_per' => $list['discount_per'],
                                          'discount' => $list['discount'],
                                          'cgst_amt' => $cgst_amt[$mykey].'   ('.$list['cgst_per'].'%)',
                                          'sgst_amt' => $sgst_amt[$mykey].'   ('.$list['sgst_per'].'%)',
                                          'igst_amt' => $igst_amt[$mykey].'   ('.$list['igst_per'].'%)',
                                          'total_amt' => $total_amount[$mykey], 
                                          'name' => $list['name'],
                                          'qc_batch_remark' => $batch['qc_batch_remark'],
                                          'storage_temp' => $batch['storage_temp'],
                                          'stored_in' => $batch['stored_in'],
                                    );
                                  }// end batch list loop
                                }
                            }// end inward list loop
                      }

                    // echo "<pre>"; print_r($material_list); echo "</pre>"; 
                    //die;
                      $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A3', 'Sr.No.')
                        ->setCellValue('B3', 'GRN Date')
                        ->setCellValue('C3', 'Material Name')
                        ->setCellValue('D3', 'Serial No.')
                        ->setCellValue('E3', 'Batch No.')
                        ->setCellValue('F3', 'Unit')
                        ->setCellValue('G3', 'Accepted Qty')
                        ->setCellValue('H3', 'Expire Date')
                        ->setCellValue('I3', 'PO Number')
                        ->setCellValue('J3', 'GRN No.')
                        ->setCellValue('K3', 'Invoice No.')
                        ->setCellValue('L3', 'Supplier Name')
                        ->setCellValue('M3', 'Chalan No.')
                        ->setCellValue('N3', 'Rate')
                        ->setCellValue('O3', 'Unit Amount')
                        ->setCellValue('P3', 'Discount (%)')
                        ->setCellValue('Q3', 'Discount Amount')
                        ->setCellValue('R3', 'CGST Amount (%)')
                        ->setCellValue('S3', 'SGST Amount (%)')
                        ->setCellValue('T3', 'IGST Amount (%)')
                        ->setCellValue('U3', 'Total Amount')
                        ->setCellValue('V3', 'Received By')
                        ->setCellValue('W3', 'Remark')
                        ->setCellValue('X3', 'Storage Temp.')
                        ->setCellValue('Y3', 'Storage Location');
                }


               $default_border = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000'));

               $style_header = array(
                  'borders' => array('bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border),
                  'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9')),
                  'font' => array('bold' => true)
               );

              $style_row = array(
                  'borders' => array('bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border),
                  'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))
              );

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Y1');
                $objPHPExcel->getActiveSheet()->getCell('A1')->setValue('FROM Date: '.date('d/m/Y',strtotime($from_date)).' TO Date: '.date('d/m/Y',strtotime($to_date)));

                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:Y1')->applyFromArray($style_header);


                $objPHPExcel->getActiveSheet()->getStyle("A1:Y1")->getFont()->setSize(18);

                $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('B3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('C3')->applyFromArray($style_header)->getFont()->setSize(12); 
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('E3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('F3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('G3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('H3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('I3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('J3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('K3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('L3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('M3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('N3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('O3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('P3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('R3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('S3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('T3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('U3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('V3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('W3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('X3')->applyFromArray($style_header)->getFont()->setSize(12);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('Y3')->applyFromArray($style_header)->getFont()->setSize(12);

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);    
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(25);

                if(!empty($material_list)){
                   $cell_no = 4;
                   $ser_no = 1;

                   foreach($material_list as $key => $mynewdata)
                   {

                     foreach($mynewdata as $keyid => $data)
                     {
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell_no, $ser_no)->getStyle('A'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('B'.$cell_no, $data['grn_date'])->getStyle('B'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('C'.$cell_no, $data['mat_name'])
                            ->setCellValue('D'.$cell_no, $data['lot_number'])
                            ->setCellValue('E'.$cell_no, $data['batch_number']);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('F'.$cell_no, $data['unit'])->getStyle('F'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('G'.$cell_no, $data['accepted_qty'])->getStyle('G'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('H'.$cell_no, $data['expire_date'])->getStyle('H'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('I'.$cell_no, $data['po_number'])
                            ->setCellValue('J'.$cell_no, $data['grn_number'])
                            ->setCellValue('K'.$cell_no, $data['invoice_number'])
                            ->setCellValue('L'.$cell_no, $data['supp_firm_name'])
                            ->setCellValue('M'.$cell_no, $data['chalan_number'])
                            ->setCellValue('N'.$cell_no, $data['rate'])
                            ->setCellValue('O'.$cell_no, $data['unit_amount'])
                            ->setCellValue('P'.$cell_no, $data['discount_per'])
                            ->setCellValue('Q'.$cell_no, $data['discount']);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('R'.$cell_no, $data['cgst_amt'])->getStyle('R'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('S'.$cell_no, $data['sgst_amt'])->getStyle('S'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('T'.$cell_no, $data['igst_amt'])->getStyle('T'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)     
                            ->setCellValue('U'.$cell_no, $data['total_amt']);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('V'.$cell_no, $data['name'])->getStyle('V'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('W'.$cell_no, $data['qc_batch_remark'])->getStyle('W'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('X'.$cell_no, $data['storage_temp'])->getStyle('X'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)    
                            ->setCellValue('Y'.$cell_no, $data['stored_in'])->getStyle('Y'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $cell_no ++; 
                        $ser_no ++;  
                      }    
                   }
                }

         }
              //$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Inward_report_'.date("YmdHis").'.xlsx"');
              header('Cache-Control: max-age=0');
              // If you're serving to IE 9, then the following may be needed
              header('Cache-Control: max-age=1');

              // If you're serving to IE over SSL, then the following may be needed
              header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
              header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
              header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
              header ('Pragma: public'); // HTTP/1.0
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
              ob_end_clean();
              $objWriter->save('php://output');
              add_users_activity('Inward',$this->user_id,'Export Inward details');
              exit;
  }

  public function export_outward_excel_sheet(){
           $this->load->library('PHPExcel');
           $objPHPExcel = new PHPExcel();
          if(isset($_REQUEST))
          {
             $from_date = date('Y-m-d',strtotime($_REQUEST['from_date']));
             $to_date = date('Y-m-d',strtotime($_REQUEST['to_date']));
             $dep_id = $_REQUEST['dep_id'];

             if(!empty($from_date) && !empty($to_date))
             {
                $where = array('out.outward_date >=' => $from_date, 'out.outward_date <=' => $to_date, 'out.is_deleted' => '0');
                $department_name = 'ALL Department';
                if(!empty($dep_id))
                {
                  $dep_details = $this->department_model->get_department_details(array('dep_id' => $dep_id));
                  $department_name = $dep_details[0]['dep_name'];
                  $where['out.dep_id'] = $dep_id;
                }

                $material_batch_list = $this->store_model->outward_batch_wise_listing($where);

                //echo "<pre>"; print_r($material_batch_list); echo "</pre>"; die;

                $material_list = array();
                if(!empty($material_batch_list))
                {
                  foreach ($material_batch_list as $key => $batch_list) 
                  {
                      $where = array('id' => $batch_list['raised_by']);
                      $raised_by = $this->user_model->get_all_users($where);

                      $issued_by = $this->user_model->get_user_details($batch_list['issued_by']);

                      $mat_amount[$key] =  ($batch_list['outward_qty'] * $batch_list['rate']);

                      if(!empty($batch_list['discount'])){
                        $mat_amount[$key] =  ($mat_amount[$key] - $batch_list['discount']);  
                      }
                      
                      if(isset($batch_list['discount_per']) && !empty($batch_list['discount_per'])){
                         $minus_amt[$key] = (($batch_list['discount_per']/100) * $mat_amount[$key]);
                         $mat_amount[$key] = (float)$mat_amount[$key] - (float)$minus_amt[$key];
                      }


                      $cgst_amt[$key] = (($batch_list['cgst_amt_per']/100) * $mat_amount[$key]);

                      $sgst_amt[$key] = (($batch_list['sgst_amt_per']/100) * $mat_amount[$key]);

                      $igst_amt[$key] = (($batch_list['igst_amt_per']/100) * $mat_amount[$key]);

                      
                      $total_amount[$key] =  ($mat_amount[$key] + $cgst_amt[$key] + $sgst_amt[$key] + $igst_amt[$key]);

                      if($batch_list['expire_date'] == 'na'){
                          $batch_list['expire_date'] = 'na';
                      }else{
                          $batch_list['expire_date'] = date('d-m-Y', strtotime($batch_list['expire_date']));
                      }

                      $material_list[$key] = array(
                        'material_name' => $batch_list['mat_name'],
                        'material_code' => $batch_list['mat_code'],
                        'batch_number' =>  $batch_list['batch_number'],
                        'outward_date' => date('d-m-Y', strtotime($batch_list['outward_date'])),
                        'outward_qty' => $batch_list['outward_qty'],
                        'pack_size' => $batch_list['pack_size'],
                        'expire_date' => $batch_list['expire_date'],
                        'remark' => $batch_list['remark'],
                        'issued_by' => $issued_by[0]['name'],
                        'raised_by' => $raised_by[0]['name'],
                        'received_by' => $batch_list['received_by'],
                        'price_rate' => $batch_list['rate'],
                        'unit_price' => $mat_amount[$key],
                        'discount_per' => $batch_list['discount_per'],
                        'discount' => $batch_list['discount'],
                        'cgst_amt' => $cgst_amt[$key],
                        'sgst_amt' => $sgst_amt[$key],
                        'igst_amt' => $igst_amt[$key],
                        'total_amt' => $total_amount[$key],
                        'available_stocks' => $batch_list['stock_qty']
                      );
                  }
                }

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'Sr.No.')
                ->setCellValue('B3', 'Material Name')
                ->setCellValue('C3', 'Material Code')
                ->setCellValue('D3', 'Batch No.')
                ->setCellValue('E3', 'Date Of Outward')
                ->setCellValue('F3', 'Quantity')
                ->setCellValue('G3', 'Pack Size')
                ->setCellValue('H3', 'Expire Date')
                ->setCellValue('I3', 'Remark')
                ->setCellValue('J3', 'Issue By')
                ->setCellValue('K3', 'Raised By')
                ->setCellValue('L3', 'Received BY')
                ->setCellValue('M3', 'Price Rate')
                ->setCellValue('N3', 'Unit Price')
                ->setCellValue('O3', 'Discount (%)')
                ->setCellValue('P3', 'Discount')
                ->setCellValue('Q3', 'CGST Amount')
                ->setCellValue('R3', 'SGST Amount')
                ->setCellValue('S3', 'IGST Amount')
                ->setCellValue('T3', 'Total Amount')
                ->setCellValue('U3', 'Available Stocks');

           
            
               $default_border = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000'));

               $style_header = array(
                  'borders' => array('bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border),
                  'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9')),
                  'font' => array('bold' => true)
               );

              $style_row = array(
                  'borders' => array('bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border),
                  'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))
              );

            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:U1');
            $objPHPExcel->getActiveSheet()->getCell('A1')->setValue('FROM Date: '.date('d/m/Y',strtotime($from_date)).' TO Date: '.date('d/m/Y',strtotime($to_date)));

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:U1')->applyFromArray($style_header);


            $objPHPExcel->getActiveSheet()->getStyle("A1:U1")->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:U2');
            $objPHPExcel->getActiveSheet()->getCell('A2')->setValue('Department: '.$department_name);

            $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:U2')->applyFromArray($style_header);

            $objPHPExcel->getActiveSheet()->getStyle("A2:U2")->getFont()->setSize(18);

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('B3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('C3')->applyFromArray($style_header)->getFont()->setSize(12); 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('E3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('H3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('I3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('J3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('K3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('L3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('M3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('N3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('O3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('P3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('R3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('S3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('T3')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('U3')->applyFromArray($style_header)->getFont()->setSize(12);


            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);    
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);

             if(!empty($material_list)){
                  $cell_no = 4;
                  $ser_no = 1;
                 // echo "<pre>"; print_r($material_list);
                  $total_outward_mat_price = 0;
                  $total_unit_price = 0;
                  $total_discount_percentage = 0;
                  $total_discount_amount = 0;
                  $total_cgst_amount = 0;
                  $total_sgst_amount = 0;
                  $total_igst_amount = 0;

                  foreach ($material_list as $key => $data) 
                  {
                      
                      $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$cell_no, $ser_no)
                            ->setCellValue('B'.$cell_no, $data['material_name'])
                            ->setCellValue('C'.$cell_no, $data['material_code'])
                            ->setCellValue('D'.$cell_no, $data['batch_number'])
                            ->setCellValue('E'.$cell_no, $data['outward_date'])
                            ->setCellValue('F'.$cell_no, $data['outward_qty'])
                            ->setCellValue('G'.$cell_no, $data['pack_size'])
                            ->setCellValue('H'.$cell_no, $data['expire_date'])
                            ->setCellValue('I'.$cell_no, $data['remark'])
                            ->setCellValue('J'.$cell_no, $data['issued_by'])
                            ->setCellValue('K'.$cell_no, $data['raised_by'])
                            ->setCellValue('L'.$cell_no, $data['received_by'])
                            ->setCellValue('M'.$cell_no, $data['price_rate'])
                            ->setCellValue('N'.$cell_no, $data['unit_price'])
                            ->setCellValue('O'.$cell_no, $data['discount_per'])
                            ->setCellValue('P'.$cell_no, $data['discount'])
                            ->setCellValue('Q'.$cell_no, $data['cgst_amt'])
                            ->setCellValue('R'.$cell_no, $data['sgst_amt'])
                            ->setCellValue('S'.$cell_no, $data['igst_amt'])
                            ->setCellValue('T'.$cell_no, $data['total_amt'])
                            ->setCellValue('U'.$cell_no, $data['available_stocks']);

                            $total_outward_mat_price = $total_outward_mat_price + $data['total_amt'];
                            $total_unit_price =  $total_unit_price + $data['unit_price'];
                            $total_discount_percentage = $total_discount_percentage + $data['discount_per'];
                            $total_discount_amount = $total_discount_amount + $data['discount']; 
                            $total_cgst_amount = $total_cgst_amount + $data['cgst_amt'];
                            $total_sgst_amount = $total_cgst_amount + $data['sgst_amt'];
                            $total_igst_amount = $total_igst_amount + $data['igst_amt'];

                       $cell_no ++; 
                       $ser_no ++;
                  }

                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$cell_no, 'TOTAL'); 
                /* $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$cell_no, $total_unit_price);
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$cell_no, $total_discount_percentage);
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$cell_no, $total_discount_amount);
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$cell_no, $total_cgst_amount);
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$cell_no, $total_sgst_amount);
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$cell_no, $total_igst_amount);*/
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$cell_no, $total_outward_mat_price);

                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('M'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12);
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('N'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12); 
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12); 
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('P'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12); 
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12);
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('R'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12);
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('S'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12);
                 $objPHPExcel->setActiveSheetIndex(0)->getStyle('T'.$cell_no)->applyFromArray($style_header)->getFont()->setSize(12);   
             }
             //die;
              $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="Material_outward_report_'.date("YmdHis").'.xlsx"');
              header('Cache-Control: max-age=0');
              // If you're serving to IE 9, then the following may be needed
              header('Cache-Control: max-age=1');

              // If you're serving to IE over SSL, then the following may be needed
              header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
              header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
              header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
              header ('Pragma: public'); // HTTP/1.0
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
              ob_end_clean();
              $objWriter->save('php://output');
              add_users_activity('Outward',$this->user_id,'Export Issue/Outward details');
              exit;

             }
          }   
  }


}
