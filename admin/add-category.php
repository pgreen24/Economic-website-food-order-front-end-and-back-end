<?php
include('partials/menu.php');
?>

<div class="main-content">
    <div class="warpper">
        <h1> Add Category</h1>
        <br><br>
        <?php
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add']; 
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload']; 
            unset($_SESSION['upload']);
        }
        ?>
        <br> <br>

        
        <!--Add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <Table class="tbl-30">

            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title"placeholder="category title">
                </td>
            </tr>

            <tr>
                <td>Select Image: </td>
                <td><input type="file" name="image"></td>
                

            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured"value="Yes">Yes
                    <input type="radio" name="featured"value="No">No
                </td>
            </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active"value="Yes">Yes
                    <input type="radio" name="active"value="No">No
                </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="submit" name="submit" value="Add Food" class = "btn-secondary">

                    </td>
                </tr>

            </Table>
        </form>
         <!--Add category form Ends -->

         <?php

         //check the submit button is clicked or not
         if(isset($_POST['submit']))
         {
            //echo "clicked";

            //1. Get the value  from  category form
            $title=$_POST['title'];
            //for radio input,we need to check whether the button is selected or not
            if(isset($_POST['featured']))
            {
                $featured =$_POST['featured'];

            }
            else
            {

                $featured ="No";

            }
                    if(isset($_POST['active']))
                    {

                        $active=$_POST['active'];


                    }
                    else
                    {
                        $active= "No";

                    }
                    //check imge is selected or not and set the value for large 
                    //print_r($_FILES['image']);

                    //die();//bREAK THE CODE HERE
                    if(isset($_FILES['image']['name']))
                    
                       {

                            //upload the image
                            //to upload image we need image name,source path and destination
                            $image_name = $_FILES['image']['name'];


                            //upload the image only if image is selected
                            if($image_name != "")
                            {

                                //auto rename our image
                                //Get the Extension of our image(jpg,phg,gif,etc)e.g "secialfood1.jpg

                                $ext =end(explode('.',$image_name));

                                //rename the image

                                $image_name = "Food_category_".rand(000,999).'.'.$ext;//e.g food category_834.jpg

                                $source_path = $_FILES['image']['tmp_name'];

                                $destination_path ="../images/category/".$image_name;

                                $upload =move_uploaded_file($source_path,$destination_path);

                                if($upload==false)
                                {
                                    $_SESSION['upload'] ="<div class ='error'>Failed to upload Image</div>";
                                    header('location:'.SITEURL.'admin/add-category.php');
                                    die();

                                }
                            }
                        }
                    else
                    {
                        $image_name="";
                    }

                    //2. create sql query to insert category into database
                    $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name ='$image_name',
                    featured='$featured',
                    active='$active'
                    ";

                    //3.Execute the query and save in database
                    $res = mysqli_query($conn,$sql);
                    //4.check wether the query is Executed  or not and display appropiate message
                    if($res==true)
                    {
                        $_SESSION['add']="<div class = 'success'>category Added Successfully</div>";
                        
                        header("location:".SITEURL.'admin/manage-category.php');
            

                    }
                    else
                    {
                        $_SESSION['add']="<div class = 'success'>failed to  category Added</div>";
                            
                            header("location:".SITEURL.'admin/manage-category.php');
                        

                    }
         }

         ?>

    </div>

</div>
<?php
include('partials/footer.php');
?>