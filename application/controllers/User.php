<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**

* Copyright (C) Datar Cancer Genetics Limited - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential    
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Rakesh Ahirrao
 * @version : 1.0
 * @since : 31/08/2018
 */
require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
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
        $this->load->model('user/user_model');
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        print_r($this->global);exit;
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        $data = $this->global;
        $this->loadViews("dashboard", $this->global, NULL , NULL);

        $data['patient_list'] = $patient_list;
        $data['page_title'] = "CDC Patients List";
        $data['breadcrumb'] = array(array('class'=>'active','title'=>'<i class="fa fa-dashboard"></i> '.$data['page_title']));
        $data['page'] = 'dashboard/list';
		$this->load->view('main_dashboard_template',$data);

    }

    /**
     * This function is used to load the user list
     */
    function listing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $data = $this->global;

            $data['userRecords'] = $this->user_model->userListing();
            //echo "<pre>";print_r($data);echo "</pre>";exit;

            $data['page_title'] = '<i class="fa fa-users"></i> User Management';
            $data['breadcrumb'] = array(array('class'=>'active','title'=>$data['page_title']));
            $data['page'] = 'user/users';
            $this->load->view('main_dashboard_template',$data);
        }
    }
    function listing_old()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $data = $this->global;

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "index.php/user/listing/", $count, 5 );

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $data['page_title'] = '<i class="fa fa-users"></i> User Management';
            $data['breadcrumb'] = array(array('class'=>'active','title'=>$data['page_title']));
            $data['page'] = 'user/users';
            $this->load->view('main_dashboard_template',$data);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $permissions = permission_array();
            asort($permissions);
            
            $data = $this->global;
            $data['roles'] = $this->user_model->getUserRoles();
            $data['permissions'] = $permissions;
            $data['page_title'] = 'Add New User';
            $data['breadcrumb'] = array(array('url'=>site_url('user/listing'),'title'=>'<i class="fa fa-users"></i> User Management'),array('class'=>'active','title'=>$data['page_title']));
            //print_r($data['roles']);exit;
            $data['page'] = 'user/addNew';
            $this->load->view('main_dashboard_template',$data);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    function checkUsernameExist()
    {
        $userId = $this->input->post("userId");
        $username = $this->input->post("username");

        if(empty($userId)){
            $result = $this->user_model->checkUsernameExist($username);
        } else {
            $result = $this->user_model->checkUsernameExist($username, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            //$this->form_validation->set_rules('username','User Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            //$this->form_validation->set_rules('role','Role','trim|required|numeric');
            //$this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            //$this->form_validation->set_rules('permissions[]','Permissions','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $username = strtolower($this->input->post('username'));
                $password = trim($this->input->post('password'));
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array('user_name'=>$username,'email'=>$email, 'password'=>getHashedPassword($password), 'role_id'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'created'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->addNewUser($userInfo);

                if($result > 0)
                {
                    $this->load->library('SystemEmail','systememail');
                    $where = array('id'=>$roleId);
                    $role_details = $this->user_model->getUserRoles($where);
                    $param = array('name'=>$name, 'email_id'=>$email, 'password'=>$password, 'role'=>$role_details[0]);
                    //$this->systememail->sendRegistrationInternalEmail($param);
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }

                redirect('user/addNew');
            }
        }
    }


    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('user/listing');
            }


            $data = $this->global;
            $permissions = permission_array();
            asort($permissions);
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            $data['permissions'] = $permissions;
            $data['page_title'] = 'Edit User';
            $data['breadcrumb'] = array(array('url'=>site_url('user/listing'),'title'=>'<i class="fa fa-users"></i> User Management'),array('class'=>'active','title'=>$data['page_title']));
            $data['page'] = 'user/editOld';
            $this->load->view('main_dashboard_template',$data);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            //$this->form_validation->set_rules('role','Role','trim|required|numeric');
            //$this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            //$this->form_validation->set_rules('permissions[]','Permissions','required');

            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = trim($this->input->post('password'));
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array();

                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'role_id'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updated'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'role_id'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId,
                        'updated'=>date('Y-m-d H:i:s'));
                }

                $result = $this->user_model->editUser($userInfo, $userId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('user/listing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));

            $result = $this->user_model->deleteUser($userId, $userInfo);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass_bk20180417_1516()
    {
        $data = $this->global;
        $data['page_title'] = 'Change Password';
        $data['breadcrumb'] = array(array('url'=>site_url('user/listing'),'title'=>'<i class="fa fa-users"></i> User Management'),array('class'=>'active','title'=>$data['page_title']));
        $data['page'] = 'user/changePassword';
        $this->load->view('main_dashboard_template',$data);
    }


    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('user/loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updated'=>date('Y-m-d H:i:s'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if($result > 0){ 
                    $p = $this->user_model->getUserInfo($this->vendorId);
                    if(!empty($p)){                        
                        $this->load->library('SystemEmail','systememail');
                        $param = array('email_id'=>$p[0]->email,'password'=>$newPassword, 'name'=>$p[0]->name);
                        //$this->systememail->updatePasswordSuccessfullEmail($param);
                        $this->systememail->updatePasswordInternalEmail($param);    
                    }
                    $this->session->set_flashdata('success', 'Password updation successful'); 
                }else{
                    $this->session->set_flashdata('error', 'Password updation failed'); 
                }

                redirect('user/loadChangePass');
            }
        }
    }

    function logout(){
        $this->load->model('login_model');
        $userdata = $this->session->userdata; 
        $user_id = $userdata['resilient']['userId'];
        $this->login_model->logoutUser($user_id);
        $this->logoutComplete();
    }

    function logout_module(){
        $this->load->model('login_model');
        $userdata = $this->session->userdata; 
        $user_id = $userdata['resilient']['userId'];
        $this->login_model->logoutUser($user_id);
        header('Location: /um');
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, NULL, NULL);
    }

    public function get_user_details(){
        if(!empty($_POST)){
            $user_id = $_POST['user_id'];
            $user_details = $this->user_model->get_user_details($user_id);
            if(!empty($user_details)){
                echo $permissions = $user_details[0]['permissions'];
            }
        }
    }

}

?>