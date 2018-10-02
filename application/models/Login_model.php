<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
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
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($email_id, $password)
    {
        //$cp_db = $this->load->database("cp",true);
        $this->db->select('BaseTbl.id, BaseTbl.password, BaseTbl.name, BaseTbl.role_id, BaseTbl.permissions, Roles.groups, Roles.user_role');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Roles','Roles.id = BaseTbl.role_id');
        $this->db->where('BaseTbl.email', $email_id);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        //echo $cp_db->last_query();exit;

        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($password, $user[0]->password)){
                $this->load->helper('string');
                //$this->load->helper('functions');

                $current_time = date("Y-m-d H:i:s");
                $data['user_login_id'] = $user[0]->id;
                $data['created'] = $current_time;
                $data['last_visited'] = $current_time;
                $data['remote_ip'] = get_client_ip();
                $user[0]->token = $data['token'] = random_string('alnum',30);
                $this->db->insert('user_verification', $data);
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    function loginMeThroughAPI($user_id, $user_name, $password=NULL)
    {
       
        $this->db->select('BaseTbl.id, BaseTbl.user_name, BaseTbl.password, BaseTbl.name, BaseTbl.email, BaseTbl.role_id, BaseTbl.permissions, Roles.groups, Roles.user_role');
        $this->db->from('users as BaseTbl');
        $this->db->join('user_roles as Roles','Roles.id = BaseTbl.role_id');
        if(!empty($user_id)){
            $this->db->where('BaseTbl.id', $user_id);
        }
        $this->db->where('BaseTbl.user_name', $user_name);
        $this->db->where('BaseTbl.isDeleted', '0');
        $query = $this->db->get();
       // echo $this->db->last_query();exit;

        $user = $query->result();

        if(!empty($user)){
            if(!empty($password) && (verifyHashedPassword($password, $user[0]->password))){
                $this->load->helper('string');
                //$this->load->helper('functions');

                $current_time = date("Y-m-d H:i:s");
                $data['user_login_id'] = $user[0]->id;
                $data['created'] = $current_time;
                $data['last_visited'] = $current_time;
                $data['remote_ip'] = get_client_ip();
                $user[0]->token = $data['token'] = random_string('alnum',30);
                $this->db->insert('user_verification', $data);
                return $user;
            } else {
               $this->load->helper('string');
                //$this->load->helper('functions');

                $current_time = date("Y-m-d H:i:s");
                $data['user_login_id'] = $user[0]->id;
                $data['created'] = $current_time;
                $data['last_visited'] = $current_time;
                $data['remote_ip'] = get_client_ip();
                $user[0]->token = $data['token'] = random_string('alnum',30);
                $this->db->insert('user_verification', $data);
                return $user;
            }
        } else {
            return array();
        }
    }

    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('id');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
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
        $result = $this->db->insert('reset_password', $data);

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
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('id, email, name');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update('users', array('password'=>getHashedPassword($password)));
        $this->db->delete('reset_password', array('email'=>$email));
    }

    function logoutUser($user_id = null, $ip = null){
        if(!empty($user_id)){
            $this->db->delete('user_verification', array('user_login_id'=>$user_id));
        }
        if(!empty($ip)){
            $this->db->delete('user_verification', array('remote_ip'=>$ip));
        }
    }
}

?>