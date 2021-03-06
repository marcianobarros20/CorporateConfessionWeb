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
		$this->db->select('tbl_id,sender_name,sender_msg,time,avatar,company_id,device_id,has_image');
		 $result = $this->db->order_by("tbl_id", "desc")->get_where('tbl_feed',$data);


		 //$result->propertime = "propertime";

      	 return $result->result_array();
	}

	public function postConfession($data)
	{
		$result = $this->db->insert('tbl_feed',$data);

		return $this->db->insert_id();
	}

	public function postComment($data)
	{
		$result = $this->db->insert('tbl_comment',$data);

		if($result)
		{
			return $this->db->insert_id();;
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

	public function ifUserExists($android_id)
	{
		$data['android_id'] = $android_id;
		$result = $this->db->get_where('tbl_device_info',$data);

		if($result->result_array())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateUserData($update,$where)
	{
		$this->db->where($where);
		$result = $this->db->update('tbl_device_info', $update); 

		return $result;
	}

	public function insertNewUserData($data)
	{
		$result = $this->db->insert('tbl_device_info',$data);

		return $result;
	}

	public function getTokens()
	{
		$result = $this->db->get('tbl_device_info');

		return $result->result_array();
	}

	public function getTokensNew($data)
	{
		$result = $this->db->get_where('tbl_device_info',$data);

		return $result->result_array();
	}

	public function getTokenByDeviceId($data1)
	{
		$this->db->select('token');
		$result = $this->db->get_where('tbl_device_info',$data1);

		return $result->row_array()['token'];
	}

	public function getConfessionByID($data)
	{
		$this->db->select('tbl_id,sender_name,sender_msg,time,avatar,company_id,device_id,has_image');
		$result = $this->db->order_by("tbl_id", "desc")->get_where('tbl_feed',$data);
		 
      	 return $result->row_array();
	}

	public function getNoOfComments($data)
	{
		$result = $this->db->get_where('tbl_comment',$data);

		return $result->num_rows();
	}

	public function getNoOfReplies($data)
	{
		$result = $this->db->get_where('tbl_comment_reply',$data);

		return $result->num_rows();
	}

	public function getCommentByID($data)
	{
		$result = $this->db->get_where('tbl_comment',$data);

		return $result->row_array();
	}

	public function getImageByID($data)
	{
		$this->db->select('confession_image');
		$result = $this->db->get_where('tbl_feed',$data);

		return $result->row_array();
	}

	public function registerLikeUnlike($data)
	{
		$result = $this->db->insert('tbl_like',$data);
		return $result;
	}

	public function getLikes($data)
	{
		$result = $this->db->get_where('tbl_like',$data);
		return $result->num_rows();
	}

	public function getPersonLiked($data1)
	{
		$result = $this->db->get_where('tbl_like',$data1);

		return $result->num_rows();
	}

	public function registerCommentInfo($data)
	{
		$result = $this->db->insert('tbl_comment_info',$data);

		return $result;
	}

	public function checkCommentRegister($data)
	{
		$data1['device_id'] = $data['device_id'];
		$data1['confession_id_fk'] = $data['confession_id_fk'];

		$result = $this->db->get_where('tbl_comment_info',$data1);

		return $result;
	}

	public function updateCommentInfo($where,$data2)
	{
		$this->db->where($where);
		$result = $this->db->update('tbl_comment_info', $data2); 

		return $result;
	}

	public function getSeenComments($data)
	{
		$result = $this->db->get_where('tbl_comment_info',$data);

		return $result->row_array()['total_count'];
	}


}
