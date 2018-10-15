<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function is_logged_in() 
{
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $sessionArray = $CI->session->userdata('erp');
    $user_id = $sessionArray['userId'];
    $is_login = $sessionArray['isLoggedIn'];
    if(isset($user_id) && $user_id > 0 && $is_login == 1){
        return $sessionArray;
    }else{
        return 0;
    }  
}

function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
 }

function get_menu($parent_id = null,$user_id)
{
        $where = "FIND_IN_SET('".$user_id."', m.user_id)";  

		$CI =& get_instance();
		$CI->db->select("m.*");
		$CI->db->from("erp_menu AS m");
		$CI->db->where("m.is_deleted","0");
		$CI->db->where("m.parent_menu_id",$parent_id);
        $CI->db->where($where);
		$CI->db->order_by("m.menu_id", "ASC");
		$query_menu = $CI->db->get();

		if($query_menu->num_rows()>0){
				return $query_menu->result_array();
		}else{
				return array();
		}	
}

function get_department($user_id){
    $CI =& get_instance();
    $CI->db->select("dep_id");
    $CI->db->from("users");
    $CI->db->where("isDeleted","0");
    $CI->db->where("id",$user_id);
    $query = $CI->db->get();
     //echo $CI->db->last_query();exit;
    if($query->num_rows()>0){
        $dep = $query->result_array();
        $dep_id = $dep[0]['dep_id'];
        return $dep_id;
    }else{
        return 0;
    }   
}

function access_department(){
        $CI =& get_instance();
        $CI->db->select("*");
        $CI->db->from("erp_departments");
        $CI->db->where("is_deleted","0");
        $CI->db->where("access_permission",'true');
        $query = $CI->db->get();
         //echo $CI->db->last_query();exit;
        if($query->num_rows()>0){
            $departments = $query->result_array();
            foreach ($departments as $key => $value) {
               $dep_id[$key] = $value['dep_id'];
            }
            return $dep_id;
        }else{
            return 0;
        }  
}

function get_permissions($user_id){
    $CI =& get_instance();
    $CI->db->select("permissions");
    $CI->db->from("users");
    $CI->db->where("isDeleted","0");
    $CI->db->where("id",$user_id);
    $query = $CI->db->get();
     //echo $CI->db->last_query();exit;
    if($query->num_rows()>0){
        $per = $query->result_array();
        $permissions = $per[0]['permissions'];
        return $permissions;
    }else{
        return 0;
    }
}

function validateAccess($functionality, $access_arr){
       // echo $functionality; print_r($access_arr); //exit;        
        if(in_array('all', $access_arr)){
            return true;
        }elseif(in_array($functionality, $access_arr)){
            return true;
        }
        return false;
}

function send_quotation_notification($quo_req_id,$supplier_id){
            //$quo_req_id = 2;
            $supplier_id = explode(',',$supplier_id);
            //$condition = array("quo_req_id"=>$quo_req_id);
            $url = array();
            foreach ($supplier_id as $key => $id) {
                $token_create = array(
                            'supplier_id' => $id, 
                            'quo_req_id' => $quo_req_id
                );

                $url[] = "?token=".base64_encode(serialize($token_create));
            }
        return $url;    
}

?>