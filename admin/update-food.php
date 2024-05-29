<?php include('partials/menu.php'); ?>


<?php

if(isset($_GET['id']))

{
    //get all the details
    $id = $_GET['id'];

    //sql query create
    $sql2="SELECT * FROM tbl_food Where id=$id";

    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    //get the individual values of the set
    $title= $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];

}
else
{
    //redirect to manage food
    header('location:'.SITEURL.'admin/manage-food.php');

}

?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
            <tr>
                            <td> Title: </td> 
                            <td>
                                <input type="text" name="title" value="<?php echo $title;?>">
                            </td>
                        </tr>


                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Price: </td>
                            <td>
                                <input type="number" name="price" value="<?php echo $price; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>current Image :</td>
                            <td>
                                <?php
                                if($current_image == "")
                                {
                                    //image not available
                                    echo "<div class ='error'> Image not Added</div>";
                                }
                                else
                                {
                                    //image avalable
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image;?>" width="150px" >
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Select New Image :</td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>Category: </td>
                            <td>
                                <Select name="category">


                                    <?php
                                    //create php code to display categories from database

                                    $sql = "SELECT * FROM tbl_category WHERE  active='Yes'";

                                    $res =mysqli_query($conn,$sql);

                                    $count =mysqli_num_rows($res);
                                    if($count>0)
                                    {

                                        while($row =mysqli_fetch_assoc($res))
                                        {
                                            $category_title =$row['title'];
                                            $category_id = $row['id'];
                                            
                                            ?>
                                            <option <?php if ($current_category==$category_id) { echo "selected";}?>value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                            
                                            <?php
                                        }



                                    }
                                    else
                                    {
                                        ?>
                                        <option value="0">No category Found</option>
                                        <?php

                                    }

                                    ?>
                                </Select>
                            </td>
                        </tr>

                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input <?php if($featured=="Yes") {echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                                <input <?php if($featured=="No") {echo "checked";}?> type="radio" name="featured" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input <?php if($active=="Yes") {echo "checked";}?> type="radio" name="active" value="Yes">Yes
                                <input <?php if($active=="No") {echo "checked";}?> type="radio" name="active" value="No">No
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="submit" name="submit" value="update Food" class="btn-secondary">

                            </td>
                        </tr>


            </table>
        </form>

        <?php
        if(isset($_POST['submit']))
        {
            //echo "Button clicked"


            //1. Get all the details from the form
            $id =$_POST['id'];
            $title = $_POST['title'];
            $description=$_POST['description'];
            $price = $_POST['price'];
            $current_image =$_POST['current_image'];
            $category =$_POST['category'];

            $featured=$_POST['featured'];
            $active = $_POST['active'];

            //2. upload the image if selected

            //chek upload button is clicked or not
            if(isset($_FILES['image']['name']))
            {
                //upload Button clicked
                $image_name =$_FILES['image']['name'];//new image name

                //check the file is available
                if($image_name!= "")
                {
                    //A.uplodeed new image
                    //image is available
                    //Rename the image
                    $ext = end(explode('.', $image_name));
                    $image_name = "Food-Name-".rand(0000,9999).'.'. $ext;//this will be renamed imaged

                    //get the src and destination path
                    $src_path = $_FILES['image']['tmp_name'];//source path
                    $dest_path = "../images/food/" . $image_name;

                    //upload the image
                    $upload =move_uploaded_file($src_path,  $dest_path);
                    //check whether image uploaded of Not
                        if($upload==false)
                        {
                            //failed to upload the image
                            //redirect to Add Food page with Error message
                            $_SESSION['upload']="<div class ='error'>Failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }

                        //3.remove  the image if new image is uploaded and current image exists
                        //B.Remove current image
                        if($current_image!= "")
                        {
                            $remove_path = "../images/food/". $current_image;

                            $remove =unlink($remove_path);

                            //image is remove or not
                            if($remove==false)
                            {
                                $_SESSION['remove-failed'] ="<div class ='error'> failed to remove</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();
                            }

                        }
                    }
                    else
                    {
                        $image_name = $current_image;

                    }
            }
            else 
            {
                $image_name = $current_image;
            }

            //4. update the food in database

            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id 
            ";
            //execute the query
            $res3 =mysqli_query($conn, $sql3);

            //check without data inserted or not
            //Redirect with message to manage food

            if($res3 == true)
            {
                //data inserted successfully
                 $_SESSION['update'] ="<div class='success'> Food updated successfully</div>";
                 header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //fdailed to inset data
                $_SESSION['upate'] ="<div class='error'> Failed to updated food</div>";
                 header('location:'.SITEURL.'admin/manage-food.php');

            }

            //Redirect to manage food with session message
        }
        ?>


    </div>
</div>


<?php include('partials/footer.php'); ?>