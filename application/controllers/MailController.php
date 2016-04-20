<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MailController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('email');
		$this->load->library('email');
	}

	public function sendEmail() {
		$to = $this->input->post('to');
		$subject = $this->input->post('subject');
		$message = $this->input->post('body');
		$headers = $this->input->post('from');
		/*$this->email->from($from);
		$this->email->to($to); 
		$this->email->subject($subject);
		$this->email->message($email_body);	
		$status = $this->email->send();*/
		$status = mail($to,$subject,$message,$headers);
		print_r($status);
	}
}