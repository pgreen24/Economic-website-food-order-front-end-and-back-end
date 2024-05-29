<?php include('partials-front/menu.php'); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION['login']))
{
    echo $_SESSION['login'];
    unset($_SESSION['login']);
}
if(isset($_SESSION['no-login-message']))
{
    echo $_SESSION['no-login-message'];
    unset($_SESSION['no-login-message']);
}


?>

<?php
     //check the submit button is clicked or not
     if(isset($_POST['submit'])){
        //process for Login
        //1.get the data from login form
       //$username = $_POST['username'];
        //$password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password =  md5($_POST['password']);
        $password = mysqli_real_escape_string($conn , $raw_password);



         //2. sql to check the user with user and password exists or not

         $sql ="SELECT * FROM tbl_user WHERE username='$username' AND password = '$password'";
         //execute the query 
         $res= mysqli_query($conn, $sql);

        //4. count rows to check whether the user exits or not
        $count =mysqli_num_rows($res);

        if($count==1)
        {
            //user available
            $_SESSION['user']=$username;//check the user is loged in or Not and logout willunset it
            $_SESSION['login']="<div class = 'success'>Login successful</div>";
            

            //redirect to  to home page/ dashboard
            header("location:".SITEURL.'index.php');
            exit;

        }
        else
        {
            //user not available and login fail
            //user available

            $_SESSION['login']="<div class = 'error text-center'>username or password did not match.</div>";

            //redirect to  to home page/ dashboard
            header("location:".SITEURL.'login.php');
            exit;

        }

     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../food-order/css/log.css">
</head>
<body>
<br><br>
    <form action="login.php" method="post">
        <h2 text-align= "center">Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="checkbox" onclick="toggleVisibility()">Show Password
        <br><br>
        <p class="forgot" ><a href="forgot.php">Forgot Password?</a></p>
        <input  type="submit" name ="submit" value="Login" class="btn-primary">
        <br><br>
        <p>Don't have an account? <a href="../food-order/register.php">Sign Up</a></p>
    </form>

    <script >
        function toggleVisibility() {
    var passwordInput = document.getElementsByName('password')[0];
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}
    </script>
    <?php include('partials-front/footer.php'); ?>
</body>
</html>

