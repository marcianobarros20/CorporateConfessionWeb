<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionWeb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('ConfessionModel');
		$this->load->library('session');
	}

	public function index()
	{
		//echo site_url();
		$this->load->view('index');
	}

}