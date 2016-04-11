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
		$data['name'] = "kingsuk";
		$data['pass'] = "king";
		//$result['id'] = 3;
		$result = $this->ConfessionModel->index();
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
		$result = $this->ConfessionModel->postConfession($data);

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

public function showTimeStamp($time)
{
	$timestamp = $time;

	//echo $timestamp;
	//echo time();

	$timeincode = strtotime("2016-04-11 17:28:32");

	$result = $this->time_elapsed_string($timeincode);

	return $result;


	
}





}