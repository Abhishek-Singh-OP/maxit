<?php
class user_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
                $this->load->database();
	}
	
function cards(){
    $query = $this->db->get('card');
    if($query->num_rows() > 0){
        return $query->result();
    }
}

function establishment(){
    $query = $this->db->get('establishment');
    if($query->num_rows() > 0) {
        return $query->result();
    }
}
function offer(){
    $query = $this->db->get('offers');
    if($query->num_rows() > 0) {
        return $query->result();
    }
}
         
function addData($tableName,$data){
	if($this->db->insert($tableName, $data)){
        return true;
    }else{
        return false;
	}
}
	
}
?>