<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Lims_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code        
    }

    public function getUserTypesFromLims(){
    	$lims_db = $this->load->database('limsdb',true);

    	$lims_db->select("*");
    	$lims_db->from("user_types");

    	$query = $lims_db->get();
        //echo $lims_db->last_query();exit;
        
        $result = $query->result();        
        return $result;


    }

    public function getAllStaffTypesFromLims(){
    	$lims_db = $this->load->database('limsdb',true);

    	$lims_db->select("*");
    	$lims_db->from("staff_types");

    	$query = $lims_db->get();
        //echo $lims_db->last_query();exit;
        
        $result = $query->result();        
        return $result;


    }

}