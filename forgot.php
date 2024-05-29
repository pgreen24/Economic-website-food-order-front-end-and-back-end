<?php include('partials-front/menu.php'); ?>
<?php 
/* Reset your password form, sends reset.php password link */
require 'config/constants.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM tbl_registration WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: error.php");
        header("location:".SITEURL.'error.php');
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data
        
        $email = $user['email'];
        $hash = $user['hash'];
        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password Reset Link ( clevertechie.com )';
        $message_body = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password:

        C:\xampp\htdocs\food-order\reset.php='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body);

        
        header("location:".SITEURL.'success.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <link rel="stylesheet" href="../food-order/css/log.css">
</head>

<body>
 <!--Display Site Logo at The Top-->
  
    <form action="forgot.php" method="post">
        <h2 text-align= "center">Reset Your Password</h2>
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Email Address">
        <input  type="submit" name ="submit" value="Reset" class="btn-primary">
        
    </form>
     
  
          
</body>

</html>
<?php include('partials-front/footer.php'); ?>