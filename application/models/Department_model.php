<?php 
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
class Department_model extends CI_Model {

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
        // Your own constructor code
    }

    public function insert_department($insert_data){
    	 $this->db->insert('erp_departments',$insert_data);
         return $this->db->insert_id();
    }

    public function update_department($update_data,$dep_id){
    	$this->db->where('dep_id',$dep_id);
        $this->db->update('erp_departments',$update_data);
        return true;
    }


    public function get_department_listing(){
    	$this->db->select("*");
        $this->db->from("erp_departments");
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $dep_details = $query->result_array();
        if(!empty($dep_details)){
            return $dep_details;
        } else {
            return array();
        }
    }

    public function delete_department($dep_id){
    	 $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where_in('dep_id', $dep_id);
         $this->db->update('erp_departments');
         return true;
    }

    public function get_export_department_details($dep_id){
    	 $this->db->select("*");
         $this->db->from("erp_departments");
         $this->db->where_in('dep_id',$dep_id);
         $this->db->where("is_deleted","0");
         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $dep_details = $query->result_array();
         if(!empty($dep_details)){
            return $dep_details;
         } else {
            return array();
         }
    }


    public function get_department_details($where){
    	$this->db->select("*");
        $this->db->from("erp_departments");
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $dep_details = $query->result_array();
        if(!empty($dep_details)){
            return $dep_details;
        } else {
            return array();
        }
    }

    public function get_next_pre_dep($navigation,$dep_id){

    	if($navigation == 'next'){
    		$next_id = 'SELECT min(dep_id) FROM erp_departments WHERE dep_id > '.$dep_id.' AND is_deleted ="0"';
    		$sql = 'SELECT dep_id FROM erp_departments WHERE dep_id = ('.$next_id.') AND is_deleted = "0"';
    	}else{
    		$pre_id = 'SELECT max(dep_id) FROM erp_departments WHERE dep_id < '.$dep_id.' AND is_deleted = "0"';
            $sql = 'SELECT dep_id FROM erp_departments WHERE dep_id = ('.$pre_id.') AND is_deleted = "0"';
    	}

    	$dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $data_arr = $dbResult->row_array();
            $data_arr = $data_arr['dep_id'];
        }else{
            $data_arr = 0;
        }
        return $data_arr;
    }

    public function get_user_details($dep_id){
        $this->db->select("*");
        $this->db->from("users"); 
        $this->db->where_in("dep_id",$dep_id); 
        $this->db->where("isDeleted","0");

        $query = $this->db->get();
        //echo $this->db->last_query();
        $user_details = $query->result_array();
        if(!empty($user_details)){
                return $user_details;
        }else{
                return array();
        }

    }

    public function get_approval_to_user_details($where = array()){
            $this->db->select("*");
            $this->db->from("users"); 
            if(!empty($where)){
                $this->db->where($where);
            }
            $query = $this->db->get();
            //echo $this->db->last_query();
            $user_details = $query->result_array();
            if(!empty($user_details)){
                    return $user_details;
            }else{
                    return array();
            }
    }

    public function check_department_used($dep_id,$tables){
        $dep_count = array();
         foreach ($tables as $key => $table) 
         {
                 $sql = 'SELECT dep_id FROM `'.$table.'` WHERE dep_id = '.$dep_id.' AND is_deleted = "0"';
                 $dbResult = $this->db->query($sql);
                 //echo $this->db->last_query();

                 if($dbResult->num_rows() > 0){
                    $data_arr = $dbResult->row_array();
                    $data_arr = $data_arr['dep_id'];
                    $dep_count[] = $data_arr;
                 }
        }
        return $dep_count; 
    }
}
?>