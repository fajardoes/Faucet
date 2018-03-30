<?php
//ini_set('display_errors', true);
if (isset($_POST['walletF'])  && isset($_POST['amountF'])){
	include("conn.php");
	require "../vendor/autoload.php";
    use Superior\Wallet;
    $wallet = new Superior\Wallet();
	$walletF = $_POST['walletF'];
	$amountF = $_POST['amountF'];

	$query = "SELECT id_fau_users FROM fau_users WHERE wallet = '$walletF'";
	 if(!$result = mysqli_query($cnn, $query)){
    	exit(mysqli_error($cnn));
 	}
 	$data = mysqli_fetch_row($result);
 	$userid = (int) $data[0];
 	$response = array();
 	$arr = array();
 	if (mysqli_num_rows($result) > 0) {

 		 $query2 = "SELECT balance FROM fau_balance WHERE id_user = '$userid'";
    	 
    	 if(!$result = mysqli_query($cnn, $query2)){
 		 exit(mysqli_error($cnn));
 	     }
 	     if (mysqli_num_rows($result) > 0) {
 	         $row = mysqli_fetch_row($result) 
 			 $balance = (int) $row[0];
 			 if($balance >= $amountF){
 			 	 $destination1 = (object) ['amount' => $amountF,'address' => $walletF;
 			 	 $options = ['destinations' => $destination1];
 			 	 $objeto = $wallet->transfer($options);
 			 	 $new_balance = $balance-$amountF;
 			 	 //insert into payments_real table
 			 	 $query3 = "UPDATE fau_balance SET balance = '$new_balance' WHERE id_user = '$userid'"; 
                	 if (!$result = mysqli_query($cnn, $query3)) {
                     exit(mysqli_error($cnn));
                      }
 			 }else{
 			 	$response = ['status'] = 0;
 			 }
         }else{
 		     $response = ['status'] = 1;
 		}
 	 }else{
 	 	   $response = ['status'] = 2;
 	 }

 	 $arr =['status'] = $response;
 	 $arr =['transfer_data'] = $objeto; 
 	 echo json_encode($arr);

   //  echo "$objeto";
   // // echo ($address);
   //  echo $destination1->{'amount'};
}
?>
