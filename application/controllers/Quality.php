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

    public function grr_passing(){
    	 $data = $this->global;
    	 echo $this->load->view('quality/grr_passing_layout',$data,true);
    }
}