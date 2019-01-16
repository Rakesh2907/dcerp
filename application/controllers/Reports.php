<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 * Updated by Rakesh Ahirrao, December 2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Reports extends CI_Controller 
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
        $this->load->model('report_model');	
        $this->scope = [];
        // Your own constructor code
    }


    public function index(){
		$data = $this->global;


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

    private function stacked_bar_purchase_order($departments, $selected_year, $selected_month){
        $dep_purchase_order = array();

        foreach ($departments as $key => $dep_name)
        {
              $where = array('d.dep_id' => $dep_name['dep_id'], 'po.is_deleted' => '0');
              // $like = $selected_year.'-'.$selected_month;
              $like = $selected_year;
              $purchase_order_list = $this->report_model->get_department_wise_purchase_order($where,$like);

              //echo "<pre>"; print_r($purchase_order_list); echo "</pre>";
              $pending_count  = 1;
              $approved_count = 1;
              $completed_count = 1;

              foreach ($purchase_order_list as $key => $po_list) 
              {
                    if($po_list['dep_id'] == $dep_name['dep_id'])
                    {
                        if($po_list['approval_flag'] == 'pending' && $po_list['status'] == 'non_completed'){
                            $dep_purchase_order[$dep_name['dep_name']]['pending'] =  $pending_count;
                            $pending_count++;
                        }

                        if($po_list['approval_flag'] == 'approved' && $po_list['status'] == 'non_completed'){
                            $dep_purchase_order[$dep_name['dep_name']]['approved'] =  $approved_count;
                            $approved_count++;
                        }

                        if($po_list['status'] == 'completed'){
                            $dep_purchase_order[$dep_name['dep_name']]['completed'] =  $completed_count;
                            $completed_count++;
                        }
                        
                    }
              }
         }

        return $dep_purchase_order;
    }

    private function coloum_bar_material_requisition($departments, $selected_year, $selected_month){
        $dep_material_requisition = array();
        foreach ($departments as $key => $dep_name)
        {
                $where = array('d.dep_id' => $dep_name['dep_id'], 'pmr.is_deleted' => '0');
               // $like = $selected_year.'-'.$selected_month;
                $like = $selected_year;
                $material_req_list = $this->report_model->get_department_wise_material_requisition($where,$like);

               // echo "<pre>"; print_r($material_req_list); echo "</pre>";
                $pending_count  = 1;
                $hod_approved_count = 1;
                $completed = 1;
                foreach ($material_req_list as $key => $req_list) 
                {
                    if($req_list['dep_id'] == $dep_name['dep_id'])
                    {

                        if($req_list['purchase_approval_flag'] == 'pending'){
                            $dep_material_requisition[$dep_name['dep_name']]['pending'] =  $pending_count;
                            $pending_count++;
                        }

                        if($req_list['purchase_approval_flag'] == 'approved'){
                            $dep_material_requisition[$dep_name['dep_name']]['approved'] =  $hod_approved_count;
                            $hod_approved_count++;
                        }

                        if($req_list['purchase_approval_flag'] == 'completed'){
                            $dep_material_requisition[$dep_name['dep_name']]['completed'] =  $completed;
                            $completed++;
                        }
                        
                    }
                }
        }

          return $dep_material_requisition;

    }

    private function horizontal_bar_chart_panal($departments, $selected_year, $selected_month){
    	    $dep_consumption = array();
    	foreach ($departments as $key => $dep_name)
    	{

            $where = array('d.dep_id' => $dep_name['dep_id'], 'out.is_deleted' => '0');
            $like = $selected_year.'-'.$selected_month;
            $material_batch_list = $this->report_model->get_department_wise_outward_batch_list($where,$like);

            if(!empty($material_batch_list)){
                 //echo "<pre>"; print_r($material_batch_list); echo "</pre>";
                $total_dep_amount[$dep_name['dep_id']] = 0;
                foreach ($material_batch_list as $key => $batch_list) {
                    
                     if($batch_list['dep_id'] == $dep_name['dep_id']){
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

                        
                         $total_amount[$dep_name['dep_id']][$key] =  ($mat_amount[$key] + $cgst_amt[$key] + $sgst_amt[$key] + $igst_amt[$key]);
                       
                         $dep_consumption[$dep_name['dep_name']] += $total_amount[$dep_name['dep_id']][$key];
                           
                     }
                }
            }
        }

        return $dep_consumption;
    }

    private function line_chart_panel($sel_departments, $selected_line_year){
    	$month_consumption = array();
    	$month_number_list = array('01','02','03','04','05','06','07','08','09','10','11','12');
        foreach ($sel_departments as $key => $dep_name){

        	$where = array('d.dep_id' => $dep_name['dep_id'], 'out.is_deleted' => '0');
            $like = $selected_line_year;
            $selected_batch_list = $this->report_model->get_department_wise_outward_batch_list($where,$like);	

       		foreach ($selected_batch_list as $key => $value) {
       			 $myoutward_date = explode('-', $value['outward_date']);
       			 $month_number = $myoutward_date[1];
       			 if (in_array($month_number, $month_number_list)){
       			 	 $m_number = date('m',strtotime($value['outward_date']));
       			 	 if($month_number == $m_number)
       			 	 {

       			 	 	$mat_amount[$key] =  ($value['outward_qty'] * $value['rate']);

                        if(!empty($value['discount'])){
                            $mat_amount[$key] =  ($mat_amount[$key] - $value['discount']);  
                        }

                        if(isset($value['discount_per']) && !empty($value['discount_per'])){
                            $minus_amt[$key] = (($value['discount_per']/100) * $mat_amount[$key]);
                            $mat_amount[$key] = (float)$mat_amount[$key] - (float)$minus_amt[$key];
                        }

                         $cgst_amt[$key] = (($value['cgst_amt_per']/100) * $mat_amount[$key]);

                         $sgst_amt[$key] = (($value['sgst_amt_per']/100) * $mat_amount[$key]);

                         $igst_amt[$key] = (($value['igst_amt_per']/100) * $mat_amount[$key]);

                        
                         $total_amount[$month_number][$key] =  ($mat_amount[$key] + $cgst_amt[$key] + $sgst_amt[$key] + $igst_amt[$key]);
                       
                         $month_consumption[$month_number] += $total_amount[$month_number][$key];
       			 	 	 
       			 	 }
       			 }
       		}
        }

        return $month_consumption;
    }

	public function material_consumption(){
		 $data = $this->global;

		 //$month = 8;
		 //echo $monthName = date("F", mktime(0, 0, 0, $month, 10));
		 $data['sess_dep_id']= $this->dep_id;
		 if(!empty($_POST)){
		 	    $selected_month = trim($_POST['selected_month']);		
	  		  $selected_year =  trim($_POST['selected_year']);
			    $data['dep_id']= $selected_department = trim($_POST['dep_id']);
			    $selected_line_year = trim($_POST['selected_line_year']);
	  			$coloum_last_years = trim($_POST['coloum_last_years']);
          $staked_last_years = trim($_POST['staked_last_years']);
		 }else{
        $last_month_year = explode('-',date('Y-m', strtotime(date('Y-m')." -1 month")));

		 		$selected_month = trim($last_month_year[1]);
        $selected_year = $selected_line_year = $coloum_last_years = $staked_last_years = trim($last_month_year[0]);
         
		 	  $data['dep_id']= $selected_department = $this->dep_id;
		 }

		 $data['selected_year'] = $selected_year;
		 $data['selected_line_year'] = $selected_line_year;
     $data['selected_coloum_year'] = $coloum_last_years;
     $data['selected_stacked_year'] = $staked_last_years;
		 $data['last_month'] = $selected_month;
		 $current_year = date('Y');
		 $range = range($current_year, $current_year-10);
		 $years = array_combine($range, $range);
		 $months = array(
			  '01'=> 'January',
			  '02'=> 'February',
			  '03'=> 'March',
			  '04'=> 'April',
			  '05'=> 'May',
			  '06'=> 'June',
			  '07'=> 'July ',
			  '08'=> 'August',
			  '09'=> 'September',
			  '10'=> 'October',
			  '11'=> 'November',
			  '12'=>'December'
		 );

		 $data['month_list'] = $months;
		 $data['last_years'] = $years; 

		 $departments = $this->department_model->get_department_listing();
		 $data['departments_list'] = $departments;

     $dep_consumption = $this->horizontal_bar_chart_panal($departments, $selected_year, $selected_month);

        $depname = array();
        $dep_outward_mat = array();
        if(!empty($dep_consumption)){
            foreach ($dep_consumption as $dep_name => $dep_value) {
                $depname[] = "'".$dep_name."'";
                $dep_outward_mat[] = $dep_value; 
            }
        }
         
        $data['departments'] = implode(', ', $depname);
        $data['dep_cusumption_val'] = implode(', ', $dep_outward_mat);


        $condition = array('dep_id' => $selected_department);

        $sel_departments = $this->department_model->get_department_details($condition);

       
        $month_consumption = $this->line_chart_panel($sel_departments, $selected_line_year);


         //echo "<pre>"; print_r($month_consumption); echo "</pre>"; 
       	$month_outward_val = array();
       	$month_year = array();

       	if(!empty($month_consumption)){
       		//sort($month_consumption);
            foreach ($month_consumption as $month_num => $month_value) {
                $month_year[] = "'".$month_num."-".$selected_line_year."'";
                $month_outward_val[] = $month_value; 
            }
        }

        $data['month_year_val'] = implode(', ', $month_year);
        $data['month_cusumption_val'] = implode(', ', $month_outward_val);

        $dep_material_requisition = $this->coloum_bar_material_requisition($departments, $coloum_last_years, $selected_month);

        $reqdep = array();
        $req_spending = array();
        $req_scompleted = array();
        $req_sapproved = array();
        $req_spending_count = $req_scompleted_count = $req_sapproved_count = 0;
        if(!empty($dep_material_requisition)){
           foreach ($dep_material_requisition as $dep_name => $dep_val) {
                $reqdep[] = "'".$dep_name."'";
                if(isset($dep_val['pending'])){
                     $req_spending[] = $dep_val['pending'];
                     $req_spending_count +=$dep_val['pending'];
                }else{
                     $req_spending[] = 0;
                }

                if(isset($dep_val['completed'])){
                    $req_scompleted[] = $dep_val['completed'];
                    $req_scompleted_count +=$dep_val['completed'];
                }else{
                    $req_scompleted[] = 0;
                }
               
               if(isset($dep_val['approved'])){
                    $req_sapproved[] = $dep_val['approved']; 
                    $req_sapproved_count +=$dep_val['approved'];
               }else{ 
                    $req_sapproved[] = 0;
               } 
           }
        }

        $data['store_mat_req_dep'] = implode(', ', $reqdep);
        $data['store_mat_pending'] = implode(', ', $req_spending);
        $data['store_mat_completed'] = implode(', ', $req_scompleted);
        $data['store_mat_approved'] =implode(', ', $req_sapproved);
        $data['store_total_pending'] = $req_spending_count;
        $data['store_total_completed'] = $req_scompleted_count;
        $data['store_total_approved'] = $req_sapproved_count;

        //echo "<pre>"; print_r($dep_material_requisition); echo "</pre>";

        $dep_purchase_orders = $this->stacked_bar_purchase_order($departments, $staked_last_years, $selected_month);
        
        $po_dep = array();
        $po_pending = array();
        $po_completed = array();
        $po_approved = array();
        $po_pending_count = $po_completed_count = $po_approved_count = 0;
        if(!empty($dep_material_requisition))
        {
           foreach ($dep_purchase_orders as $dep_name => $dep_val) {
                $po_dep[] = "'".$dep_name."'";
                if(isset($dep_val['pending'])){
                     $po_pending[] = $dep_val['pending'];
                     $po_pending_count +=$dep_val['pending'];
                }else{
                     $po_pending[] = 0;
                }

                if(isset($dep_val['completed'])){
                    $po_completed[] = $dep_val['completed'];
                    $po_completed_count +=$dep_val['completed'];
                }else{
                    $po_completed[] = 0;
                }
               
               if(isset($dep_val['approved'])){
                    $po_approved[] = $dep_val['approved'];
                    $po_approved_count += $dep_val['approved'];
               }else{ 
                    $po_approved[] = 0;
               } 
           }

            $data['po_dep'] = implode(', ', $po_dep);
            $data['po_pending'] = implode(', ', $po_pending);
            $data['po_completed'] = implode(', ', $po_completed);
            $data['po_approved'] =implode(', ', $po_approved);
            $data['po_total_pending'] = $po_pending_count;
            $data['po_total_completed'] = $po_completed_count;
            $data['po_total_approved'] = $po_approved_count;
            //echo "<pre>"; print_r($dep_purchase_orders); echo "</pre>";
        }

		    echo $this->load->view('reports/material_consumption_layout',$data,true);
	}

    public function grr_passing($from_grn_date=null, $to_grn_date=null, $vendor_id='0'){
        $data = $this->global;

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

        echo $this->load->view('reports/grr_passing_layout',$data,true);
    }	

    public function export_grr_passing_excel_sheet(){
        if(isset($_REQUEST))
        {

           $from_date = date('Y-m-d',strtotime($_REQUEST['from_date']));
           $to_date = date('Y-m-d',strtotime($_REQUEST['to_date'])); 
           $vendor_id = $_REQUEST['vendor_id'];


           if(!empty($from_date) && !empty($to_date))
           {
                 $where = array('iwd.grn_date >=' => $from_date, 'iwd.grn_date <=' => $to_date, 'iwd.inward_form' => 'material_inward_form', 'iwd.is_deleted' => '0', 'batch.is_deleted' => '0');

                 if($vendor_id > 0){
                      $where['iwd.vendor_id'] = $vendor_id;
                 }
           }

           $material_batch_list = $this->report_model->inward_batch_wise_listing($where);

          // echo "<pre>"; print_r($material_batch_list); echo "</pre>"; die;


           if(!empty($material_batch_list)){
                $i = 0;
                foreach ($material_batch_list as $key => $value) {
                   $sheet[$value['cat_name']][$value['mat_code']][] = $value;
                }
                ksort($sheet);
           }

           $this->load->library('PHPExcel');
           $objPHPExcel = new PHPExcel(); 

           $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B8', 'Sr.No.')
                ->setCellValue('C8', 'Material Code')
                ->setCellValue('D8', 'Material Name')
                ->setCellValue('E8', 'Unit')
                ->setCellValue('F8', 'Bar code/CAT NO')
                ->setCellValue('G8', 'Batch No')
                ->setCellValue('H8', 'Received Qty')
                ->setCellValue('I8', 'Accepted Qty')
                ->setCellValue('J8', 'Expiry Date')
                ->setCellValue('K8', 'Shipping Temp')
                ->setCellValue('L8', 'Storage Temp')
                ->setCellValue('M8', 'Stored In Location')
                ->setCellValue('N8', 'Batch Status')
                ->setCellValue('O8', 'Remarks');



           $default_border = array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb'=>'000000'));

           $style_header = array(
                  'borders' => array('bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border),
                  'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9')),
                  'font' => array('bold' => true)
           );

           $style_row = array(
                  'font' => array('bold' => true)
           );

           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:R2');
           $objPHPExcel->getActiveSheet()->getCell('A2')->setValue('Datar Cancer Genetics Limted');
           $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:R2')->applyFromArray($style_header);


           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:R3');
           $objPHPExcel->getActiveSheet()->getCell('A3')->setValue('GRR QC Passing Statement');
           $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:R3')->applyFromArray($style_header);

           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:R5');
           $objPHPExcel->getActiveSheet()->getCell('A5')->setValue('FROM GRN Date: '.date('d/m/Y',strtotime($from_date)).' TO GRN Date: '.date('d/m/Y',strtotime($to_date)));

           $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
           $objPHPExcel->setActiveSheetIndex(0)->getStyle('A5:R5')->applyFromArray($style_header);


            $objPHPExcel->getActiveSheet()->getStyle("A5:R5")->getFont()->setSize(12);


            $objPHPExcel->setActiveSheetIndex(0)->getStyle('B8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('C8')->applyFromArray($style_header)->getFont()->setSize(12); 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('D8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('E8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('H8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('I8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('J8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('K8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('L8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('M8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('N8')->applyFromArray($style_header)->getFont()->setSize(12);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('O8')->applyFromArray($style_header)->getFont()->setSize(12);
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);    
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

            //echo "<pre>"; print_r($sheet); echo "</pre>";  die;

            if(!empty($sheet))
            {
                $start_cell_no = 11;
                $cell_no = 11;
               
                foreach ($sheet as $cat_name => $data) 
                {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$start_cell_no, $cat_name)->getStyle('A'.$start_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$start_cell_no)->applyFromArray($style_row)->getFont()->setSize(12);

                        $ser_no = 1;
                        $mat_code_cell_no = $cell_no;
                        foreach ($data as $mat_code => $value) {
                         
                             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$cell_no, $ser_no)->getStyle('B'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cell_no, $mat_code)->getStyle('C'.$cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                         $mat_name_cell_no = $cell_no;     
                           foreach ($value as $key => $val) {
                              if(isset($val['sub_material_name']) && !empty($val['sub_material_name'])){
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$mat_name_cell_no, $val['sub_material_name']);
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$mat_name_cell_no, $val['sub_mat_unit']);
                              }else{
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$mat_name_cell_no, $val['mat_name']);
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$mat_name_cell_no, $val['mat_unit']);
                              }

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$mat_name_cell_no, $val['bar_code']);
                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$mat_name_cell_no, $val['batch_number']);
                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$mat_name_cell_no, $val['received_qty'])->getStyle('H'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$mat_name_cell_no, $val['accepted_qty'])->getStyle('I'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               if($val['na_allowed'] == 'yes'){
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$mat_name_cell_no, 'NA');
                               }else{
                                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$mat_name_cell_no, date('d/m/Y', strtotime($val['expire_date'])));
                               }

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$mat_name_cell_no, $val['shipping_temp'])->getStyle('K'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$mat_name_cell_no, $val['storage_temp'])->getStyle('L'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$mat_name_cell_no, $val['stored_in'])->getStyle('M'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$mat_name_cell_no, ucfirst($val['qc_batch_status']))->getStyle('N'.$mat_name_cell_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$mat_name_cell_no, $val['qc_batch_remark']);

                              $mat_name_cell_no++;
                           }
                          $cell_no = $mat_name_cell_no; 
                          $ser_no++;          
                        }
                       //$cell_no = $mat_code_cell_no;      
                    
                    $cell_no = $cell_no + 2;
                    $start_cell_no = $cell_no;   
                }

               $footer_cell_no =   $start_cell_no + 4;
               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$footer_cell_no, 'Inspected By:');
               $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$footer_cell_no)->applyFromArray($style_row)->getFont()->setSize(12);

               $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$footer_cell_no, 'Checked By:');
               $objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.$footer_cell_no)->applyFromArray($style_row)->getFont()->setSize(12);
            }
           //die;
             // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="GRRN_QC_Passing_Summary'.date("YmdHis").'.xlsx"');
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
              add_users_activity('Reports GRR Passing',$this->user_id,'Export GRR Passing details');
              exit;
        }    
    }

    public function outward_excel_sheet_store(){
          $data = $this->global;
          if($this->validate_request()){
                 $departments = $this->department_model->get_department_listing();
                 $data['departments'] = $departments;

                 $from_date = date('Y-m-d',strtotime($fselected_from_outward_date));
                 $to_date = date('Y-m-d',strtotime($fselected_to_outward_date));

                $where = array();

                 if(!empty($fselected_from_outward_date) && !empty($fselected_to_outward_date)){
                    $where = array('out.outward_date >=' => $from_date, 'out.outward_date <=' => $to_date, 'out.is_deleted' => '0');

                    if(!empty($dep_id)){
                        $where['out.dep_id'] = $dep_id;
                    }
                 }
                
                $outwards = $this->store_model->outward_listing($where);
                $data['outwards'] = $outwards;
                $data['fselected_from_outward_date'] = $fselected_from_outward_date;
                $data['fselected_to_outward_date'] = $fselected_to_outward_date;
                $data['selected_dep_id'] = $dep_id;
                echo $this->load->view('reports/outward_batch_wise_report',$data,true);
          }else{
                echo $this->load->view('errors/html/error_404',$data,true);
          }
    }

}