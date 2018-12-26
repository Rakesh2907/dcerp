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

    private function horizontal_bar_chart_panal($departments, $selected_year, $selected_month){
    	    $dep_consumption = array();
    	foreach ($departments as $key => $dep_name)
    	{

            $where = array('d.dep_id' => $dep_name['dep_id']);
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

        	$where = array('d.dep_id' => $dep_name['dep_id']);
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
	  			
		 }else{
		 		$selected_month = date('m', strtotime('-1 month'));
		 		$selected_year = $selected_line_year = date('Y');	
		 	    $data['dep_id']= $selected_department = $this->dep_id;
		 }

		 $data['selected_year'] = $selected_year;
		 $data['selected_line_year'] = $selected_line_year;
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

		echo $this->load->view('reports/material_consumption_layout',$data,true);
	}	

}