<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, December 2018
 */
	
class Report_model extends CI_Model {
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

    public function get_department_wise_material_requisition($where = array(),$like){
              $this->db->select("pmr.*, mr.*, d.dep_name, d.dep_id");
              $this->db->from("erp_purchase_material_requisition pmr");
              $this->db->join("erp_material_requisition as mr", "pmr.req_id = mr.req_id");
              $this->db->join("erp_departments as d", "mr.dep_id = d.dep_id");

               if(!empty($where)){
                  $this->db->where($where); 
               }

               $this->db->like('mr.req_date', $like);
               $this->db->order_by("mr.req_date", "asc");
               $query = $this->db->get();
                //echo $this->db->last_query(); echo "<br>";//exit; 
              $req_list = $query->result_array();
              if(!empty($req_list)){
                     return $req_list;
              }else{
                     return array();
              }

    }

    public function get_department_wise_outward_batch_list($where = array(),$like){
               $this->db->select("out.outward_date, batch.*, d.dep_id, d.dep_name");
               $this->db->from("erp_material_outwards as out");
               $this->db->join("erp_material_outward_batchwise as batch", "out.outward_id = batch.outward_id");
               $this->db->join("erp_departments as d", "out.dep_id = d.dep_id");
               if(!empty($where)){
                  $this->db->where($where); 
               }
               $this->db->like('out.outward_date', $like);
               $this->db->order_by("out.outward_date", "asc");
               $query = $this->db->get();

               //echo $this->db->last_query(); echo "<br>";//exit; 
               $outward_batch_wise_list = $query->result_array();
              if(!empty($outward_batch_wise_list)){
                     return $outward_batch_wise_list;
              }else{
                     return array();
              }
    }

    public function get_department_wise_purchase_order($where = array(),$like){
            $this->db->select("po.po_date, po.approval_flag, po.status, d.dep_id, d.dep_name");
            $this->db->from("erp_purchase_order as po");
            $this->db->join("erp_departments as d", "po.dep_id = d.dep_id");
            if(!empty($where)){
                  $this->db->where($where); 
            }
            $this->db->like('po.po_date', $like);
            $this->db->order_by("po.po_date", "asc");
            $query = $this->db->get();

            $purchase_orders = $query->result_array();
            if(!empty($purchase_orders)){
                     return $purchase_orders;
            }else{
                     return array();
            }

    }

    public function inward_batch_wise_listing($where = array()){
          $this->db->select("iwd.grn_date, batch.*, mcat.cat_name, m.mat_name, m.mat_code, uid.unit AS mat_unit, subm.sub_material_name, unitid.unit AS sub_mat_unit");
          $this->db->from("erp_material_inwards as iwd");
          $this->db->join("erp_material_inward_batchwise as batch", "iwd.inward_id = batch.inward_id",'LEFT');
          $this->db->join("erp_material_master as m", "batch.mat_id = m.mat_id",'LEFT');
          $this->db->join("erp_sub_material_master as subm", "batch.sub_mat_id = subm.sub_mat_id",'LEFT');
          $this->db->join("erp_categories as mcat", "m.cat_id = mcat.cat_id",'LEFT');
          $this->db->join("erp_unit_master as uid", "m.unit_id = uid.unit_id",'LEFT');
          $this->db->join("erp_unit_master as unitid", "subm.unit_id = unitid.unit_id",'LEFT');
          if(!empty($where)){ 
            $this->db->where($where); 
          }
          $this->db->order_by("batch.sub_mat_id", "asc");
          $query = $this->db->get();
          //echo $this->db->last_query();exit;
          $inward_batch_wise_list = $query->result_array();
          if(!empty($inward_batch_wise_list)){
                 return $inward_batch_wise_list;
          }else{
                 return array();
          }



    }

}

?>