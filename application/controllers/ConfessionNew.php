<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfessionNew extends CI_Controller {

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

	public function notifiFirst()
	{
		$token = "fEGhvqURPbg:APA91bEH8t4K2FgrOQahjvfbfu09eifVDluYEO_3K6kw8AZtiX9YuCOrVupzojbFKeJGE3Z4OeQyxSApEssjiRg6e0_AfdQGZ2UfRIuxx5P2c1BhVQXOzBNZe0oIR4LIs4XmoLopOunW";

		$this->pushNotification($token);
	}
	public function notifiSecond()
	{
		$token = "df_lpBr1Hp0:APA91bFTkEB6PF0Ls9HNSPWp83IWwP3hgDT8RjQLml6o24p_vPgW6Qn5Gk6U2UGm_21xsfBgyMwuuycSm43j9pMT6NPvDSxdJ30k8_KZxJ81Va5esY-tD56HC0rx4VInMU2T6Gdb0tyO";

		$this->pushNotification($token);
	}

	public function sendPush()
	{
		$data['title'] = "send push";
		$data['message'] = "sending push";

		$this->pushNotification($data);
	}


	public function pushNotification($push)
	{
		//Getting api key 
		$api_key = "AIzaSyCMYYkHPQKcRjsrwZryisVNo-qzL2fn2Rs";//$_POST['apikey'];	
		
		//Getting registration token we have to make it as array 
		$reg_token[] = "deJYQNM9qoI:APA91bG8XxX6Y7I9BoTVdkHJjbDBLY4hU__BGGTskCAJP9wzBXLBL3c6_gc1TXOcXUfrbNV-KU_D2glmyvQuuRuBOsUl8Fv8WjUf6nt0EwRaT74Jfx6xhMV77rGEc7ud4gbZ2vT4kyhH";
		$reg_token[] = "eum2xTSXTNI:APA91bGKc4ARn5pGu64OfyWmPkvEigzw9dB9f1t1BopebaSFrX5B2ref1Oe-YBWW9yq9v1ZOp-MfghO0f3VzTwsZKcp0boKo5KEoRWgBY4jcxerMn5MjPZAyN_SiRgEAl0z97UztfCCy";
		//Getting the message 
		$message = "from localhost";//$_POST['message'];
		
		//Creating a message array 
		/*$msg = array
		(
			'message' 	=>"Confession Mdsfasdf sdfasdf sfsadf sadfa fsdfasd fasdfasdf sadfasdf sdfasdf sdfasdf sdfasdf sdfasdfasd sdfsdfasdfa dsfsd sdfasdfasd sdf dsfa sdfdsf sdaf  sddfs fsadf essage",
			'title'		=> 'Oracle Header',
			'subtitle'	=> 'Confession Name',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);*/

		$msg['message'] = $push['message'];
		$msg['title'] = $push['title'];
		
		//Creating a new array fileds and adding the msg array and registration token array here 
		$fields = array
		(
			'registration_ids' 	=> $reg_token,
			'data'			=> $msg
		);
		
		//Adding the api key in one more array header 
		$headers = array
		(
			'Authorization: key=' . $api_key,
			'Content-Type: application/json'
		); 
		
		//Using curl to perform http request 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		//Getting the result 
		$result = curl_exec($ch );
		curl_close( $ch );
		
		//Decoding json from result 
		$res = json_decode($result);

		
		//Getting value from success 
		$flag = $res->success;
		
		//if success is 1 means message is sent 
		if($flag == 1){
			//echo "1";
		}else{
			//echo "Error in sending Push Notification";
		}
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
		$push['title'] = $data['sender_name'];
		$push['message'] = $data['sender_msg']; 
		if($result)
		{
			
			$this->pushNotification($push);
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
		$push['title'] = $data['sender_name'];
		$push['message'] = $data['sender_msg']; 
		if($result)
		{
			
			$this->pushNotification($push);
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

public function getCommentReply()
{
	$data['comment_id_fk'] = $this->input->post('comment_id_fk');
	$result = $this->ConfessionModel->getCommentReply($data);

	$i=0;
		foreach ($result as $key)
		{
			$time = strtotime($key['reply_time']);
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
	//echo json_encode($result);
}

public function postCommentReply()
{
	$data['reply_name'] = $this->input->post('reply_name');
	$data['reply_msg'] = $this->input->post('reply_msg');
	$data['reply_time'] = date("Y-m-d H:i:s");
	$data['comment_id_fk'] = $this->input->post('comment_id_fk');
	$data['avatar'] = $this->input->post('avatar');

	$result = $this->ConfessionModel->postCommentReply($data);
	echo $result;
}


public function saveToken()
{
	$data['token'] = $this->input->post('token');
	$data['android_id'] = $this->input->post('android_id');
	$data['company_id'] = $this->input->post('company_id');
	$data['time'] = date("Y-m-d H:i:s");

	$result = $this->ConfessionModel->ifUserExists($data['android_id']);

	if($result)//user exists
	{
		
		$update['token'] = $data['token'];
		$update['company_id'] = $data['company_id'];
		$where['android_id'] = $data['android_id'];

		$result1 = $this->ConfessionModel->updateUserData($update,$where);//updating user details

		if($result1)
		{
			echo "updated";
		}
		else
		{
			echo "error in saveTOKEN";
		}


	}
	else//user does not exists
	{
		$result2 = $this->ConfessionModel->insertNewUserData($data);//inserting new user's data into database
		if($result2)
		{
			echo "inserted";
		}
		else
		{
			echo "not inserted";
		}
	}



	echo json_encode($data);
}









}
