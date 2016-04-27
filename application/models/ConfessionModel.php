<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionModel extends CI_Model {

      Public function __construct() 
      { 
         parent::__construct(); 
         $this->load->database();
      } 

	public function index($data)
	{
		//asc");
		 $result = $this->db->order_by("tbl_id", "desc")->get_where('tbl_feed',$data);
		 //$result->propertime = "propertime";

      	 return $result->result_array();
	}

	public function postConfession($data)
	{
		$result = $this->db->insert('tbl_feed',$data);

		return $result;
	}

	public function postComment($data)
	{
		$result = $this->db->insert('tbl_comment',$data);

		if($result)
		{
			return $result;
		}
	}

	public function fetchComment($data)
	{
		$this->db->where($data);
		$result = $this->db->order_by("comment_id", "desc")->get('tbl_comment');
		//$result=$this->db->get('tbl_comment');

		if($result)
		{
			return $result->result_array();
		}


	}

	public function getDetailsOfID($data)
	{
		$result = $this->db->get_where('company_info_tbl',$data);

		return $result->result_array();
	}

	public function getCommentReply($data)
	{
		$result = $this->db->get_where('tbl_comment_reply',$data);
		return $result->result_array();
	}
	public function postCommentReply($data)
	{
		$result = $this->db->insert('tbl_comment_reply',$data);
		return $result;
	}


}
