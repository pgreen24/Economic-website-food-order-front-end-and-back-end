<?php include('partials-front/menu.php'); ?>
<?php 
/* Verifies registered user email, the link to this page
   is included in the register.php email message 
*/
require 'config/constants.php';
session_start();

//Hey! Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 
    
    //TC: Select user with matching email and hash, who hasn't verified their account yet (active = 0)
    $result = $mysqli->query("SELECT * FROM tbl_registration WHERE email='$email' AND hash='$hash' AND active='0'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "Account has already been activated or the URL is invalid!";
        header("location:".SITEURL.'error.php');
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";
        
        //TC: Set the user status to active (active = 1)
        $mysqli->query("UPDATE tbl_registration SET active='1' WHERE email='$email'") or die($mysqli->error);
        $_SESSION['active'] = 1;
       
        header("location:".SITEURL.'success.php');
    }
}
else {
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    header("location:".SITEURL.'error.php');
}     
?>
<?php include('partials-front/footer.php'); ?>