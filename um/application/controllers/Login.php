<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
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
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {        
        //$isLoggedIn = $this->session->userdata('isLoggedIn');
        $mainSession = $this->session->userdata('um');
        $isLoggedIn = $mainSession['isLoggedIn'];
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            //$this->load->view('login');
            $data['page'] = "login/login";
            $this->load->view('login/main_dashboard_template',$data);
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe_old(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email or User Name', 'required|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE){
            //redirect('/login');
            $this->index();
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user_login = $this->login_model->getUserDetails($email);
            if(count($user_login) > 0){
                $where = array("user_id"=>$user_login->id, "logged_out"=>0);
                $pre_login = $this->login_model->getPreviousSignInLog($where);

                if(count($pre_login) > 0){
                    if($pre_login->attempted_number >= 3){
                        $this->session->set_flashdata('error', 'Your Account has been locked, Please contact to IT Team.');
                        redirect('login');
                    }
                }
            }


            $result = $this->login_model->loginMe($email, $password);
            if(count($result) > 0){
                $this->load->model('common_model');
                foreach ($result as $res){
                    $pwd_updated_date = '';
                    if(isset($res->pwd_updated) && !empty($res->pwd_updated)){
                        $pwd_updated_date = strtotime(date("Y-m-d", strtotime($res->pwd_updated)));
                    }
                    $todays_date = strtotime(date("Y-m-d"));
                    $datediff = $todays_date - $pwd_updated_date;
                    $diff1 = round($datediff / (60 * 60 * 24));
                    
                    $sessionArray = array('um'=>array('userId'=>$res->id, 'name'=>$res->name, 'role_id'=>$res->role_id, 'staff_id'=>$res->staff_type_id, 'isLoggedIn'=>TRUE, 'pswd_updated_days'=>$diff1));
                    //echo "<pre>";print_r($sessionArray);echo "</pre>";exit;
                                    
                    $this->session->set_userdata($sessionArray);

                    if($res->role_id != ROLE_ADMIN){
                        /**** ****/
                        if(count($pre_login) > 0){
                            $where = array('id'=>$pre_login->id);
                            $update_data = array('logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                            $this->common_model->updateData("user_signin_log", $where, $update_data);
                        }else{
                            $input_data = array("user_id"=>$res->id, 'project_id'=>0, 'logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                            $this->common_model->insertData("user_signin_log", $input_data);
                        }
                        /**** ****/
                    }
                    redirect('dashboard');
                }
            }elseif(count($pre_login) > 0){
                $this->load->model('common_model');
                $current_time = strtotime(date("Y-m-d H:i:s"));
                $last_tried_time = strtotime($pre_login->created);
                $diff = ($current_time - $last_tried_time) / 60;
                if($diff < 15){
                    $attempted_number = (int) $pre_login->attempted_number;
                    $attempted_number++;
                    $where = array('id'=>$pre_login->id);
                    $update_data = array('attempted_number'=>$attempted_number);
                    $this->common_model->updateData("user_signin_log", $where, $update_data);
                }else{
                    $where = array($pre_login->id);
                    $update_data = array('logged_out'=>1, 'logged_out_at'=>date("Y-m-d H:i:s"));
                    $this->common_model->updateData("user_signin_log", $where, $update_data);


                    $input_data = array("user_id"=>$user_login->id, 'project_id'=>0, 'logged_in'=>0, 'created'=>date("Y-m-d H:i:s"), 'attempted_number'=>1);
                    $this->common_model->insertData("user_signin_log", $input_data);
                }

                $this->session->set_flashdata('error', 'User Name or password mismatch');
                redirect('login');
            }else{                
                if(!empty($user_login) && ($user_login->role_id != ROLE_ADMIN)){
                    $this->load->model('common_model');
                    $input_data = array("user_id"=>$user_login->id, 'project_id'=>0, 'logged_in'=>0, 'created'=>date("Y-m-d H:i:s"), 'attempted_number'=>1);
                    $this->common_model->insertData("user_signin_log", $input_data);
                }

                $this->session->set_flashdata('error', 'User Name or password mismatch');
                redirect('login');
            }
        }
    }

    public function loginMe(){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email or User Name', 'required|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE){
            //redirect('/login');
            $this->index();
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user_login = $this->login_model->getUserDetails($email);            
            if(count($user_login) > 0){
                $where = array("user_id"=>$user_login->id, "logged_out"=>0);
                $pre_login = $this->login_model->getPreviousSignInLog($where);

                if(count($pre_login) > 0){
                    if($pre_login->attempted_number >= 3){
                        $this->shoot_unauthorise_access_attempt_email($email, "Invalid Password and Account Locked");
                        $this->shoot_account_locked_email($user_login);
                        $this->session->set_flashdata('error', 'Your Account has been locked, Please contact to IT Team.');
                        redirect('login');
                    }
                }

                $result = $this->login_model->loginMe($email, $password);
                if(count($result) > 0){
                    $this->load->model('common_model');
                    foreach ($result as $res){
                        $pwd_updated_date = '';
                        if(isset($res->pwd_updated) && !empty($res->pwd_updated)){
                            $pwd_updated_date = strtotime(date("Y-m-d", strtotime($res->pwd_updated)));
                        }
                        $todays_date = strtotime(date("Y-m-d"));
                        $datediff = $todays_date - $pwd_updated_date;
                        $diff1 = round($datediff / (60 * 60 * 24));
                        
                        $sessionArray = array('um'=>array('userId'=>$res->id, 'name'=>$res->name, 'role_id'=>$res->role_id, 'staff_id'=>$res->staff_type_id, 'isLoggedIn'=>TRUE, 'pswd_updated_days'=>$diff1));
                        //echo "<pre>";print_r($sessionArray);echo "</pre>";exit;
                                        
                        $this->session->set_userdata($sessionArray);
                        if($res->role_id != ROLE_ADMIN){
                            if(count($pre_login) > 0){
                                //echo "<pre>";print_r($pre_login);echo "</pre>";exit;
                                /*$where = array('id'=>$pre_login->id);
                                $update_data = array('logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                                $this->common_model->updateData("user_signin_log", $where, $update_data);*/
                                //$logged_out_at = date("Y-m-d H:i:s", (strtotime("+30 minutes", strtotime($pre_login->logged_in_at))));
                                $logged_out_at = date("Y-m-d H:i:s");

                                $pre_login_date = new DateTime($pre_login->logged_in_at);
                                $time_diff = $pre_login_date->diff(new DateTime($logged_out_at));
                                $set_logout = false;
                                if($time_diff->h >0){
                                    $set_logout = true;
                                }elseif($time_diff->i > 30){
                                    $set_logout = true;
                                }

                                if($set_logout){
                                    $where = array('id'=>$pre_login->id);
                                    $update_data = array('logged_out'=>1, 'logged_out_at'=>$logged_out_at);
                                    $this->common_model->updateData("user_signin_log", $where, $update_data);

                                    $input_data = array("user_id"=>$res->id, 'project_id'=>0, 'logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                                    $this->common_model->insertData("user_signin_log", $input_data);
                                }else{
                                    $where = array('id'=>$pre_login->id);
                                    $update_data = array('logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                                    $this->common_model->updateData("user_signin_log", $where, $update_data);
                                }
                            }else{
                                $input_data = array("user_id"=>$res->id, 'project_id'=>0, 'logged_in'=>1, 'logged_in_at'=>date("Y-m-d H:i:s"), 'remote_ip'=>$_SERVER['REMOTE_ADDR']);
                                $this->common_model->insertData("user_signin_log", $input_data);
                            }
                        }                            
                    }
                    redirect('dashboard');
                }else{
                    if(count($pre_login) > 0){
                        $this->load->model('common_model');
                        $current_time = strtotime(date("Y-m-d H:i:s"));
                        $last_tried_time = strtotime($pre_login->created);
                        $diff = ($current_time - $last_tried_time) / 60;
                        if($diff < 15){
                            $attempted_number = (int) $pre_login->attempted_number;
                            $attempted_number++;
                            $where = array('id'=>$pre_login->id);
                            $update_data = array('attempted_number'=>$attempted_number);
                            $this->common_model->updateData("user_signin_log", $where, $update_data);
                        }else{
                            $where = array('id'=>$pre_login->id);
                            $update_data = array('logged_out'=>1, 'logged_out_at'=>date("Y-m-d H:i:s"));
                            $this->common_model->updateData("user_signin_log", $where, $update_data);


                            $input_data = array("user_id"=>$user_login->id, 'project_id'=>0, 'logged_in'=>0, 'remote_ip'=>$_SERVER['REMOTE_ADDR'], 'created'=>date("Y-m-d H:i:s"), 'attempted_number'=>1);
                            $this->common_model->insertData("user_signin_log", $input_data);
                        }
                        $this->shoot_unauthorise_access_attempt_email($email, "Invalid Password");
                    }else{
                        if(!empty($user_login) && ($user_login->role_id != ROLE_ADMIN)){
                            $this->load->model('common_model');
                            $input_data = array("user_id"=>$user_login->id, 'project_id'=>0, 'logged_in'=>0, 'remote_ip'=>$_SERVER['REMOTE_ADDR'], 'created'=>date("Y-m-d H:i:s"), 'attempted_number'=>1);
                            $this->common_model->insertData("user_signin_log", $input_data);
                            $this->shoot_unauthorise_access_attempt_email($email, "Invalid Password");
                        }
                    }                    
                    $this->session->set_flashdata('error', 'User Name or password mismatch');
                    redirect('login');
                }
            }else{
                $this->shoot_unauthorise_access_attempt_email($email, "Invalid User Name");
                $this->session->set_flashdata('error', 'Invalid User Name.');
                redirect('login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $this->load->view('forgotPassword');
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email|xss_clean');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->input->post('login_email');
            
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
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
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
            redirect('/forgotPassword');
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
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
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

            redirect("/login");
        }
    }

    private function shoot_unauthorise_access_attempt_email($user_name=NULL, $status=NULL){
        $this->load->helper('commonfunctions');
        if(!empty($user_name) && !empty($status)){
            $data['user_name'] = $user_name;
            $data['status'] = $status;
            $data['ip_addesss'] = getRealIpAddr();

            $to_emails = array("developer@datarpgx.org");//, "itd@datarpgx.org"

            $subject = "Login failed at ".$data['ip_addesss']." by ".$data['user_name'];
            $message = $this->load->view('email/unauthorise_access_attempt_email', $data, true);

            $this->load->library('email');

            foreach($to_emails as $to){
                $this->email->clear();

                $this->email->from(EMAIL_FROM, FROM_NAME);
                $this->email->to($to);

                $this->email->subject($subject);
                $this->email->message($message);

                $this->email->send();
                //echo $this->email->print_debugger();exit;
            }
        }
    }

    private function shoot_account_locked_email($userObj=NULL){
        $this->load->helper('commonfunctions');
        if(!empty($userObj) && !empty($userObj)){            
            $userObj->email_id = preg_replace('/[0-9]+/', '', $userObj->email_id);
            //echo "<pre>";print_r($userObj);echo "</pre>";exit;
            $data['user_name'] = $userObj->login_user_name;
            $data['name'] = $userObj->name;

            $to_emails = array($userObj->email_id, "developer@datarpgx.org");//, "itd@datarpgx.org"

            $subject = "User Management Account has been locked.";
            $message = $this->load->view('email/account_locked_email', $data, true);

            $this->load->library('email');

            foreach($to_emails as $to){
                $this->email->clear();

                $this->email->from(EMAIL_FROM, FROM_NAME);
                $this->email->to($to);

                $this->email->subject($subject);
                $this->email->message($message);

                $this->email->send();
                //echo $this->email->print_debugger();exit;
            }
        }
    }
}

?>