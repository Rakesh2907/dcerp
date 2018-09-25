<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('docx_to_pdf')){
    function docx_to_pdf($file_path, $file_name){        
        $file_headers = @get_headers(PYTHON_DOCX_PDF_SCRIPT);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.0 404 NOT FOUND') {
            return array("error","Error occured in file conversion, please contact to Technical Admin.");
        }else{
            $application_path = substr($_SERVER['SCRIPT_FILENAME'], 0, -9).$file_path;
            $post_fields = array('path'=>$application_path, 'file_name'=>$file_name);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, PYTHON_DOCX_PDF_SCRIPT);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec ($ch);

            curl_close ($ch);

            // further processing ....
            return $server_output;
        }
    }
}

if(!function_exists('get_lesions_for_graph'))
{
    function get_lesions_for_graph($patient_lision, $patient_lision_comparision)
    {
        $petct_date = array();
        $graph_lesion_dimension_options = array();
        $graph_lesion_suvmax_options = array();                    
        foreach($patient_lision as $key1=>$lesion){
            $dimension_arr = array();
            $suvmax_arr = array();
            $graph_option1 = array();
            $graph_option2 = array();
            foreach($patient_lision_comparision as $key=>$comp){
                if(!in_array($comp->petct_date, $petct_date)){
                    $petct_date[] = $comp->petct_date;
                }                            
                if($lesion->id === $comp->lesion_id){                                
                    $dimension_arr[$comp->petct_date] = json_decode($comp->dimensions);
                    $suvmax_arr[$comp->petct_date] = $comp->suvmax;

                    $lesion->dimensions = $dimension_arr;
                    $lesion->suvmax = $suvmax_arr;
                    $patient_lision[$key1] = $lesion;
                    //$graph_option1[] = (float)$comp->dimension_area;
                    //$graph_option2[] = (float)$comp->suvmax;


                    $dimensions = $dimension_arr[$comp->petct_date];
                    if(!empty($dimensions) && in_array($dimensions->h, array("(regressed)","regressed"))){
                        if($prv_dimension_area > 0){
                            $new_dimension_area = ($prv_dimension_area * 2) / 3;
                            $patient_lision_comparision[$key]->dimension_area = $new_dimension_area;
                            $graph_option1[] = (float)number_format($new_dimension_area,2);
                            $prv_dimension_area = (float)number_format($new_dimension_area,2);
                        }   
                    }else{
                        $graph_option1[] = (float)$comp->dimension_area;
                        $prv_dimension_area = (float)$comp->dimension_area;
                    }

                    if(in_array($comp->suvmax, array("(regressed)","regressed"))){
                        if($prv_suvmax > 0){
                            $new_suvmax = ($prv_suvmax * 2) / 3;
                            $patient_lision_comparision[$key]->suvmax = $new_suvmax;
                            $graph_option2[] = (float)number_format($new_suvmax, 2);
                            $prv_suvmax = (float)number_format($new_suvmax, 2);
                        }
                    }else{
                        $graph_option2[] = (float)$comp->suvmax;
                        $prv_suvmax = (float)$comp->suvmax;
                    }
                }                        
            }
            $graph_lesion_dimension_options[] = array("name"=>$lesion->lesion,"data"=>$graph_option1);
            $graph_lesion_suvmax_options[] = array("name"=>$lesion->lesion,"data"=>$graph_option2);
        }

        return array($petct_date, $graph_lesion_dimension_options, $graph_lesion_suvmax_options);
    }
}


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();

        $CI->load->library('email');

        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $CI->email->initialize($config);

        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        //var_dump($detail);
        //die;

        //$CI = setProtocol();
        //var_dump($CI);
        //die;

        $CI = get_instance();
        $CI->load->library('email');

        //echo $CI->load->view('login/email/resetPassword', $data, TRUE);exit;

        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('login/email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);        
        //var_dump($CI->email);
        //die;
        $status = $CI->email->send();
        //echo $CI->email->print_debugger();exit;

        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

?>