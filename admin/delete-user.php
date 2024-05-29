<?php

//include constants.php file here
include('../config/constants.php');
//1. get the id of to be deleted


echo $id =$_GET['id'];

//2.create sql query delete admin
$sql = "DELETE FROM tbl_user WHERE id=$id";

//eXECUTE THE QUERY
$res = mysqli_query($conn,$sql);

//check whether the query executed successfully or not

if($res==true){

    //query executed successfully and admin deleted
    //echo "admin deleted";
    //CREATE SESSION VARIABLE TO DISPLAY MESSAGE
    $_SESSION['delete'] ="<div class = success >Admin Deleted Successfully user</div>";
    //redirect to manage admin page
    header('location:'.SITEURL. 'admin/manage-user.php');
}
else
{
    //failed to delete admin
    //echo "FAILED TO DELETE ADMIN";
    $_SESSION['delete'] ="<div class =error>Admin Failed to Deleted User.Try Again</div>";

    header('location:'.SITEURL. 'admin/manage-user.php');
}


//3.Redirect to manage admin page with message(success /error)

?>