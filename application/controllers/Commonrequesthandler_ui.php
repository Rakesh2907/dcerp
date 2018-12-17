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
         	echo '<option value="" onclick="add_sub_category('.$cat_id.')">(+) Add New</option>';
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
          $this->load->model('purchase_model');
          $data = $this->global;
          $mat_code = $this->purchase_model->get_mat_code($keyword);
          $data['mat_code'] = $mat_code; 
          echo $this->load->view('common/sub_views/mat_code_autocomplete',$data,true);   
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

         $data['i'] = $row_id = $obj_arr->row;

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

           $data['mat_id'] = $mat_id = $obj_arr->mat_id;  
           $data['i'] = $row_id = $obj_arr->row;
           echo $this->load->view('store/sub_views/add_new_row_outward',$data,true);
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

}
