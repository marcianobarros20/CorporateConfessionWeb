<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionModel extends CI_Model {

      Public function __construct() 
      { 
         parent::__construct(); 
         $this->load->database();
      } 

	public function index()
	{
		//asc");
		 $result = $this->db->order_by("tbl_id", "desc")->get('tbl_feed');

      	 return $result->result_array();
	}

	public function postConfession($data)
	{
		$result = $this->db->insert('tbl_feed',$data);

		return $result;
	}


}