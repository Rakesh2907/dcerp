<?php
class Common_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getTableContentCounts($sql){
        $data_arr = array();
        $dbResult = $this->db->query($sql);
        if($dbResult->num_rows() > 0){
            $data_arr = $dbResult->row_array();            
        }
        return $data_arr;
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

    public function insertData($table, $content, $batch = false){
        if(!empty($table) && !empty($content)){
            if($batch){                
                $this->db->insert_batch($table,$content);
                return $this->db->affected_rows();
            }else{
                $this->db->insert($table,$content);
                return $this->db->insert_id();
            }
        }
    }

    public function checkUserLoginId($login_id){
        $this->db->select('count(*) as cnt');
        $this->db->from('user_logins');
        $this->db->where('login_id',$login_id);
        //$this->db->where('username','muqeet');
        $query = $this->db->get();
        $rs = $query->row();

        if($rs->cnt > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updateData($table, $condition, $content, $batch = false){
        if(!empty($table) && !empty($condition) && !empty($content)){
            if($batch){
                $this->db->update_batch($table, $content, $condition);
                return $this->db->affected_rows();
            }else{
                $this->db->where($condition);
                $rep = $this->db->update($table,$content);
                //echo $this->db->last_query();exit;
                return $rep;
            }
        }
    }

    public function getTestsDetailsUsingName($test_name){
        if(!empty($test_name)){
            $this->db->select('id, short_code, test_type, test_name');
            $this->db->from('cp_tests');
            $this->db->where('test_name',$test_name);
            $query = $this->db->get();
            //echo $this->db->last_query();exit;

            $test_details = $query->row_array();

            if(!empty($test_details)){
                return $test_details;
            } else {
                return array();
            }
        }else{
            return array();
        }   
    }

    public function getAllTests($where = null){
        $this->db->select('id, short_code, test_type, test_name');
        $this->db->from('cp_tests');
        if(!empty($where)){
            $this->db->where_in('id', $where);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        $test_list = $query->result();

        if(!empty($test_list)){
            return $test_list;
        } else {
            return array();
        }
    }

    public function getTestList_Where($fields=null, $where = null){
        if(!empty($fields)){
            $this->db->select($fields);
        }else{
            $this->db->select('*');
        }        
        $this->db->from('cp_tests');
        if(!empty($where)){
            foreach($where as $wobj){
                switch($wobj['wos']){
                    case 'or_where':
                        $this->db->or_where($wobj['field'], $wobj['value']);
                    break;
                    case 'where_in':
                        $this->db->where_in($wobj['field'], $wobj['value']);
                    break;
                    case 'or_where_in':
                        $this->db->or_where_in($wobj['field'], $wobj['value']);
                    break;
                    case 'where_not_in':
                        $this->db->where_not_in($wobj['field'], $wobj['value']);
                    break;
                    case 'or_where_not_in':
                        $this->db->or_where_not_in($wobj['field'], $wobj['value']);
                    break;
                    case 'like':
                        $this->db->like($wobj['field'], $wobj['value']);
                    break;
                    case 'or_like':
                        $this->db->or_like($wobj['field'], $wobj['value']);
                    break;
                    case 'not_like':
                        $this->db->not_like($wobj['field'], $wobj['value']);
                    break;
                    case 'or_not_like':
                        $this->db->or_not_like($wobj['field'], $wobj['value']);
                    break;
                    case 'having':
                        $this->db->having($wobj['field'], $wobj['value']);
                    break;
                    case 'or_having':
                        $this->db->or_having($wobj['field'], $wobj['value']);
                    break;
                    default:
                        $this->db->where($wobj['field'], $wobj['value']);
                    break;
                }
            }
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        $test_list = $query->result();

        if(!empty($test_list)){
            return $test_list;
        } else {
            return array();
        }
    }
}
?>