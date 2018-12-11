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
          $dep_access = access_department();
          $this->global['access'] = json_decode(get_permissions($this->user_id));//json_decode($user_details['permissions']);
          $this->global['token'] = $user_details['token'];
          $this->global['access_dep'] = $dep_access;
        }
        // Your own constructor code
    }

    public function pending_material_requisation_listing($dep_id,$where){
         $this->db->select("mr.*,d.dep_name, d.dep_id");
         $this->db->from("erp_material_requisition mr");
         $this->db->join("erp_departments as d", "mr.dep_id = d.dep_id");
         $this->db->where("mr.dep_id", $dep_id);
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

    public function material_requisation_listing($dep_id,$where){
         $this->db->select("mr.*,d.dep_name, d.dep_id");
         $this->db->from("erp_material_requisition mr");
         $this->db->join("erp_departments as d", "mr.dep_id = d.dep_id");
         if(is_array($this->global['access_dep']) && in_array($dep_id, $this->global['access_dep'])){  
         }else{
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

    public function get_selected_req_material_details($where,$where_in = array(),$where_not_in = array()){
          $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.current_stock, rdm.id, rdm.req_id, rdm.mat_id, rdm.dep_id, rdm.unit_id, rdm.require_qty, rdm.received_qty, rdm.require_date, rdm.require_users, rdm.material_note, rdm.stock_qty, rdm.po_qty, rdm.requisation_send_purchase");
          $this->db->from("erp_material_master m");
          $this->db->join("erp_material_requisition_details as rdm","m.mat_id = rdm.mat_id","left");
          $this->db->where($where);
          if(!empty($where_in)){
            $this->db->where_in("rdm.mat_id",$where_in);
          } 

          if(!empty($where_not_in)){
            $this->db->where_not_in('rdm.mat_id', $where_not_in);  
          }

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

    public function update_requisation_send_purchase_flag($where){
        $this->db->set('requisation_send_purchase', "yes");
        $this->db->where($where);
        $this->db->update('erp_material_requisition_details');
        return $this->db->affected_rows();
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

    public function get_material_outward_number(){
       $this->db->select("outward_number"); 
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


    public function insert_inward($insert_data){
        $this->db->insert('erp_material_inwards',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_outward($insert_data){
        $this->db->insert('erp_material_outwards',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_inward_items_details($insert_data){
        $this->db->insert('erp_material_inward_details',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_outward_item_details($insert_data){
        $this->db->insert('erp_material_outward_details',$insert_data);
        return $this->db->insert_id();
    }

    public function insert_outward_items_details_batchwise($insert_data){
        $this->db->insert('erp_material_outward_batchwise',$insert_data);
        return $this->db->insert_id();
    }

    public function update_material_requisation($update_data,$req_id){
           $this->db->where('req_id', $req_id);
           $this->db->where('is_deleted', "0");  
           $this->db->update('erp_material_requisition',$update_data);
           return $req_id;
    }

    public function update_inward($update_data,$inward_id){
           $this->db->where('inward_id', $inward_id);
           $this->db->where('is_deleted', "0");  
           $this->db->update('erp_material_inwards',$update_data);
           return $inward_id;
    }

    public function update_outward($update_data,$outward_id){
           $this->db->where('outward_id', $outward_id);
           $this->db->update('erp_material_outwards',$update_data);
           return $outward_id;
    }

    public function update_inward_items_details($update_data,$where){
          $this->db->where($where);
          $this->db->update('erp_material_inward_details',$update_data);
          return $this->db->affected_rows(); 
    }

    public function update_outward_material($update_data,$where){
          $this->db->where($where);
          $this->db->update('erp_material_outward_details',$update_data);
          return $this->db->affected_rows();
    }

    public function insert_selected_material($insert_data,$mat_id){
           $this->db->insert('erp_material_requisition_details', $insert_data);
           return $mat_id;
    }

    public function insert_material_purchase_requisation($insert_data){
           $this->db->insert('erp_purchase_material_requisition', $insert_data);
           return $this->db->insert_id();
    }

    public function delete_outward_item_details($outward_id){
            $this->db->where('outward_id', $outward_id);
            $this->db->delete('erp_material_outward_details'); 

            $this->db->where('outward_id', $outward_id);
            $this->db->delete('erp_material_outward_batchwise'); 
            return true;
    }


    public function delete_requisation_details($req_id,$dep_id){
            $this->db->where('dep_id', $dep_id);
            $this->db->where('req_id', $req_id);
            $this->db->delete('erp_material_requisition_details'); 
            return true;
    }

    public function delete_requisation_drafts($mat_id){
           // $this->db->where('dep_id', $dep_id);
            $this->db->where_in('mat_id', $mat_id);
            $this->db->delete('erp_material_requisation_draft'); 
    }

    public function delete_inward_details_drafts($po_id){
             $this->db->where('po_id', $po_id);
             $this->db->delete('erp_material_inward_details_draft'); 
    }

    public function update_requisation_number($req_number){
            $this->db->set('material_requisation_number', $req_number);
            $this->db->update('erp_auto_increament');
            return true;   
    }

    public function update_outward_number($outward_number){
            $this->db->set('outward_number', $outward_number);
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

    public function insert_inward_material_draft($insert_data){
        $this->db->insert('erp_material_inward_details_draft',$insert_data);
        return $this->db->insert_id();
    }

    public function save_batch_number($insert_data){
        $this->db->insert('erp_material_inward_batchwise',$insert_data);
        return $this->db->insert_id();
    }

    public function update_note_material_draft($material_note,$mat_id,$dep_id){

          $this->db->set('material_note', $material_note);
          $this->db->where('dep_id', $dep_id);
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

    public function po_listing($where){
         $this->db->select("*");
         $this->db->from("erp_purchase_order"); 
         $this->db->where($where);
         $this->db->where('is_deleted', "0"); 

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $dep_ids = $query->result();

         if(!empty($dep_ids)){
                return $dep_ids;
         }else{
                return array();
         }
    }

    public function get_purchase_order_material_details($po_id,$mat_id){
         $this->db->select("*");
         $this->db->from("erp_purchase_order_details"); 
         $this->db->where('po_id', $po_id);
         $this->db->where_in('mat_id',$mat_id);
         $this->db->where('is_deleted', "0"); 

         $query = $this->db->get();
        //echo $this->db->last_query();exit;
         $dep_ids = $query->result();

         if(!empty($dep_ids)){
                return $dep_ids;
         }else{
                return array();
         }
    }


    public function get_inward_material_details_draft($where){
          $this->db->select("m.mat_id, m.mat_code, m.mat_name, imd.*");
          $this->db->from("erp_material_master m");
          $this->db->join("erp_material_inward_details_draft as imd", "m.mat_id = imd.mat_id"); 
          $this->db->where($where);

          $query = $this->db->get();
          $draft_pod = $query->result_array();

          if(!empty($draft_pod)){
                  return $draft_pod;
          }else{
                  return array();
          }
    }


    public function get_selected_po_material_details($condition, $draft_material = array()){
          $this->db->select("m.mat_id, m.mat_code, m.mat_name, po.id, po.po_id, po.req_id, po.quotation_id, po.mat_id, po.hsn_code, po.dep_id, po.unit_id, po.qty, po.received_qty, po.rate, po.expire_date, po.cgst_per, po.cgst_amt, po.sgst_per, po.sgst_amt, po.igst_per, po.igst_amt, po.discount, po.discount_per, po.mat_amount,u.unit_description");
          $this->db->from("erp_material_master m");
          $this->db->join("erp_purchase_order_details as po","m.mat_id = po.mat_id","left");
          $this->db->join("erp_unit_master as u","po.unit_id = u.unit_id","left");
          $this->db->where($condition);

          if(!empty($draft_material)){
            $this->db->where_not_in('m.mat_id', $draft_material);  
          }

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

    public function remove_material_inward_draft($po_id,$mat_id){
          $this->db->where('po_id', $po_id);
          $this->db->where('mat_id', $mat_id);
          $this->db->delete('erp_material_inward_details_draft');    
          return true;
    }

    public function set_quantity_requisation($quantity,$mat_id,$dep_id,$table){
            $this->db->set('require_qty', $quantity);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $dep_id);
            $this->db->update($table);
            return true;
    }

     public function update_units_requisation($unit_id,$mat_id,$dep_id,$table){
            $this->db->set('unit_id', $unit_id);
            $this->db->where('mat_id', $mat_id);
            $this->db->where('dep_id', $dep_id);
            $this->db->update($table);
            return true;
    }
    

    public function update_outward_quantity($outward_qty,$inward_id,$mat_id,$batch_id){
           $this->db->set('outward_qty', $outward_qty); 
           $this->db->where('inward_id', $inward_id);
           $this->db->where('mat_id', $mat_id);
           $this->db->where('batch_id', $batch_id);
           $this->db->update('erp_material_inward_batchwise');
           return $this->db->affected_rows();  
    }

    public function inward_items($where){
             $this->db->select("inward.*, po.po_number, vendor.supp_firm_name");
             $this->db->from("erp_material_inwards as inward");
             $this->db->join("erp_purchase_order as po","inward.po_id = po.po_id","left");
             $this->db->join("erp_supplier as vendor","inward.vendor_id = vendor.supplier_id","left");
             $this->db->where($where);

             $query = $this->db->get();
              //echo $this->db->last_query();exit;
             $inwards = $query->result_array();
             if(!empty($inwards)){
                  return $inwards;
             }else{
                  return array();
             }
    }

    public function material_inward_details($where){
            $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.current_stock, m.total_stock, iwd.*");
            $this->db->from("erp_material_master m");
            $this->db->join("erp_material_inward_details as iwd", "m.mat_id = iwd.mat_id");
            $this->db->where($where);

            $query = $this->db->get();

            $inward_details = $query->result_array();
            if(!empty($inward_details)){
                 return $inward_details;
            }else{
                 return array();
            }
    } 

    public function get_outward_material($where){
            $this->db->select("m.mat_id, m.mat_code, m.mat_name, m.current_stock, m.total_stock, owd.*"); 
            $this->db->from("erp_material_master m");
            $this->db->join("erp_material_outward_details as owd", "m.mat_id = owd.mat_id");
            $this->db->where($where);
            $query = $this->db->get();

            $outward_details = $query->result_array();
            if(!empty($outward_details)){
                 return $outward_details;
            }else{
                 return array();
            }

    }

    public function check_batch_number($where){

          $this->db->select("*"); 
          $this->db->from("erp_material_inward_batchwise");
          $this->db->where($where);
          $query = $this->db->get();
          //echo $this->db->last_query();exit;
          $batch_details = $query->result_array();
          if(!empty($batch_details)){
                 return $batch_details;
          }else{
                 return array();
          }   
    }

    public function update_batch_number($update_data,$where){
           $this->db->where($where);
           $this->db->update('erp_material_inward_batchwise',$update_data);
           return $this->db->affected_rows();
    }

    public function delete_batch_number($where){
          $this->db->where($where);
          $this->db->delete('erp_material_inward_batchwise');    
          return $this->db->affected_rows();
    }

    public function updated_accepted_qty_inward_details($updated_data,$where){
           $this->db->where($where);
           $this->db->update('erp_material_inward_details',$update_data);
           return $this->db->affected_rows();
    }

    public function outward_listing($where=''){
            $this->db->select("out.*, dep.dep_name, req.req_number");
            $this->db->from("erp_material_outwards as out");
            $this->db->join("erp_departments as dep", "out.dep_id = dep.dep_id");
            $this->db->join("erp_material_requisition as req", "req.req_id = out.req_id");
            if(!empty($where)){
                $this->db->where($where);
            }
            $query = $this->db->get();

            $outward_details = $query->result_array();
            if(!empty($outward_details)){
                 return $outward_details;
            }else{
                 return array();
            }
    }

    public function outward_batch_details($where = array()){
          $this->db->select("*");
          $this->db->from("erp_material_outward_batchwise");
          if(!empty($where)){
                $this->db->where($where);
          }
          $query = $this->db->get();

          $outward_batch_details = $query->result_array();
          if(!empty($outward_batch_details)){
                 return $outward_batch_details;
          }else{
                 return array();
          }

    }

    public function material_requisition_details_update_pre_rec_qty($received_qty, $req_id, $mat_id){
            $sql_query = 'UPDATE erp_material_requisition_details SET received_qty = '.$received_qty.' WHERE req_id = '.$req_id.' AND mat_id ='.$mat_id.'';
            $dbResult = $this->db->query($sql_query);
    }

    public function compare_req_received_qunatity($req_id){
        $sql = 'SELECT COUNT(req_id) AS match_qty FROM erp_material_requisition_details where require_qty = received_qty AND req_id = '.$req_id.' AND is_deleted = "0"';

        $dbResult = $this->db->query($sql);
            if($dbResult->num_rows() > 0){
                $data_arr = $dbResult->row_array();
                $data_arr = $data_arr['match_qty'];
            }else{
                $data_arr = 0;
            }
        return $data_arr;
    }
}    
?>