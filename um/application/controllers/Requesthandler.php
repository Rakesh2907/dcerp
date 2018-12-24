<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Requesthandler extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('user_model');
        $this->scope = [];
    }

    public function jump_to_project(){
        if($this->validate_request()){
            $entityBody = file_get_contents('php://input', 'r');
            $obj_arr = json_decode($entityBody);

            $user_id = $this->scope['user_id'];
            $project_id = $obj_arr->project_id;

            $ip = $_SERVER['REMOTE_ADDR'];
	    $startIp = '172.16';
	    $startIp1 = '192.168.150'; 
            $ipcheck = $this->startsWith($ip, $startIp);
	    $ipcheck1 = $this->startsWith($ip, $startIp1);

            if(!empty($user_id) && !empty($project_id)){
                $where = array("user_id"=>$user_id,"project_id"=>$project_id);
                $user_credentials = $this->project_model->usersProjectCredentials($where, true);
                //echo "<pre>";print_r($user_credentials);echo "</pre>";exit;
                if(!empty($user_credentials)){
                    //echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
                    $origin = '';
                    if(isset($_SERVER['HTTP_ORIGIN'])){
                        $origin = $_SERVER['HTTP_ORIGIN'];
                    }else{
                        $origin = 'http://'.$_SERVER['HTTP_HOST'];
                    }
                    //echo $origin;exit;
                    if(isset($user_credentials->key) && ($user_credentials->key === 'lims')){
                        //$url = $_SERVER['HTTP_ORIGIN']."/LIMS";
                        $url = $origin."/".stripslashes($user_credentials->project_url); 
                    }else{
                        $url = $origin."/".stripslashes($user_credentials->project_url);  
                    }
                    
                    $input_data['user_id'] = $user_id;
                    $input_data['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $input_data['user_browser'] = $_SERVER['HTTP_USER_AGENT'];
                    $input_data['username'] = $user_credentials->project_end_user_name;
                    $input_data['password'] = $user_credentials->project_end_password;
                    $input_data['project'] = $user_credentials->key;
                    $input_data['project_id'] = $user_credentials->project_id;
                    //echo "<pre>";print_r($url);echo "</pre>";exit;
		    // && ($ipcheck1 === false)

                    if(isset($user_credentials->key) && ($user_credentials->key === 'lims') && ((($ipcheck === false)) && (!in_array($user_id, array(3,33,21,71,73,53,109,111,125,127))))){
                        echo json_encode(array("status"=>"error", "msg"=>"Remote access not permitted."));
                    }elseif(!empty($input_data['username']) && !empty($input_data['password'])){ 
                        $ch = curl_init($url);

                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
			            $curl_info = curl_getinfo($ch);
                        curl_close($ch);

                        $resp = json_decode($result);
                         //echo "<pre>";print_r($resp);echo "</pre>";exit;
                        if(isset($resp[0]) && ($resp[0] === 'success')){
                            if(isset($user_credentials->key) && ($user_credentials->key === 'lims')){
                                //$url = $origin;
                                $url = $origin."/index.php?id=".$resp[1];
                            }else{
                                $url = str_replace('api/', '',$url."?id=".$resp[1]);    
                            }
                            //echo "<pre>";print_r($url);echo "</pre>";exit;
                            echo json_encode(array("status"=>"success", "url"=>$url));
                        }else{
                            if(isset($resp[1]) && ($resp[1])){
                                //echo "<pre>1: ";print_r($result);echo "</pre>";exit;
                                echo json_encode(array("status"=>"error", "msg"=>"Error005: ".$resp[1]));
                            }else{
                                //echo "<pre>2: ";print_r($curl_info);echo "</pre>";exit;
				//echo "<pre>2: ";var_dump($result);echo "</pre>";exit;
                                echo json_encode(array("status"=>"error", "msg"=>"Error004: Invalid user credentials."));
                            }
                        }
                    }else{
                        echo json_encode(array("status"=>"error", "msg"=>"Error003: Your login has not be created yet."));
                    }
                }else{
                    echo json_encode(array("status"=>"error", "msg"=>"Error002: Invalid user credentials."));
                }
            }else{
                echo json_encode(array("status"=>"error", "msg"=>"Error001: Incomplete information given to process."));
            }
        }else{
            echo json_encode(array("status"=>"error", "msg"=>"Invalid Request."));
        }
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public function unlock_user(){
        if($this->validate_request()){
            $entityBody = file_get_contents('php://input', 'r');
            $obj_arr = json_decode($entityBody);

            if(isset($obj_arr->userId) && !empty($obj_arr->userId)){
                $where = array("user_id"=>$obj_arr->userId, "logged_out"=>0, "attempted_number >="=>3);
                //$update_data = array("attempted_number"=>0);
                $update_data = array("logged_out"=>1, "account_reset_on"=>date("Y-m-d H:i:s"));//"attempted_number"=>0, 
                $this->load->model("common_model");
                if($this->common_model->updateData('user_signin_log', $where, $update_data)){
                    $this->session->set_flashdata('success', 'User unlocked successfuly!');
                    echo json_encode(array("status"=>"success"));
                }else{
                    echo json_encode(array("status"=>"error","msg"=>"Process failed."));
                }
            }else{
                echo json_encode(array("status"=>"error","msg"=>"User id missing."));
            }
        }else{
            echo json_encode(array("status"=>"error", "msg"=>"Invalid Request."));
        }
    }

    private function validate_request(){
        //$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
        $mainSession = $this->session->userdata('um');
        $user_id = $mainSession['userId'];
        $role_id = $mainSession['role_id'];

    	$headers=array();
	    foreach (getallheaders() as $name => $value) {
	        $headers[$name] = $value;
	    }

	    if(isset($headers['Authorization']) && !empty($headers['Authorization'])){
            $token = base64_decode($headers['Authorization']);

            if(isset($role_id) && ($user_id == $token)){
                $this->scope['user_id'] = $user_id;
                $this->scope['request_method'] = $_SERVER['REQUEST_METHOD'];
                return true;
            }else{
                return false;
            }
	    }else{
            return false;
        }
    }
}
?>