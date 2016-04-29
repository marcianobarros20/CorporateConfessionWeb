<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionWebModel extends CI_Model {

      Public function __construct() 
      { 
         parent::__construct(); 
         $this->load->database();
      }

     public function getCountry()
	{
		
		$result = $this->db->get('countries');

		return $result->result_array();
	}

	public function getState($data)
	{
		$result = $this->db->get_where('states',$data);
		return $result->result_array();
	}

	public function getCities($data)
	{
		$result = $this->db->get_where('cities',$data);
		return $result->result_array();
	}

	public function registerCompany($data)
	{
		$result = $this->db->insert('company_info_tbl',$data);

		return $result;
	}

	public function searchCompany($data)
	{
		$this->db->select('company_name,tbl_id,company_logo');
		$this->db->from('company_info_tbl');
		$this->db->like('company_name', $data['company_name'],'after');
		return $this->db->get()->result_array();
	} 


  }