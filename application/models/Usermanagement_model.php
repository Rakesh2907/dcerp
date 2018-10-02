<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Usermanagement_model extends CI_Model
{
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
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function getProjectDetails()
    {
        $user_mgmt = $this->load->database("user_mgmt",true);

        $user_mgmt->select("*");
        $user_mgmt->from("project");
        $user_mgmt->where(array("key"=>"erp","is_deleted"=>"0"));
        $query = $user_mgmt->get();
        //echo $user_mgmt->last_query();exit;
        
        $user = $query->row();
        return $user;
    }


    function projectSignIn($userInfo)
    {
		$user_mgmt = $this->load->database("user_mgmt",true);
        $user_mgmt->trans_start();
        $user_mgmt->insert('user_project_signin_log', $userInfo);

        $insert_id = $user_mgmt->insert_id();

        $user_mgmt->trans_complete();

        return $insert_id;
    }
	
	function getRecentLogin(){
		$user_mgmt = $this->load->database("user_mgmt",true);
		
		$user_mgmt->select("*");
		$user_mgmt->from("user_project_signin_log");
		$user_mgmt->where("is_enabled", 1);
		$user_mgmt->order_by("created", "DESC");
		$query = $user_mgmt->get();
		//echo $user_mgmt->last_query();exit;
		
		$user = $query->row();
		return $user;
	}
	
	function updateRecentLogin($userInfo, $id){
		$user_mgmt = $this->load->database("user_mgmt",true);
        $user_mgmt->where('id', $id);
        $user_mgmt->update('user_project_signin_log', $userInfo);
        if($user_mgmt->affected_rows()){
            return TRUE;
        }else{
            return FALSE;
        }
	}
}