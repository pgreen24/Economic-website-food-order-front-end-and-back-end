<?php include('partials-front/menu.php'); ?>
<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="../food-order/css/log.css">
</head>
<body>
<!--Display Site Logo at The Top--> 

<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        header("location:".SITEURL.'Login.php');
    endif;
    ?>
    </p>     
    <a href="login.php"><button class="button button-block"/>Login</button></a>
</div>
</body>
</html>
<?php include('partials-front/footer.php'); ?>