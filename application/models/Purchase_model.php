<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 * Updated by Rakesh Ahirrao, October 2018
 */
 
class Purchase_model extends CI_Model {
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

    public function get_unit_listing(){

    	$this->db->select("*");
        $this->db->from("erp_unit_master");
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        $units = $query->result_array();
        if(!empty($units)){
            return $units;
        } else {
            return array();
        }
    }

    public function get_supplier_listing(){
        $this->db->select("*");
        $this->db->from("erp_supplier");
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        $supplier = $query->result_array();
        if(!empty($supplier)){
            return $supplier;
        } else {
            return array();
        }
    }

    public function get_category_listing($where){
        $this->db->select("*");
        $this->db->from("erp_categories");
        $this->db->where($where);
        $query = $this->db->get();
        $category = $query->result_array();
        if(!empty($category)){
            return $category;
        } else {
            return array();
        }
    }

    public function get_location_listing(){
        $this->db->select("*");
        $this->db->from("erp_locations");
        $query = $this->db->get();
        $locations = $query->result_array();
        if(!empty($locations)){
            return $locations;
        } else {
            return array();
        }
    }

    public function get_terms_conditions($table){
          $this->db->select("*"); 
          $this->db->from($table);
          $query = $this->db->get();
          $terms = $query->result_array();
          if(!empty($terms)){
                return $terms;
          }else{
                return array();
          } 
    }

    public function get_material_listing($flag=false,$where){
        $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.mat_details, m.current_stock, m.rejected_current_qty, m.minimum_level, m.mat_status, m.scrape_opening_qty, m.scrape_current_qty, c.cat_id, c.cat_name, u.unit_id, u.unit");
        $this->db->from("erp_material_master m");
        $this->db->join('erp_categories as c','m.cat_id = c.cat_id');
        $this->db->join('erp_unit_master as u','m.unit_id = u.unit_id');
        $this->db->where($where);

        $query = $this->db->get();
        $materials = $query->result_array();
        if(!empty($materials)){
            return $materials;
        } else {
            return array();
        }
    }

    public function get_export_material_details($mat_id){

        $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.mat_details, m.current_stock, m.rejected_current_qty, m.minimum_level, m.mat_status, m.scrape_opening_qty, m.scrape_current_qty, m.parent_mat_code, m.parent_mat_name, c.cat_id, c.cat_name, u.unit_id, u.unit");
        $this->db->from("erp_material_master m");
        $this->db->join('erp_categories as c','m.cat_id = c.cat_id');
        $this->db->join('erp_unit_master as u','m.unit_id = u.unit_id');
        $this->db->where_in('m.mat_id',$mat_id);
        $this->db->where("m.is_deleted","0");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $materials = $query->result_array();
        if(!empty($materials)){
            return $materials;
        } else {
            return array();
        }
    }

    public function get_assign_material($supplier_id){
         $this->db->select("m.mat_id, m.mat_code, m.mat_name, sm.sup_mat_code, sm.mat_rate, sm.unit_id, sm.mat_discount, sm.lead_time, sm.credit_days");
         $this->db->from("erp_material_master m");
         $this->db->join('erp_supplier_materials as sm','m.mat_id = sm.mat_id','left');
         $this->db->where('sm.supplier_id',$supplier_id); 
         $this->db->where("m.is_deleted","0");
         $this->db->where("sm.is_deleted","0"); 
         $this->db->order_by("sm.id", "asc");

         $query = $this->db->get();
        //echo $this->db->last_query();//exit;
         $materials = $query->result_array();
         if(!empty($materials)){
                return $materials;
         }else{
                return array();
         }

    }

    public function update_assign_material($update_data,$mat_id,$supplier_id){
         $this->db->where('supplier_id', $supplier_id);
         $this->db->where('mat_id', $mat_id);
         $this->db->where('is_deleted', "0");
         $this->db->update('erp_supplier_materials',$update_data);
         return $mat_id;
    }

    
    public function update_purchase_order($update_data,$po_id){
          $this->db->where('po_id', $po_id);
          $this->db->where('is_deleted', "0");
          $this->db->update('erp_purchase_order',$update_data);
          return $po_id;
    }

