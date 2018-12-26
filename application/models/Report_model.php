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

}

?>