<?php
if (isset($_POST['wallet'])){
	include("conn.php");

	$wallet = $_POST['wallet'];

	$query = "SELECT id_fau_users FROM fau_users WHERE wallet = '$wallet'";
	 if(!$result = mysqli_query($cnn, $query)){
 		exit(mysqli_error($cnn));
 	}
 	$data = mysqli_fetch_row($result);
 	$userid = (int) $data[0];
 	$response = array();
 	if (mysqli_num_rows($result) > 0) {

 		 $query2 = "SELECT balance FROM fau_balance WHERE id_user = '$userid'";
    	 
    	 if(!$result = mysqli_query($cnn, $query2)){
 		 exit(mysqli_error($cnn));
 	     }
 	
 	if (mysqli_num_rows($result) > 0) {
 	   $row = mysqli_fetch_row($result);
 	   $faucet_balance = (int) $row[0];
 		
 	}else {
 	  $response['status'] = 0;
 	  $response['message'] = "Invalid Request!";
 	} 	
 	}else{
 	  $response['status'] = 200;
 	  $response['message'] = "Invalid Request!";
 	}
 	echo json_encode($response);
 }
?>