    public function update_selected_purachase_order($update_data,$po_id,$mat_id){
          $this->db->where('po_id', $po_id);
          $this->db->where('mat_id', $mat_id);
          $this->db->where('is_deleted', "0");
          $this->db->update('erp_purchase_order_details',$update_data);
          return $mat_id;  
    }

    public function remove_supplier_assign_material($supplier_id,$material_id){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where('supplier_id', $supplier_id);
         $this->db->where('mat_id', $material_id);
         $this->db->update('erp_supplier_materials');
         return true;   
    }

    public function get_material_listing_pop_up($assign_material = array()){
        //echo "ewewe <pre>"; print_r($assign_material); echo "</pre>";
        $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.cat_id, m.mat_rate, c.cat_name, c.cat_stockable, c.cat_id");
        $this->db->from("erp_material_master m");
        $this->db->join("erp_categories as c", "m.cat_id = c.cat_id");
        $this->db->where("m.is_deleted","0");

        if(!empty($assign_material)){
            $this->db->where_not_in('m.mat_id', $assign_material);  
        }
        $query = $this->db->get();
         //echo $this->db->last_query(); //exit;
        $material = $query->result_array();
        if(!empty($material)){
            return $material;
        } else {
            return array();
        }
    }

    public function insert_unit($insert_data){
    	 $this->db->insert('erp_unit_master',$insert_data);
         return $this->db->insert_id();
    }

    public function insert_supplier($insert_data){
         $this->db->insert('erp_supplier',$insert_data);
         return $this->db->insert_id();
    }

    public function insert_categories($insert_data){
         $this->db->insert('erp_categories',$insert_data);
         return $this->db->insert_id();
    }

