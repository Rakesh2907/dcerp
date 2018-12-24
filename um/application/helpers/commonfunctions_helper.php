<?php
    function getRealIpAddr()
    {
        if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])){
            //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    function getIterationIndex($val){
        $analytes = get_analytes();
        $loop = 0;
        foreach($analytes as $k=>$a){
            if($k === $val){
                return $loop;
                $break;
            }
            $loop++;
        }

    }

    function validateFileExist($path, $file_name){
        $file_path = $path."/".$file_name;
        if (file_exists($file_path)) {
            $ext = explode(".",$file_name);
            $file = $ext[0]."_".time()."_".generateRandomString(3, "num");
            $file_name = $file.".".$ext[1];
            validateFileExist($path, $file_name);
        }
        return $file_name;
    }

    function createDirectory($path){
        if(!empty($path)){
            $d_arr = explode("/",$path);
            $d_path = '';
            foreach($d_arr as $d_name){
                if(!empty($d_name)){
                    $d_path = $d_path.$d_name;
                    if (!file_exists($d_path)) {
                        mkdir($d_path, 0777);
                    }
                    $d_path = $d_path."/";
                }
            }
            return $d_path;
        }
    }

    function digitSuffix($number){
        $last_num = substr($number, -1);
        if($last_num === '1'){
            return $number."st";
        }elseif($last_num === '2'){
            return $number."nd";
        }elseif($last_num === '3'){
            return $number."rd";
        }else{
            return $number."th";
        }
    }

    function encrypt($string, $key=5) {
        $result = '';
        for($i=0, $k= strlen($string); $i<$k; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    function decrypt($string, $key=5) {
        $result = '';
        $string = base64_decode($string);
        for($i=0,$k=strlen($string); $i< $k ; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }

    function getMedicalProgram($medical_program){
        switch($medical_program){
            case "challenger_program":
                return "Challenger Program";
            break;
            case "smash_fifty":
                return "Smash 50";
            break;
            case "guardian":
                return "Guardian Program";
            break;
        }
    }

    function generateUserLoginId($user_type){
        $date = date('Ymd');
        $num = rand(1, 9999);
        switch(strlen($num)){
            case 1:
                $num = (int) "000".$num;
            break;
            case 2:
                $num = (int) "00".$num;
            break;
            case 3:
                $num = (int) "0".$num;
            break;
        }
        if($user_type == 'member'){
            $id = "CPM-".$date.$num;
        }else{
            $id = "CPP-".$date.$num;
        }
        echo $id;

    }

    function generateRandomString($length = 0,$type=null) {
        if($length > 0){
            switch($type){
                case 'num':
                    $characters = '0123456789';
                    break;
                case 'alph':
                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alph_caps':
                    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alph_small':
                    $characters = 'abcdefghijklmnopqrstuvwxyz';
                    break;
                case 'alphnum_caps':
                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alphnum_small':
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                    break;
                case 'color':
                    $characters = '0123456789ABCDEF';
                    break;
                default:
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
            }

            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }

    function page_redirect($page){
        redirect($page);
    }

    function validate_permission($role, $role_text, $permission, $permission_list){
        //echo "<pre>";print_r($permission_list);echo "</pre>";exit;
        if(($role === '1') && ($role_text === 'System Administrator')){
            //echo "Here... Admin";
            return true;
        }else{
            if(!empty($permission) && !empty($permission_list) && in_array($permission, $permission_list)){
                //echo "Here.. 1";
                return true;
            }elseif(in_array('all', $permission_list)){
                //echo "Here.. 2";
                return true;
            }else{
                //echo "Here.. 3";
                return false;
            }
        }
    }

    function validateAccess($functionality, $access_arr){
        //echo $functionality; print_r($access_arr);exit;        
        if(in_array('all', $access_arr)){
            return true;
        }elseif(in_array($functionality, $access_arr)){
            return true;
        }
        return false;
    }

    if(!function_exists('get_date_pattern')) {
        function get_date_pattern($date, $pattern=NULL){
            if(!empty($date)){
                switch($pattern){
                    case 'd M.Y':
                        return date('d M.Y',strtotime($date));
                    break;
                    default:
                        return date('d/m/Y',strtotime($date));
                    break;
                }
            }
        }
    }

    if(!function_exists('mime_content_type')) {

        function mime_content_type($filename) {

            $mime_types = array(

                'txt' => 'text/plain',
                'htm' => 'text/html',
                'html' => 'text/html',
                'php' => 'text/html',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
                'swf' => 'application/x-shockwave-flash',
                'flv' => 'video/x-flv',

                // images
                'png' => 'image/png',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'ico' => 'image/vnd.microsoft.icon',
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',

                // archives
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                'exe' => 'application/x-msdownload',
                'msi' => 'application/x-msdownload',
                'cab' => 'application/vnd.ms-cab-compressed',

                // audio/video
                'mp3' => 'audio/mpeg',
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',

                // adobe
                'pdf' => 'application/pdf',
                'psd' => 'image/vnd.adobe.photoshop',
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',

                // ms office
                'doc' => 'application/msword',
                'rtf' => 'application/rtf',
                'xls' => 'application/vnd.ms-excel',
                'ppt' => 'application/vnd.ms-powerpoint',

                // open office
                'odt' => 'application/vnd.oasis.opendocument.text',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );

            $ext = strtolower(array_pop(explode('.',$filename)));
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            }
            elseif (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }
            else {
                return 'application/octet-stream';
            }
        }
    }

?>