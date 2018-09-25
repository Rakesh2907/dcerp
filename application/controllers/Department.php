<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller 
{   
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
            $this->global['access'] = json_decode($user_details['permissions']);
            $this->global['token'] = $user_details['token'];
        }
        $this->load->model('department_model');	
    }

    // Department listing
    public function index(){
    	$data = $this->global;
    	$departments = $this->department_model->get_department_listing();
    	//echo "<pre>"; print_r($departments); echo "</pre>";
    	$data['departments'] = $departments;
    	echo $this->load->view('department/department_layout',$data,true);
    }

    // Add new department form
    public function add_department_form(){
    	$data = $this->global;
    	echo $this->load->view('department/forms/add_department_form',$data,true);
    }

    // edit department
 	public function edit_department_form($dep_id){
 		$data = $this->global;
 		if($dep_id > 0){

 			$data['next_dep_id'] = $this->department_model->get_next_pre_dep('next',$dep_id); 
			$data['pre_dep_id'] = $this->department_model->get_next_pre_dep('pre',$dep_id); 


 			$department_details = $this->department_model->get_department_details(array('dep_id' => $dep_id));
 			$data['dep_details'] = $department_details; 
 			echo $this->load->view('department/forms/edit_department_form',$data,true);
 		}else{
 			echo $this->load->view('errors/html/error_404',$data,true);
 		}
 		
 	}

 	// Delete Department
 	public function delete_department(){
 		if(isset($_POST)){
 			$dep_id = $_POST['ids'];

            $tables =  $tables = array('erp_material_requisition','erp_material_requisition_details');

            $check_dep = $this->department_model->check_department_used($dep_id,$tables);
            if(count($check_dep) > 0){
                $result = array(
                         'status' => 'warning',
                         'message' => "This department not permitted to delete. It's Used"
                );
            }else{
 			    $deleted = $this->department_model->delete_department($dep_id);
        	    if($deleted){
                    $result = array(
                         'status' => 'success',
                         'message' => "Deleted Department",
                         'redirect' => 'department/index'
                    );
                }
            }    
 		}else{
            $result = array(
                'status' => 'error',
                'message' => 'Error! Department Id not found'
            );
        }

        echo json_encode($result);
 	}

    // Save and update department
    public function save_department(){
    	$post_obj = $_POST;
    	if(!empty($post_obj)){
    		//echo "<pre>"; print_r($post_obj); echo "</pre>";
    		if($post_obj['submit_type'] == 'insert'){
    			$insert_data = array(
    				'dep_name' => strtoupper(trim($post_obj['dep_name'])),
    				'dep_description' => trim($post_obj['dep_description']),
    				'created' => date('Y-m-d H:i:s'),
    				'created_by' => $this->user_id,
    				'is_deleted' => '0'
    			);

    			$insert_dep_id = $this->department_model->insert_department($insert_data);
				if($insert_dep_id > 0){
					echo (int)$insert_dep_id;
				}
    		}else{
    			$dep_id = $post_obj['dep_id'];
    			$update_data = array(
    				'updated' => date('Y-m-d H:i:s'),
    				'updated_by' => $this->user_id,
    				'dep_name' => strtoupper(trim($post_obj['dep_name'])),
    				'dep_description' => trim($post_obj['dep_description'])
    			);
    			$this->department_model->update_department($update_data,$dep_id);
    			echo 'updated';
    		}

    	}else{

    	}
    }

    public function export_department()
    {
    	 if(isset($_REQUEST)){
    	 	$dep_id = explode(',', $_REQUEST['ids']);
    	 	$dep_details = $this->department_model->get_export_department_details($dep_id);
			//echo "<pre>"; print_r($supplier_details); echo "</pre>"; exit; 


    	 	$this->load->library('PHPExcel');
		 	$objPHPExcel = new PHPExcel();

		 	$objPHPExcel->setActiveSheetIndex(0)
		 	  		->setCellValue('A1', '#')
                    ->setCellValue('B1', 'Department name')
                    ->setCellValue('C1', 'Department Description');

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

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            if(!empty($dep_details)){
            	$cell_no = 2;
            	$ser_no = 1;
            	foreach ($dep_details as $key => $data) {
            		$objPHPExcel->setActiveSheetIndex(0)
            		 				->setCellValue('A'.$cell_no, $ser_no)
                    				->setCellValue('B'.$cell_no, $data['dep_name'])
                    				->setCellValue('C'.$cell_no, $data['dep_description']);
                   $cell_no ++; 
            	   $ser_no ++; 				
            	}
            }


		 	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="department_summary_'.date("YmdHis").'.xlsx"');
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
}

?>