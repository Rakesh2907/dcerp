<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
 
class Common_model extends CI_Model {

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

    public function get_sub_menu_details($parent_id = null)
    {

    	$where = "FIND_IN_SET('".$this->user_id."', m.user_id)";
    	$this->db->select("m.*");
		$this->db->from("erp_menu AS m");
		$this->db->where("m.is_deleted","0");
		$this->db->where("m.parent_menu_id",$parent_id);
		$this->db->where($where);
		$this->db->order_by("m.menu_id", "ASC");

		$query_menu = $this->db->get();

		if($query_menu->num_rows()>0){
				return $query_menu->result_array();
		}else{
				return array();
		}
    }

    public function get_supplier_assign_department($dep_id){

            $where = "FIND_IN_SET('".$dep_id."', dep_id)";
            $this->db->select("supplier_id");
            $this->db->from("erp_supplier");
            $this->db->where("is_deleted","0");
            $this->db->where($where);
            $this->db->order_by("supplier_id", "asc");
            $query = $this->db->get();
            //echo $this->db->last_query();//exit;
            $supplier_details = $query->result_array();
            if(!empty($supplier_details)){
                return $supplier_details;
            } else {
                return array();
            }
    }


    public function update_unit($unit_id,$mat_id,$table){
            $this->db->set('unit_id', $unit_id);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $this->dep_id);
            $this->db->update($table);
            return true;
    }

    public function set_quantity($quantity,$mat_id,$table){
            $this->db->set('require_qty', $quantity);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $this->dep_id);
            $this->db->update($table);
            return true;
    }

    public function set_require_date($require_date,$mat_id,$dep_id,$table){
            $this->db->set('require_date', $require_date);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $dep_id);
            $this->db->update($table);
            return true;
    }

    public function get_sub_materials($where){
            $this->db->select("*");
            $this->db->from("erp_sub_material_master");
            $this->db->where($where);
            $query = $this->db->get();
            //echo $this->db->last_query();//exit;
            $material_details = $query->result_array();
            if(!empty($material_details)){
                return $material_details;
            }else{
                return array();
            } 
    }

    public function get_material_batch_number($where){  //get_sub_materials_batch_number
            $this->db->select("*");
            $this->db->from("erp_material_inward_batchwise");
            $this->db->where($where);
            $query = $this->db->get();
            //echo $this->db->last_query();//exit;
            $batch_details = $query->result_array();
            if(!empty($batch_details)){
                return $batch_details;
            }else{
                return array();
            } 
    }

    public function remove_batch_number($where){
         $this->db->set('is_deleted', '1');
         $this->db->set('updated', date("Y-m-d H:i:s"));
         $this->db->set('updated_by', $this->user_id);
         $this->db->where($where);
         $this->db->update('erp_material_inward_batchwise');
         return $this->db->affected_rows();
    }



}    