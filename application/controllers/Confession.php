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
		$data['company_id'] = $this->input->post('company_id');
		
		//$result['id'] = 3;
		$result = $this->ConfessionModel->index($data);
		//echo "<pre>";
		//print_r($result);

		$i=0;
		foreach ($result as $key)
		{
			$time = strtotime($key['time']);
			$time1=$this->time_elapsed_string($time);
			
			$result[$i]['propertime'] = $time1;

			$i++;
			
		}
		//echo "<pre>";
		//print_r($result);
		echo json_encode($result);
		//print_r($result);

	}


	public function postConfession()
	{

		$data['sender_name'] = $this->input->post('name');
		$data['sender_msg'] = $this->input->post('confession');
		$data['avatar'] = $this->input->post('avatar');
		
		$data['time'] = date("Y-m-d H:i:s");
		//echo json_encode($data);
		$data['company_id'] = $this->input->post('company_id');
		$result = $this->ConfessionModel->postConfession($data);
//		echo $result;
//exit;
		if($result)
		{
			print_r($result);
		}
		else
		{
			echo "error";
		}

		
	}

	public function postConfessionNew()
	{

		$data['sender_name'] = $this->input->post('name');
		$data['sender_msg'] = $this->input->post('confession');
		$data['avatar'] = $this->input->post('avatar');
		$data['device_id'] = $this->input->post('device_id');
		$data['time'] = date("Y-m-d H:i:s");
		//echo json_encode($data);
		$data['company_id'] = $this->input->post('company_id');
		$result = $this->ConfessionModel->postConfession($data);
//		echo $result;
//exit;
		if($result)
		{
			print_r($result);
		}
		else
		{
			echo "error";
		}

		
	}



public function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

public function showTimeStamp()
{
	

	//echo $timestamp;
	//echo time();

	$timeincode = strtotime("2016-04-11 19:04:07");

	$result = $this->time_elapsed_string($timeincode);

	echo date("Y-m-d H:i:s");

echo $result;


	
}

public function postComment()
{
	$data['comment_name'] = $this->input->post('comment_name');
	$data['comment_msg'] = $this->input->post('comment_msg');
	$data['avatar'] = $this->input->post('avatar');
	$data['comment_time'] = date("Y-m-d H:i:s");
	$data['confession_id_fk'] = $this->input->post('confession_id_fk');

	$result = $this->ConfessionModel->postComment($data);

	if($result)
	{
		print_r($result);
	}
}

public function fetchComment()
{
	$data['confession_id_fk'] = $this->input->post('confession_id_fk');

	$result = $this->ConfessionModel->fetchComment($data);

	$i=0;
		foreach ($result as $key)
		{
			$time = strtotime($key['comment_time']);
			$time1=$this->time_elapsed_string($time);
			
			$result[$i]['propertime'] = $time1;

			$i++;
			
		}

	

	if($result)
	{
		//print_r($result);
		echo json_encode($result);
	}
	else
	{
		echo "no result";
	}
}

public function getDetailsOfID()
{
	$data['registered_code'] = $this->input->post('code');

	$result = $this->ConfessionModel->getDetailsOfID($data);
	if($result)
	{
		
	
	echo json_encode($result);
	}
	else
	{
		echo "no response";
	}
}







}
