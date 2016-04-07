<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confession extends CI_Controller {


	public function index()
	{
		$data['name'] = $this->input->post('name');
		$data['password'] = $this->input->post('password');
		/*$string['welcome'] = "Welcome To Confession App";
		$string['msg'] = "Hellp Employee";*/
		
		echo json_encode($data);
	}



}