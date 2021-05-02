<?php
$error = NULL;

if(isset($_POST['submit'])){

    //Get from data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $email = $_POST['email'];
    

    if(strlen($username) < 5) {
        $error = "Your username must be at least 5 characters";
    }elseif($cpassword != $password) {
        $error .= "<p>Your passwords do not match</p>";
    }else{
        //Form is valid

        //Connect to the database
        $mysqli = NEW MySQLi('localhost','root','','cart_system');
        if($mysqli->connect_error){
            die("Connection Failed!".$mysqli->connect_error);
        }

        //Sanitize form data
        $username = $mysqli->real_escape_string($username);
        $password = $mysqli->real_escape_string($password);
        $cpassword = $mysqli->real_escape_string($cpassword);
        $email = $mysqli->real_escape_string($email);
        

        //Generate Vkey
        $vkey = md5(time().$username);

        //insert account into the database
        $password = md5($password);
        $insert = $mysqli->query("INSERT INTO users(username, password, email, vkey) 
        VALUES('$username', '$password', '$email', '$vkey')");

        if($insert){
            //Send Email
            $to = $email;
            $subject = "Email Verification";
            $message = "<a href='http://localhost/EP/art/registration/verify.php?vkey=$vkey'>Register Account </a>";
            $headers = "From: ksendza.1999@gmail.com" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            header('location: index.php');
        }else{
            echo $mysqli->error;
        }

    }
      
}
if(isset($_POST['log_submit'])){

  //Connect to the database
  $mysqli = NEW MySQLi('localhost','root','','cart_system');
  if($mysqli->connect_error){
      die("Connection Failed!".$mysqli->connect_error);
  }
  //Get form data
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $password = md5($password);

  //Query the database
  $resultSet = $mysqli->query("SELECT * FROM users WHERE username = 'username' AND password = '$password' LIMIT 1 ");

  if($resultSet->num_rows != 0){
    //Process Login
    $row = $resultSet->fetch_assoc();
    $verified = $row['verified'];
    $email = $row['email'];
    $date = $row['createdate'];
    $date = strtotime($date);
    $date = date('M d Y', $date);
    
    if($verified == 1){
      //Continue Processing
      

    }else{
      $error = "This account has not yet been verified";

    }
  }else{
    //Invalid credentials
    $error = "The username or password you entered is incorrect";
  }
}
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" method="POST" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
            </div>
            <input type="submit" value="Login" name="log_submit" class="btn solid" />
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
         
          <form action="" method="POST" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="cpassword" placeholder="Confirm password" />
            </div>
            <input type="submit" class="btn" name="submit" value="Sign up" />
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <center>
          <?php
          $error = NULL;
          ?>
          </center>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  </body>
</html>
