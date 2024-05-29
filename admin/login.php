<?php
include('../config/constants.php');

?>


<html>
    <head>
        <title> Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin2.css">
    </head>
    <body>
        <div class="login">

        <h1 class="text-center">Login</h1>
        <br><br>

        <?php

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
        <br><br>
        
        <!-- login form starts here -->
        <form action="" method="POST" class="text-center">
            Username: </br>
            <input type="text" name = "username" placeholder="Enter user name"><br><br>
            password: </br>
            <input type="password" name ="password" placeholder="Enter password"><br><br>
            <input  type="submit" name ="submit" value="Login" class="btn-primary"><br><br>

        </form>
        <!-- login form End here  -->
        <p class="text-center">created by -<a href="www.Rabeyaakterlima.com">Rabeya Akter Lima</a></p>
        </div>

    </body>
</html>
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

         $sql ="SELECT * FROM tbl_admin WHERE username='$username' AND password = '$password'";
         //execute the query 
         $res= mysqli_query($conn, $sql);

        //4. count rows to check whether the user exits or not
        $count =mysqli_num_rows($res);

        if($count==1)
        {
            //user available

            $_SESSION['login']="<div class = 'success'>Login successful</div>";
            $_SESSION['user']=$username;//check the user is loged in or Not and logout willunset it


            //redirect to  to home page/ dashboard
            header("location:".SITEURL.'admin/');

        }
        else
        {
            //user not available and login fail
            //user available

            $_SESSION['login']="<div class = 'error text-center'>username or password did not match.</div>";

            //redirect to  to home page/ dashboard
            header("location:".SITEURL.'admin/login.php');

        }

     }
?>