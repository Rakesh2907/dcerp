<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($email, $password)
    {
        $this->db->select('BaseTbl.id, BaseTbl.password, BaseTbl.name, BaseTbl.login_user_name, BaseTbl.role_id, BaseTbl.staff_type_id, BaseTbl.pwd_updated ');
        $this->db->from('users as BaseTbl');
        //$this->db->join('roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.email_id', $email);
        $this->db->or_where('BaseTbl.login_user_name', $email);
        $this->db->where('BaseTbl.is_deleted', '0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $user = $query->result();
        
        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            }else{
                return array();
            }
        }else{
            return array();
        }
    }


    /**
     * This function used to get user details if exist
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function getUserDetails($email)
    {
        $this->db->select('id, name, login_user_name, email_id, role_id');
        $this->db->from('users');
        $this->db->where('email_id', $email);
        $this->db->or_where('login_user_name', $email);
        $this->db->where('is_deleted', '0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->row();
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('userId');
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email){
        $this->db->select('userId, email, name');
        $this->db->from('users');
        $this->db->where('is_deleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id){
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows;
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password){
        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);
        $this->db->update('users', array('password'=>getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email'=>$email));
    }

    function getPreviousSignInLog($where){
        $this->db->select('*');
        $this->db->from('user_signin_log');
        $this->db->where($where);
        $this->db->order_by('created', 'DESC');
        $query = $this->db->get();

        return $query->row();
    }
}

?>