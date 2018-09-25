<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
class Store_model extends CI_Model {
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
        // Your own constructor code
    }

    public function material_requisation_listing($dep_id,$where){
         $this->db->select("mr.*,d.dep_name, d.dep_id");
         $this->db->from("erp_material_requisition mr");
         $this->db->join("erp_departments as d", "mr.dep_id = d.dep_id");
         if($dep_id != '21'){
            $this->db->where("mr.dep_id", $dep_id);
         }
         $this->db->where($where);
         $this->db->order_by("mr.req_id", "asc");
         $query = $this->db->get();
         //echo $this->db->last_query();exit;
         $material_req = $query->result_array();
         if(!empty($material_req)){
                return $material_req;
         }else{
                return array();
         }
    }

    public function selected_material_requisation_details($mat_id,$dep_id,$req_id){
       $assign_id = array(); 
       foreach ($mat_id as $key => $id) {
           $insert_data = array(
                    'mat_id' => $id,
                    'dep_id' => $dep_id,
                    'req_id' => $req_id
           );
           $this->db->insert('erp_material_requisition_details',$insert_data);
            array_push($assign_id,$id);
       }
       return $assign_id;
    }

    public function selected_material_requisation($mat_id,$dep_id){
    	$assign_id = array();
    	foreach ($mat_id as $key => $id) {
    		$insert_data = array(
                    'mat_id' => $id,
                    'dep_id' => $dep_id,
             );
             $this->db->insert('erp_material_requisation_draft',$insert_data);
             array_push($assign_id,$id);
    	}
    	return $assign_id;
    }

    public function get_selected_materials_draft($where){
    	 $this->db->select("m.mat_id, m.mat_code, m.mat_name, rdm.mat_id, rdm.dep_id, rdm.unit_id, rdm.require_qty, rdm.require_date, rdm.material_note");
         $this->db->from("erp_material_master m");
         $this->db->join("erp_material_requisation_draft as rdm","m.mat_id = rdm.mat_id","left");
         $this->db->where($where); 
         $this->db->where("m.is_deleted","0");
         $this->db->order_by("rdm.req_draft_id", "asc");

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $materials = $query->result_array();
         if(!empty($materials)){
                return $materials;
         }else{
                return array();
         }
    }

    public function get_selected_req_material_details($where){
          $this->db->select("m.mat_id, m.mat_code, m.mat_name, rdm.id, rdm.id, rdm.req_id, rdm.mat_id, rdm.dep_id, rdm.unit_id, rdm.require_qty, rdm.require_date, rdm.require_users, rdm.material_note");
          $this->db->from("erp_material_master m");
          $this->db->join("erp_material_requisition_details as rdm","m.mat_id = rdm.mat_id","left");
          $this->db->where($where); 
          $this->db->where("m.is_deleted","0");
          $this->db->where("rdm.is_deleted","0");
          $this->db->order_by("rdm.id", "asc");

          $query = $this->db->get();
            //echo $this->db->last_query();exit;
          $materials = $query->result_array();
          if(!empty($materials)){
                    return $materials;
          }else{
                    return array();
          }
    }

    public function remove_selected_material($dep_id,$material_id){
    	 $this->db->where('mat_id', $material_id);
    	 $this->db->where('dep_id', $dep_id);
         $this->db->delete('erp_material_requisation_draft');    
         return true;
    }

    public function remove_selected_material_details($id,$req_id){
            $this->db->set('is_deleted', "1");
            $this->db->where('id', $id);
            $this->db->where('req_id', $req_id);
            $this->db->update('erp_material_requisition_details');
            return true;   
    }


    public function get_material_requisation_number(){
    	 $this->db->select("material_requisation_number");
    	 $this->db->from("erp_auto_increament");
    	 $this->db->where("id",1);
    	 $query = $this->db->get();
    	 $requisation_number = $query->result();
         if(!empty($requisation_number)){
                return $requisation_number;
         }else{
                return array(); 
         }
    }

    public function insert_material_requisation($insert_data){
    	   $this->db->insert('erp_material_requisition',$insert_data);
    	   return $this->db->insert_id();
    }

    public function update_material_requisation($update_data,$req_id){
           $this->db->where('req_id', $req_id);
           $this->db->where('is_deleted', "0");  
           $this->db->update('erp_material_requisition',$update_data);
           return $req_id;
    }

    public function insert_selected_material($insert_data,$mat_id){
           $this->db->insert('erp_material_requisition_details', $insert_data);
           return $mat_id;
    }

    public function delete_requisation_details($req_id,$dep_id){
            $this->db->where('dep_id', $dep_id);
            $this->db->where('req_id', $req_id);
            $this->db->delete('erp_material_requisition_details'); 
            return true;
    }

    public function delete_requisation_drafts($mat_id,$dep_id){
            $this->db->where('dep_id', $dep_id);
            $this->db->where_in('mat_id', $mat_id);
            $this->db->delete('erp_material_requisation_draft'); 
    }

    public function update_requisation_number($req_number){
            $this->db->set('material_requisation_number', $req_number);
            $this->db->update('erp_auto_increament');
            return true;   
    }

    public function material_requisation_details($req_id){
           $this->db->select("*");
           $this->db->from("erp_material_requisition"); 
           $this->db->where("req_id", $req_id);

           $query = $this->db->get();
           $requisation_details = $query->result();

           if(!empty($requisation_details)){
                return $requisation_details;
           }else{
                return array();
           }

    }

    public function requisation_departments($req_id){
         $this->db->select("dep_id");
         $this->db->from("erp_material_requisition"); 
         $this->db->where("req_id", $req_id);

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $dep_ids = $query->result();

         if(!empty($dep_ids)){
                return $dep_ids;
         }else{
                return array();
         }
    }

    public function upadate_status($req_id,$status)
    {
        $this->db->set('approval_flag', $status);

        if($status == 'approved'){
            $this->db->set('approval_date', date("Y-m-d H:i:s"));  
        }
        $this->db->where('req_id', $req_id);
        $this->db->where('is_deleted', "0");  
        $this->db->update('erp_material_requisition');
        return true;  
    }

    public function insert_material_quotation_draft($insert_data){
         $this->db->insert('erp_material_quotation_draft',$insert_data);
         return $this->db->insert_id();
    }

    public function update_note_material_draft($material_note,$mat_id){

          $this->db->set('material_note', $material_note);
          $this->db->where('dep_id', $this->dep_id);
          $this->db->where('mat_id', $mat_id);

          $this->db->update('erp_material_requisation_draft');
          return true;  
    }

    public function update_note_material_req_details($material_note,$detail_id){
          $this->db->set('material_note', $material_note);
          $this->db->where('dep_id', $this->dep_id);
          $this->db->where('id', $detail_id);
          $this->db->update('erp_material_requisition_details');
          return true; 
    }
}    
?>