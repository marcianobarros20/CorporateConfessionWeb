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
			$result[$i]['totalcomments'] = $this->getNoOfComments($key['tbl_id']);

			$i++;
			
		}
		//echo "<pre>";
		//print_r($result);
		echo json_encode($result);
		//print_r($result);

	}

	public function getNoOfComments($tblid)
	{
		$data['confession_id_fk'] = $tblid;

		$result = $this->ConfessionModel->getNoOfComments($data);

		return $result; 
		//print_r($result);
	}

	public function getTokens($pushdata)
	{
		$result = $this->ConfessionModel->getTokens();

		if($result)
		{
			foreach ($result as $key)
			{
				$reg_token[]=$key['token'];
			}

			$this->pushNotification1($reg_token,$pushdata);

			//print_r($reg_token);
		}

		

		


	}

	

	public function sendPush()
	{
		$data['title'] = "send push";
		$data['message'] = "sending push";

		$this->pushNotification1($data);
	}

	public function pushNotification1($reg_token,$msg)
	{
		//Getting api key 
		$api_key = "AIzaSyCMYYkHPQKcRjsrwZryisVNo-qzL2fn2Rs";//$_POST['apikey'];	
		
		//Getting registration token we have to make it as array 
		/*$reg_token[] = "dsOfDCWOy_M:APA91bFS31hMmhtlEajUMqx-qdCmAuyhCgJiNotBznPpbjIOuN7PguUad8ilXPUh8SRtGwLq1GKfEd5Kns6Xym8K4-QSaNKUPNdA6EtcnElsBNdzcjRO3IWJYUIuvkZbpfQosyZaHTXf";*/
		/*$reg_token[] = "dsfsfDCWOy_M:APA91bFS31hMmhtlEajUMqx-qdCmAuyhCgJiNotBznPpbjIOuN7PguUad8ilXPUh8SRtGwLq1GKfEd5Kns6Xym8K4-QSaNKUPNdA6EtcnElsBNdzcjRO3IWJYUIuvkZbpfQosyZaHTXf";*/
		
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

		//$msg['message'] = "localhost body";//$push['message'];
		//$msg['title'] = " Database localhost";//$push['title'];
		
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
		if($flag){
			echo "1";
		}else{
			//echo "Error in sending Push Notification";
			print_r($res);
		}
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
		$pushdata['name'] = $data['sender_name'];
		$pushdata['message'] = $data['sender_msg'];
		$pushdata['title'] = "New Confession"; 
		if($result)
		{
			//echo $result;
			$tblid['tbl_id'] = $result;
			$result1 = $this->ConfessionModel->getConfessionByID($tblid);
			
			$result1['propertime'] = $this->time_elapsed_string(strtotime($result1['time']));
			$result1['title'] = "New Confession";
			$result1['pushNotification'] = "1";
			/*$i=0;
			foreach ($result1 as $key)
			{
				$time = strtotime($key['time']);
				$time1=$this->time_elapsed_string($time);
				
				$result1[$i]['propertime'] = $time1;
				$result1[$i]['title'] = "New Confession";
				$result1[$i]['pushNotification'] = 1;

				$i++;
				
			}*/
			//print_r($result1);
			$this->getTokens($result1);
			//print_r($result);
		}
		else
		{
			echo "error";
		}

		
	}

	public function postConfessionNewWithImage()
	{
		$data['sender_name'] = $this->input->post('name');
		$data['sender_msg'] = $this->input->post('confession');
		$data['avatar'] = $this->input->post('avatar');
		$data['device_id'] = $this->input->post('device_id');
		$data['time'] = date("Y-m-d H:i:s");
		$data['company_id'] = $this->input->post('company_id');
		$data['confession_image'] = $this->input->post('confession_image');
		$data['has_image'] = 1;

		$result = $this->ConfessionModel->postConfession($data);

		if($result)
		{
			//echo $result;
			$tblid['tbl_id'] = $result;
			$result1 = $this->ConfessionModel->getConfessionByID($tblid);
			
			$result1['propertime'] = $this->time_elapsed_string(strtotime($result1['time']));
			$result1['title'] = "New Confession";
			$result1['pushNotification'] = "1";
		
			$this->getTokens($result1);
			
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
	$data['device_id'] = $this->input->post('device_id');

	$result = $this->ConfessionModel->postComment($data);

	$data1['comment_id'] = $result;

	if($result)
	{
			$result1 = $this->ConfessionModel->getCommentByID($data1);

			$data2['tbl_id'] = $result1['confession_id_fk'];

			$result2 = $this->ConfessionModel->getConfessionByID($data2); 

			$result2['propertime'] = $this->time_elapsed_string(strtotime($result2['time']));
			$result2['title'] = "New Comment On Confession";
			$result2['pushNotification'] = "1";
			
		
			$this->getTokens($result2);

			print_r($result2);
	}
	else
	{
		echo "error";
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
			$result[$i]['totalReplies'] = $this->getNoOfReplies($key['comment_id']);

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

public function getNoOfReplies($tbl_id)
{
	$data['comment_id_fk'] = $tbl_id;

	$result = $this->ConfessionModel->getNoOfReplies($data);

	return $result;
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
	$data['device_id'] = $this->input->post('device_id');

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


public function getImageByID()
{
	$data['tbl_id'] = $this->input->post('confession_id_fk');

	$result = $this->ConfessionModel->getImageByID($data);

	echo json_encode($result);
}









}
