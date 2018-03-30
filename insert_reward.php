<?php
if (isset($_POST['wallet']) && isset($_POST['payment'])) {
	# code...
	include("conn.php");

	$wallet = $_POST['wallet'];
	$payment = $_POST['payment'];
	$response = array();

	$query = "SELECT id_fau_users FROM fau_users WHERE wallet = '$wallet'";
	if(!$result = mysqli_query($cnn, $query)){
 		exit(mysqli_error($cnn));
 	}
 	if (mysqli_num_rows($result)>0) {
 		# code...
 		 	$data = mysqli_fetch_row($result);
 	        $userid = (int) $data[0];

 	           $query1 = "INSERT INTO fau_users_payments(fau_user_id,payment,payment_date) VALUES ('$userid','$payment',now()) ";
 	           if (!$result = mysqli_query($cnn, $query1)) {
                    exit(mysqli_error($cnn));
                }

                //Handle the balance

                $query2 = "SELECT * FROM fau_balance WHERE id_user = '$userid'";
                 if (!$result = mysqli_query($cnn, $query2)) {
                    exit(mysqli_error($cnn));
                }

                if (mysqli_num_rows($result)>0) {
                	$query3 = "SELECT balance FROM fau_balance WHERE id_user = '$userid'";
                	 if (!$result = mysqli_query($cnn, $query3)) {
                     exit(mysqli_error($cnn));
                }                
                $data2 = mysqli_fetch_row($result);
                $old_balance = (int) $data2[0];
                $new_balance = $old_balance+$payment;
                $query4 = "UPDATE fau_balance SET balance = '$new_balance' WHERE id_user = '$userid'"; 
                	 if (!$result = mysqli_query($cnn, $query4)) {
                     exit(mysqli_error($cnn));
                }
                }else{

                	$query5 = "INSERT INTO fau_balance (balance,id_user) VALUES ('$payment','$userid')";
                	 if (!$result = mysqli_query($cnn, $query5)) {
                     exit(mysqli_error($cnn));
                }
          }
    	}else{
    		
    	   $response = "Invalid Request try to loggin again.";
    	}
	}else{
         $response = "Invalid Request try to loggin again.";
	}
	 echo json_encode($response);
?>