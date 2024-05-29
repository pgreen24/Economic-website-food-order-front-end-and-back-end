<?php include('partials-front/menu.php'); ?>
<?php
/*Yeah! The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'config/constants.php';
session_start();

//Hey! Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 

    //Hey! Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM tbl_registration WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location:".SITEURL.'error.php');
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location:".SITEURL.'error.php');  
}
?>
<!DOCTYPE html>
<html >
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <link rel="stylesheet" href="../food-order/css/log.css">
</head>
</head>

<body>

<form action="reset_password.php"" method="post">
        <h2 text-align= "center">Choose Your New Password</h2>
        <label for="password">New Password</label>
        <input type="password" id="password" name="New password" placeholder="New password">
        <label for="password">confirm Password</label>
        <input type="password" id="password" name=" confirm password" placeholder="confirm password">
        <!--Hey! This input field is needed, to get the email of the user -->
        <input type="hidden" name="email" value="<?= $email ?>">    
          <input type="hidden" name="hash" value="<?= $hash ?>">  
          <input  type="submit" name ="submit" value="Apply" class="btn-primary">
    </form>
 <!--Load Cloudflare jquery.min.js online-->   
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <!--Load index.js from the resource folder--> 
  <script >
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});
  </script>

</body>
</html>
<?php include('partials-front/footer.php'); ?>