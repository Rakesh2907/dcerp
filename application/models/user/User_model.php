<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
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


    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Roles.user_role');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Roles','Roles.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.role_id !=', 1);
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing()
    {
        $this->db->select('BaseTbl.id, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Roles.user_role');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Roles','Roles.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.role_id !=', 1);
        $this->db->where('BaseTbl.role_id !=', 16);
        //$this->db->limit($page, $segment);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        $result = $query->result();
        return $result;
    }

    function userListing_old($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, Roles.user_role');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Roles','Roles.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.role_id !=', 1);
        $this->db->where('BaseTbl.role_id !=', 16);
        //$this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles($where = FALSE)
    {
        $this->db->select('id, user_role, groups, created');
        $this->db->from('user_roles');
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->where('id !=', 1);
        //$this->db->where('is_deleted', 'false');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->result();
    }

    function addUserRole($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('user_roles', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
        //print_r($this->db->affected_rows());exit;
    }

    function editUserRole($userInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('user_roles', $userInfo);
        if($this->db->affected_rows()){
            return TRUE;
        }else{
            return FALSE;
        }
        //print_r($this->db->affected_rows());exit;
    }


    function getGroups($where = NULL)
    {
        $this->db->select('id, slug, title, system_functions, email_notify_usrs');
        $this->db->from('system_groups');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->result();
    }

    function addGroup($groupInfo)
    {
        $this->db->trans_start();
        $this->db->insert('system_groups', $groupInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
        //print_r($this->db->affected_rows());exit;
    }

    function editGroup($groupInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('system_groups', $groupInfo);
        if($this->db->affected_rows()){
            return TRUE;
        }else{
            return FALSE;
        }
        //print_r($this->db->affected_rows());exit;
    }

    function getSystemFuntionalities(){
        $this->db->select('id, slug, title');
        $this->db->from('system_functionalities');       
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("email", $email);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function checkUsernameExist($username, $userId = 0)
    {
        $this->db->select("user_name");
        $this->db->from("users");
        $this->db->where("user_name", $username);
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('id, name, email, user_name, mobile, role_id, permissions');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
		    $this->db->where('role_id !=', 1);
        $this->db->where('id', $userId);
        $query = $this->db->get();

        return $query->result();
    }


    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);

        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);

        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('id, password');
        $this->db->where('id', $userId);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('users');
        //echo $this->db->last_query();exit;

        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('users', $userInfo);

        return $this->db->affected_rows();
    }

    function checkUserToken($token){
        $this->db->select('*');
        $this->db->from('user_verification');
        $this->db->where('token', $token);
        $this->db->where("TIMESTAMPDIFF(SECOND,`last_visited`,'".date('Y-m-d H:i:s')."') <=", 1200);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->result();
    }

    function updateUserVerification($user_session){
        $userInfo['last_visited'] = date('Y-m-d H:i:s');
        $this->db->where('user_login_id', $user_session['userId']);
        $this->db->where('token', $user_session['token']);
        $this->db->where('remote_ip', $user_session['ip']);
        $this->db->update('user_verification', $userInfo);
    }

    public function get_user_details($user_ids){ 
         $id = explode(',', $user_ids);
         $this->db->select('*');
         $this->db->from('users');
         $this->db->where_in('id', $id);
         $this->db->where('isDeleted', '0');
         $query = $this->db->get();
       // echo $this->db->last_query();
         $user_details = $query->result_array();
         if(!empty($user_details)){
                return $user_details;
         }else{
                return array();
         }
    }

   public function get_users(){
      $this->db->select('u.*, d.dep_id, d.dep_name');
      $this->db->from('users as u');
      $this->db->join('erp_departments as d','d.dep_id = u.dep_id','left');
      $this->db->where('isDeleted', '0');
      $query = $this->db->get();
      $user_details = $query->result_array();
      if(!empty($user_details)){
                return $user_details;
      }else{
                return array();
      }
   }

   public function get_all_access_keys(){
        $this->db->select('*');
        $this->db->from('erp_permission_keys');
        $this->db->order_by("permission_keys", "asc");
        $query = $this->db->get();
        $key_details = $query->result_array();

        if(!empty($key_details)){
            return $key_details;
        }else{
            return array();
        }
   } 


   public function assign_assess_key($mykeys,$user_id){
         $this->db->set('permissions',$mykeys);
         $this->db->set('updated',date("Y-m-d H:i:s"));
         $this->db->set('updatedBy',$this->user_id);
         $this->db->where('id', $user_id);
         $this->db->update('users');
         return $user_id;   
   }

   public function get_all_users(){
        $user_mgmt_db = $this->load->database('user_mgmt', TRUE);
        $user_mgmt_db->select('id, name, status');
        $user_mgmt_db->from('users');
        $user_mgmt_db->where('is_deleted', "0");
        $query = $user_mgmt_db->get();

        $user_details = $query->result_array();
        if(!empty($user_details)){
                  return $user_details;
        }else{
                  return array();
        } 
   }
}