<?php
/* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Rakesh Ahirrao, August 2018
 */
 
class Settings_model extends CI_Model {

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
            $this->global['access'] = json_decode(get_permissions($this->user_id));//json_decode($user_details['permissions']);
            $this->global['token'] = $user_details['token'];
        }
        // Your own constructor code
    }

    public function insert_menu($insert_data){
         $this->db->insert('erp_menu',$insert_data);
         return $this->db->insert_id();
    }

    public function get_menu_details($menu_id)
	{
            $this->db->select("m.*");
            $this->db->from("erp_menu AS m");
            $this->db->where("m.is_deleted","0");
            $this->db->where("m.menu_id",$menu_id);
            $this->db->order_by("m.menu_id", "ASC");

            $query_menu = $this->db->get();

            if($query_menu->num_rows()>0){
                    return $query_menu->result_array();
            }else{
                    return array();
            }
    }

    public function delete_menu($menu_id){
         $this->db->set('is_deleted','1');
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updated_by',$this->user_id);
         $this->db->where('menu_id', $menu_id);
         $this->db->update('erp_menu');
         return true;
    }

    public function update_menu($update_data,$menu_id){
         $this->db->where('menu_id', $menu_id);
         $this->db->where('is_deleted', "0");
         $this->db->update('erp_menu',$update_data);
         return $menu_id;
    }
}
?>