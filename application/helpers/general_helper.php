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

function add_users_activity($module_name,$user_id,$activities){

        $insert_data = array(
            'modules' => $module_name,
            'user_id'=> $user_id,
            'activities'=> $activities,
            'activities_date_time'=>date('Y-m-d H:i:s')
        );

        $CI =& get_instance();
        $CI->db->insert('erp_user_activities',$insert_data);
        return $CI->db->insert_id();
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

function convertToIndianCurrency($number) 
{
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}
//echo "56721351.61 = " . convertToIndianCurrency(56721351.61);
?>