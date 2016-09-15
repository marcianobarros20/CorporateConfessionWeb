<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionWeb extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('ConfessionWebModel');
		$this->load->library('session');
		require_once(APPPATH.'libraries/stripe-php-3.21.0/init.php');
		//require_once(APPPATH.'libraries/stripe-php-3.21.0/lib/Stripe.php'); // Your path may be different
		//$this->load->library('stripe');

	}

	public function index()
	{
		//echo site_url();
		$result = $this->ConfessionWebModel->getStripeTokens();
		$this->load->view('index',$result);
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

	public function getCompanyDetails()
	{
		$data['tbl_id'] = $this->input->post('tbl_id');

		$result = $this->ConfessionWebModel->getCompanyDetails($data);

		echo json_encode($result);
	}

	public function stripeToken()
	{

		if($this->input->post('package_name')=="free")
		{
			echo true;
		}
		else
		{
			$result = $this->ConfessionWebModel->getStripeTokens();
			

			if($result->secret_key)
			{
				\Stripe\Stripe::setApiKey($result->secret_key);

				$token = $this->input->post('stripeToken');

				try {
				  $customer = \Stripe\Customer::create(array(
				  "source" => $token,
				  "plan" => $this->input->post('package_name'),
				  "email" => $this->input->post('customerEmail'))
				);

				} catch(\Stripe\Error\Card $e) {
					print_r($e);
				}
				
				
				if($customer['subscriptions']['data'][0]['status']=="active")
				{
					echo true;
				}
				else
				{
					echo false;
				}
			}
			else
			{
				echo false;
			}
			
		}

	}
	public function test()
	{
		echo "hello";
	}

}