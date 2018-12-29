<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 * Updated by Rakesh Ahirrao, October 2018
 */

class Apivendor_model extends CI_Model {

	  public function __construct(){
        	parent::__construct();
    }

     public function quotation_listing($where){
         $this->db->select("qr.*, d.dep_name, d.dep_id");
         $this->db->from("erp_material_quotation_request qr");
         $this->db->join("erp_departments as d", "qr.dep_id = d.dep_id","inner");
         $this->db->where("qr.is_deleted","0");
         $this->db->where($where);
         $this->db->order_by("qr.quo_req_id", "desc");
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
         $this->db->select("m.mat_id, m.mat_code, m.mat_name, qb.require_qty, qb.unit_id, qb.mat_req_id");
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
      
      public function get_quotation_number(){
          $this->db->select("quotation_number");
          $this->db->from("erp_auto_increament");
          $this->db->where("id",1);
          $query = $this->db->get();
          $quotation_number = $query->result();
          if(!empty($quotation_number)){
                return $quotation_number;
          }else{
                return array(); 
          } 
      }

      public function insert_quotation($insert_data){
             $this->db->insert('erp_supplier_quotation_bid',$insert_data);
             return $this->db->insert_id();
      }

      public function insert_quotation_details($insert_data){
            $this->db->insert('erp_supplier_quotation_bid_details',$insert_data);
            return $this->db->insert_id();
      }

      public function update_quotation_number($quotation_number){
            $this->db->set('quotation_number', $quotation_number);
            $this->db->update('erp_auto_increament');
            return true; 
      }

      public function update_latest_quotation($quotation_id,$quo_req_id){
            $this->db->set('last_quotation_id', $quotation_id);
            $this->db->where("quo_req_id",$quo_req_id);
            $this->db->update('erp_material_quotation_request');
            return true; 
      }
}