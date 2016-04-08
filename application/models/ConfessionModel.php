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
		 $result = $this->db->get('tbl_feed');
      	 return $result->result_array();
	}


}