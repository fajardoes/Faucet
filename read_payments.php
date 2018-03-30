<?php
if (isset($_POST['wallet'])) {
   include("conn.php");

$wallet = $_POST['wallet'];

$data = '<table class="table table-hover table-responsive">
                        <tr>
                            <th>N°</th>
                            <th>Payment_Id</th>
                            <th>Date</th>
                            <th>Payment</th>
                        </tr>';
$response = array();

    $query = "SELECT id_fau_users FROM fau_users WHERE wallet = '$wallet'";
    if(!$result = mysqli_query($cnn, $query)){
        exit(mysqli_error($cnn));
    }
    if (mysqli_num_rows($result)>0) {
            $user = mysqli_fetch_row($result);
            $userid = (int) $user[0];

$query2 = "SELECT idfau_users_payments, payment_date, payment FROM fau_users_payments WHERE fau_user_id = '$userid'  order by payment_date DESC limit 100";

 if(!$result = mysqli_query($cnn, $query2)){
        exit(mysqli_error($cnn));
    }
    if (mysqli_num_rows($result)>0) {
        # code...
        $number = 1;
        $sum = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            # code...
              $value = (int) $row['payment'];
              $sum = $sum+$value;
              $data .= '<tr>
                <td>'.$number.'</td>
                <td>'.$row['idfau_users_payments'].'</td>
                <td>'.$row['payment_date'].'</td>
                <td>'.$row['payment'].'</td>
            </tr>';
            $number++;
        }
    }else{
       $sum = 0;
       $data .= '<tr><td colspan="6">Records not found!</td></tr>';
    }
    $data .= '<tfoot>
              <tr>
              <th></th>
              <th></th>
              <th>Total</th>
              <th>'.$sum.'</th>
              </tr>
              </tfoot>
              </table>';
 
    echo $data;
}else
{
         $response = "Invalid Request try to login again";
         echo json_encode($response);
}
}

?>