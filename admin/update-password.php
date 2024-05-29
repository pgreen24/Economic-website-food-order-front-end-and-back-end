<?php

include('partials/menu.php');

?>
<div class="main-content">
    <div class= "wrapper">
        <h1>Change password</h1>

        <br><br>
        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }

        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current password: </td>
                <td>
                    <input type="password" name="Current_password" placeholder="Current password">
                </td>
            </tr>

            <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="New password">
                </td>

            </tr>

            <tr>
            <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm password">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>

            </tr>




        </table>

        </form>

    </div>
</div>


<?php
//check the submit button is clicked or not

if(isset($_POST['submit'])){

    //echo "clicked";

    //1. get the data from form

      $id=$_POST['id'];
      $Current_password = md5($_POST['Current_password']);
      $new_password = md5($_POST['new_password']);
      $confirm_password = md5($_POST['confirm_password']);

    //2. check the user with current id and  current password exixts or not

    $sql = "SELECT * FROM  tbl_admin WHERE id=$id And password ='$Current_password'";

    // execute the query

    $res =mysqli_query($conn, $sql);

   if($res==true)
    {
        //check data is availale or not
        $count=mysqli_num_rows($res);
        if($count==1)
       {
            //user exists and password can be changed
            //echo "user found";
            //check whether the new password and confirm match or not
            if($new_password == $confirm_password)
            {
                //update the password
                //echo"password match";

                $sql2 ="UPDATE tbl_admin SET
                password='$new_password'
                WHERE ID =$id
                ";
                //execute the query 
                $res2 =mysqli_query($conn,$sql2);

                //check the query wxecuted or not
                if($res2 == true)
                {
                    //display success messaage
                    //Redirect to manage admin page with eoor message
                $_SESSION['change-pwd'] ="<div class ='success'> password change successfully </div>";
                //redirect the user 
                header('location:'.SITEURL.'admin/manage-admin.php');


                }
                else
                {

                    //display success messaage
                    //Redirect to manage admin page with eoor message
                $_SESSION['change-pwd'] ="<div class ='error'> Failed to change password </div>";
                //redirect the user 
                header('location:'.SITEURL.'admin/manage-admin.php');

                }

            }

            else
            {
                //Redirect to manage admin page with eoor message
                $_SESSION['pwd-not-match'] ="<div class ='error'> password Did not match </div>";
                //redirect the user 
                header('location:'.SITEURL.'admin/manage-admin.php');

            }

        }
        else
        {
            $_SESSION['user-not-found'] ="<div class ='error'>User Not Found. </div>";
            //redirect the user 
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }//

    //3.check the new password and confirm password match or not

    //4. change password if all above is true

}


?>



<?php

include('partials/footer.php');

?>