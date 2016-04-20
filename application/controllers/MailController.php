<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MailController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('email');
	}

	public function sendEmail() {
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$subject = $this->input->post('subject');
		$email_body = $this->input->post('body');
		$this->email->from($from, 'Corporate Confession Admin');
		$this->email->to($to); 
		$this->email->subject($subject);
		$this->email->message($email_body);	
		$status = $this->email->send();
		print_r($status);
	}
}