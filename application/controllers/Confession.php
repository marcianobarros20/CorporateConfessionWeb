<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confession extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('ConfessionModel');
		$this->load->library('session');
	}



	public function index()
	{
		//$result = $this->ConfessionModel->index();

		//print_r($result);
		$data['name'] = "kingsuk";
		$data['pass'] = "king";
		//$result['id'] = 3;
		$result = $this->ConfessionModel->index();

		echo json_encode($result);
		//print_r($result);
	}
	public function postConfession()
	{

		$data['sender_name'] = $this->input->post('name');
		$data['sender_msg'] = $this->input->post('confession');
		$result = $this->ConfessionModel->postConfession($data);

		print_r($result);
	}



}