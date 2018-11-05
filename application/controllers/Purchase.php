<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 * Updated by Rakesh Ahirrao, October 2018
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ERROR);
class Purchase extends CI_Controller 
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
        $this->scope = [];
        // Your own constructor code
    }

	public function index(){
		$data = $this->global;
		echo $this->load->view('purchase/purchase_layout',$data,true);
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


	// Get unit listing using Data Table
	public function unit($value=''){
		 $data = $this->global;
		 $unit_details = $this->purchase_model->get_unit_listing();
		 if(!empty($unit_details)){
		 	$data['myunits'] = $unit_details;
		 	echo $this->load->view('purchase/unit_layout',$data,true);
	     }else{
	     	echo $this->load->view('errors/html/error_404',$data,true);
	     }		 
		 
	}

	// Get supplier lists.
	public function supplier($value=''){    
		 $data = $this->global;
		 $suppliers = $this->purchase_model->get_supplier_listing();

		 if(!empty($suppliers)){
		 	$data['mysuppliers'] = $suppliers;
		 	echo $this->load->view('purchase/supplier_layout',$data,true);
		 }else{
		 	echo $this->load->view('errors/html/error_404',$data,true);
		 }
		 	 
	}

	// Get Categories listing.
	public function category(){
		$data = $this->global;
		$where = array('is_deleted' => '0');
		$category = $this->purchase_model->get_category_listing($where);

		if(!empty($category)){
			$data['mycategory'] = $category;
			echo $this->load->view('purchase/category_layout',$data,true);
		}else{
			echo $this->load->view('errors/html/error_404',$data,true);
		}

	}

	// Get material listing.
	public function material($value=''){
		  $data = $this->global;
		  $where = array('m.is_deleted' => "0");
		  $material_list = $this->purchase_model->get_material_listing(false,$where);
		  $data['material_list'] = $material_list;
		  echo $this->load->view('purchase/material_layout',$data,true);
	}
	// Get supplier materials
	public function supplier_material($supplier_id){
		echo $supplier_id;
	}

	// Unit Form Layout
	public function add_unit_form(){
		$data = $this->global;
		echo $this->load->view('purchase/forms/add_unit_form',$data,true);
	}

	// Insert Units in database table.
	public function save_unit(){

		if($this->validate_request()){
			$post_obj = $_POST;
			if(isset($post_obj['unit']))
			{
				if(isset($post_obj['unit_id'])){
					$update_data = array(
						'unit' => $post_obj['unit'],
						'unit_description' => $post_obj['unit_description'],
						'updated' => date('Y-m-d H:i:s'),
						'updated_by' => $this->user_id
					);
					$this->purchase_model->update_unit($update_data,$post_obj['unit_id']);
					$result = array(
						'status' => 'success',
						'message' => 'Record Updated Successfully',
						'unit_id' => $post_obj['unit_id'],
						'redirect' => 'purchase/unit',
						'myaction' => 'updated'
					);
					echo json_encode($result);exit;
				}else{
					$insert_data['unit'] = trim($post_obj['unit']);
					$insert_data['unit_description'] = trim($post_obj['unit_description']);
					$insert_data['created'] = date('Y-m-d H:i:s');
					$insert_data['created_by'] = $this->user_id;

					$insert_unit_id = $this->purchase_model->insert_unit($insert_data);
					if($insert_unit_id > 0){
						$result = array(
							'status' => 'success',
							'message' => 'Record Added Successfully',
							'unit_id' => (int)$insert_unit_id, 
							'redirect' => 'purchase/unit',
							'myaction' => 'inserted'
						);
					}else{
						$result = array(
							'status' => 'error',
							'message' => 'Error! Not Added Record. Try again.'
						);
					}
					echo json_encode($result);exit;
			    } 		
			}else{
				$result = array(
							'status' => 'error',
							'message' => 'Error! Try again.'
			    );
			}
			 echo json_encode($result);exit;
		}else{
			 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
		}	
	}

	// Insert Supplier details in supplier table.
	public function save_supplier(){
	   if($this->validate_request()){	
			$post_obj = $_POST;
			//echo "<pre>"; print_r($post_obj); echo "</pre>"; exit;
			if($post_obj['submit_type'] == 'insert'){
				$insert_data['created'] = date('Y-m-d H:i:s');
				$insert_data['created_by'] = $this->user_id;
				$insert_data['supp_firm_name'] = trim($post_obj['supp_firm_name']);
				$insert_data['supp_contact_person'] = trim($post_obj['supp_contact_person']);
				$insert_data['supp_address'] = trim($post_obj['supp_address']);
				$insert_data['supp_contact_designation'] = trim($post_obj['supp_contact_designation']);
				$insert_data['supp_country'] = $post_obj['supp_country'];
				$insert_data['supp_state'] = $post_obj['supp_state'];
				$insert_data['supp_city'] = trim($post_obj['supp_city']);
				$insert_data['supp_pin'] = trim($post_obj['supp_pin']);
				$insert_data['supp_phone1'] = trim($post_obj['supp_phone1']);
				$insert_data['supp_phone2'] = trim($post_obj['supp_phone2']);
				$insert_data['supp_mobile'] = trim($post_obj['supp_mobile']);
				$insert_data['supp_mobile2'] = trim($post_obj['supp_mobile2']);
				$insert_data['supp_fax'] = trim($post_obj['supp_fax']);
				$insert_data['supp_email'] = trim($post_obj['supp_email']);
				$insert_data['supp_website'] = trim($post_obj['supp_website']);
				$insert_data['supp_description'] = trim($post_obj['supp_description']);
				$insert_data['dep_id'] = implode(',', $post_obj['dep_id']);

				$supplier_id = $this->purchase_model->insert_supplier($insert_data);
				if($supplier_id > 0){

					if(isset($post_obj['quo_req_id']))
					{ 
						if($post_obj['quo_req_id'] == '0'){
							$result = array(
								'status' => 'success',
								'message' => 'Vendor Added Successfully',
								'supplier_id' => $supplier_id,
								'redirect' => 'purchase/add_quotations_form/supplier_id/'.$supplier_id,
								'myaction' => 'inserted'
							);
						}else{
							$result = array(
							  'status' => 'success',
							  'message' => 'Vendor Added Successfully',
							  'supplier_id' => $supplier_id,
							  'redirect' => 'purchase/edit_supplier_form/'.$supplier_id,
							  'myaction' => 'inserted'
						      );
						}
					}else{
						$result = array(
							'status' => 'success',
							'message' => 'Vendor Added Successfully',
							'supplier_id' => $supplier_id,
							'redirect' => 'purchase/edit_supplier_form/'.$supplier_id,
							'myaction' => 'inserted'
						);	
					}	
					echo json_encode($result); exit;	
						//echo (int)$supplier_id;
				}else{
					$result = array(
						'status' => 'error',
						'message' => 'Error! Try again',
						'myfunction' => 'save_supplier'
					);
				  echo json_encode($result); exit;	
				}
			}else{
				$update_data['updated'] = date('Y-m-d H:i:s');
				$update_data['updated_by'] = $this->user_id;	
				$update_data['supp_firm_name'] = trim($post_obj['supp_firm_name']);
				$update_data['supp_contact_person'] = trim($post_obj['supp_contact_person']);
				$update_data['supp_address'] = trim($post_obj['supp_address']);
				$update_data['supp_contact_designation'] = trim($post_obj['supp_contact_designation']);
				$update_data['supp_country'] = $post_obj['supp_country'];
				$update_data['supp_state'] = $post_obj['supp_state'];
				$update_data['supp_city'] = trim($post_obj['supp_city']);
				$update_data['supp_pin'] = trim($post_obj['supp_pin']);
				$update_data['supp_phone1'] = trim($post_obj['supp_phone1']);
				$update_data['supp_phone2'] = trim($post_obj['supp_phone2']);
				$update_data['supp_mobile'] = trim($post_obj['supp_mobile']);
				$update_data['supp_mobile2'] = trim($post_obj['supp_mobile2']);
				$update_data['supp_fax'] = trim($post_obj['supp_fax']);
				$update_data['supp_email'] = trim($post_obj['supp_email']);
				$update_data['supp_website'] = trim($post_obj['supp_website']);
				$update_data['supp_description'] = trim($post_obj['supp_description']);
				$update_data['dep_id'] = implode(',', $post_obj['dep_id']);

				$this->purchase_model->update_supplier($update_data,$post_obj['supplier_id']);
				$result = array(
					 'status' => 'success',
					 'message' => 'Vendor Updated Successfully',
					 'supplier_id' => $post_obj['supplier_id'],
					 'redirect' => 'purchase/supplier',
					 'myaction' => 'updated'
				);
				echo json_encode($result);exit;
			}
		}else{
			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
		}	
	}

	// Insert sub-category
	public function save_sub_category(){
 
      if($this->validate_request()){

		$entityBody = file_get_contents('php://input', 'r');
		$obj_arr = json_decode($entityBody);
		$cat_id = $obj_arr->cat_id;

			if($cat_id > 0)
			{	
	                if(count($obj_arr->sub_cat_code) > 0 && count($obj_arr->sub_cat_name) > 0){
			            if(count($obj_arr->sub_cat_code) == count($obj_arr->sub_cat_name)){
			            			$sub_cat = array();
			            			for ($i = 0; $i < count($obj_arr->sub_cat_code); $i++) { 
			                           if(!empty($obj_arr->sub_cat_code[$i]) && !empty($obj_arr->sub_cat_name[$i])){
			                           		$sub_cat[$i]['sub_cat_code'] = $obj_arr->sub_cat_code[$i];
			            					$sub_cat[$i]['sub_cat_name'] = $obj_arr->sub_cat_name[$i];
			                           }
			            			}

			            			foreach ($sub_cat as $key => $value) {
			            				$insert_data['created'] = date('Y-m-d H:i:s');
						 				$insert_data['created_by'] = $this->user_id;
						 				$insert_data['cat_id'] = $cat_id;
						 				$insert_data['cat_code'] = trim($value['sub_cat_code']);
						 				$insert_data['cat_name'] = strtoupper(trim($value['sub_cat_name']));
						 				$insert_data['cat_for'] = trim($obj_arr->cat_for);
						 				$insert_data['cat_stockable'] = trim($obj_arr->cat_stockable);
						 				$sub_cat_id = $this->purchase_model->insert_sub_categories($insert_data);
			            			}

			            }
			        }
			       $result = array(
							'status' => 'success',
							'message' => 'Sub category Added Successfully',
							'sub_category_id' => (int)$sub_cat_id,
							'category_id' => $cat_id 
				   );
				  echo json_encode($result); exit;			
			    //echo (int)$sub_cat_id; 	
		    }else{
		    	$result = array(
		    		'status' => 'error',
		    		'message' => 'Error! Try again',
		    		'myfunction' => 'save_sub_category'
		    	);
		    	echo json_encode($result); exit;
		    }
	    }else{
	    	echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	    }
	}

	// Insert Material
	public function save_material(){
		if($this->validate_request())
		{
			$post_obj = $_POST;
			$sess_dep_id = $this->dep_id;
			if($post_obj['submit_type'] == 'insert')
			{
				 $exits = $this->purchase_model->check_mat_code(trim($post_obj['mat_code']));

				 if(count($exits) > 0){
					 	$result = array(
					 		'status' => 'warning',
					 		'message' => 'This Material already created.',
					 	);
                 }else{

				    $as_on_date = explode("/", $post_obj['as_on_date']);
				    $day = $as_on_date[0];
				    $month = $as_on_date[1];
				    $year = $as_on_date[2];
				    $full_date = $day.'-'.$month.'-'.$year;

				    $as_on_date = date("Y-m-d",strtotime($full_date));

					$insert_data['created'] = date('Y-m-d H:i:s');
					$insert_data['created_by'] = $this->user_id;
					$insert_data['unique_number'] = trim($post_obj['unique_number']);
					$insert_data['mat_code'] = trim($post_obj['mat_code']);
					$insert_data['mat_name'] = trim($post_obj['mat_name']);
					$insert_data['mat_details'] = trim($post_obj['mat_details']);
					$insert_data['mat_rate'] = trim($post_obj['mat_rate']);
					$insert_data['cat_id'] = trim($post_obj['cat_id']);
					$insert_data['sub_cat_id'] = trim($post_obj['sub_cat_id']);
					$insert_data['mat_parent_id'] = trim($post_obj['mat_parent_id']);
					$insert_data['parent_mat_code'] =trim($post_obj['parent_mat_code']);
					$insert_data['parent_mat_name'] =trim($post_obj['parent_mat_name']);
					$insert_data['unit_id'] = trim($post_obj['unit_id']);
					$insert_data['opening_stock'] = trim($post_obj['opening_stock']);
					$insert_data['current_stock'] = trim($post_obj['current_stock']);
					$insert_data['as_on_date'] = trim($as_on_date);
					$insert_data['minimum_level'] = trim($post_obj['minimum_level']);
					$insert_data['reorder_qty'] = trim($post_obj['reorder_qty']);
					$insert_data['mat_length'] = trim($post_obj['mat_length']);
					$insert_data['mat_weight'] = trim($post_obj['mat_width']);
					$insert_data['weight_unit_id'] = trim($post_obj['weight_unit_id']);
					$insert_data['location_id'] = trim($post_obj['location_id']);
					$insert_data['tolerance'] = trim($post_obj['tolerance']);
					$insert_data['length_unit_id'] = trim($post_obj['length_unit_id']);
					$insert_data['free_stock'] = trim($post_obj['free_stock']);
					$insert_data['mat_rate2'] = '0.000';
					$insert_data['prod_type'] = '';
					$insert_data['rejected_opening_qty'] = trim($post_obj['rejected_opening_qty']);
					$insert_data['rejected_current_qty'] = trim($post_obj['rejected_current_qty']);
					$insert_data['mat_status'] = trim($post_obj['mat_status']);
					$insert_data['scrape_opening_qty'] = trim($post_obj['scrape_opening_qty']);
					$insert_data['scrape_current_qty'] = trim($post_obj['scrape_current_qty']);
					$insert_data['transport'] = '0.00';
					$insert_data['mat_width'] = trim($post_obj['mat_width']);
					$insert_data['mat_thickness'] = trim($post_obj['mat_thickness']);
					$insert_data['packing'] = '';
					$insert_data['pack_size'] = trim($post_obj['pack_size']);
					$insert_data['no_of_reaction'] = trim($post_obj['no_of_reaction']);
					$insert_data['is_deleted'] = "0";

					//echo "<pre>"; print_r($insert_data); echo "</pre>"; exit;
					try {
						$material_id = $this->purchase_model->insert_material($insert_data);

					  	if($material_id > 0){
						  		$mat_id = array(
						  		     '0' => $material_id
						  		);
						  	   $this->purchase_model->update_unique_number($post_obj['unique_number']);
					  		     // assign new material to supplier.
						  	   if(isset($post_obj['supplier_id'])){

						  	   	   if($post_obj['supplier_id'] > 0){
					  		     	
					  		     	$assigned = $this->purchase_model->assign_material($mat_id,$post_obj['supplier_id']);
					  		     	$result = array(
					  		     		'redirect' => 'purchase/edit_supplier_form/'.$post_obj['supplier_id'].'/tab_2',
					  		     		'supplier_id' => $post_obj['supplier_id'],
					  		     		'material_id' => (int)$material_id,
					  		     		'status' => 'success',
					  		     		'message' => 'Material Added and Assign to Supplier Successfully'
					  		     	);
					  		      }else{
					  		      	   $result = array(
					  		    		'redirect' => 'purchase/edit_material_form/'.$material_id,
					  		    		'material_id' => (int)$material_id,
					  		    		'status' => 'success',
					  		    		'message' => 'Record Added Successfully'
					  		    	   ); 
					  		      }
						  	   }else if(isset($post_obj['req_id'])){ 
							  	   	if($post_obj['req_id'] == '0' && $post_obj['action'] == 'insert'){
						  		     	 $assigned = $this->store_model->selected_material_requisation($mat_id,$sess_dep_id);
						  		     	 $result = array(
						  		     	 	'redirect' => 'store/add_requisation_form',
						  		     	 	'material_id' => (int)$material_id,
						  		     	 	'status' => 'success',
						  		     	 	'message' => 'Material Added and Assign to Material Requisation'
						  		     	 );
						  		     }else if($post_obj['req_id'] != '0' && $post_obj['action'] == 'edit'){
					  		     	 	$req_id = $post_obj['req_id'];
					  		     	 	$assigned = $this->store_model->selected_material_requisation_details($mat_id,$sess_dep_id,$req_id);
						  		     	 $result = array(
						  		     	 	'redirect' => 'store/edit_requisation_form/req_id/'.$req_id,
						  		     	 	'material_id' => (int)$material_id,
						  		     	 	'status' => 'success',
						  		     	 	'message' => 'Material Added and Assign to Material Requisation'
						  		     	 );
					  		   		} 	 
					  		   }else if(isset($post_obj['quo_req_id'])){
					  		   		if($post_obj['quo_req_id'] == '0' && $post_obj['action'] == 'insert'){
					  		   			$assigned = $this->purchase_model->selected_material_quotation($mat_id,$sess_dep_id);
					  		   			$result = array(
						  		     	 	'redirect' => 'purchase/add_quotations_form',
						  		     	 	'material_id' => (int)$material_id,
						  		     	 	'status' => 'success',
						  		     	 	'message' => 'Material Added and Assign to Quotation Request'
						  		     	);
					  		   		}else if($post_obj['quo_req_id'] != '0' && $post_obj['action'] == 'edit'){

					  		   		}
					  		   }else{
					  		    	$result = array(
					  		    		'redirect' => 'purchase/edit_material_form/'.$material_id,
					  		    		'material_id' => (int)$material_id,
					  		    		'status' => 'success',
					  		    		'message' => 'Record Added Successfully'
					  		    	); 	
					  		   }

					  	}else{
					  		$result = array(
					  			'status' => 'error',
					  			'message' => 'Error! Try again'
					  		);
					  	} 
					 }catch (Exception $e) {
  							$result = array(
  								'status' => 'error',
  								'message' => $e->getMessage()
  							);
					 } 
				  }	 
				 echo json_encode($result);exit;
			}else{

				    $as_on_date = explode("/", $post_obj['as_on_date']);
				    $day = $as_on_date[0];
				    $month = $as_on_date[1];
				    $year = $as_on_date[2];
				    $full_date = $day.'-'.$month.'-'.$year;

				    $as_on_date = date("Y-m-d",strtotime($full_date));

				    $mat_id = $post_obj['mat_id'];

					$update_data['updated'] = date('Y-m-d H:i:s');
					$update_data['updated_by'] = $this->user_id;	
					$update_data['mat_code'] = trim($post_obj['mat_code']);
					$update_data['mat_name'] = trim($post_obj['mat_name']);
					$update_data['mat_details'] = trim($post_obj['mat_details']);
					$update_data['mat_rate'] = trim($post_obj['mat_rate']);
					$update_data['cat_id'] = trim($post_obj['cat_id']);
					$update_data['sub_cat_id'] = trim($post_obj['sub_cat_id']);
					$update_data['mat_parent_id'] = trim($post_obj['mat_parent_id']);
					$update_data['parent_mat_code'] =trim($post_obj['parent_mat_code']);
					$update_data['parent_mat_name'] =trim($post_obj['parent_mat_name']);
					$update_data['unit_id'] = trim($post_obj['unit_id']);
					$update_data['opening_stock'] = trim($post_obj['opening_stock']);
					$update_data['current_stock'] = trim($post_obj['current_stock']);
					$update_data['as_on_date'] = trim($as_on_date);
					$update_data['minimum_level'] = trim($post_obj['minimum_level']);
					$update_data['reorder_qty'] = trim($post_obj['reorder_qty']);
					$update_data['mat_length'] = trim($post_obj['mat_length']);
					$update_data['mat_weight'] = trim($post_obj['mat_width']);
					$update_data['weight_unit_id'] = trim($post_obj['weight_unit_id']);
					$update_data['location_id'] = trim($post_obj['location_id']);
					$update_data['tolerance'] = trim($post_obj['tolerance']);
					$update_data['length_unit_id'] = trim($post_obj['length_unit_id']);
					$update_data['free_stock'] = trim($post_obj['free_stock']);
					$update_data['mat_rate2'] = '0.000';
					$update_data['prod_type'] = '';
					$update_data['rejected_opening_qty'] = trim($post_obj['rejected_opening_qty']);
					$update_data['rejected_current_qty'] = trim($post_obj['rejected_current_qty']);
					$update_data['mat_status'] = trim($post_obj['mat_status']);
					$update_data['scrape_opening_qty'] = trim($post_obj['scrape_opening_qty']);
					$update_data['scrape_current_qty'] = trim($post_obj['scrape_current_qty']);
					$update_data['transport'] = '0.00';
					$update_data['mat_width'] = trim($post_obj['mat_width']);
					$update_data['mat_thickness'] = trim($post_obj['mat_thickness']);
					$update_data['packing'] = '';
					$update_data['pack_size'] = trim($post_obj['pack_size']);
					$update_data['no_of_reaction'] = trim($post_obj['no_of_reaction']);
					$update_data['is_deleted'] = "0";

					$this->purchase_model->update_material($update_data,$mat_id);
					$result = array(
					  		    		'redirect' => 'purchase/material',
					  		    		'material_id' => (int)$mat_id,
					  		    		'status' => 'success',
					  		    		'message' => 'Record Updated Successfully'
				    );
					echo json_encode($result); exit;
			}
		}else{
			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
		}	
	}

	// Insert category
	public function save_category()
	{
		if($this->validate_request())
		{
			$entityBody = file_get_contents('php://input', 'r');
            $obj_arr = json_decode($entityBody);
            if(!empty($obj_arr)){
            	if($obj_arr->submit_type == 'insert')
            	{
            		 $insert_data['created'] = date('Y-m-d H:i:s');
					 $insert_data['created_by'] = $this->user_id;
					 $insert_data['cat_code'] = trim($obj_arr->cat_code);
					 $insert_data['cat_name'] = strtoupper(trim($obj_arr->cat_name));
					 $insert_data['cat_for'] = trim($obj_arr->cat_for);
					 $insert_data['cat_stockable'] = trim($obj_arr->cat_stockable);
					 $cat_id = $this->purchase_model->insert_categories($insert_data);
   					 if($cat_id > 0)
   					 {	
                         if(count($obj_arr->sub_cat_code) > 0 && count($obj_arr->sub_cat_name) > 0){
		            		if(count($obj_arr->sub_cat_code) == count($obj_arr->sub_cat_name)){
		            			$sub_cat = array();
		            			for ($i = 0; $i < count($obj_arr->sub_cat_code); $i++) { 
		                           if(!empty($obj_arr->sub_cat_code[$i]) && !empty($obj_arr->sub_cat_name[$i])){
		                           		$sub_cat[$i]['sub_cat_code'] = $obj_arr->sub_cat_code[$i];
		            					$sub_cat[$i]['sub_cat_name'] = $obj_arr->sub_cat_name[$i];
		                           }
		            			}

		            			foreach ($sub_cat as $key => $value) {
		            				$insert_data['created'] = date('Y-m-d H:i:s');
					 				$insert_data['created_by'] = $this->user_id;
					 				$insert_data['cat_id'] = $cat_id;
					 				$insert_data['cat_code'] = trim($value['sub_cat_code']);
					 				$insert_data['cat_name'] = strtoupper(trim($value['sub_cat_name']));
					 				$insert_data['cat_for'] = trim($obj_arr->cat_for);
					 				$insert_data['cat_stockable'] = trim($obj_arr->cat_stockable);
					 				$sub_cat_id = $this->purchase_model->insert_sub_categories($insert_data);
		            			}
		            		}
		            	 }
		            	
		            	$result = array(
							'status' => 'success',
							'message' => 'Record Added Successfully',
							'category_id' => (int)$cat_id,
							'redirect' => 'purchase/edit_category_form/'.$cat_id,
							'myaction' => 'inserted'
					    );		
		            	echo json_encode($result); exit;
	            	 }else{
	            	 	$result = array(
	            	 		'status' => 'error',
	            	 		'message' => 'Error! Try again',
	            	 		'myaction' => 'inserted'
	            	 	);
	            	 	echo json_encode($result); exit;
	            	 }	
            	}else{
            			$update_data['updated'] = date('Y-m-d H:i:s');
						$update_data['created_by'] = $this->user_id;	
						$update_data['cat_code'] = trim($obj_arr->cat_code);
					 	$update_data['cat_name'] = strtoupper(trim($obj_arr->cat_name));
					 	$update_data['cat_for'] = trim($obj_arr->cat_for);
					 	$update_data['cat_stockable'] = trim($obj_arr->cat_stockable);
					 	$this->purchase_model->updated_categories($update_data,$obj_arr->cat_id);
					 	if($obj_arr->cat_id > 0){
					 			if($this->purchase_model->delete_sub_categories($obj_arr->cat_id))
					 			{
					 					if(count($obj_arr->sub_cat_code) > 0 && count($obj_arr->sub_cat_name) > 0){
							            		if(count($obj_arr->sub_cat_code) == count($obj_arr->sub_cat_name)){
							            			$sub_cat = array();
							            			for ($i = 0; $i < count($obj_arr->sub_cat_code); $i++) { 
							                           if(!empty($obj_arr->sub_cat_code[$i]) && !empty($obj_arr->sub_cat_name[$i])){
							                           		$sub_cat[$i]['sub_cat_code'] = $obj_arr->sub_cat_code[$i];
							            					$sub_cat[$i]['sub_cat_name'] = $obj_arr->sub_cat_name[$i];
							                           }
							            			}
							            			foreach ($sub_cat as $key => $value) {
							            				$insert_data['created'] = date('Y-m-d H:i:s');
										 				$insert_data['created_by'] = $this->user_id;
										 				$insert_data['cat_id'] = $obj_arr->cat_id;
										 				$insert_data['cat_code'] = trim($value['sub_cat_code']);
										 				$insert_data['cat_name'] = strtoupper(trim($value['sub_cat_name']));
										 				$insert_data['cat_for'] = trim($obj_arr->cat_for);
										 				$insert_data['cat_stockable'] = trim($obj_arr->cat_stockable);
										 				$sub_cat_id = $this->purchase_model->insert_sub_categories($insert_data);
							            			}

							            		}
		            	 			    }
					 			}
					 	}
						$result = array(
							'status' => 'success',
							'message' => 'Record Updated Successfully',
							'category_id' => (int)$obj_arr->cat_id,
							'redirect' => 'purchase/category',
							'myaction' => 'updated'
					    );		
		            	echo json_encode($result); exit;	
            	}
            }else{
            	$result = array(
	            	 		'status' => 'error',
	            	 		'message' => 'Error! Try again',
	            	 		'myaction' => 'no_field'
	            );
	            echo json_encode($result); exit;
            }
        }else{
        	echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }    
	}
	//Save Assign Material form details
	public function save_assign_material(){
      if($this->validate_request()){
		//echo "<pre>"; print_r($_POST); echo "</pre>";
		$sup_mat = array();
		$supplier_id = $_POST['supplier_id'];
		if(count($_POST['sup_mat_code']) > 0){
			foreach ($_POST['sup_mat_code'] as $mat_id => $val){
				$sup_mat[$mat_id]['sup_mat_code'] = $val;
				$sup_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
				$sup_mat[$mat_id]['mat_discount'] = trim($_POST['mat_discount'][$mat_id]);
				$sup_mat[$mat_id]['mat_rate'] = trim($_POST['mat_rate'][$mat_id]);
				$sup_mat[$mat_id]['credit_day'] = trim($_POST['credit_day'][$mat_id]);
				$sup_mat[$mat_id]['lead_time'] = trim($_POST['lead_time'][$mat_id]);
			}
			$updated = array();
			foreach ($sup_mat as $mat_id => $value) {
				 $update_data = array(
				 	 'sup_mat_code' => $value['sup_mat_code'],
				 	 'unit_id' => $value['unit_id'],
				 	 'mat_rate' => $value['mat_rate'],
				 	 'mat_discount' => $value['mat_discount'],
				 	 'credit_days' => $value['credit_day'],
				 	 'lead_time' => $value['lead_time'],
				 	 'updated' => date("Y-m-d H:i:s"),
				 	 'updated_by' => $this->user_id
				 );
				 $updated[] = $this->purchase_model->update_assign_material($update_data,$mat_id,$supplier_id);
			}

			$material_id = json_encode($updated);
			if(count($updated)){
				$result = array(
					'status' => 'success',
					'message' => 'Records updated Successfully',
					'material_id' => $material_id,
					'redirect' => 'purchase/edit_supplier_form/'.$supplier_id.'/tab_2',
					'myaction' => 'updated'
				);
			}else{

			}
			echo json_encode($result);
		} 
	   }else{
	   	  echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login.")); 		
	   }	
	}

	// Deleted Selecated Units
	public function delete_units(){
	  if($this->validate_request())
	  {	
        if(isset($_POST)){
        	$unit_id = $_POST['ids'];

        	$tables = array('erp_material_master','erp_material_requisition_details');

        	$check_unit = $this->purchase_model->check_unit_used($unit_id,$tables);
        	if(count($check_unit) > 0){
        		 $result = array(
			  			 'status' => 'warning',
			  			 'message' => "This unit not permitted to delete. It's Used"
			  	 );
        	}else{
        		$deleted = $this->purchase_model->delete_units($unit_id);
        		if($deleted){
        			$result = array(
			  			 'status' => 'success',
			  			 'message' => "Deleted Unit",
			  			 'redirect' => 'purchase/unit'
			  	    );
        		}
        	}	
        }else{
        	$result = array(
        		'status' => 'error',
        		'message' => 'Error! Unit Id not found'
        	);
        }
			echo json_encode($result);
	  }else{
	  	    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	  }	
	}
	// Deleted selected Supplier
	public function delete_supplier(){
	  if($this->validate_request())
	  {		
			if(isset($_POST)){
				$supplier_id = explode(',', $_POST['ids']);
				$tables = array('erp_supplier_quotation_bid','erp_supplier_quotation_bid_details','erp_supplier_materials','erp_purchase_order');

				$check_supplier = $this->purchase_model->check_supplier_used($_POST['ids'],$tables);
				if(count($check_supplier) > 0){
					   $result = array(	
							'status' => 'warning',
							'message' => "This vendor not permitted to delete. It's Used"
					   );	
				}else{
						$deleted = $this->purchase_model->delete_supplier($supplier_id);
						if($deleted){
							$result = array(
					  			 'status' => 'success',
					  			 'message' => "Deleted Vendor",
					  			 'redirect' => 'purchase/supplier'
				  	        );
						}
				}
			}else{
				$result = array(
	        		'status' => 'error',
	        		'message' => 'Error! Vendor ID not found'
	        	);
			}

			echo json_encode($result); exit;
	   }else{
	  	    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	   }		
	}

	// deleted selected category
	public function delete_category(){
	  if($this->validate_request())
	  {	
			if(isset($_POST)){
				 $cat_id = $_POST['ids'];
				 $tables = array('erp_material_master');

				 $check_cat = $this->purchase_model->check_category_used($cat_id,$tables);
				 if(count($check_cat) > 0){
				 	 $result = array(
				  			 'status' => 'warning',
				  			 'message' => "This category not permitted to delete. It's Used"
				  	 );
				 }else{
				 	$deleted = $this->purchase_model->delete_category($cat_id);
	        	  	if($deleted){
	        			$result = array(
				  			 'status' => 'success',
				  			 'message' => "Deleted Category",
				  			 'redirect' => 'purchase/category'
				  	    );
	        		}
	        	}
			}else{
				$result = array(
	        		'status' => 'error',
	        		'message' => 'Error! Category Id not found'
	        	);
			}
			echo json_encode($result); exit;
	   }else{
	  	    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	   }	
	}

	// Remove assign material
	public function remove_supplier_assign_material(){
	   	if($this->validate_request())
	    {
		  if(isset($_POST)){
		  		$supplier_id = trim($_POST['supplier_id']);
		  		$material_id = trim($_POST['mat_id']);
		  		$removed = $this->purchase_model->remove_supplier_assign_material($supplier_id,$material_id);
		  		$result = array(
		  			 'status' => 'success',
		  			 'supplier_id' => $supplier_id,
		  			 'material_id' => $material_id,
		  			 'message' => 'Removed Assign Material',
		  			 'redirect' => 'purchase/edit_supplier_form/'.$supplier_id.'/tab_2'
		  		);
		  		echo json_encode($result); exit;
		  }
	    }else{
	  	    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	    }	  
	}

	// Assign material
	public function assign_material(){
		 if(isset($_POST)){
		 		$mat_id = explode(',', $_POST['mat_ids']);
		 		$supplier_id = $_POST['supplier_id'];
		 		$assigned = $this->purchase_model->assign_material($mat_id,$supplier_id);
		 		if(!empty($assigned)){
		 			echo implode(',', $assigned);
		 		}else{
		 			echo 'false';
		 		}	
		 }
	}


	//load assign material 
	public function load_supplier_assign_material(){
		if(isset($_REQUEST)){

		 	$supplier_id = $_REQUEST['supplier_id'];
		 	$assign_materials = $this->purchase_model->get_assign_material($supplier_id);
		 	if(!empty($assign_materials)){
		 		$data['assign_materials'] = $assign_materials;
		 		echo $this->load->view('purchase/sub_views/supplier_assign_material_list',$data,true);
		 	}else{

		 	}
		}	
	}


    // get units for edit units.
	public function get_unit()
	{
	   if($this->validate_request())
	   {	
		 $entityBody = file_get_contents('php://input', 'r');
         $obj_arr = json_decode($entityBody);
         
         if(!empty($obj_arr) && isset($obj_arr->unit_id)){
         		 $unit_details = $this->purchase_model->get_unit_details(array("unit_id"=>$obj_arr->unit_id));
         		 if(!empty($unit_details)){
         		 	 echo json_encode($unit_details);
         		 }else{
         		 	 echo json_encode(array("status"=>"error", "msg"=>"Invalid Request."));
         		 }
         }
       }else{
	  	    echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	   }  
	}


    // edit supplier form
	public function edit_supplier_form($supplier_id, $tab='tab_1'){
		    $data = $this->global;
			if($supplier_id > 0){
			 	$data['supplier_id'] = $supplier_id;
			    $assign_material = array();
			    $assign_materials = $this->purchase_model->get_assign_material($supplier_id);
			    if(!empty($assign_materials)){
			    	foreach ($assign_materials as $key => $value) {
			    		array_push($assign_material, $value['mat_id']);
			    	}
			    }

				$supplier_details = $this->purchase_model->get_supplier_details($supplier_id);
				
				$material_list = $this->purchase_model->get_material_listing_pop_up($assign_material);
				$data['material_list'] = $material_list;
				$data['next_supplier_id'] = $this->purchase_model->get_next_previous('next',$supplier_id);
				$data['pre_supplier_id'] = $this->purchase_model->get_next_previous('pre',$supplier_id);
				$data['tabs'] = $tab;
				

				$data['assign_materials'] = $assign_materials;
				$unit_details = $this->purchase_model->get_unit_listing();
				$data['unit_list'] = $unit_details;

				$department = $this->department_model->get_department_listing();
				$data['departments'] = $department;

				foreach ($supplier_details as $key => $sup_val) 
				{
					$data['supplier_id'] = $sup_val['supplier_id'];	
					$data['supp_firm_name'] = $sup_val['supp_firm_name'];
					$data['supp_contact_person'] = $sup_val['supp_contact_person'];
					$data['supp_address'] = $sup_val['supp_address'];
					$data['supp_city'] =  $sup_val['supp_city'];
					$data['supp_pin'] = $sup_val['supp_pin'];
					$data['supp_contact'] =  $sup_val['supp_contact'];
					$data['supp_mobile'] = $sup_val['supp_mobile'];
					$data['supp_fax'] = $sup_val['supp_fax'];
					$data['supp_email'] = $sup_val['supp_email'];
					$data['supp_state'] = $sup_val['supp_state'];
					$data['supp_country'] = $sup_val['supp_country'];
					$data['supp_contact_designation'] = $sup_val['supp_contact_designation'];
					$data['supp_phone1'] = $sup_val['supp_phone1'];
					$data['supp_phone2'] = $sup_val['supp_phone2'];
					$data['supp_phone3'] = $sup_val['supp_phone3'];
					$data['supp_mobile2'] = $sup_val['supp_mobile2'];
					$data['supp_website'] = $sup_val['supp_website'];
					$data['supp_description'] = $sup_val['supp_description'];
					$data['assign_dep_id'] = $sup_val['dep_id'];
				}

				$quotations = $this->purchase_model->get_supplier_quotation(array('supplier_id' => $supplier_id));

				$data['quotation_list'] = $quotations;

				$condition = array('s.supplier_id' => $supplier_id);
 		 		$po_listing = $this->purchase_model->purchase_order_listing($condition);
 		 		$data['po_listing'] = $po_listing;

				//echo "<pre>"; print_r($quotations); echo "</pre>";
				echo $this->load->view('purchase/forms/edit_supplier_form',$data,true);
			}else{
				echo $this->load->view('errors/html/error_404',$data,true);
			}
	}

	// edit category
	public function edit_category_form($cat_id){
		$data = $this->global;
		if($cat_id > 0){
			$data['cat_id'] = $cat_id;
			$category_details = $this->purchase_model->get_categories_details(array("cat_id"=>$cat_id));
			
			$data['next_cat_id'] = $this->purchase_model->get_next_previous_cat('next',$cat_id);
			$data['pre_cat_id'] = $this->purchase_model->get_next_previous_cat('pre',$cat_id);


			foreach ($category_details as $key => $cat_val) {
				$data['cat_id'] = $cat_val['cat_id'];
				$data['cat_code'] = $cat_val['cat_code'];
				$data['cat_name'] = $cat_val['cat_name'];
				$data['cat_for'] = $cat_val['cat_for'];
				$data['cat_stockable'] = $cat_val['cat_stockable'];
			}

			echo $this->load->view('purchase/forms/edit_category_form',$data,true);
		}else{
			echo $this->load->view('errors/html/error_404',$data,true);
		}
	}
	
	//edit material
	public function edit_material_form($mat_id){
		$data = $this->global;
		if($mat_id > 0){

			 $data['next_mat_id'] = $this->purchase_model->get_next_pre_mat('next',$mat_id); 
			 $data['pre_mat_id'] = $this->purchase_model->get_next_pre_mat('pre',$mat_id); 


			 $where = array('is_deleted' => '0');
			 $category = $this->purchase_model->get_category_listing($where);
		 	 $unit_details = $this->purchase_model->get_unit_listing();
		 	 $material_list = $this->purchase_model->get_material_listing_pop_up();
		 	 $location = $this->purchase_model->get_location_listing();

		     $data['categories'] = $category;
		     $data['units'] = $unit_details;
		     $data['material_list'] = $material_list;
		     $data['location_list'] = $location;

		     $material_details = $this->purchase_model->get_material_details(array("mat_id"=>$mat_id));
		     $data['material_details'] = $material_details;
			 echo $this->load->view('purchase/forms/edit_material_form',$data,true);
		}else{
			echo $this->load->view('errors/html/error_404',$data,true);
		}
	}

	// export supplier
	public function export_supplier(){
		if(isset($_REQUEST)){
			$supplier_id = explode(',', $_REQUEST['ids']);
			$supplier_details = $this->purchase_model->get_export_supplier_details($supplier_id);
			//echo "<pre>"; print_r($supplier_details); echo "</pre>"; exit;

			$this->load->library('PHPExcel');
		 	$objPHPExcel = new PHPExcel();

		 	$objPHPExcel->setActiveSheetIndex(0)
		 	  		->setCellValue('A1', '#')
                    ->setCellValue('B1', 'Firm name')
                    ->setCellValue('C1', 'Contact Person')
                    ->setCellValue('D1', 'Address')
                    ->setCellValue('E1', 'City')
                    ->setCellValue('F1', 'State')
                    ->setCellValue('G1', 'Country')
                    ->setCellValue('H1', 'Pin Code')
                    ->setCellValue('I1', 'Contact')
                    ->setCellValue('J1', 'Mobile1')
                    ->setCellValue('K1', 'Mobile2')
            		->setCellValue('L1', 'Phone1')
            		->setCellValue('M1', 'Phone2')
            		->setCellValue('N1', 'Phone3')
            		->setCellValue('O1', 'Fax')
            		->setCellValue('P1', 'Email')
            		->setCellValue('Q1', 'Website');

            
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

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->applyFromArray($style_header); 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('E1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('H1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('I1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('J1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('K1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('L1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('M1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('N1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('O1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('P1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('Q1')->applyFromArray($style_header);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);		
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);


            if(!empty($supplier_details)){
            	$cell_no = 2;
            	$ser_no = 1;
            	foreach ($supplier_details as $key => $data) {
            		 $objPHPExcel->setActiveSheetIndex(0)
            		 				->setCellValue('A'.$cell_no, $ser_no)
                    				->setCellValue('B'.$cell_no, $data['supp_firm_name'])
                    				->setCellValue('C'.$cell_no, $data['supp_contact_person'])
                    				->setCellValue('D'.$cell_no, $data['supp_address'])
                    				->setCellValue('E'.$cell_no, $data['supp_city'])
                    				->setCellValue('F'.$cell_no, $data['supp_state'])
                    				->setCellValue('G'.$cell_no, $data['supp_country'])
                    				->setCellValue('H'.$cell_no, $data['supp_pin'])
                    				->setCellValue('I'.$cell_no, $data['supp_contact'])
                    				->setCellValue('J'.$cell_no, $data['supp_mobile'])
                    				->setCellValue('K'.$cell_no, $data['supp_mobile2'])
                    				->setCellValue('L'.$cell_no, $data['supp_phone1'])
                    				->setCellValue('M'.$cell_no, $data['supp_phone2'])
                    				->setCellValue('N'.$cell_no, $data['supp_phone3'])
                    				->setCellValue('O'.$cell_no, $data['supp_fax'])
                    				->setCellValue('P'.$cell_no, $data['supp_email'])
                    				->setCellValue('Q'.$cell_no, $data['supp_website']);
            	 	$cell_no ++; 
            	 	$ser_no ++;
            	}
            }

		 	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="supplier_summary_'.date("YmdHis").'.xlsx"');
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
			exit;
		}	
	}

	// export units
	public function export_units(){
		if(isset($_REQUEST)){
		 	$unit_id = explode(',', $_REQUEST['ids']);
		 	$unit_details = $this->purchase_model->get_export_unit_details($unit_id);
		 	$sheet = [];

		 	foreach ($unit_details as $key => $val) {
		 		$sheet[$val['unit_id']]['unit_id'] = $val['unit_id'];
		 		$sheet[$val['unit_id']]['unit'] = $val['unit'];
		 		$sheet[$val['unit_id']]['unit_description'] = $val['unit_description'];
		 	}
		 	

		 	$this->load->library('PHPExcel');
		 	$objPHPExcel = new PHPExcel();

		 	$objPHPExcel->setActiveSheetIndex(0)
		 	  		->setCellValue('A1', '#')
                    ->setCellValue('B1', 'Unit ID')
                    ->setCellValue('C1', 'Unit Name')
                    ->setCellValue('D1', 'Unit Decription');

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

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->applyFromArray($style_header); 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->applyFromArray($style_header);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

            //echo "<pre>"; print_r($sheet); echo "</pre>"; exit;

            if(!empty($sheet)){
            	$cell_no = 2;
            	$ser_no = 1;
            	foreach ($sheet as $key => $data) {
            		  //echo "<pre>"; print_r($data); echo "</pre>";
            		 $objPHPExcel->setActiveSheetIndex(0)
            		 				->setCellValue('A'.$cell_no, $ser_no)
                    				->setCellValue('B'.$cell_no, $data['unit_id'])
                    				->setCellValue('C'.$cell_no, $data['unit'])
                    				->setCellValue('D'.$cell_no, $data['unit_description']);
            	 	$cell_no ++; 
            	 	$ser_no ++;    	
            	}
            }

            //exit;

            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="unit_summary_'.date("YmdHis").'.xlsx"');
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
			exit;
		 }
	}

	//export material 
	public function export_material(){
		if(isset($_REQUEST)){
			$mat_id = explode(',', $_REQUEST['ids']);
			$material_details = $this->purchase_model->get_export_material_details($mat_id);
            
			$this->load->library('PHPExcel');
		 	$objPHPExcel = new PHPExcel();

		 	$objPHPExcel->setActiveSheetIndex(0)
		 	  		->setCellValue('A1', '#')
                    ->setCellValue('B1', 'Material Code')
                    ->setCellValue('C1', 'Material Name')
                    ->setCellValue('D1', 'Current Stock')
                    ->setCellValue('E1', 'Rejected Current Qty')
                    ->setCellValue('F1', 'Minimum Level')
                    ->setCellValue('G1', 'Material Status')
                    ->setCellValue('H1', 'Scrape Opening Qty')
                    ->setCellValue('I1', 'Scrape Current Qty')
                    ->setCellValue('J1', 'Category Name')
                    ->setCellValue('K1', 'Unit Name')
                    ->setCellValue('L1', 'Parent Material Code')
                    ->setCellValue('M1', 'Parent Material Name'); 

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

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->applyFromArray($style_header); 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('E1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('H1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('I1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('J1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('K1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('L1')->applyFromArray($style_header);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('M1')->applyFromArray($style_header);       

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);		
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);

            if(!empty($material_details)){
            	$cell_no = 2;
            	$ser_no = 1;
            	foreach ($material_details as $key => $data) {
            		   $objPHPExcel->setActiveSheetIndex(0)
            		 				->setCellValue('A'.$cell_no, $ser_no)
                    				->setCellValue('B'.$cell_no, $data['mat_code'])
                    				->setCellValue('C'.$cell_no, $data['mat_name'])
                    				->setCellValue('D'.$cell_no, $data['current_stock'])
                    				->setCellValue('E'.$cell_no, $data['rejected_current_qty'])
                    				->setCellValue('F'.$cell_no, $data['minimum_level'])
                    				->setCellValue('G'.$cell_no, $data['mat_status'])
                    				->setCellValue('H'.$cell_no, $data['scrape_opening_qty'])
                    				->setCellValue('I'.$cell_no, $data['scrape_current_qty'])
                    				->setCellValue('J'.$cell_no, $data['cat_name'])
                    				->setCellValue('K'.$cell_no, $data['unit'])
                    				->setCellValue('L'.$cell_no, $data['parent_mat_code'])
                    				->setCellValue('M'.$cell_no, $data['parent_mat_name']);
                    $cell_no ++; 
            	 	$ser_no ++;				
            	}
            }

		 	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="material_summary_'.date("YmdHis").'.xlsx"');
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
			exit;
		}
	}
	// Add new supplier
	public function add_supplier_form($variable='quo_req_id',$id = 0,$action='insert'){
		$data = $this->global;
		$data['variable'] = trim($variable);
  	    $data['myid'] = trim($id);
  	    $data['action'] = $action;
  	    $department = $this->department_model->get_department_listing();
		$data['departments'] = $department;

		echo $this->load->view('purchase/forms/add_supplier_form',$data,true);
	}

    // Add new category for material.
	public function add_category_form($value=''){
		 $data = $this->global;
		 echo $this->load->view('purchase/forms/add_category_form',$data,true);
	}

	// Add new material 
	public function add_material_form($variable = 'supplier_id', $myid = 0, $action = 'insert'){
		 $data = $this->global;

		 $material_unique_number = $this->purchase_model->get_material_unique_number();

		 $material_unique_number = explode('/', $material_unique_number[0]->material_unique_number);
		 $increment = ($material_unique_number[1] + 1);
		 $material_unique_number = $material_unique_number[0].'/'.$increment;

		 $data['material_unique_number'] =  $material_unique_number;  

		 $where = array('is_deleted' => '0');
		 $category = $this->purchase_model->get_category_listing($where);
		 $unit_details = $this->purchase_model->get_unit_listing();
		 $material_list = $this->purchase_model->get_material_listing_pop_up();
		 $location = $this->purchase_model->get_location_listing();

		 $data['myid'] = trim($myid);
		 $data['variable'] = trim($variable);
		 $data['categories'] = $category;
		 $data['units'] = $unit_details;
		 $data['material_list'] = $material_list; 
		 $data['location_list'] = $location;
		 $data['action'] = $action;
		 //echo "<pre>"; print_r($location); echo "</pre>";
		echo $this->load->view('purchase/forms/add_material_form',$data,true);	
	}

	// check material
	public function check_mat_code(){
		 $entityBody = file_get_contents('php://input', 'r');
         $obj_arr = json_decode($entityBody);

         $mat_code = strtolower($obj_arr->mat_code);
         $exits = $this->purchase_model->check_mat_code($mat_code);
         if(count($exits) > 0){
         	echo count($exits);
         }else{
         }
	}

	//Delete Material
 	public function delete_material(){
 		 if(isset($_POST))
 		 {
 		 	$mat_id = trim($_POST['mat_id']);

 		 	$tables = array('erp_supplier_materials','erp_material_requisation_draft','erp_material_requisition_details','erp_supplier_quotation_bid_details','erp_material_quotation_draft', 'erp_purchase_order_details');

 		 	$check_material = $this->purchase_model->material_already_used($mat_id,$tables);
 		 	if(count($check_material) > 0){
 		 		 $result = array(
			  			 'status' => 'warning',
			  			 'material_id' => $mat_id,
			  			 'message' => "This material not permitted to delete. It's Used"
			  	  );
 		 	}else{
 		 		$deleted = $this->purchase_model->delete_material($mat_id);
	 		 	if($deleted){
	 		 	   $result = array(
			  			 'status' => 'success',
			  			 'material_id' => $mat_id,
			  			 'message' => 'Deleted Material',
			  			 'redirect' => 'purchase/material'
			  	   );	
	 		 	}
 		 	}
 		 }else{
 		 	 $result = array(
 		 	 	'status' => 'error',
 		 	 	'message' => 'Error! Material Id not found'
 		 	 );
 		 }
 		 echo json_encode($result);
 	}

 	//Quotations layouts
 	public function quotations($tab='tab_1',$date = 0,$quo_req_id = 0){
 		 $data = $this->global;
 		
 		 $condition = 'last_quotation_id = 0';
 		 $pending_quotations = $this->purchase_model->quotation_listing($condition);
 		 $data['pending_quotations'] = $pending_quotations;


 		 $mycondtion1 = "approval_status_purchase = 'approved' AND approval_status_account != 'approved' AND last_quotation_id > 0";
 		 $purchase_approved_quotations = $this->purchase_model->quotation_listing($mycondtion1);


 		 $mycondtion2 = "approval_status_purchase != 'approved' AND approval_status_account = 'approved' AND last_quotation_id > 0";
 		 $account_approved_quotations = $this->purchase_model->quotation_listing($mycondtion2);

 		 $mycondtion3 = "approval_status_purchase != 'approved' AND approval_status_account != 'approved' AND last_quotation_id > 0";
 		 $not_approved_quotations = $this->purchase_model->quotation_listing($mycondtion3);

 		 $my_quotations = array_merge($purchase_approved_quotations,$account_approved_quotations,$not_approved_quotations);
 		 $data['quotations'] = $my_quotations;

 		
 		 $condition =  "approval_status_purchase = 'approved' AND approval_status_account = 'approved' AND last_quotation_id > 0";
 		 $approved_quotations = $this->purchase_model->quotation_listing($condition);
 		 $data['approved_quotations'] = $approved_quotations;
 		 $data['tabs'] = $tab; 
 		 $data['quo_req_id'] = $quo_req_id;
		 echo $this->load->view('purchase/quotations_layout',$data,true);
 	}

 	//Add new Quotations
 	public function add_quotations_form($variable="supplier_id",$id = 0){
 		$data = $this->global;
 		$sess_dep_id = $this->dep_id;
 		$quotation_request_num = $this->purchase_model->get_quotation_request_number();
 		$quotation_request_number = $quotation_request_num[0]->quotation_request_number + 1;
 		$quotation_request_number = "0000{$quotation_request_number}";
 		$condition = array();
 		$data['dep_id'] = 0;
 		if($variable == 'dep_id'){
 				$condition = array('qdm.dep_id' => $id);
 		 		$data['dep_id'] = $id;		
 		}
 		$selected_material = array();
 		$selected_materials = $this->purchase_model->get_selected_materials_draft($condition); // material quotation draft.
 		if(!empty($selected_materials)){
 			 foreach ($selected_materials as $key => $value) {
                array_push($selected_material, $value['mat_id']);
             }
 		}
 		
 		$suppliers = $this->purchase_model->get_supplier_listing();
 		//echo "<pre>"; print_r($suppliers); echo "</pre>";
		if(!empty($suppliers)){
		 	$data['mysuppliers'] = $suppliers;
		}
		if($variable == 'supplier_id'){
			$data['variable'] = $variable;
			$data['vendor_id'] = array($id);
		}
		$data['submit_type'] = 'insert'; 
		$data['quo_req_id'] = 0;
		$data['quotation_request_number'] = 'Quo/'.date('Y').'/'.$quotation_request_number;
		$data['hidden_quo_req_number'] = $quotation_request_number;
		$data['selected_materials'] = $selected_materials;
		
		$material_listing = $this->purchase_model->get_material_listing_pop_up($selected_material);
        $data['material_list'] = $material_listing;
        $unit_details = $this->purchase_model->get_unit_listing();
	    $data['unit_list'] = $unit_details;
	    $department = $this->department_model->get_department_listing();
		$data['departments'] = $department;
		echo $this->load->view('purchase/forms/add_quotations_form',$data,true);
 	}

 	public function edit_quotation_form($variable = 'quo_req_id', $quo_req_id = 0){
 			echo "in1111";
 	}

 	// Selected material quotation
 	public function selected_material_quotation(){
 		if($this->validate_request())
	    {
 			if(isset($_POST)){
 			 	$mat_id = explode(',', $_POST['mat_ids']);
 			 	$sess_dep_id = $this->dep_id;
 			 	$action = $_POST['action'];
                $req_id = $_POST['req_id'];

                if($action == 'edit' && $req_id > 0){

                }else{
                	$assigned = $this->purchase_model->selected_material_quotation($mat_id,$sess_dep_id);
                }

                if(!empty($assigned)){
                	 if($action == 'edit' && $req_id > 0){

                	 }else{
                	 	$redirect = 'purchase/add_quotations_form';
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

 	public function remove_selected_material_quotation_request(){
 		if($this->validate_request())
	    {
 			if(isset($_POST))
 			{
                $dep_id = trim($_POST['dep_id']);
                $material_id = trim($_POST['mat_id']);
                $removed = $this->purchase_model->remove_selected_material_quotation_request($dep_id,$material_id);
                $result = array(
                    'status' => 'success',
                    'dep_id' => $dep_id,
                    'material_id' => $material_id,
                    'message' => 'Removed Selected Material',
                    'redirect' => 'purchase/add_quotations_form'
                );
               echo json_encode($result); exit; 
           }
        }else{
        	 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
        }    
 	}

 	

 	public function save_purchase_order(){
 		if($this->validate_request()){
 			if(!empty($_POST)){
 				if($_POST['submit_type'] == 'insert'){
 					$dep_id = $_POST['dep_id'];
 					$po_insert_data = array(
 						'po_type' => $_POST['po_type'], 
 						'po_number' => $_POST['po_number'],
 						'po_date' => date('Y-m-d',strtotime($_POST['po_date'])),
 						'supplier_id' => $_POST['supplier_id'],
 						'dep_id' => $_POST['dep_id'],
 						'delievery_schedule' => $_POST['delievery_schedule'],
 						'delievery_schedule_days' => $_POST['delievery_schedule_days'],
 						'transport' => $_POST['transport'],
 						'freight_charges' => $_POST['freight_charges'],
 						'payment_terms' => $_POST['payment_terms'],
 						'test_certificate' => $_POST['test_certificate'],
 						'custom_duty' => $_POST['custom_duty'],
 						'approval_flag' => $_POST['approval_flag'],
 						'approval_by' => $_POST['approval_by'],
 						'notes' => trim($_POST['notes']),
 						'remarks' => trim($_POST['remarks']),
 						'currency' => trim($_POST['currency']),
 						'total_amt' => trim($_POST['total_amt']),
 						'total_cgst' => trim($_POST['total_cgst']),
 						'total_sgst' => trim($_POST['total_sgst']),
 						'total_igst' => trim($_POST['total_igst']),
 						'freight_amt' => trim($_POST['freight_amt']),
 						'other_amt' =>  trim($_POST['other_amt']),
 						'total_bill_amt' => trim($_POST['total_bill_amt']),
 						'rounded_amt' => trim($_POST['rounded_amt']),
 						'po_form' => trim($_POST['po_form']),
 						'created' => date('Y-m-d H:i:s'),
 						'created_by' => $this->user_id
 					);

 					 if(isset($_POST['req_id']) && $_POST['po_form'] == 'requisition_form'){
 						 $po_insert_data['req_id'] = $_POST['req_id'];
 					 }


 					 if(isset($_POST['quotation_id']) && $_POST['po_form'] == 'quotation_form'){
 					 		 $po_insert_data['quotation_id'] = $_POST['quotation_id'];
 					 }

 					 if(isset($_POST['cat_id']) && $_POST['po_form'] == 'general_form'){
 					 		$po_insert_data['cat_id'] = $_POST['cat_id'];
 					 }

 					 $purchase_order_num = explode('/', $_POST['po_number']);
 					 $purchase_order_num = $purchase_order_num[2] + 1;
 					 $purchase_order_num = 'DCGL/'.date('Y').'/'.$purchase_order_num;

 					 $po_mat = array();
 					 if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0){
	                 		$po_id = $this->purchase_model->insert_purchase_order($po_insert_data);
	                 		if($po_id > 0){
	                 			foreach ($_POST['mat_code'] as $mat_id => $val) {
	                 				$po_mat[$mat_id]['mat_code'] = $val;
	                 				$po_mat[$mat_id]['hsn_code'] = $_POST['hsn_code'][$mat_id];
	                 				$po_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
	                 				$po_mat[$mat_id]['qty'] = $_POST['qty'][$mat_id];
	                 				$po_mat[$mat_id]['rate'] = $_POST['rate'][$mat_id];
	                 				$po_mat[$mat_id]['discount_per'] = $_POST['discount_per'][$mat_id];
	                 				$po_mat[$mat_id]['discount'] = $_POST['discount'][$mat_id];
	                 				$po_mat[$mat_id]['mat_amount'] = $_POST['mat_amount'][$mat_id];
	                 				$po_mat[$mat_id]['cgst_per'] = $_POST['cgst_per'][$mat_id];
	                 				$po_mat[$mat_id]['cgst_amt'] = $_POST['cgst_amt'][$mat_id];
	                 				$po_mat[$mat_id]['sgst_per'] = $_POST['sgst_per'][$mat_id];
	                 				$po_mat[$mat_id]['sgst_amt'] = $_POST['sgst_amt'][$mat_id];
	                 				$po_mat[$mat_id]['igst_per'] = $_POST['igst_per'][$mat_id];
	                 				$po_mat[$mat_id]['igst_amt'] = $_POST['igst_amt'][$mat_id];
	                 			}

	                 			$added_material = array();
	                 			foreach ($po_mat as $mat_id => $value){
	                 				$insert_data = array(
	                 					'po_id' => $po_id,
	                 					'mat_id' => $mat_id,
	                 					'dep_id' => $dep_id,
	                 					'hsn_code' => $value['hsn_code'],
	                 					'unit_id' => $value['unit_id'],
	                 					'qty' => $value['qty'],
	                 					'rate' => $value['rate'],
	                 					'expire_date' => date('Y-m-d'),
	                 					'cgst_per' => $value['cgst_per'],
	                 					'cgst_amt' => $value['cgst_amt'],
	                 					'sgst_per' => $value['sgst_per'],
	                 					'sgst_amt' => $value['sgst_amt'],
	                 					'igst_per' => $value['igst_per'],
	                 					'igst_amt' => $value['igst_amt'],
	                 					'discount' => $value['discount'],
	                 					'discount_per' => $value['discount_per'], 
	                 					'mat_amount' => $value['mat_amount'],
	                 					'created' => date('Y-m-d'),
	                 					'created_by' => $this->user_id 
	                 				);

	                 				if(isset($_POST['req_id']) && $_POST['po_form'] == 'requisition_form'){
	                 				 	 $insert_data['req_id'] = $_POST['req_id'];
	                 				}

	                 				if(isset($_POST['quotation_id']) && $_POST['po_form'] == 'quotation_form'){
 					 		 			 $insert_data['quotation_id'] = $_POST['quotation_id'];
 					 				}

 					 				if(isset($_POST['cat_id']) && $_POST['po_form'] == 'general_form'){
 					 					 $insert_data['cat_id ']  = $_POST['cat_id']; 	
 					 				}
	                 				$added_material[] = $this->purchase_model->insert_selected_purachase_order($insert_data,$mat_id);
	                 			}

	                 			 if(count($added_material) > 0){
	                 			 	    if(isset($_POST['req_id']) && $_POST['po_form'] == 'requisition_form'){
	                 			 	     	 	$condition = array('req_id' => $_POST['req_id'], 'dep_id' => $dep_id);
	                 			 	     	 	$redirect_link = 'purchase/purchase_order_requisition';
	                 			 	    } 

	                 			 	    if(isset($_POST['quotation_id']) && $_POST['po_form'] == 'quotation_form'){
	                 			 	    		$condition = array('quotation_id' => $_POST['quotation_id'], 'dep_id' => $dep_id);	
	                 			 	    		$redirect_link = 'purchase/purchase_order_quotation';
	                 			 	    }

	                 			 	    if(isset($_POST['cat_id']) && $_POST['po_form'] == 'general_form'){
	                 			 	    	 	$condition = array('cat_id' => $_POST['cat_id'], 'dep_id' => $dep_id);	
	                 			 	    		$redirect_link = 'purchase/purchase_order';
	                 			 	    }

	                 			 		$deleted = $this->purchase_model->delete_purchase_order_drafts($condition);

	                 			 		$result = array(
	                                        'status' => 'success',
	                                        'message' => 'Purchase Order Created Successfully.',
	                                        'redirect' => $redirect_link,
	                                        'myaction' => 'inserted'
	                                    );

	                                    $update_po_number = $this->purchase_model->update_po_number($purchase_order_num);
	                 			 }else{
	                 			 	$result = array(
	                                        'status' => 'error',
	                                        'message' => 'Error ! Materials not Inserted.',
	                                        'myfunction' => 'purchase/save_purchase_order'
	                                 );
	                 			 }

	                 		}else{
	                 			 $result = array(
	                                    'status' => 'error', 
	                                    'message' => 'Error ! Purchase Order Not Inserted.',
	                             );
	                 		}
	                 }else{
	                 	if($_POST['po_form'] == 'requisition_form'){
	                 			$msg = 'Please Browse Requisation.';
	                 	}else if($_POST['po_form'] == 'quotation_form'){
	                 			$msg = 'Please Select Quotation.';
	                 	}else{
	                 			$msg = 'Please Select Category.';
	                 	}

	                 	$result = array(
		                                    'status' => 'warning',
		                                    'message' => $msg,
		                                    'myfunction' => 'purchase/save_purchase_order' 
		                 );
	                 }
	            }else{
	            		$po_id = $_POST['po_id'];
		            	$po_update_data = array(
		            		'po_type' => $_POST['po_type'], 
		            		'po_number' => $_POST['po_number'],
		            		'po_date' => date('Y-m-d',strtotime($_POST['po_date'])),
		            		'delievery_schedule' => $_POST['delievery_schedule'],
	 						'delievery_schedule_days' => $_POST['delievery_schedule_days'],
	 						'transport' => $_POST['transport'],
	 						'freight_charges' => $_POST['freight_charges'],
	 						'payment_terms' => $_POST['payment_terms'],
	 						'test_certificate' => $_POST['test_certificate'],
	 						'custom_duty' => $_POST['custom_duty'],
	 						'approval_flag' => $_POST['approval_flag'],
	 						'approval_by' => $_POST['approval_by'],
	 						'approval_date' => date('Y-m-d H:i:s'),
	 						'notes' => trim($_POST['notes']),
	 						'remarks' => trim($_POST['remarks']),
	 						'currency' => trim($_POST['currency']),
	 						'total_amt' => trim($_POST['total_amt']),
	 						'total_cgst' => trim($_POST['total_cgst']),
	 						'total_sgst' => trim($_POST['total_sgst']),
	 						'total_igst' => trim($_POST['total_igst']),
	 						'freight_amt' => trim($_POST['freight_amt']),
	 						'other_amt' =>  trim($_POST['other_amt']),
	 						'total_bill_amt' => trim($_POST['total_bill_amt']),
	 						'rounded_amt' => trim($_POST['rounded_amt']),
	 						'amendment' => $_POST['amendment'],
	 						'updated' => date('Y-m-d H:i:s'),
	 						'updated_by' => $this->user_id
		            	);

		            	$po_mat = array();
		            	if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0){
		            		$po_id = $this->purchase_model->update_purchase_order($po_update_data,$po_id);
		            		if($po_id > 0){
		            			foreach ($_POST['mat_code'] as $mat_id => $val) {
	                 				$po_mat[$mat_id]['mat_code'] = $val;
	                 				$po_mat[$mat_id]['hsn_code'] = $_POST['hsn_code'][$mat_id];
	                 				$po_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
	                 				$po_mat[$mat_id]['qty'] = $_POST['qty'][$mat_id];
	                 				$po_mat[$mat_id]['rate'] = $_POST['rate'][$mat_id];
	                 				$po_mat[$mat_id]['discount_per'] = $_POST['discount_per'][$mat_id];
	                 				$po_mat[$mat_id]['discount'] = $_POST['discount'][$mat_id];
	                 				$po_mat[$mat_id]['mat_amount'] = $_POST['mat_amount'][$mat_id];
	                 				$po_mat[$mat_id]['cgst_per'] = $_POST['cgst_per'][$mat_id];
	                 				$po_mat[$mat_id]['cgst_amt'] = $_POST['cgst_amt'][$mat_id];
	                 				$po_mat[$mat_id]['sgst_per'] = $_POST['sgst_per'][$mat_id];
	                 				$po_mat[$mat_id]['sgst_amt'] = $_POST['sgst_amt'][$mat_id];
	                 				$po_mat[$mat_id]['igst_per'] = $_POST['igst_per'][$mat_id];
	                 				$po_mat[$mat_id]['igst_amt'] = $_POST['igst_amt'][$mat_id];
	                 			}

	                 			$updated_material = array();
	                 			foreach ($po_mat as $mat_id => $value){
	                 				$update_data = array(
	                 					'hsn_code' => $value['hsn_code'],
	                 					'unit_id' => $value['unit_id'],
	                 					'qty' => $value['qty'],
	                 					'rate' => $value['rate'],
	                 					'cgst_per' => $value['cgst_per'],
	                 					'cgst_amt' => $value['cgst_amt'],
	                 					'sgst_per' => $value['sgst_per'],
	                 					'sgst_amt' => $value['sgst_amt'],
	                 					'igst_per' => $value['igst_per'],
	                 					'igst_amt' => $value['igst_amt'],
	                 					'discount' => $value['discount'],
	                 					'discount_per' => $value['discount_per'], 
	                 					'mat_amount' => $value['mat_amount'],
	                 					'updated' => date('Y-m-d'),
	                 					'updated_by' => $this->user_id 
	                 				);
	                 				$updated_material[] = $this->purchase_model->update_selected_purachase_order($update_data,$po_id,$mat_id);
	                 			}

	                 			if(count($updated_material) > 0){

	                 				if($_POST['po_form'] == 'requisition_form'){
	                 					$link = 'purchase/purchase_order_requisition';
	                 				}

	                 				if($_POST['po_form'] == 'quotation_form'){
	                 					$link = 'purchase/purchase_order_quotation';
	                 				}

	                 				if($_POST['po_form'] == 'general_form'){
	                 					$link = 'purchase/purchase_order';
	                 				}

	                 				$result = array(
	                                        'status' => 'success',
	                                        'message' => 'Purchase Order Updated Successfully.',
	                                        'redirect' => $link,
	                                        'myaction' => 'updated'
	                                );
	                 			}else{
	                 				$result = array(
	                                        'status' => 'error',
	                                        'message' => 'Error ! Materials not updated.',
	                                        'myfunction' => 'purchase/save_purchase_order'
	                                 );
	                 			}
		            		}else{
		            			$result = array(
	                                    'status' => 'error', 
	                                    'message' => 'Error ! Purchase Order Not Inserted.',
	                             );
		            		}
		            	}
	            }
 			}else{
 				 $result = array(
	                            'status' => 'error', 
	                            'message' => 'Error ! Post Records not found.',
	             ); 
 			}
 			echo json_encode($result);
 	    }else{
 	    	echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 	    }		
 	}

 	public function save_quotations(){
 	   	if($this->validate_request())
	    {
	 		 if(!empty($_POST)){
	 		 	if($_POST['submit_type'] == 'insert')
	            {
	            	 $dep_id = $_POST['dep_id'];
	            	 $hidden_quo_req_number = $_POST['hidden_quo_req_number'];

	            	 $quo_insert_data = array(
	            	 	'created' => date('Y-m-d H:i:s'),
	            	 	'created_by' => $this->user_id,
	            	 	'quotation_request_number' => $_POST['quo_req_number'],
	            	 	'request_date' => date('Y-m-d'),
	            	 	'dep_id' => $dep_id,
	            	 	'supplier_id' => implode(',', $_POST['suppliers']),
	            	 );

	            	 $req_mat = array();
	            	 if(isset($_POST['mat_code']) && count($_POST['mat_code']) > 0)
	                 {
	                 		$quo_req_id = $this->purchase_model->insert_quotation_request($quo_insert_data);
	                 		if($quo_req_id > 0){
	                 			foreach ($_POST['mat_code'] as $mat_id => $val) {
	                 				$req_mat[$mat_id]['mat_code'] = $val;
	                 				$req_mat[$mat_id]['require_qty'] = $_POST['require_qty'][$mat_id];
	                 				$req_mat[$mat_id]['unit_id'] = $_POST['unit_id'][$mat_id];
	                 				$req_mat[$mat_id]['mat_req_id'] = $_POST['mat_req_id'][$mat_id];
	                 			}

	                 			$added_material = array();
	                 			foreach ($req_mat as $mat_id => $value){
		                 			$insert_data = array(
		                 				'quo_req_id' => $quo_req_id,
		                 				'mat_id' => $mat_id,
		                 				'unit_id' => $value['unit_id'],
		                 				'require_qty' => $value['require_qty'],
		                 				'dep_id' => $dep_id,
		                 				'mat_req_id' => $value['mat_req_id'],
		                 				'created' => date("Y-m-d H:i:s"),
		                 				'created_by' => $this->user_id,
		                 			);
		                 			$added_material[] = $this->purchase_model->insert_selected_material_quotation($insert_data,$mat_id);
		                 	    }

		                 	    if(count($added_material) > 0){
		                 	    	  $deleted = $this->purchase_model->delete_quotation_drafts($added_material,$dep_id);
		                 	    	  $result = array(
	                                        'status' => 'success',
	                                        'message' => 'Quotation Request Set Successfully.',
	                                        'redirect' => 'purchase/quotations',
	                                        'myaction' => 'inserted'
	                                  );
		                 	    	  $update_req_number = $this->purchase_model->update_quotation_number($hidden_quo_req_number);

		                 	    	  //$url = send_quotation_notification($quo_req_id,$_POST['suppliers']);

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
		                                    'message' => 'Please Browse materials.',
		                                    'myfunction' => 'purchase/save_quotations' 
		                    );
	                 }
	            }else{
	               echo 'update functionality';
	            }
	 		 }else{
	 		 	 $result = array(
	                            'status' => 'error', 
	                            'message' => 'Error ! Post Records not found.',
	             ); 
	 		 }
	 		 	echo json_encode($result);
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		} 
 	}

 	public function resend_quotation_request(){
 		$data = $this->global;	

 		if($this->validate_request()){
 				$entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$quo_req_id = $obj_arr->quo_req_id;
				$supplier_id = $obj_arr->supplier_id;
				$url = send_quotation_notification($quo_req_id,$supplier_id);	
				foreach ($url as $key => $value) {
					echo $this->config->item("vendor_erp").''.$value; echo "</br>";
				}
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		}

 	}
 	public function get_vendor_bid_details(){
 		$data = $this->global;
 		if(!empty($_POST)){
 		 	$quotation_id = $_POST['quotation_id'];

 		 	$where = array('quotation_id' => $quotation_id, 'is_deleted' => '0');
			$quotations = $this->purchase_model->get_supplier_quotation($where);
			$data['quotations'] = $quotations;

 		 	$quotation_details = $this->purchase_model->get_supplier_quotation_details(array('bd.quotation_id'=>$quotation_id));
 			$data['quotation_details'] = $quotation_details;
 			//echo "<pre>"; print_r($quotations); echo "</pre>";
 			echo $this->load->view('purchase/sub_views/supplier_bid_details',$data,true);
 		}
 	}

 	public function get_quotation_details(){
 		   $data = $this->global;
 		if(!empty($_POST)){
 			$quo_req_id = $_POST['quo_req_id'];
 			$supplier_id = explode(',',$_POST['supplier_id']);

 			$quotation = $this->purchase_model->get_supplier_quotation(array('quo_req_id'=>$quo_req_id),array('supplier_id'=>$supplier_id));
 			
 			$suppliers_bids = array();
 			if(!empty($quotation))
 			{
		 			foreach ($quotation as $key => $val_bids) {
		 				array_push($suppliers_bids,$val_bids['supplier_id']);
		 			}
 		    }
	 		if(!empty($suppliers_bids)){

		 			$request_details = $this->purchase_model->get_quotation_request_details(array('qb.quo_req_id'=>$quo_req_id));
		 			$supplier_details = $this->purchase_model->get_supplier_details($suppliers_bids);

		 			foreach ($supplier_details as $key => $supplier) {
		 				$mysuppliers[$supplier['supplier_id']]['supplier_id'] = $supplier['supplier_id'];
		 				$mysuppliers[$supplier['supplier_id']]['supp_firm_name'] = $supplier['supp_firm_name'];
		 			}
		 			
		 			$materials = array();

		 			foreach ($request_details as $key => $value) {
		 				//echo "<pre>"; print_r($value); echo "</pre>";
		 				$supplier_bid = $this->purchase_model->get_supplier_bid_details(array('bd.quo_req_id' => $quo_req_id,'bd.mat_id' => $value['mat_id']),explode(',',$value['supplier_id']));
		 				$value['suppliers_bid'] = $supplier_bid;
		 				$bid_details[$value['mat_id']] = $value;
		 			}
		 			
		 			$data['suppliers'] =  $mysuppliers;
		 			$data['bid_details'] = $bid_details;
		 			$data['quotation_request_id'] = $quo_req_id;
		 			$data['suppliers_ids']	= $suppliers_bids;
		    //echo "<pre>"; print_r($bid_details); echo "</pre>";
 					echo $this->load->view('purchase/sub_views/quotation_bid',$data,true);
	 		 }else{
	 		 	 $unit_details = $this->purchase_model->get_unit_listing();
				 $data['unit_list'] = $unit_details;
	 		 	 $request_details = $this->purchase_model->get_quotation_request_details(array('qb.quo_req_id'=>$quo_req_id));
	 		 	 $data['request_materials_list'] = $request_details;
	 		 	 echo $this->load->view('purchase/sub_views/quotation_request_materials',$data,true);   
	 		 }
	 		 
 		}else{
 			echo $this->load->view('errors/html/error_404',$data,true);
 		}
 	}

 	public function get_supplier_quotation_details(){
 		   $data = $this->global;

 		  if(!empty($_POST)){
 		  		$quo_req_id = $_POST['quo_req_id'];
 				$supplier_id = $_POST['supplier_id'];
 				$data['supplier_id'] = $supplier_id;
 				$data['quotation_request_id'] = $quo_req_id;
 				$data['sess_dep_id'] = $this->dep_id;

 				$condition = array("quo_req_id"=>$quo_req_id);
 		 		$quotation_request = $this->purchase_model->quotation_listing($condition);
 		 	
 		 		$data['approval_status_purchase'] = $quotation_request[0]['approval_status_purchase'];
 		 		$data['approval_status_account'] = $quotation_request[0]['approval_status_account'];
 		 		$data['quotation_request'] = $quotation_request;

 		 		//echo "<pre>"; print_r($quotation_request); echo "</pre>";
 				$supplier_details = $this->purchase_model->get_supplier_details($supplier_id);
 				$data['supplier_details'] = $supplier_details;

 				$quotation = $this->purchase_model->get_supplier_quotation(array('quo_req_id'=>$quo_req_id,'supplier_id'=>$supplier_id));
 				$data['quotation'] = $quotation;
 				$quotation_id = $quotation[0]['quotation_id'];
 				$data['quotation_id'] = $quotation_id;
 				$data['cradit_days'] =  $quotation[0]['credit_days'];
 				$data['status_purchase'] = $quotation[0]['status_purchase'];
 				$data['status_account'] = $quotation[0]['status_account'];

 				$data['user_name'] = '';
 				$data['user_name_account'] = '';
 				//echo "<pre>"; print_r($quotation); echo "</pre>";

 				if(isset($quotation[0]['approval_by_purchase']) && !empty($quotation[0]['approval_by_purchase']))
 				{
 					$approved_user_id = $quotation[0]['approval_by_purchase'];
 					$users = $this->user_model->get_user_details($approved_user_id);
 					$data['user_name'] = $users[0]['name']; 
 				}

 				if(isset($quotation[0]['approval_by_account']) && !empty($quotation[0]['approval_by_account']))
 				{
 					$approved_user_id = $quotation[0]['approval_by_account'];
 					$users = $this->user_model->get_user_details($approved_user_id);
 					$data['user_name_account'] = $users[0]['name']; 
 				}

 				$quotation_details = $this->purchase_model->get_supplier_quotation_details(array('bd.quo_req_id'=>$quo_req_id,'bd.quotation_id'=>$quotation_id,'bd.supplier_id'=>$supplier_id));
 				$data['quotation_details'] = $quotation_details;
 				//echo "<pre>"; print_r($quotation_details); echo "</pre>";
 		  		echo $this->load->view('purchase/sub_views/view_quotation',$data,true);
 		  }
 	}

 	public function quotation_status(){

 	  if($this->validate_request()){

 		  $data = $this->global;
		 
		 if(!empty($_POST)){
		 	 $status = $_POST['status'];
		 	 $quotation_id = $_POST['quotation_id'];
		 	 $quo_req_id = $_POST['quo_req_id'];
		 	 $approval_dep = $_POST['approval_dep'];

		 	 $quo_req_id = $this->purchase_model->update_quotation_request_status($status,$quo_req_id,$quotation_id,$approval_dep);
		 	 if($quo_req_id > 0){
		 	 		$quotation_id = $this->purchase_model->update_quotation_status($quotation_id,$status,$approval_dep);
		 	 		if($quotation_id > 0){
		 	 			$result = array(
		 	 				 'status' => 'success',
		 	 				 'message' => 'Quataion Approved',
		 	 				 'redirect' => 'purchase/quotations',
		 	 			);
		 	 		}
		 	 }else{
			 	 	$result = array(
			 	 				 'status' => 'error',
			 	 				 'message' => 'Error ! Quataion Approved'
			 	 	);
		 	 }
		 }else{
		 	 $result = array(
			 	 				 'status' => 'error',
			 	 				 'message' => 'Error ! Post data not found',
			 	 				 'myfunction' => 'purchase/quotation_status'
			 );
		 }
		 echo json_encode($result); 
	   }else{
	   	 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
	   }	 
 	}
 	
 	public function purchase_order($tab = 'tab_1'){
 		 $data = $this->global;  

 		 $condition = array('po.approval_flag' => 'pending', 'po.is_deleted' => '0');
 		 $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['pending_po'] = $po_pending_listing;

 		 $condition = array('po.approval_flag' => 'approved', 'po.is_deleted' => '0');
 		 $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['approved_po'] = $po_approved_listing;

 		 $condition = array('po.approval_flag' => 'approved', 'po.status' => 'completed', 'po.is_deleted' => '0');
 		 $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['completed_po'] = $po_completed_listing;

 		 $data['tabs'] = $tab;

 		 echo $this->load->view('purchase/purchase_orders',$data,true);	
 	}

 	public function purchase_order_quotation(){
 		 $data = $this->global; 

 		 $condition = array('approval_flag' => 'pending', 'po_form' => 'quotation_form');
 		 $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['pending_po'] = $po_pending_listing;

 		 $condition = array('approval_flag' => 'approved', 'po_form' => 'quotation_form');
 		 $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['approved_po'] = $po_approved_listing;

 		 $condition = array('approval_flag' => 'approved', 'po_form' => 'quotation_form', 'status' => 'completed');
 		 $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['completed_po'] = $po_completed_listing;

 		 echo $this->load->view('purchase/purchase_order_quotation_layout',$data,true);
 		//echo $this->load->view('errors/html/error_404',$data,true);
 	}

 	public function purchase_order_requisition(){
 		 $data = $this->global;

 		 $condition = array('approval_flag' => 'pending', 'po_form' => 'requisition_form');
 		 $po_pending_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['pending_po'] = $po_pending_listing;

 		 $condition = array('approval_flag' => 'approved', 'po_form' => 'requisition_form');
 		 $po_approved_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['approved_po'] = $po_approved_listing;

 		 $condition = array('approval_flag' => 'approved', 'po_form' => 'requisition_form', 'status' => 'completed');
 		 $po_completed_listing = $this->purchase_model->purchase_order_listing($condition);
 		 $data['completed_po'] = $po_completed_listing;

 		 echo $this->load->view('purchase/purchase_order_requisition_layout',$data,true);
 	}

 	public function add_purchase_order_form($po_type ='general_po',$dep_id = 0, $supplier_id = 0, $cat_id = 0){
 			 $data = $this->global;
 			 
 			 $po_number = $this->purchase_model->get_purchase_order_number();

		 	 $po_number = explode('/', $po_number[0]->po_number);
		 	 $increment = ($po_number[2] + 1);
		 	 $po_number = $po_number[0].'/'.date('Y').'/'.$increment;

		 	 $data['po_number'] =  $po_number;  

 		     $departments = $this->department_model->get_department_listing();
 		     $data['departments'] = $departments;

 		     $suppliers = $this->purchase_model->get_supplier_listing();
 		     $data['suppliers'] = $suppliers;

	 		 $delievery_schedule = $this->purchase_model->get_delievery_schedule();
	 		 $data['delievery_schedule'] = $delievery_schedule;

	 		 $transport = $this->purchase_model->get_transports();
	 		 $data['transport'] = $transport;

	 		 $freight_charges = $this->purchase_model->get_freight_charges();
	 		 $data['freight_charges'] = $freight_charges;

	 		 $payment_terms = $this->purchase_model->get_payment_terms();
	 		 $data['payment_terms'] = $payment_terms;

	 		 $custom_duty = $this->purchase_model->get_custom_duty();
	 		 $data['custom_duty'] = $custom_duty;


	 		 $where = array('is_deleted' => '0', 'cat_for' => 'general_po');
			 $category = $this->purchase_model->get_category_listing($where);

			 $data['form_type'] = 'insert';
 			 $data['po_type'] = $po_type;
 		 	 $data['dep_id'] = $dep_id;
 		 	 $data['supplier_id'] = $supplier_id;
 		 	 $data['cat_id'] = $cat_id;
 		 	 $data['form'] = 'general';
 		 	 $data['supplier_name'] = '';

 		 	 if($supplier_id > 0){
 		 	 	$supplier_details = $this->purchase_model->get_supplier_details($supplier_id);
 		 	 //echo "<pre>"; print_r($supplier_details); echo "</pre>";
 		 	 	$data['supplier_name'] = $supplier_details[0]['supp_firm_name'];
 		 	 }

 		 	 $data['po_drafts_details'] = '';
 		 	 if($cat_id > 0){
 		 	 	$where = array('pod.cat_id' => $cat_id, 'pod.dep_id' => $dep_id);
 		 	 	$po_drafts_details = $this->purchase_model->get_purchase_order_draft($where);
 		 	 	$unit_details = $this->purchase_model->get_unit_listing();
			 	$data['unit_listing'] = $unit_details;
 		 	 	$data['po_drafts_details'] = $po_drafts_details; 
 		 	 }

 		 	 $data['general_category'] = $category;
 		 	 $data['po_approval_assign_by'] = $dep_user_details = $this->department_model->get_user_details(21);
 			 echo $this->load->view('purchase/forms/add_purchase_order_form',$data,true);
 	}

 	public function add_purchase_order_quotation_form($po_type ='material_po',$dep_id = 0, $supplier_id = 0, $quo_id = 0){
 		 $data = $this->global; 

 		 $po_number = $this->purchase_model->get_purchase_order_number();

		 $po_number = explode('/', $po_number[0]->po_number);
		 $increment = ($po_number[2] + 1);
		 $po_number = $po_number[0].'/'.date('Y').'/'.$increment;

		 $data['po_number'] =  $po_number;  

 		 $departments = $this->department_model->get_department_listing();
 		 $data['departments'] = $departments;

 		 $suppliers = $this->purchase_model->get_supplier_listing();
 		 $data['suppliers'] = $suppliers;

 		 $delievery_schedule = $this->purchase_model->get_delievery_schedule();
 		 $data['delievery_schedule'] = $delievery_schedule;

 		 $transport = $this->purchase_model->get_transports();
 		 $data['transport'] = $transport;

 		 $freight_charges = $this->purchase_model->get_freight_charges();
 		 $data['freight_charges'] = $freight_charges;

 		 $payment_terms = $this->purchase_model->get_payment_terms();
 		 $data['payment_terms'] = $payment_terms;

 		 $custom_duty = $this->purchase_model->get_custom_duty();
 		 $data['custom_duty'] = $custom_duty;

 		 $data['form_type'] = 'insert';
 		 $data['po_type'] = $po_type;
 		 $data['dep_id'] = $dep_id;
 		 $data['supplier_id'] = $supplier_id;
 		 $data['quo_id'] = $quo_id;
 		 $data['form'] = 'quotation';
 		 $data['supplier_name'] = '';

 		 if($supplier_id > 0){
 		 	 $supplier_details = $this->purchase_model->get_supplier_details($supplier_id);
 		 	 //echo "<pre>"; print_r($supplier_details); echo "</pre>";
 		 	 $data['supplier_name'] = $supplier_details[0]['supp_firm_name'];

 		 	$where = array('supplier_id' => $supplier_id, 'status_purchase' => 'approved', 'status_account' => 'approved', 'is_deleted' => '0');
			$quotations = $this->purchase_model->get_supplier_quotation($where);
			//echo "<pre>"; print_r($quotations); echo "</pre>";
			$data['quotations'] = $quotations; 
 		 }

 		 $data['po_drafts_details'] = '';
 		 $data['myquotations'] = array();
 		 if($quo_id > 0){
 		 	 $where = array('pod.quotation_id' => $quo_id, 'pod.dep_id' => $dep_id);
 		 	 $po_drafts_details = $this->purchase_model->get_purchase_order_draft($where);

 		 	$where = array('quotation_id' => $quo_id, 'status_purchase' => 'approved', 'status_account' => 'approved', 'is_deleted' => '0');
			$myquotations = $this->purchase_model->get_supplier_quotation($where);
			//echo "<pre>"; print_r($myquotations); echo "</pre>";
			$data['myquotations'] = $myquotations; 

 		 	 $unit_details = $this->purchase_model->get_unit_listing();
			 $data['unit_listing'] = $unit_details;
 		 	 $data['po_drafts_details'] = $po_drafts_details; 
 		 }

 		 $data['po_approval_assign_by'] = $dep_user_details = $this->department_model->get_user_details(21);
 		 echo $this->load->view('purchase/forms/add_purchase_order_quotation_form',$data,true);
 	}

 	public function add_purchase_order_requisation_form($po_type ='material_po',$dep_id = '0', $supplier_id = '0', $req_id = '0'){
 		 $data = $this->global; 

 		 $po_number = $this->purchase_model->get_purchase_order_number();

		 $po_number = explode('/', $po_number[0]->po_number);
		 $increment = $po_number[2];
		 $po_number = $po_number[0].'/'.date('Y').'/'.$increment;

		 $data['po_number'] =  $po_number;  

 		 $departments = $this->department_model->get_department_listing();
 		 $data['departments'] = $departments;

 		 $suppliers = $this->purchase_model->get_supplier_listing();
 		 $data['suppliers'] = $suppliers;

 		 $delievery_schedule = $this->purchase_model->get_delievery_schedule();
 		 $data['delievery_schedule'] = $delievery_schedule;

 		 $transport = $this->purchase_model->get_transports();
 		 $data['transport'] = $transport;

 		 $freight_charges = $this->purchase_model->get_freight_charges();
 		 $data['freight_charges'] = $freight_charges;

 		 $payment_terms = $this->purchase_model->get_payment_terms();
 		 $data['payment_terms'] = $payment_terms;

 		 $custom_duty = $this->purchase_model->get_custom_duty();
 		 $data['custom_duty'] = $custom_duty;

 		 $data['form_type'] = 'insert';
 		 $data['po_type'] = $po_type;
 		 $data['dep_id'] = $dep_id;
 		 $data['supplier_id'] = $supplier_id;
 		 $data['req_id'] = $req_id;
 		 $data['form'] = 'requisation';
 		 $data['supplier_name'] = '';
 		 $data['req_number'] = '';
 		 if($supplier_id > 0){
 		 	 $supplier_details = $this->purchase_model->get_supplier_details($supplier_id);
 		 	 //echo "<pre>"; print_r($supplier_details); echo "</pre>";
 		 	 $data['supplier_name'] = $supplier_details[0]['supp_firm_name'];
 		 }
 		 $data['po_drafts_details'] = '';
 		 if($req_id > 0){
 		 	 $req_details = $this->store_model->material_requisation_details($req_id);
 		 	 $data['req_number'] = $req_details[0]->req_number;

 		 	 $req_dep_id = $this->store_model->requisation_departments($req_id);
             $req_dep_id = $req_dep_id[0]->dep_id;
             $where = array('pod.req_id' => $req_id, 'pod.dep_id' => $req_dep_id);
 		 	 $po_drafts_details = $this->purchase_model->get_purchase_order_draft($where);
 		 	 $unit_details = $this->purchase_model->get_unit_listing();
			 $data['unit_listing'] = $unit_details;
 		 	 $data['po_drafts_details'] = $po_drafts_details; 
 		 }

 		  $data['po_approval_assign_by'] = $dep_user_details = $this->department_model->get_user_details(21);
 		 echo $this->load->view('purchase/forms/add_purchase_order_requisation_form',$data,true);	
 	}


 	public function get_vendor_approved_quotations(){
 		if($this->validate_request()){
 			$data = $this->global;
			$entityBody = file_get_contents('php://input', 'r');
			$obj_arr = json_decode($entityBody);
			$vendor_id = $obj_arr->vendor_id;
			$where = array('supplier_id' => $vendor_id, 'status_purchase' => 'approved', 'status_account' => 'approved', 'is_deleted' => '0');
			$quotations = $this->purchase_model->get_supplier_quotation($where);
			$data['quotations'] = $quotations; 
			echo $this->load->view('purchase/sub_views/quotations_options',$data,true);
		}else{
			 echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
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
        	echo $this->load->view('purchase/sub_views/requisition_list',$data,true);
 	}

 	public function general_materials(){
 			$data = $this->global;
			$entityBody = file_get_contents('php://input', 'r');
			$obj_arr = json_decode($entityBody);
			$cat_id = $obj_arr->cat_id;
			$submit_type = $obj_arr->submit_type;

			$data['cat_id'] = $cat_id;
			$data['submit_type'] = $submit_type;
			$where = array("m.is_deleted" => "0", "m.cat_id" => $cat_id);
		    $material_list = $this->purchase_model->get_material_listing(false,$where);
		    $data['general_materials'] = $material_list;
		    echo $this->load->view('purchase/sub_views/po_general_materials',$data,true);
 	}

 	public function selected_material_generals(){
 		 if($this->validate_request()){ 
 		 	 $mat_id = explode(',', $_POST['mat_ids']);
             $action = $_POST['action'];
             $cat_id = $_POST['cat_id']; 
             $dep_id = $_POST['dep_id'];

             $supplier_id = $_POST['supplier_id'];
			 $po_type = $_POST['po_type'];

             $where = array('dep_id' => $dep_id, 'cat_id' => $cat_id);
             $po_details_draft = $this->purchase_model->delete_purchase_order_draft($where);
             foreach ($mat_id as $key => $val) {
             		$insert_data = array(
                		'cat_id' => $cat_id,
                		'mat_id' =>	$val,
                		'hsn_code' => null,
                		'dep_id' => $dep_id,
                		'unit_id' => '2',
                		'qty' => '0',
                		'rate' => '0.00',
                		'expire_date' => date("Y-m-d"),
                		'cgst_per' => '0',
                		'cgst_amt' => '0.00',
                		'sgst_per' => '0',
                		'sgst_amt' => '0.00',
                		'igst_per' => '0',
                		'igst_amt' => '0.00',
                		'discount' => '0.00',
                		'mat_amount' => '0.00',
                		'discount_per' => '0.00'
                	);

                	$po_draft_id[] = $this->purchase_model->insert_po_details_draft($insert_data);
             }
             if(count($po_draft_id) > 0){
                	$result = array(
		 	 				 'status' => 'success',
		 	 				 'redirect' => 'purchase/add_purchase_order_form/'.$po_type.'/'.$dep_id.'/'.$supplier_id.'/'.$cat_id,
		 	 	    );
             }
            echo json_encode($result); 
 		 }else{
 		 	echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		 }
 	}

 	public function get_vendor_approved_quotation_details(){
 			$data = $this->global;
 		 if($this->validate_request()){		
 			$entityBody = file_get_contents('php://input', 'r');
			$obj_arr = json_decode($entityBody);
			$quo_id = $obj_arr->quo_id;
			$supplier_id = $obj_arr->supplier_id;
			$po_type = $obj_arr->po_type;
			$dep_id = $obj_arr->dep_id;


			$quotation = $this->purchase_model->get_supplier_quotation(array('quotation_id'=>$quo_id,'is_deleted' => '0'));

			$condition = array('bd.quotation_id' => $quo_id, 'bd.is_deleted' => '0', 'status' => 'approval');
			$quotation_details =  $this->purchase_model->get_supplier_quotation_details($condition);
			
			$where = array('dep_id' => $dep_id, 'quotation_id' => $quo_id);
			$po_details_draft = $this->purchase_model->delete_purchase_order_draft($where);

			//echo "<pre>"; print_r($quotation_details); echo "</pre>";
			$po_draft_id = array();
			foreach ($quotation_details as $key => $mat_details) {
				$insert_data = array(
					'quotation_id' => $quo_id,
					'mat_id' => $mat_details['mat_id'],
					'hsn_code' => null,
					'dep_id' => $dep_id,
					'unit_id' => $mat_details['unit_id'],
					'qty' => $mat_details['quo_qty'],
					'rate' => $mat_details['quo_rate'],
					'expire_date' => $mat_details['expire_date'],
					'cgst_per' => $mat_details['cgst_per'],
                	'cgst_amt' => $mat_details['cgst_amt'],
                	'sgst_per' => $mat_details['sgst_per'],
                	'sgst_amt' => $mat_details['sgst_amt'],
                	'igst_per' => $mat_details['igst_per'],
                	'igst_amt' => $mat_details['igst_amt'],
                	'discount' => $mat_details['discount'],
                	'mat_amount' => $mat_details['quo_price'],
                	'discount_per' => $mat_details['discount_per']
				);
				$po_draft_id[] = $this->purchase_model->insert_po_details_draft($insert_data);
			}

			if(count($po_draft_id) > 0){
                	$result = array(
		 	 				 'status' => 'success',
		 	 				 'redirect' => 'purchase/add_purchase_order_quotation_form/'.$po_type.'/'.$dep_id.'/'.$supplier_id.'/'.$quo_id,
		 	 	    );
            }
            echo json_encode($result); 
		}else{
			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
		}	

 	}

 	public function get_requisation_materials_list(){
 			$data = $this->global; 
 			if(!empty($_POST))
            {
                $req_id = $_POST['req_id'];
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
                echo $this->load->view('purchase/sub_views/po_view_requisation_material_list',$data,true);
            }else{
                echo $this->load->view('errors/html/error_404',$data,true);
            }
 	}

 	public function get_requisation_material_details(){
 		  	if($this->validate_request()){		
 		  		$entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$req_id = $obj_arr->req_id;	
				$supplier_id = $obj_arr->supplier_id;
				$po_type = $obj_arr->po_type;

 		   		$dep_id = $this->store_model->requisation_departments($req_id);
                $dep_id = $dep_id[0]->dep_id;
                $where = array('rdm.dep_id' => $dep_id, 'rdm.req_id' => $req_id);
                $selected_materials = $this->store_model->get_selected_req_material_details($where);
                $where = array('dep_id' => $dep_id, 'req_id' => $req_id);
                $po_details_draft = $this->purchase_model->delete_purchase_order_draft($where);
                $po_draft_id = array();
                foreach ($selected_materials as $key => $mat_details) {
                	$insert_data = array(
                		'req_id' => $mat_details['req_id'],
                		'mat_id' =>	$mat_details['mat_id'],
                		'hsn_code' => null,
                		'dep_id' => $mat_details['dep_id'],
                		'unit_id' => $mat_details['unit_id'],
                		'qty' => $mat_details['require_qty'],
                		'rate' => '0.00',
                		'expire_date' => date("Y-m-d"),
                		'cgst_per' => '0',
                		'cgst_amt' => '0.00',
                		'sgst_per' => '0',
                		'sgst_amt' => '0.00',
                		'igst_per' => '0',
                		'igst_amt' => '0.00',
                		'discount' => '0.00',
                		'mat_amount' => '0.00',
                		'discount_per' => '0.00'
                	);

                	$po_draft_id[] = $this->purchase_model->insert_po_details_draft($insert_data);
                }	

                if(count($po_draft_id) > 0){
                	$result = array(
		 	 				 'status' => 'success',
		 	 				 'redirect' => 'purchase/add_purchase_order_requisation_form/'.$po_type.'/'.$dep_id.'/'.$supplier_id.'/'.$req_id,
		 	 	    );
                }
                echo json_encode($result); 
          }else{
          	  echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
          }     
 	}

 	public function get_purchase_order_materials_list(){
 		$data = $this->global; 
 		if($this->validate_request())
 		{	
	 		if(!empty($_POST))
	        {
	        	 $po_id = $_POST['po_id'];

	        	 $condition = array('po_id' => $po_id);
	 		 	 $purchase_order = $this->purchase_model->purchase_order_listing($condition);
	 		 	 $data['purchase_order'] = $purchase_order;

	 		 	// echo "<pre>"; print_r($purchase_order); echo "</pre>";

	        	 $where = array('po.po_id' => $po_id);
	             $selected_materials = $this->purchase_model->get_selected_po_material_details($where);
	             $data['purchase_order_details'] = $selected_materials;
	             $unit_details = $this->purchase_model->get_unit_listing();
	             $data['unit_list'] = $unit_details; 
	             echo $this->load->view('purchase/sub_views/po_view_selected_material_list',$data,true);
	        }else{
	        	echo $this->load->view('errors/html/error_404',$data,true);
	        }
	    }else{
	    	echo $this->load->view('errors/html/error_404',$data,true);
	    }    
 	}

 	public function change_purchase_order_status(){
 			$data = $this->global;
 			if($this->validate_request())
 		    {
 		    	$entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$po_id = $obj_arr->po_id;
				$status = $obj_arr->status;
				$po_update_data['approval_flag'] = $status;
				$po_update_data['approval_by'] = $this->user_id;
				$po_update_data['approval_date'] =date('Y-m-d H:i:s');
				$mypo_id = $this->purchase_model->update_purchase_order($po_update_data,$po_id);

				if($mypo_id > 0){
					$result = array(
						"status"=>"success",
						"redirect" => "purchase/purchase_order"
					);
				}
				echo json_encode($result);
 		    }else{
 		    	echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		    }
 	}

 	public function edit_purchase_order_form($variable = 'po_id',$po_id = 0, $amend ='no'){
 		 $data = $this->global;
 		 $data['po_id'] = $po_id;
 		 $where = array('po_id' => $po_id);
 		 $purchase_orders = $this->purchase_model->get_purchase_order($where);

 		 $data['form_type'] = 'edit';

 		 //echo "<pre>"; print_r($purchase_orders); echo "</pre>";

 		 $departments = $this->department_model->get_department_listing();
 		 $data['departments'] = $departments;

 		 $suppliers = $this->purchase_model->get_supplier_listing();
 		 $data['suppliers'] = $suppliers;


 		 $delievery_schedule = $this->purchase_model->get_delievery_schedule();
 		 $data['delievery_schedule'] = $delievery_schedule;

 		 $transport = $this->purchase_model->get_transports();
 		 $data['transport'] = $transport;

 		 $freight_charges = $this->purchase_model->get_freight_charges();
 		 $data['freight_charges'] = $freight_charges;

 		 $payment_terms = $this->purchase_model->get_payment_terms();
 		 $data['payment_terms'] = $payment_terms;

 		 $custom_duty = $this->purchase_model->get_custom_duty();
 		 $data['custom_duty'] = $custom_duty;
 		 
 		  if($purchase_orders[0]['supplier_id'] > 0){
 		 	 $supplier_details = $this->purchase_model->get_supplier_details($purchase_orders[0]['supplier_id']);
 		 	 //echo "<pre>"; print_r($supplier_details); echo "</pre>";
 		 	 $data['supplier_name'] = $supplier_details[0]['supp_firm_name'];
 		 }

 		 $unit_details = $this->purchase_model->get_unit_listing();
		 $data['unit_listing'] = $unit_details;

 		 if($purchase_orders[0]['po_form'] == 'requisition_form'){
 		 	if($purchase_orders[0]['req_id'] > 0){
 		 		$req_details = $this->store_model->material_requisation_details($purchase_orders[0]['req_id']);
 		 	 	$data['req_number'] = $req_details[0]->req_number;
         		$data['req_id'] = $purchase_orders[0]['req_id'];
 		 	}
 		    $data['form'] = 'requisation';
 		 }

 		 if($purchase_orders[0]['po_form'] == 'quotation_form'){
 		 	if($purchase_orders[0]['quotation_id'] > 0){
 		 		$where = array('supplier_id' => $purchase_orders[0]['supplier_id'], 'quotation_id' => $purchase_orders[0]['quotation_id'], 'status_purchase' => 'approved', 'status_account' => 'approved', 'is_deleted' => '0');
				$quotations = $this->purchase_model->get_supplier_quotation($where);
				$data['quo_number'] = $quotations[0]['quotation_number'];
				$data['quotation_id'] = $purchase_orders[0]['quotation_id'];
 		 	}
 		 	$data['form'] = 'quotation';
 		 }

 		 if($purchase_orders[0]['po_form'] == 'general_form'){
 		 	$data['form'] = 'general';
 		 	$where = array('is_deleted' => '0', 'cat_for' => 'general_po');
			$category = $this->purchase_model->get_category_listing($where);
			$data['general_category'] = $category;
			$data['cat_id'] = $purchase_orders[0]['cat_id'];
 		 }

 		 $where = array('po.po_id' => $po_id);
         $selected_materials = $this->purchase_model->get_selected_po_material_details($where);
         $data['po_details'] = $selected_materials;

 		 $data['po_approval_assign_by'] = $dep_user_details = $this->department_model->get_user_details(21);

 		 if($amend == 'yes'){ //echo "inn1"; die;
   		 	 $purchase_orders[0]['approval_flag'] = 'pending';
   		 	 $purchase_orders[0]['po_number'] = $purchase_orders[0]['po_number'].'-A';
   		 }


 		 if($purchase_orders[0]['approval_flag'] == 'approved'){
      			$disabled = 'disabled="disabled"';
   		 }else{
      			$disabled = '';
   		 } 

   		 $data['disabled'] = $disabled;
   		 $data['amend'] = $amend;
   		 $data['purchase_order'] = $purchase_orders;
   		 // echo "<pre>"; print_r($purchase_orders); echo "</pre>";
 		 echo $this->load->view('purchase/forms/edit_purchase_order_form',$data,true);
 	}


 	public function insert_terms_conditions(){
 		if($this->validate_request()){		
 		  		$entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$new_terms = $obj_arr->new_terms;
				$terms_table = $obj_arr->table;
				$coloumn = $obj_arr->coloumn;

				$insert_data  = array(''.$coloumn.'' => $new_terms);
				$this->purchase_model->insert_terms_conditions($terms_table, $insert_data);
				$terms = $this->purchase_model->get_terms_conditions($terms_table);
				$data['terms'] = $terms;
				$data['coloumn_name'] = $coloumn; 
				//echo "<pre>"; print_r($terms); echo "</pre>";
				echo $this->load->view('purchase/sub_views/dropdown_terms_conditions',$data,true);
		}else{
			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
		}				
 	}

 	public function remove_purchase_order(){
 		if($this->validate_request()){
 			$entityBody = file_get_contents('php://input', 'r');
			$obj_arr = json_decode($entityBody);
			$po_id = $obj_arr->po_id;

			$id = $this->purchase_model->remove_purchase_order($po_id);
			if($id > 0){
				$result = array(
                    'status' => 'success',
                    'po_id' => $po_id,
                    'message' => 'Removed purchase order',
                    'redirect' => 'purchase/purchase_order'
                );
               echo json_encode($result); exit; 
			}
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		}
 	}

 	public function get_supplier_assign_department(){
 		if($this->validate_request()){
 				$entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$dep_id = $obj_arr->dep_id;

				$assign_supplier = $this->common_model->get_supplier_assign_department($dep_id);
				$vendor_id = array();
				foreach ($assign_supplier as $key => $value) {
					$vendor_id[] = $value['supplier_id'];
				}

				$suppliers = $this->purchase_model->get_supplier_listing();
				if(!empty($suppliers)){
				 	$data['mysuppliers'] = $suppliers;
				 	$data['vendor_id'] = $vendor_id;
				}
			   echo $this->load->view('purchase/sub_views/dropdown_supplier_listing',$data,true);
				
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		}
 	}

 	public function change_material_status(){
 		if($this->validate_request()){
 			if(!empty($_POST)){
        		$mat_id = explode(',', $_POST['ids']);
 				$status = $_POST['status'];
 				$quotation_id = $_POST['quotation_id'];
 				$mystatus = $this->purchase_model->update_quotation_material_status($status,$mat_id,$quotation_id);
 				if($mystatus){
 					if($status == 'pending'){
 						$msg = 'UnChecked Material Disapproved';
 					}else{
 						$msg = 'Checked Material Approved';
 					}

 					$result = array(
 						'status' => 'success',
 						'message' => $msg
 					);
 				}
            }else{
            	$result = array(
 						'status' => 'error',
 						'message' => 'Post value not found'
 				);
            }
            echo json_encode($result);		
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		}
 	}

 	public function send_purchase_order_quotation(){
 		if($this->validate_request()){
 			    $entityBody = file_get_contents('php://input', 'r');
				$obj_arr = json_decode($entityBody);
				$po_id = $obj_arr->po_id;
				$vendor_id = $obj_arr->vendor_id;
				$quotation_id = $obj_arr->quo_id;

				$where = array('supplier_id' => $vendor_id, 'quotation_id' => $quotation_id, 'is_deleted' => '0');
				$quotation = $this->purchase_model->get_supplier_quotation($where); 
				$vendor_panal_quotation_id = $quotation[0]['vendor_panal_quotation_id'];
				
				$details = array(
					'erp_po_id' => $po_id,
					'erp_vendor_id' => $vendor_id,
					'erp_quotation_id' => $quotation_id,
					'vendor_quotation_id' => $vendor_panal_quotation_id
				);

				$url = $this->config->item("vendor_erp").'Api_erp/add_purchase_order';
				$fields_string = http_build_query($details);
        		$ch = curl_init();
        		 curl_setopt($ch,CURLOPT_URL, $url);
        		 curl_setopt($ch,CURLOPT_POST, 1);
        		 curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        		 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        		 curl_setopt($ch,CURLOPT_HEADER, 0);
                            //execute post
        		 $result2 = curl_exec($ch);
        		curl_close($ch);
        		$resp = json_decode($result2);
        		//echo "<pre>"; print_r($resp); echo "</pre>"; die;
        		if($resp->status == 'success'){
        			$result = array(
        				"status" => 'success',
        				"message" => $resp->message
        			);
        		}else{
        			$result = array(
        				"status" => 'error',
        				'redirect' => 'purchase/purchase_order'

        			);
        		}
        	echo json_encode($result);
 		}else{
 			echo json_encode(array("status"=>"error", "message"=>"Access Denied, Please re-login."));
 		}
 	}

}
