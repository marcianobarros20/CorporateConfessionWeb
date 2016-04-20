<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confession extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('email');
	}

	public function sendEmail($from, $to, $subject, $email_body) {
		$this->email->from($from, 'Corporate Confession Admin');
		$this->email->to($to); 
		$this->email->subject($subject);
		$this->email->message($email_body);	
		$this->email->send();
	}
}