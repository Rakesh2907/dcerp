<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
     /* This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.id, BaseTbl.email_id, BaseTbl.name, Role.role');
        $this->db->from('users as BaseTbl');
        $this->db->join('roles as Role', 'Role.id = BaseTbl.role_id','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', '0');
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
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.id, BaseTbl.email_id, BaseTbl.name, BaseTbl.login_user_name, Role.role, `Log`.`attempted_number`');
        $this->db->from('users as BaseTbl');
        $this->db->join('roles as Role', 'Role.id = BaseTbl.role_id','left');
        $this->db->join('user_signin_log as Log', '`Log`.`user_id` = `BaseTbl`.id AND `Log`.`logged_out` = 0 AND `Log`.`attempted_number` = 3','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.is_deleted', '0');
        $this->db->where('BaseTbl.role_id !=', 1);
        //$this->db->limit($page, $segment);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->result();        
        return $result;
    }

    function getUserStaffType($where = NULL){
        $this->db->select('*');
        $this->db->from('staff_types');
        if(!empty($where)){
            $this->db->where($where);
        }
        ///$this->db->where('is_deleted', '0');
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get the projects information
     * @return array $result : This is result of the query
     */
    function getProjects($where = NULL){
        $this->db->select('*');
        $this->db->from('project');
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->where('is_deleted', '0');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles(){
        $this->db->select('id, role');
        $this->db->from('roles');
        $this->db->where('id !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0){
        $this->db->select("email_id");
        $this->db->from("users");
        $this->db->where("email_id", $email);   
        $this->db->where("is_deleted", '0');
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkUserNameExists($email, $userId = 0)
    {
        $this->db->select("login_user_name");
        $this->db->from("users");
        $this->db->where("login_user_name", $email);   
        $this->db->where("is_deleted", '0');
        if($userId != 0){
            $this->db->where("id !=", $userId);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

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
        $this->db->select('id, name, login_user_name, email_id, projects, role_id, staff_type_id');
        $this->db->from('users');
        $this->db->where('is_deleted', '0');
		$this->db->where('role_id !=', 1);
        $this->db->where('id', $userId);
        $query = $this->db->get();
        
        //return $query->result();
        return $query->row();
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
        $this->db->where('is_deleted', '0');
        $query = $this->db->get('users');
        
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
        $this->db->where('is_deleted', '0');
        $this->db->update('users', $userInfo);
        
        return $this->db->affected_rows();
    }
}

  