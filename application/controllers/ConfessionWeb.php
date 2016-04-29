<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionWeb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('ConfessionWebModel');
		$this->load->library('session');
	}

	public function index()
	{
		//echo site_url();
		$this->load->view('index');
	}

	public function getCountry()
	{
		$result = $this->ConfessionWebModel->getCountry();

		echo json_encode($result);
	}

	public function getState()
	{
		$data['country_id'] = $this->input->post('country_id');

		$result = $this->ConfessionWebModel->getState($data);

		echo json_encode($result);
	}

	public function getCities()
	{
		$data['state_id'] = $this->input->post('state_id');

		$result = $this->ConfessionWebModel->getCities($data);

		echo json_encode($result);
	}

	public function registerCompany()
	{
		$data['company_name'] = $this->input->post('company_name');
		$data['company_email'] = $this->input->post('company_email');
		$data['company_employee_strength'] = $this->input->post('company_employee_strength');
		$data['company_country'] = $this->input->post('company_country');
		$data['company_state'] = $this->input->post('company_state');
		$data['company_city'] = $this->input->post('company_city');
		$data['company_logo'] = $this->input->post('imageBASE');
		

		$data['registered_code'] = substr(strtoupper(str_replace(' ', '', $data['company_name'])),0,5)."TIER5".rand(101,10000);

		$result = $this->ConfessionWebModel->registerCompany($data);

		if($result)
		{
			echo json_encode($data['registered_code']);
		}
		else
		{
			echo json_encode("error");
		}

		
	}

	public function searchCompany()
	{
		$data['company_name'] = $this->input->post('search');
		$result = $this->ConfessionWebModel->searchCompany($data);

		echo json_encode($result);
	}

}