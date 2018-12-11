<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, September 2018
 */
class Dashboard_model extends CI_Model {

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
    }


    public function get_distinct_quotation_request_number($where){
            $this->db->select('quo_req_id');
            $this->db->from('erp_supplier_quotation_bid');
            $this->db->where($where);
            $this->db->distinct('quo_req_id');
            $query = $this->db->get();
            $request_number = $query->result_array();

            if(!empty($request_number)){
                    return $request_number;
            }else{
                    return array(); 
            }
    }


    public function quotation_listing($quo_request_id){

         $this->db->select("*");
         $this->db->from("erp_material_quotation_request");
         $this->db->where("is_deleted","0");
         $this->db->where_in('quo_req_id',$quo_request_id);
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

    public function batch_wise_listing(){

        $this->db->select("m.mat_id, m.mat_code, m.mat_name, bw.batch_number, bw.expire_date, bw.accepted_qty");
        $this->db->from("erp_material_master m");
        $this->db->join("erp_material_inward_batchwise as bw","m.mat_id = bw.mat_id","left");

        $where = "DATE(bw.expire_date) < DATE_ADD(CURDATE(), INTERVAL 60 DAY) AND `bw.is_deleted` = '0' AND bw.accepted_qty != bw.outward_qty";

        $this->db->where($where);
        $this->db->order_by("bw.expire_date", "ASC");
        $query = $this->db->get();

        $batch_wise_listing = $query->result_array();

        if(!empty($batch_wise_listing)){
                return $batch_wise_listing;
        }else{
                return array(); 
        }
    }

}