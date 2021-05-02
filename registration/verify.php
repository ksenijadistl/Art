<?php

if(isset($_GET['vkey'])){
    //Process Verification
    $vkey = $_GET['vkey'];

    $mysqli = NEW MySQLi('localhost','root','','cart_system');
    if($mysqli->connect_error){
        die("Connection Failed!".$mysqli->connect_error);
    }

    $resultSet = $mysqli->query("SELECT verified,vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
    
    if($resultSet->num_rows == 1){
        //Validate The email
        $update = $mysqli->query("UPDATE USERS SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");

        if($update){
            echo "Your account has been verified. You my now login.";
        }else{
            echo $mysqli->error;
        }

    }else{
        echo "This account invalid or already verified";
    }


}else{
    die("Something went wrong");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
  </body>
  </html>