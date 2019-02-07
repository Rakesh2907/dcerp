<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
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

    public function notification_list($notify = 'all'){

      if($this->validate_request())
      {
      	  $login_user_id = $this->user_id;
          $data = $this->global;
          if($notify == 'all'){
              $where = array('notify_to' => $login_user_id);
          }else{
              $where = array('notify_to' => $login_user_id, 'notify_check'=> 'unseen');
          }
          
          $notification_details = $this->common_model->get_notifications($where);

          //echo "<pre>"; print_r($notification_details); echo "</pre>"; die;

          if(!empty($notification_details)){
              $data['notification_list'] = $notification_details;
          }else{
               $data['notification_list'] = '';
          }
            echo $this->load->view('notification/notification_layout',$data,true);
      }else{
            echo $this->load->view('errors/html/error_404',$data,true);
      }

    }


}	