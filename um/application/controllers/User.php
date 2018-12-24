<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');           
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->isLoggedIn();
        //$this->global['pageTitle'] = 'CodeInsect : Dashboard';
        //$data = $this->global;
        //$data['page'] = "login/login";
        //$this->load->view('login/main_dashboard_template',$data);
        
        //$this->loadViews("dashboard", $this->global, NULL , NULL);
        $this->userListing();
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        $this->isLoggedIn();        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data = $this->global;

        
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress ( "userListing/", $count, 5 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            //echo "<pre>";print_r($data['userRecords']);echo "</pre>";exit;
            
            $data['pageTitle'] = 'CodeInsect : User Listing';

            $data['page'] = "dashboard/user/users";
            $this->load->view('dashboard/main_dashboard_template',$data);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data = $this->global;

            $data['roles'] = $this->user_model->getUserRoles();
            $data['projects'] = $this->user_model->getProjects();
            $data['staff_type'] = $this->user_model->getUserStaffType();
            //echo "<pre>";print_r($data['staff_type']);echo "</pre>";exit;

            $data['pageTitle'] = 'CodeInsect : Add New User';

            $data['page'] = "dashboard/user/addNew";
            $this->load->view('dashboard/main_dashboard_template',$data);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $this->isLoggedIn();
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

    /**
     * This function is used to check whether user name already exist or not
     */
    function checkUserNameExists()
    {
        $this->isLoggedIn();
        $userId = $this->input->post("userId");
        $login_user_name = $this->input->post("login_user_name");

        if(empty($userId)){
            $result = $this->user_model->checkUserNameExists($login_user_name);
        } else {
            $result = $this->user_model->checkUserNameExists($login_user_name, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            //echo "<pre>";print_r($_POST);echo "</pre>";exit;
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('login_user_name','User Name','trim|required|max_length[20]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('projects[]','Projects','trim|required');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $login_user_name = str_replace(" ", "_", strtolower($this->input->post('login_user_name')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $projects = $this->input->post('projects');
                $roleId = $this->input->post('role');
                
                
                $userInfo = array('email_id'=>$email, 'password'=>getHashedPassword($password), 'pswd'=>$password, 'role_id'=>$roleId, 'name'=> $name, 'login_user_name' => $login_user_name, 'created_by'=>$this->user_id, 'created'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    if(!empty($projects)){
                        $this->load->model("common_model");
                        $insert_projects = array();
                        foreach($projects as $pro){
                            $sub_arr = array("user_id"=>$result, "project_id"=>$pro, "created"=>date("Y-m-d H:i:s"), "created_by"=>$this->user_id);
                            array_push($insert_projects, $sub_arr);
                        }
                        $this->common_model->insertData("user_project_mapping", $insert_projects, true);
                    }
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('user/userListing');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        $this->isLoggedIn();

        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('user/userListing');
            }

            $this->load->model('user_model');
            $data = $this->global;

            $data['roles'] = $this->user_model->getUserRoles();
            $data['projects'] = $this->user_model->getProjects();
            $data['staff_type'] = $this->user_model->getUserStaffType();

            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId); 

            $this->load->model('project_model');
            $where = array("user_id"=>$userId);
            $projects = $this->project_model->usersProjectsList($where);
            $pro_arr = array();
            foreach($projects as $pro){
                array_push($pro_arr, $pro->project_id);
            }
            $data['userInfo']->projects = $pro_arr;

            $data['pageTitle'] = 'CodeInsect : Edit User';

            $data['page'] = "dashboard/user/editOld";
            $this->load->view('dashboard/main_dashboard_template',$data);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            //echo "<pre>";print_r($_POST);echo "</pre>";exit;
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $this->load->model('project_model');
                $where = array("user_id"=>$userId);
                $assinged_projects = $this->project_model->usersProjectsList($where);
                $assinged_projects_arr = array();
                foreach($assinged_projects as $pro){
                    array_push($assinged_projects_arr, $pro->project_id);
                }

                $name = ucwords(strtolower($this->input->post('fname')));
                $login_user_name = str_replace(" ", "_", strtolower($this->input->post('login_user_name')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $projects = $this->input->post('projects');                
                $roleId = $this->input->post('role');
                $staff_type_id = null;
                if($this->input->post('staff_type')){
                    $staff_type_id = $this->input->post('staff_type');
                }
                
                $userInfo = array();
                
                if(empty($password)){
                    $userInfo = array('email_id'=>$email, 'role_id'=>$roleId, 'name'=> $name, 'login_user_name' => $login_user_name, "staff_type_id"=>$staff_type_id, 'updated_by'=>$this->user_id, 'updated'=>date('Y-m-d H:i:s'));
                }else{
                    $userInfo = array('email_id'=>$email, 'password'=>getHashedPassword($password), 'role_id'=>$roleId, 'name'=> $name, 'login_user_name' => $login_user_name, "staff_type_id"=>$staff_type_id, 'updated_by'=>$this->user_id, 'updated'=>date('Y-m-d H:i:s'), 'pwd_updated_by'=>$this->user_id, 'pwd_updated'=>date('Y-m-d H:i:s'));
                }

                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true){
                    if(!empty($projects)){                        
                        $this->load->model("common_model");
                        $insert_projects = $projects;
                        foreach($assinged_projects_arr as $pro_id){
                            if(!in_array($pro_id, $projects)){
                                $where = array("user_id"=>$userId, "project_id"=>$pro_id);
                                $sub_arr = array("is_deleted"=>'1', "updated"=>date("Y-m-d H:i:s"), "updated_by"=>$this->user_id);
                                $this->common_model->updateData("user_project_mapping", $where, $sub_arr);
                            }
                        }

                        foreach($projects as $pro){
                            $sql = "SELECT COUNT(*) AS cnt FROM user_project_mapping WHERE user_id=".$userId." AND project_id = ".$pro." AND is_deleted = '0'";
                            $res = $this->common_model->getDataFromQuery($sql);
                            if(empty($res[0]['cnt'])){
                                $sub_arr = array("user_id"=>$userId, "project_id"=>$pro, "created"=>date("Y-m-d H:i:s"), "created_by"=>$this->user_id);
                                $this->common_model->insertData("user_project_mapping", $sub_arr);
                            }
                        }
                    }
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('user/userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        $this->isLoggedIn();
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('is_deleted' => '1','updated_by'=>$this->user_id, 'updated'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->isLoggedIn();
        $data = $this->global;
        $data['page_title'] = 'Change Password<small>Set new password for your account</small>';
        $data['page'] = "dashboard/user/changePassword";        
        $this->load->view('dashboard/main_dashboard_template',$data);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->isLoggedIn();
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required');
        $this->form_validation->set_rules('newPassword','New password','required');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->user_id, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('user/loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updated_by'=>$this->user_id, 'updated'=>date('Y-m-d H:i:s'), 'pwd_updated_by'=>$this->user_id, 'pwd_updated'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->user_id, $usersData);
                
                if($result > 0){ 
                    $this->session->set_flashdata('success', 'Password updated successfully');                    
                }else{
                    $this->session->set_flashdata('error', 'Password updation failed');
                }
                
                redirect('user/loadChangePass');
            }
        }
    }

    function logout(){
        $this->load->model('login_model');

        $where = array("user_id"=>$this->user_id, "logged_in"=>1, "logged_out"=>0);
        $pre_login = $this->login_model->getPreviousSignInLog($where);
        if(count($pre_login) > 0){
            $this->load->model('common_model');
            $where = array('id'=>$pre_login->id);
            $update_data = array('logged_out'=>1, 'logged_out_at'=>date("Y-m-d H:i:s"));
            $this->common_model->updateData("user_signin_log", $where, $update_data);
        }
        
        $this->main_logout();
    }
    

    function pageNotFound(){
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>