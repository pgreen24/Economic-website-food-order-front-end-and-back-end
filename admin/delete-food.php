<?php

//inlude constants page
include('../config/constants.php');
   //echo "delete food page";

   if(isset($_GET['id'])&& isset($_GET['image_name']))//Either use '&&' or'And'
   {

                //process to delete
                //echo"process to delete";

                //1.Get  id image name
                $id=$_GET['id'];
                $image_name = $_GET['image_name'];
                // 2.remove the image if available
                //check whether the image is available or not and delete only if available
                if( $image_name != "")
                {
                    //it has image and need to remove from folder
                    //Get the image
                    $path ="../images/food/" . $image_name;
                    //remove image file from folder
                    $remove =unlink($path);

                    //check whether the image is removed or not

                    if($remove == false)
                    {
                        //failed to remove image
                        $_SESSION['upload'] ="<div class = 'error'>failed to Remove image file.</div>";
                        //rediect to manage food
                        header('location:' .SITEURL.'admin/manage-food.php');
                        //stop the process of deleting food
                        die();

                    }
                }
                //3.delete food from database;

                $sql ="DELETE FROM tbl_food where id=$id";
                //execute the query
                $res =mysqli_query($conn, $sql);

                //check whether the query executed or not and set the session message respectively
                //4.redirect to manage food with session message

                if($res==true)
                {
                    //food deleted
                    $_SESSION['delete'] = "<div class='success'>Food deleted successfully</div>";
                    header('location:' .SITEURL.'admin/manage-food.php');

                }

                else
                {
                    //failed to manage food session
                    $_SESSION['delete'] = "<div class='error'>FAILED TO ADDED FOOD</div>";
                    header('location:' .SITEURL.'admin/manage-food.php');

                }


                
            

   }
   else
   {

    //Redirect to manage food page
    //echo "Redirect";

    $_SESSION['unauthorize'] ="<div class ='error'>unauthorized Access.</div>";
    header('location:' .SITEURL.'admin/manage-food.php');

   }
?>