    public function insert_sub_categories($insert_data){
        $this->db->insert('erp_sub_categories',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_material($insert_data){
        $this->db->insert('erp_material_master',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_po_details_draft($insert_data){
        $this->db->insert('erp_purchase_order_details_draft',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_terms_conditions($terms_table, $insert_data){
         $this->db->insert(''.$terms_table.'',$insert_data);
    }

    public function delete_units($delete_units){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where_in('unit_id', $delete_units);
         $this->db->update('erp_unit_master');
         return true;
    }
    
    public function delete_supplier($delete_supplier){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where_in('supplier_id', $delete_supplier);
         $this->db->update('erp_supplier');
         return true;
    }

    public function delete_material($mat_id){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where('mat_id',$mat_id);
         $this->db->update('erp_material_master');
         return true;
    }

    public function check_supplier_used($supplier_id,$tables){
        $supplier_count = array();
        foreach ($tables as $key => $table) {
             $sql = 'SELECT supplier_id FROM `'.$table.'` WHERE supplier_id IN ('.$supplier_id.') AND is_deleted = "0"';
             $dbResult = $this->db->query($sql);
              //echo $this->db->last_query();
             if($dbResult->num_rows() > 0){
                     $data_arr = $dbResult->row_array();
                     $data_arr = $data_arr['supplier_id'];
                     $supplier_count[] = $data_arr;
             }
        }
        return $supplier_count;
    }

    public function check_unit_used($unit_id,$tables){
         $unit_count = array();
         foreach ($tables as $key => $table) 
         {
                 $sql = 'SELECT unit_id FROM `'.$table.'` WHERE unit_id = '.$unit_id.' AND is_deleted = "0"';
                 $dbResult = $this->db->query($sql);
                 //echo $this->db->last_query();

                 if($dbResult->num_rows() > 0){
                    $data_arr = $dbResult->row_array();
                    $data_arr = $data_arr['unit_id'];
                    $unit_count[] = $data_arr;
                 }
          }
         return $unit_count;   
    }

    public function check_category_used($cat_id,$tables){
            $cat_count = array();
            foreach ($tables as $key => $table) 
            {
                 $sql = 'SELECT cat_id FROM `'.$table.'` WHERE cat_id = '.$cat_id.' AND is_deleted = "0"';
                 $dbResult = $this->db->query($sql);
                 //echo $this->db->last_query();

                 if($dbResult->num_rows() > 0){
                    $data_arr = $dbResult->row_array();
                    $data_arr = $data_arr['cat_id'];
                    $cat_count[] = $data_arr;
                 }
            }
            return $cat_count; 
    }

    public function delete_category($cat_id){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where_in('cat_id', $cat_id);
         $this->db->update('erp_categories');

         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where_in('cat_id', $cat_id);
         $this->db->update('erp_sub_categories');
         return true;
    }


     public function remove_purchase_order($po_id){
        
          $this->db->set('is_deleted','1');
          $this->db->set('updated',date("Y-m-d H:i:s"));
          $this->db->set('updated_by',$this->user_id);
          $this->db->where('po_id', $po_id); 
          $this->db->update('erp_purchase_order');

          $this->db->set('is_deleted','1');
          $this->db->set('updated',date("Y-m-d H:i:s"));
          $this->db->set('updated_by',$this->user_id);
          $this->db->where('po_id', $po_id);
          $this->db->update('erp_purchase_order_details'); 
          return $po_id;
     }


    public function update_quotation_request_status($status,$quo_req_id,$quotation_id,$approval_dep){

        if($approval_dep == 'Purchase'){
             $this->db->set('approval_by_purchase',$this->user_id);
             $this->db->set('approval_date_purchase',date("Y-m-d H:i:s"));
             $this->db->set('approval_status_purchase',$status); 
             $this->db->set('approval_quotation_id_purchase',$quotation_id);   
        }else{
             $this->db->set('approval_by_account',$this->user_id);  
             $this->db->set('approval_date_account',date("Y-m-d H:i:s")); 
             $this->db->set('approval_status_account',$status); 
             $this->db->set('approval_quotation_id_account',$quotation_id);   
        }

        
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where('quo_req_id', $quo_req_id);
         $this->db->update('erp_material_quotation_request');   
         return $quo_req_id; 
    }

    public function update_quotation_status($quotation_id, $status, $approval_dep){

         
         if($approval_dep == 'Purchase'){
             $this->db->set('approval_by_purchase',$this->user_id); 
             $this->db->set('status_purchase',$status); 
         }else{
            $this->db->set('approval_by_account',$this->user_id); 
            $this->db->set('status_account',$status); 
         }
         
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where('quotation_id', $quotation_id);
         $this->db->update('erp_supplier_quotation_bid');   
         return $quotation_id;
    }

    public function delete_sub_categories($cat_id){
         $this->db->where('cat_id', $cat_id);
         $this->db->delete('erp_sub_categories');    
         return true;
    }

    public function assign_material($mat_id,$supplier_id){
        $assign_id = array();
        foreach ($mat_id as $key => $id) {
             $insert_data = array(
                    'mat_id' => $id,
                    'supplier_id' => $supplier_id,
                    'created' => date("Y-m-d H:i:s"),
                    'created_by' => $this->user_id
             );
             $this->db->insert('erp_supplier_materials',$insert_data);
             array_push($assign_id,$id);
        }
        return $assign_id;
    }

    public function update_unit($data,$unit_id){
        $this->db->where('unit_id',$unit_id);
        $this->db->update('erp_unit_master',$data);
        return true;
    }

    public function update_supplier($data,$supplier_id){
        $this->db->where('supplier_id',$supplier_id);
        $this->db->update('erp_supplier',$data);
        return true;
    }

    public function updated_categories($data,$cat_id){
        $this->db->where('cat_id',$cat_id);
        $this->db->update('erp_categories',$data);
        return true;
    }

    public function update_material($data,$mat_id){
        $this->db->where('mat_id',$mat_id);
        $this->db->update('erp_material_master',$data);
        return true;
    }

    public function get_export_unit_details($unit_id){
        $this->db->select("*");
        $this->db->from("erp_unit_master");
        $this->db->where_in('unit_id',$unit_id);
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $unit_details = $query->result_array();
        if(!empty($unit_details)){
            return $unit_details;
        } else {
            return array();
        }
    }

    public function get_export_supplier_details($supplier_id){
        $this->db->select("*");
        $this->db->from("erp_supplier");
        $this->db->where_in('supplier_id',$supplier_id);
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $supplier_details = $query->result_array();
        if(!empty($supplier_details)){
            return $supplier_details;
        } else {
            return array();
        }
    }

    public function get_unit_details($where){
    	$this->db->select("*");
        $this->db->from("erp_unit_master");
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->where("is_deleted","0");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $unit_details = $query->result_array();
        if(!empty($unit_details)){
            return $unit_details;
        } else {
            return array();
        }
    }

    public function get_supplier_details($supplier_id){ 
        $this->db->select("*");
        $this->db->from("erp_supplier");
        if(!empty($supplier_id)){
            $this->db->where_in('supplier_id', $supplier_id);
        }
        $this->db->where("is_deleted","0");
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

    public function get_categories_details($where){
            $this->db->select("*");
            $this->db->from("erp_categories");
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->where("is_deleted","0");
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $cat_details = $query->result_array();
            if(!empty($cat_details)){
                return $cat_details;
            } else {
                return array();
            }
    }

    public function get_material_details($where){
            $this->db->select("*");
            $this->db->from("erp_material_master");
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->where("is_deleted","0");
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $mat_details = $query->result_array();
            if(!empty($mat_details)){
                return $mat_details;
            } else {
                return array();
            }
    }

    public function get_sub_categories_details($where){
            $this->db->select("*");
            $this->db->from("erp_sub_categories");
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->where("is_deleted","0");
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $cat_details = $query->result_array();
            if(!empty($cat_details)){
                return $cat_details;
            } else {
                return array();
            }
    }

    public function get_next_previous($navigation,$supplier_id){
        if($navigation == 'next'){ 
                $nxt_id = 'SELECT min(supplier_id) FROM erp_supplier WHERE supplier_id > '.$supplier_id.' AND is_deleted = "0"';

                $sql = 'SELECT supplier_id FROM erp_supplier WHERE supplier_id = ('.$nxt_id.') AND is_deleted = "0"';
        }else{
                $pre_id = 'SELECT max(supplier_id) FROM erp_supplier WHERE supplier_id < '.$supplier_id.' AND is_deleted = "0"';
                $sql = 'SELECT supplier_id FROM erp_supplier WHERE supplier_id = ('.$pre_id.') AND is_deleted ="0"';
        }
        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $data_arr = $dbResult->row_array();
            $data_arr = $data_arr['supplier_id'];
        }else{
            $data_arr = 0;
        }
        return $data_arr;
    }


    public function get_next_previous_cat($navigation,$cat_id){
        if($navigation == 'next'){
            $nxt_id = 'SELECT min(cat_id) FROM erp_categories WHERE cat_id > '.$cat_id.' AND is_deleted = "0"';
            $sql = 'SELECT cat_id FROM erp_categories WHERE cat_id = ('.$nxt_id.') AND is_deleted = "0"';
        }else{
            $pre_id = 'SELECT max(cat_id) FROM erp_categories WHERE cat_id < '.$cat_id.' AND is_deleted = "0"'; 
            $sql = 'SELECT cat_id FROM erp_categories WHERE cat_id = ('.$pre_id.') AND is_deleted = "0"';
        }

        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $data_arr = $dbResult->row_array();
            $data_arr = $data_arr['cat_id'];
        }else{
            $data_arr = 0;
        }
        return $data_arr;
    }

    public function get_next_pre_mat($navigation,$mat_id){  
        if($navigation == 'next'){
            $nxt_id = 'SELECT min(mat_id) FROM erp_material_master WHERE mat_id > '.$mat_id.' AND is_deleted ="0"';
            $sql = 'SELECT mat_id FROM erp_material_master WHERE mat_id = ('.$nxt_id.') AND is_deleted = "0"';
        }else{
            $pre_id = 'SELECT max(mat_id) FROM erp_material_master WHERE mat_id < '.$mat_id.' AND is_deleted = "0"';
            $sql = 'SELECT mat_id FROM erp_material_master WHERE mat_id = ('.$pre_id.') AND is_deleted = "0"';
        }

        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $data_arr = $dbResult->row_array();
            $data_arr = $data_arr['mat_id'];
        }else{
            $data_arr = 0;
        }
        return $data_arr;
    }

    public function get_mat_code($keyword){

            $this->db->select("mat_id, mat_code");
            $this->db->from("erp_material_master");
            $this->db->where("mat_code LIKE '$keyword%'");
            $this->db->where("is_deleted","0");

            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $mat_code_details = $query->result_array();
            if(!empty($mat_code_details)){
                return $mat_code_details;
            } else {
                return array();
            }
    }

    public function check_mat_code($mat_code){

            $this->db->select("mat_id");
            $this->db->from("erp_material_master");
            $this->db->where("mat_code",strtolower($mat_code));
            $this->db->where("is_deleted","0");

            $query = $this->db->get();
           // echo $this->db->last_query();exit;
            $check = $query->result_array();
            if(!empty($check)){
                return $check;
            } else {
                return array();
            }
    }

    public function material_already_used($mat_id,$tables){
           $mat_count = array();
           foreach ($tables as $key => $table) 
           {
                 $sql = 'SELECT mat_id FROM `'.$table.'` WHERE mat_id = '.$mat_id.' AND is_deleted = "0"';
                 $dbResult = $this->db->query($sql);
                 //echo $this->db->last_query();

                 if($dbResult->num_rows() > 0){
                    $data_arr = $dbResult->row_array();
                    $data_arr = $data_arr['mat_id'];
                    $mat_count[] = $data_arr;
                 }
           }
           return $mat_count;
    }

    public function selected_material_quotation($mat_id,$dep_id){
        $assign_id = array();
        foreach ($mat_id as $key => $id) {
             $insert_data = array(
                    'mat_id' => $id,
                    'dep_id' => $dep_id,
             );
             $this->db->insert('erp_material_quotation_draft',$insert_data);
             array_push($assign_id,$id);
        }
        return $assign_id;
    }

    public function get_selected_materials_draft($where){
         $this->db->select("m.mat_id, m.mat_code, m.mat_name, qdm.mat_id, qdm.unit_id, qdm.dep_id, qdm.require_qty, qdm.mat_req_id");
         $this->db->from("erp_material_master m");
         $this->db->join("erp_material_quotation_draft as qdm","m.mat_id = qdm.mat_id","inner");
         if(sizeof($where) > 0){
             $this->db->where($where); 
         }
         $this->db->where("m.is_deleted","0");
         $this->db->order_by("qdm.quo_draft_id", "asc");

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $materials = $query->result_array();
         if(!empty($materials)){
                return $materials;
         }else{
                return array();
         }
    }

    public function get_purchase_order($where){
         $this->db->select("po.*");
         $this->db->from("erp_purchase_order po");
         $this->db->where($where);
         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $purchase_order = $query->result_array();
         if(!empty($purchase_order)){
                return $purchase_order;
         }else{
                return array();
         }
    }

    public function get_purchase_order_draft($where){
         $this->db->select("m.mat_id, m.mat_code, m.mat_name, pod.*");
         $this->db->from("erp_material_master m");
         $this->db->join("erp_purchase_order_details_draft as pod","m.mat_id = pod.mat_id","left");
         $this->db->where($where); 
         $this->db->where("m.is_deleted","0");
         $this->db->order_by("pod.po_draft_id", "asc");

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $materials = $query->result_array();
         if(!empty($materials)){
                return $materials;
         }else{
                return array();
         }
    }

    public function get_quotation_request_number(){
         $this->db->select("quotation_request_number");
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

    public function remove_selected_material_quotation_request($dep_id,$material_id){
         $this->db->where('mat_id', $material_id);
         $this->db->where('dep_id', $dep_id);
         $this->db->delete('erp_material_quotation_draft');    
         return true;
    }

    public function insert_quotation_request($insert_data){
            $this->db->insert('erp_material_quotation_request',$insert_data);
            return $this->db->insert_id();
    }

    public function insert_selected_material_quotation($insert_data,$mat_id){
            $this->db->insert('erp_material_quotation_request_details',$insert_data);
            return $mat_id;
    }

    public function delete_quotation_drafts($mat_id){
           // $this->db->where('dep_id', $dep_id);
            $this->db->where_in('mat_id', $mat_id);
            $this->db->delete('erp_material_quotation_draft'); 
    }

    public function update_quotation_number($quotation_number){
            $this->db->set('quotation_request_number', $quotation_number);
            $this->db->update('erp_auto_increament');
            return true;
    }

    public function update_po_number($po_number){
            $this->db->set('po_number', $po_number);
            $this->db->update('erp_auto_increament');
            return true;
    }
    
    public function insert_purchase_order($insert_data){
            $this->db->insert('erp_purchase_order',$insert_data);
            return $this->db->insert_id();
    }

    public function insert_selected_purachase_order($insert_data, $mat_id){
            $this->db->insert('erp_purchase_order_details',$insert_data);
            return $mat_id;
    }

    public function delete_purchase_order_drafts($where){
            $this->db->where($where);
            $this->db->delete('erp_purchase_order_details_draft'); 
    }

    public function quotation_listing($where){

         $this->db->select("*");
         $this->db->from("erp_material_quotation_request");
         $this->db->where("is_deleted","0");
         $this->db->where($where);
         $this->db->order_by("quo_req_id", "desc");
         $query = $this->db->get();
          //echo $this->db->last_query();//exit;
         $quotation_request = $query->result_array();
         if(!empty($quotation_request)){
                return $quotation_request;
         }else{
                return array(); 
         }
    }

    public function get_quotation_request_details($where){

         $this->db->select("m.mat_id, m.mat_code, m.mat_name, qr.request_date, qr.supplier_id, qb.require_qty, qb.unit_id, qb.mat_req_id");
         $this->db->from("erp_material_master m");
         $this->db->join("erp_material_quotation_request_details as qb","m.mat_id = qb.mat_id","left");
         $this->db->join("erp_material_quotation_request as qr","qb.quo_req_id = qr.quo_req_id","left");
         $this->db->where($where); 
         $this->db->where("m.is_deleted","0");
         $this->db->order_by("qb.mat_id", "asc");

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $materials = $query->result_array();
         if(!empty($materials)){
                return $materials;
         }else{
                return array();
         }
    }

    public function get_supplier_bid_details($where,$supplier_id){

          $this->db->select("b.quotation_id, b.supplier_id, b.credit_days, b.total_price, bd.mat_id, bd.quo_rate, bd.quo_qty, bd.quo_price");
          $this->db->from("erp_supplier_quotation_bid as b");
          $this->db->join("erp_supplier_quotation_bid_details as bd","b.quotation_id = bd.quotation_id","left");
          $this->db->where_in("bd.supplier_id",$supplier_id); 
          $this->db->where($where);
          $this->db->order_by("bd.supplier_id", "asc");
          $query = $this->db->get();

          $bid = $query->result_array();
          if(!empty($bid)){
                return $bid;
          }else{
                return array();
          }
    }


    public function get_supplier_quotation($where,$where_in = array()){

            $this->db->select("*");
            $this->db->from("erp_supplier_quotation_bid");
            $this->db->where($where);
            if(!empty($where_in)){
                $condition_value = array_keys($where_in);
                $condition_value = $condition_value[0];
                $this->db->where_in($condition_value,$where_in[$condition_value]);
            }
            $this->db->order_by("quotation_id", "desc");
            $query = $this->db->get();
            //echo $this->db->last_query();
            $quotation = $query->result_array();
            if(!empty($quotation)){
                    return $quotation;
            }else{
                    return array(); 
            }
    }

    public function get_supplier_quotation_details($where){
            $this->db->select("m.mat_id, m.mat_code, m.mat_name, bd.*");
            $this->db->from("erp_material_master m");
            $this->db->join("erp_supplier_quotation_bid_details as bd","m.mat_id = bd.mat_id","left");
            $this->db->where($where); 
            $query = $this->db->get();
           // echo $this->db->last_query();
            $bid = $query->result_array();
            if(!empty($bid)){
                return $bid;
            }else{
                return array();
            }

    }

    public function get_material_unique_number(){
         $this->db->select("material_unique_number");
         $this->db->from("erp_auto_increament");
         $this->db->where("id",1);
         $query = $this->db->get();
         $unique_number = $query->result();
         if(!empty($unique_number)){
                return $unique_number;
         }else{
                return array(); 
         }
    }

    public function update_unique_number($unique_number){
            $this->db->set('material_unique_number', $unique_number);
            $this->db->update('erp_auto_increament');
            return true;
    }


    public function get_purchase_order_number(){
          $this->db->select("po_number");
          $this->db->from("erp_auto_increament");
          $this->db->where("id",1);
          $query = $this->db->get();
          $po_number = $query->result();
          if(!empty($po_number)){
                return $po_number;
          }else{
                return array(); 
          }
    }

    public function material_requisation_listing($where){
         $this->db->select("mr.*,d.dep_name, d.dep_id");
         $this->db->from("erp_material_requisition mr");
         $this->db->join("erp_departments as d", "mr.dep_id = d.dep_id");
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

    public function delete_purchase_order_draft($where){
            $this->db->where($where);
            $this->db->delete('erp_purchase_order_details_draft'); 
    }

    public function purchase_order_listing($where){
            $this->db->select("po.*, d.dep_name, d.dep_id, s.supp_firm_name");
            $this->db->from("erp_purchase_order po");
            $this->db->join("erp_departments as d", "po.dep_id = d.dep_id");
            $this->db->join("erp_supplier as s", "po.supplier_id = s.supplier_id");
            $this->db->where($where);
            $this->db->order_by("po.po_id", "asc");
            $query = $this->db->get();

            $po_list = $query->result_array();
            if(!empty($po_list)){
                    return $po_list;
            }else{
                    return array();
            }    
    }

    public function get_selected_po_material_details($where){
          $this->db->select("m.mat_id, m.mat_code, m.mat_name, po.id, po.po_id, po.req_id, po.quotation_id, po.mat_id, po.hsn_code, po.dep_id, po.unit_id, po.qty, po.rate, po.expire_date, po.cgst_per, po.cgst_amt, po.sgst_per, po.sgst_amt, po.igst_per, po.igst_amt, po.discount, po.discount_per, po.mat_amount,u.unit_description");
          $this->db->from("erp_material_master m");
          $this->db->join("erp_purchase_order_details as po","m.mat_id = po.mat_id","left");
          $this->db->join("erp_unit_master as u","po.unit_id = u.unit_id","left");
          $this->db->where($where);
          $this->db->where("m.is_deleted","0");
          $this->db->where("po.is_deleted","0");
          $this->db->order_by("po.id", "asc");

          $query = $this->db->get();
            //echo $this->db->last_query();exit;
          $materials = $query->result_array();
          if(!empty($materials)){
                    return $materials;
          }else{
                    return array();
          }
    }

    public function get_delievery_schedule(){

          $this->db->select("delievery_schedule");
          $this->db->from("erp_delievery_schedule");
          $query = $this->db->get();
          $delievery_schedule = $query->result_array();
          if(!empty($delievery_schedule)){
                return $delievery_schedule;
          }else{
                return array(); 
          }
    }

    public function get_transports(){
          $this->db->select("transport");
          $this->db->from("erp_transport");
          $query = $this->db->get();
          $transport = $query->result_array();
          if(!empty($transport)){
                return $transport;
          }else{
                return array(); 
          }
    }

    public function get_freight_charges(){
          $this->db->select("freight_charges");
          $this->db->from("erp_freight_charges");
          $query = $this->db->get();
          $freight_charges = $query->result_array();
          if(!empty($freight_charges)){
                return $freight_charges;
          }else{
                return array(); 
          }  
    }

    public function get_payment_terms(){
          $this->db->select("payment_terms");
          $this->db->from("erp_payment_terms");
          $query = $this->db->get();
          $payment_terms = $query->result_array();
          if(!empty($payment_terms)){
                return $payment_terms;
          }else{
                return array(); 
          }
    }


    public function get_custom_duty(){
          $this->db->select("custom_duty");
          $this->db->from("erp_custom_duty");
          $this->db->order_by("custom_duty", "DESC");

          $query = $this->db->get();
          $custom_duty = $query->result_array();
          if(!empty($custom_duty)){
                return $custom_duty;
          }else{
                return array(); 
          }
    }

    public function update_quotation_material_status($status,$mat_id,$quotation_id){
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->set('status',$status);
         $this->db->where('quotation_id', $quotation_id);
         $this->db->where_in('mat_id', $mat_id);
         $this->db->update('erp_supplier_quotation_bid_details');   
         return true; 
    }

    public function set_quantity($quantity,$mat_id,$table){
            $this->db->set('require_qty', $quantity);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $this->dep_id);
            $this->db->update($table);
            return true;
    }

    public function delete_po_material_draft($mat_id,$dep_id){
         $this->db->where('dep_id', $dep_id);
         $this->db->where('mat_id', $mat_id);
         $this->db->delete('erp_purchase_order_details_draft');    
         return true;
    }

}    