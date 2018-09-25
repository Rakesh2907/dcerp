<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->model("usermanagement_model");
        $usrmgmt = $this->usermanagement_model->getRecentLogin();
       // echo "<pre>"; print_r($usrmgmt); echo "</pre>"; exit;
        if(!empty($usrmgmt)){
            $usrmgmt->token = unserialize(base64_decode($usrmgmt->token));
            $update_data = array("is_enabled"=>0);
            $this->usermanagement_model->updateRecentLogin($update_data, $usrmgmt->id);
            $this->loginThroughAPI($usrmgmt);
        }else{            
            $this->isLoggedIn();
        }
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $userdata = $this->session->userdata;
        $isLoggedIn = $userdata['resilient']['isLoggedIn'];

        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            header('Location: /um/index.php/user/logout');
            /*$data['page'] = 'login/login';
            $this->load->view('login/login_template', $data);*/
        }
        else
        {
            redirect(base_url());
        }
    }

    public function loginThroughAPI($details_arr){
        $result = $this->login_model->loginMeThroughAPI($details_arr->user_id, $details_arr->user_name);
        if(count($result) > 0){
            foreach ($result as $res)
            {
                $permissions = $this->getPermisions($res->groups);
                $sessionArray = array('userId'=>$res->id,
                                        'role'=>$res->role_id,
                                        'roleText'=>$res->user_role,
                                        'name'=>$res->name,
                                        'token'=>$res->token,
                                        'email_id'=>$email_id,
                                        'permissions'=>$res->permissions,
                                        'ip'=>get_client_ip(),
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata(array("erp"=>$sessionArray));

                redirect(base_url());
            }
        }else{
            $this->session->set_flashdata('error', 'Email or password mismatch');

            redirect(base_url().'/login');
        }
    }

    /**
     * This function used to logged in user
     */
    public function loginMe()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

        if($this->form_validation->run() == FALSE)
        {
            $this->index();
            //print_r($_POST);exit;
        }
        else
        {
            $this->load->helper('commonfunctions');

            $email_id = $this->input->post('email_id');
            $password = $this->input->post('password');

            $result = $this->login_model->loginMe($email_id, $password);
            //echo "<pre>";print_r($result);echo "</pre>";exit;

            if(count($result) > 0)
            {
                //echo "<pre>";print_r($result);echo "</pre>";exit;
                foreach ($result as $res)
                {
                    $sessionArray = array('userId'=>$res->id,
                                            'name'=>$res->name,
                                            'token'=>$res->token,
                                            'email_id'=>$email_id,
                                            'role'=>$res->role_id,
                                            'roleText'=>$res->user_role,
                                            'permissions'=>$res->permissions,
                                            'ip'=>get_client_ip(),
                                            'isLoggedIn' => TRUE
                                        );
                    //echo "<pre>";print_r($sessionArray);echo "</pre>";exit;

                    $this->session->set_userdata(array("erp"=>$sessionArray));                    
                    //redirect(site_url('patient/listing'));
                    redirect(base_url());
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');

                redirect(base_url().'/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $data['page'] = 'login/forgotPassword';
        $this->load->view('login/login_template', $data);
        //$this->load->view('forgotPassword');
    }

    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';

        $this->load->library('form_validation');

        $this->form_validation->set_rules('email_id','Email','trim|required|valid_email');

        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else
        {
            $email = $this->input->post('email_id');

            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);

                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();

                $save = $this->login_model->resetPasswordUser($data);

                if($save)
                {
                    //$data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $data1['reset_link'] = site_url("login/resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email);
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = "developer@datarpgx.org";//$userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect(base_url().'/login/forgotPassword');
        }
    }

    // This function used to reset the password
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);

        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

        $data['email'] = $email;
        $data['activation_code'] = $activation_id;


        if ($is_correct == 1)
        {
            $data['page'] = 'login/newPassword';
            $this->load->view('login/login_template', $data);
            //$this->load->view('newPassword', $data);
        }
        else
        {
            redirect(base_url().'/login');
        }
    }

    // This function used to create new password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');

            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

            if($is_correct == 1)
            {
                $this->login_model->createPasswordUser($email, $password);

                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }

            setFlashData($status, $message);

            redirect(base_url()."/login");
        }
    }

    function getPermisions($grpList = NULL){
        if(!empty($grpList)){
            //print_r($grpList);exit;
            $perm_arr = array();
            $this->load->model('user/user_model');
            $grp_arr = json_decode($grpList);
            $grp_str = implode(',',$grp_arr);

            $where = array("slug IN ('" . str_replace(",", "','", $grp_str) . "') "=>NULL);
            $grp_functionalities = $this->user_model->getGroups($where);

            foreach($grp_functionalities as $fun){
                $sys_functions = json_decode($fun->system_functions);
                foreach($sys_functions as $functions){
                    if(!in_array($functions, $perm_arr)){
                        array_push($perm_arr, $functions);
                    }                    
                }
            }
            return json_encode($perm_arr);
        }
    }
}

?>