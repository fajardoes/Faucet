<?php
if (isset($_POST['wallet'])){
 include("conn.php");

 $wallet = $_POST['wallet'];

 $query1 = "SELECT id_fau_users FROM fau_users WHERE wallet = '$wallet'";
 if(!$result = mysqli_query($cnn, $query1)){
 		exit(mysqli_error($cnn));
 	}
 	$data = mysqli_fetch_row($result);
 	$userid = (int) $data[0];

   $query2 = "SELECT TIMESTAMPDIFF(MINUTE,MAX(payment_date),now()) as minutes  FROM fau_users_payments where fau_user_id = '$userid'";
    	 if (!$result2 = mysqli_query($cnn, $query2)) {
                    exit(mysqli_error($cnn));
                }
   $response = array();             
   $data2 = mysqli_fetch_row($result2);
   $minutes = (int) $data2[0];
   $response = $data2;

   echo json_encode($response);
}

?>