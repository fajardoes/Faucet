<?php
        if(isset($_POST['first_name']) && isset($_POST['last_name'])  && isset($_POST['email'])  && isset($_POST['phone'])  && isset($_POST['pass']) && isset($_POST['wallet']))
        {
            // include Database connection file  
            include("conn.php");
            // get values 
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $pass = $_POST['pass'];
            $wallet = $_POST['wallet'];
            
        $query = "SELECT * FROM fau_users WHERE email = '$email' or wallet ='$wallet'";
        if (!$result = mysqli_query($cnn, $query)) {
        exit(mysqli_error($cnn));
    }
    $response = array();
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        // $response['status'] = 200;
        // $response['message'] = "Data not found!";
           $salted = "4566654jyttgdjgghjygg".$pass."yqwsx6890d";
           $hashed = hash("sha512", $salted);
           $query = "INSERT INTO fau_users(first_name, last_name, email, phone, pass, wallet) VALUES('$first_name', '$last_name', '$email', '$phone', '$hashed', '$wallet')";
                if (!$result = mysqli_query($cnn, $query)) {
                    exit(mysqli_error($cnn));
                }
    }
    // display JSON data
    echo json_encode($response);
}        

            else{
                 $response['status'] = 200;
                 $response['message'] = "Invalid Request!";
               
            }                     
?>