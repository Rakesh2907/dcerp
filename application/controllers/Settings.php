<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller 
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
          $dep_access = access_department();
          $this->global['access'] = json_decode(get_permissions($this->user_id));//json_decode($user_details['permissions']);
          $this->global['token'] = $user_details['token'];
          $this->global['access_dep'] = $dep_access;
        }
    	 $this->load->model('settings_model');
         $this->load->model('common_model'); 
         $this->load->model('user/user_model');    
    }

    public function index($tab="menu-settings"){
    	$data = $this->global;
    	$menu_details = $this->common_model->get_sub_menu_details();
        $users = $this->user_model->get_users();
        $access_keys = $this->user_model->get_all_access_keys();
        //echo "<pre>"; print_r($access_keys); echo "</pre>";
        $data['myusers'] = $users;
        $data['parent_menu'] = $menu_details;
        $data['access_keys'] = $access_keys;
        $data['tabs'] = $tab;
    	echo $this->load->view('settings/settings_layout',$data,true);
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
         $data['sub_menu'] = $sub_menu_details;
         $data['menu_parent_id'] = $parent_id;
         echo $this->load->view('settings/sub_views/sub_menu_listing',$data,true);
    }

    public function save_parent_menu(){
         if(!empty($_POST)){
              $users = implode(',', $_POST['user_id']);
              if($_POST['submit_type'] == 'insert'){
                   $inset_data = array(
                        'menu_name' => trim($_POST['menu_name']),
                        'menu_description' => trim($_POST['menu_description']),
                        'menu_links' => trim($_POST['menu_links']),
                        'menu_icon' => trim($_POST['menu_icon']),
                        'sub_menu' => trim($_POST['sub_menu']),
                        'created' => date("Y-m-d H:i:s"),
                        'created_by' => $this->user_id,
                        'user_id' => $users
                   );

                   if($_POST['parent_id'] > 0){
                        $inset_data['parent_menu_id'] = $_POST['parent_id'];
                   }

                   $menu_id = $this->settings_model->insert_menu($inset_data);
                   if($menu_id > 0){
                            $result = array(
                                'status' => 'success',
                                'message' => 'Menu added successfully',
                                'redirect' => 'settings/index'
                            );
                    }
              }else{
                    $menu_id = $_POST['menu_id'];
                    $users = implode(',', $_POST['user_id']);
                    $update_data = array(
                        'menu_name' => trim($_POST['menu_name']),
                        'menu_description' => trim($_POST['menu_description']),
                        'menu_links' => trim($_POST['menu_links']),
                        'menu_icon' => trim($_POST['menu_icon']),
                        'sub_menu' =>trim($_POST['sub_menu']),
                        'updated' => date("Y-m-d H:i:s"),
                        'updated_by' => $this->user_id,
                        'user_id' => $users
                    );
                    $menu_id = $this->settings_model->update_menu($update_data,$menu_id);
                    if($menu_id > 0){
                        $result = array(
                                'status' => 'success',
                                'message' => 'Menu updated successfully',
                                'redirect' => 'settings/index'
                        );
                    }
              }
         }else{
                $result = array(
                                'status' => 'error',
                                'message' => 'Error! data not post.',
                );
         }
         echo json_encode($result);
    }
    
    public function save_access_permission(){
         if(!empty($_POST)){
            $permission_key = array();
            foreach ($_POST['access_keys'] as $key => $value) {
                array_push($permission_key, '"'.$value.'"');
            }
            $per_key = implode(', ', $permission_key);
            $per_key = "[".$per_key."]";
            $user_id = $_POST['emp_user_id'];
            if($this->user_model->assign_assess_key($per_key,$user_id) > 0){
                $result  = array(
                    'status' => 'success', 
                    'message' => 'Permission set successfully',
                    'redirect' => 'settings/index/user-settings'
                );
            }else{
                $result = array(
                                'status' => 'error',
                                'message' => 'Error! in Permission',
                );
            }
         }
         echo json_encode($result);
    }

    public function get_menu_details(){
         if(!empty($_POST)){
              $menu_id = $_POST['menu_id'];
              $menu_details = $this->settings_model->get_menu_details($menu_id);
              if(!empty($menu_details)){
                echo json_encode($menu_details);
              }
         }     
    }


    public function remove_memu(){
          if(!empty($_POST)){
              $menu_id = $_POST['menu_id'];
              $menu_details = $this->settings_model->get_menu_details($menu_id);
              if($menu_details[0]['parent_menu_id'] == null && $menu_details[0]['menu_links'] == null && $menu_details[0]['sub_menu'] == 0){
                  if($this->settings_model->delete_menu($menu_id)){
                    $result = array(
                        'status' => 'success',
                        'message' => 'Delete menu successfully',
                        'redirect' => 'settings/index'
                    );   
                  }
              }else{
                    $result = array(
                        'status' => 'warning',
                        'message' => 'This menu not permitted to delete...!',
                    );
              }

          }else{
                $result = array(
                        'status' => 'error',
                        'message' => 'Error! Post value not found',
                );
          }

          echo json_encode($result);
    }

    public function remove_sub_memu(){
             if(!empty($_POST))
             {
                    $menu_id = $_POST['menu_id'];
                    $menu_details = $this->settings_model->get_menu_details($menu_id);
                    if($menu_details[0]['menu_links'] == null && $menu_details[0]['sub_menu'] == 0){
                        if($this->settings_model->delete_menu($menu_id)){
                            $result = array(
                                'status' => 'success',
                                'message' => 'Delete sub menu successfully',
                                'redirect' => 'settings/index'
                            );   
                        }
                    }else{
                         $result = array(
                            'status' => 'warning',
                            'message' => 'This menu not permitted to delete...!',
                         );
                    }
             }else{
                    $result = array(
                            'status' => 'error',
                            'message' => 'Error! Post value not found',
                    );
             }
         echo json_encode($result);    
    }


    public function clear_cache(){
        header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
        header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
        header ("Cache-Control: no-cache, must-revalidate");  
        header ("Pragma: no-cache");
    }
}
?>