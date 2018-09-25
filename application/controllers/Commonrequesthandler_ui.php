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
          $require_date = date('Y-m-d',strtotime(trim($_POST['require_date'])));
          $table = $_POST['table'];

          $update_date = $this->common_model->set_require_date($require_date,$mat_id,$table);
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

}
