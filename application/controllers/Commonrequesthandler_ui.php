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
          //echo "<pre>"; print_r($inward_material); echo "<pre>";
          $data['inward_form_type'] = $inward_material[0]['inward_form'];

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

  public function export_outward_excel_sheet(){
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

                      $material_list[$key] = array(
                        'material_name' => $batch_list['mat_name'],
                        'material_code' => $batch_list['mat_code'],
                        'batch_number' =>  $batch_list['batch_number'],
                        'outward_date' => date('d-m-Y', strtotime($batch_list['outward_date'])),
                        'outward_qty' => $batch_list['outward_qty'],
                        'pack_size' => $batch_list['pack_size'],
                        'expire_date' => date('d-m-Y', strtotime($batch_list['expire_date'])),
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


                 $this->load->library('PHPExcel');
                 $objPHPExcel = new PHPExcel();

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
              add_users_activity('Outward',$this->user_id,'Export Issue details');
              exit;

             }
          }   
  }


}
