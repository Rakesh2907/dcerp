<?php
class Login_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getDataFromQuery($sql, $single_row = false){
        $data_arr = [];
        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            if($single_row){
                $data_arr = $dbResult->row_array();
            }else{
                $data_arr = $dbResult->result_array();
            }
        }
        return $data_arr;
    }

    public function getUserDetailsByUserName($username){
        $arr = [];
        $sql = "SELECT id, password, verified FROM user_logins WHERE username='".$username."'";
        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $arr = $dbResult->row_array();
        }

        return $arr;
    }

    public function getUserStatusByUserid($user_id){
        $arr = [];
        $sql = "SELECT `log_status` FROM `login_attempts` WHERE `user_id` = ".$user_id;
        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $arr = $dbResult->result_array();
        }

        return $arr;
    }

    public function setInsertUpdate($sql){
        if(!empty($sql)){
            $result = $this->db->query($sql);
            return $result;
        }
    }
}
?>