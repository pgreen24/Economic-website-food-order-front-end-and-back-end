<?php
//echo "add food";
include('partials/menu.php');

?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br> <br>
        <?php 
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        
        ?>

        
        <form action="" method="POST" enctype="multipart/form-data"> 

                    <table class="tbl-30">

                        <tr>
                            <td> Title: </td> 
                            <td>
                                <input type="text" name="title" placeholder="title of the food">
                            </td>
                        </tr>

                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5" placeholder="Descreption of the food"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Price: </td>
                            <td>
                                <input type="number" name="price">
                            </td>
                        </tr>

                        <tr>
                            <td>Select Image :</td>
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
                                            $id = $row['id'];
                                            $title =$row['title'];
                                            ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            
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
                                <input type="radio" name="featured" value="Yes">Yes
                                <input type="radio" name="featured" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input type="radio" name="active" value="Yes">Yes
                                <input type="radio" name="active" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Food" class="btn-secondary">

                            </td>
                        </tr>


                </table>

        </form>

        <?php
        
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //1.get the date from form
            $title=$_POST['title'];
            $description =$_POST['description'];
            $price = $_POST['price'];
            $category =$_POST['category'];


            //check the radion button for featured and active are cheked or not
            if(isset($_POST['featured']))
            {
                $featured =$_POST['featured'];
            }
            else
            {
                $featured= "No";

            }
            if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active="No";//setting default values
                }
        
            //2.upload the image
            //check wether the image is clicked or not and upload the image if the image is selected
            if(isset($_FILES['image']['name']))
            {
                //get the details of the selected image
                $image_name=$_FILES['image']['name'];

                //check wether the image is selected or not  and upload image only if selected
                if($image_name!="")
                {
                    //image is selected 
                    //A.renamge the image
                    //get the estention of selected image (jpg,png,gif,etc)"lima-akter.jpg"lima-akter.jpg
                    $ext = end(explode('.',$image_name));

                    //create new name for image

                    $image_name ="Food-Name-".rand(0000,9999).".".$ext;//new image Name May  be "food-name-657.jpg"


                    //B.upload the image
                    //get the src and destination path

                    //source path is the current location
                    $src = $_FILES['image']['tmp_name'];
                    
                    //destination path for the image to be upload
                   
                    $dst = "../images/food/" . $image_name;


                    //finally upload the food  image
                    $upload =move_uploaded_file($src, $dst);


                //check whether image uploaded of Not
                if($upload==false)
                {
                    //failed to upload the image
                    //redirect to Add Food page with Error message
                    $_SESSION['upload']="<div class ='error'>Failed to upload image.</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    //stop the process
                    die();
                }


                }
            }
            else
            {
                $image_name= "";//setting default value as blank
            }

            //3.insert into Data base
            
            //create a sql quert to save or add food
            //for numerical value we do not pass value insive quotes"but for string value if is compulsary to add quotes"
            $sql2 ="INSERT INTO tbl_food SET
            title= '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ";
            //execute the query
            $res2 =mysqli_query($conn, $sql2);

            //check without data inserted or not
            //4.Redirect with message to manage food

            if($res2 == true)
            {
                //data inserted successfully
                 $_SESSION['add'] ="<div class='success'> Food Added successfully</div>";
                 header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //fdailed to inset data
                $_SESSION['add'] ="<div class='error'> Failed to add food</div>";
                 header('location:'.SITEURL.'admin/manage-food.php');

            }


            



        }


        ?>
    </div>

</div>

<?php

include('partials/footer.php');?>