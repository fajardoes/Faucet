<?php 
 if (isset($_POST['wallet']))
 {
 	include("conn.php");

 	$wallet = $_POST['wallet'];
 	$total_users=0;
 	$total_rewards=0;
 	$total_paids=0;

 	$query = " SELECT * FROM fau_users WHERE wallet = '$wallet'";

 	if(!$result = mysqli_query($cnn, $query)){
 		exit(mysqli_error($cnn));
 	}
 	// setcookie("sessiontime",true,time() +(60 * 1));
 	$arr = array();
 	$response = array();
 	if (mysqli_num_rows($result) > 0) {
 		while ($row = mysqli_fetch_assoc($result)) {
 			$response = $row;
 		}

 		$query2 = "SELECT count(*) as total from fau_users";
		if(!$result = mysqli_query($cnn, $query2)){
 		exit(mysqli_error($cnn));
 	}
 	$data = mysqli_fetch_row($result);
 	$total_users = (int) $data[0];

 	    $query3 = "SELECT count(*) as total from fau_users_payments";
 	  	if(!$result = mysqli_query($cnn, $query3)){
 		exit(mysqli_error($cnn));
 	}
 	$data2 = mysqli_fetch_row($result);
 	$total_rewards = (int) $data2[0];

 	    $query4 = "SELECT sum(payment) as total from fau_users_payments";
 	    if(!$result = mysqli_query($cnn, $query4)){
 		exit(mysqli_error($cnn));
 	}
 	$data3 = mysqli_fetch_row($result);
 	$total_paids = (int) $data3[0];

 	}
  	else {
 	  $response['status'] = 200;
 	  $response['message'] = "Invalid Request!";
      $arr['total_users'] = "null";
      $arr['total_rewards'] = "null";
      $arr['total_paids'] = "null";

 	}
 	
 	$arr['total_users'] = $total_users;
 	$arr['total_rewards'] = $total_rewards;
 	$arr['total_paids'] = $total_paids;
 	$arr['user'] = $response;
 	echo json_encode($arr);
 }else {
 	 $response['status'] = 200;
     $response['message'] = "Invalid Request!";
     $arr['total_users'] = $total_users;
 	$arr['total_rewards'] = $total_rewards;
 	$arr['total_paids'] = $total_paids;
 }
 ?>

