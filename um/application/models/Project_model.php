<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model
{
	private function getColumnNameOfTable($table_name){
        $table_fields = array();
        if(!empty($table_name)){
            $sql = "SELECT `COLUMN_NAME`, `DATA_TYPE` 
                    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                    WHERE `TABLE_SCHEMA`='".$this->db->database."' 
                    AND `TABLE_NAME`='".$table_name."';";
            $resultSet =  $this->db->query($sql);
            $data_arr = $resultSet->result();
            foreach($data_arr as $col){
                $table_fields[$col->COLUMN_NAME] = $col->DATA_TYPE;
                //array_push($table_fields, $col->COLUMN_NAME);
            }
            //echo "<pre>";print_r($data_arr);echo "</pre>";exit;
        }
        return $table_fields;
    }

    function checkProjectExist($where=NULL){
        $this->db->select('*');
        $this->db->from('project');                
        if(!empty($where)){
            $this->db->or_where($where);
        }
        $this->db->where('is_deleted', '0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->result();        
        return $result;
    }

	function projectListing($where=NULL){
		$this->db->select('*');
        $this->db->from('project');        
        $this->db->where('is_deleted', '0');
        if(!empty($where)){
        	$this->db->where($where);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->result();        
        return $result;
	}

    function projectDetails($where=NULL){
        $this->db->select('*');
        $this->db->from('project');        
        $this->db->where('is_deleted', '0');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->row();        
        return $result;
    }

	function usersProjectsList($where=NULL){
		$user_project_mapping_fields = $this->getColumnNameOfTable("user_project_mapping");
        $project_fields = $this->getColumnNameOfTable("project");
        $where_string = NULL;
        $where_date_string = NULL;
        if(!empty($where)){
            foreach($where as $k=>$w){
                if (array_key_exists($k,$user_project_mapping_fields)){
                    unset($where[$k]);
                    $where["user_project_mapping.".$k] = $w;
                }elseif(array_key_exists($k,$patient_symptoms_ratings_fields)){                    
                    unset($where[$k]);
                    $where["project.".$k] = $w;
                }
            }
        }

		$this->db->select('project.`id`, user_project_mapping.`project_id`, user_project_mapping.`user_id`, user_project_mapping.`project_end_user_name`, project.`key`, project.`name`, project.`logo_url`, project.`project_url`');
        $this->db->from('user_project_mapping');
        $this->db->join('project', 'project.`id` = user_project_mapping.`project_id` AND project.is_deleted = "0" ');
        if(!empty($where)){
        	$this->db->where($where);	
        }
        $this->db->where('user_project_mapping.is_deleted','0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->result();        
        return $result;
	}

    function allProjectsList($where=NULL){
        $this->db->select("*");
        $this->db->from("project");
        if(!empty($where)){
            $this->db->where($where);   
        }
        $this->db->where('is_deleted','0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        
        $result = $query->result();        
        return $result;
    }

    function usersProjectCredentials($where=NULL, $single=false){
        $user_project_mapping_fields = $this->getColumnNameOfTable("user_project_mapping");
        $project_fields = $this->getColumnNameOfTable("project");
        $where_string = NULL;
        $where_date_string = NULL;
        if(!empty($where)){
            foreach($where as $k=>$w){
                if (array_key_exists($k,$user_project_mapping_fields)){
                    unset($where[$k]);
                    $where["user_project_mapping.".$k] = $w;
                }elseif(array_key_exists($k,$patient_symptoms_ratings_fields)){                    
                    unset($where[$k]);
                    $where["project.".$k] = $w;
                }
            }
        }


        $this->db->select('user_project_mapping.*, project.`name`, project.`key`, project.`project_url`, project.`add_user_url` ');
        $this->db->from('user_project_mapping');
        $this->db->join('project', 'project.`id` = user_project_mapping.`project_id` AND project.is_deleted = "0" ');
        if(!empty($where)){
            $this->db->where($where);   
        }
        $this->db->where('user_project_mapping.is_deleted','0');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        if($single){
            $result = $query->row();
        }else{
            $result = $query->result();
        }
                
        return $result;
    }
}