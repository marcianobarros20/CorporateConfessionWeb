<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MailController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper('email');
		$this->load->library('email');
	}

	public function sendEmail() {
		//$to = $this->input->post('to');
		//$subject = $this->input->post('subject');
		//$message = $this->input->post('body');
		//$headers = $this->input->post('from');
		$this->email->from('hello@tier5.in', 'kingsuk Roy');
		$this->email->to('kingsuk.majumder@gmail.com'); 
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.'); 	
		$status = $this->email->send();
		//$status = mail($to,$subject,$message,$headers);
		print_r($status);
		echo $this->email->print_debugger();
	}
}