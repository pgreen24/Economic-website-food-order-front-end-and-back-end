<?php include('partials-front/menu.php'); ?>
<?php
/* 
   Hello! Just two processes goes here: 
   1. Password reset process
   2. Updates database with new user password
*/
require 'config/constants.php';
session_start();

//Hey! Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    //Hey! Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) { 

        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        
        //Yeah! We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        $email = $mysqli->escape_string($_POST['email']);
        $hash = $mysqli->escape_string($_POST['hash']);
        
        $sql = "UPDATE tbl_registration SET password='$new_password', hash='$hash' WHERE email='$email'";

        if ( $mysqli->query($sql) ) {

        $_SESSION['message'] = "Your password has been reset successfully!";
        header("location:".SITEURL.'success.php');    
        

        }

    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location:".SITEURL.'error.php');  //This will only run if you there's an error
    }

}
?>
<?php include('partials-front/footer.php'); ?>