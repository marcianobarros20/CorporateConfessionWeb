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
		$to = $this->input->post('company_email');
		$name = $this->input->post('person_name');
		//$subject = $this->input->post('subject');
		//$message = $this->input->post('body');
		//$headers = $this->input->post('from');
		$from = $this->input->post('person_email');


		$this->email->from($from, $name);
		$this->email->to($to); 
		$this->email->subject('Someone Just Asked You The Unique ID of Your Company For Corporate Confession App');
		$this->email->message("<h3>This mail is sent via <a src='http://corporateconfessions.us/'>corporateconfessions.us</a></h3>.<p>The person named above have requested you to have your company's unique ID for Corporate Confessions App.If you want to share the same with the person then you can reply this email.</p>"); 	
		$status = $this->email->send();
		//$status = mail($to,$subject,$message,$headers);
		print_r($status);
		echo $this->email->print_debugger();
	}
}