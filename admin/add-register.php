<?php include ('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Register</h1>
        <br/> <br/> <br/>

        <?php 

        if(isset($_SESSION['add']))//checking whether he session is set of Not
        {
            echo $_SESSION['add'];//display the session message if set 
            unset($_SESSION['add']);//remove session message
        }
        ?>



        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>UserName</td>
                    <td><input type="text" name="username"placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td>
                    <input type="text" name="email"placeholder=" Your Email">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                    <input type="password" name="password"placeholder=" Your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Add Register" class = "btn-secondary">
                    </td>
                </tr>



            </table>
        </form>
            


    </div>



</div>


<?php include ("partials/footer.php")?>

<?php
        //process the value from and save it in Database
        //check wether the button is clicked or not 

        if(isset($_POST['submit'])){
            //Button clicked
            //echo "Button clicked";

            //1. Get the data from form
             $username =$_POST['username'];
             $email =$_POST['email'];
             $password =md5($_POST['password']);//password encryption with MD5

             //2.SQL Query to save the data into database
             $sql = "INSERT INTO tbl_registration SET
                 username= '$username',
                 email = '$email',
                 password = '$password'
                 ";
                 
                 
              //3. execute query and save data in database
              
             $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

            // 4.check wether the (query is Executed)data is interested or not and display appropiate message

            if($res==TRUE)
            {
                //DATA INSERTED
                //echo"Data inserted";
                //create a session variable to message
                $_SESSION['add']="<div class = 'success'>Register Added Successfully</div>";
                //Redirect page TO MANAGE ADMIN
                header("location:".SITEURL.'admin/manage-register.php');
            }

             else{
                //failed TO INSERT DATA
                //echo " failed to insert data";
                //create a session variable to message
                $_SESSION['add']="<div class = 'error'>Failed to Added Admin</div> ";
                //Redirect page TO Add ADMIN
                header("location:".SITEURL.'admin/manage-register.php');
             }
        }
        
        

?>

        