<?php include('partials/menu.php') ;?>

        <!-- Maiu Content Section Starts -->
        <div class = "main-content">
            <div class="wrapper">
                   <h1>Manage user</h1>
                   <br /> <br/>

                   <?php 

                   if(isset($_SESSION['add']))
                   {

                    echo $_SESSION['add'];//DISPLAYING SESION MESSAGE
                    unset($_SESSION['add']);//REMOVING SESSION MESSAGE

                   }

                   if(isset($_SESSION['delete']))
                   {

                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);

                   }



                   ?>
                   <br /> <br /> <br />

                   <!-- Button to Add Register -->
                   <a href="add-user.php" class="btn-primary">Add User</a>

                   <br /> <br /> <br />

                   <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th> user Name</th>
                        <th>Actions</th>
                    </tr>

                    <?php

                    //query to get all register
                    $sql = "SELECT * FROM tbl_user";
                    //eXECUTE THE QUERY
                    $res = mysqli_query($conn, $sql);

                    //check whether the Query is Executed of Not

                    if($res==TRUE){

                        //COUNT roWS TO CHECK WHETHER WE HAVE IN DATABASE OR NOT
                        $count = mysqli_num_rows($res);//function to  get all the rows in the database
                        $sn=1; //create avariable and assign the value

                        //check the num of rows

                        if($count>0)
                        {
                            //we have data in database
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //using while loop to get all the data from  database
                                //and  while loop will run as long as we have in database

                                //get individual data
                                $id=$rows['id'];
                                $username=$rows['username'];
                                
                               

                                //display the values in our table
                                ?>
                                <tr>
                        <td><?php  echo $sn++; ?></td>
                        <td><?php  echo $username; ?></td>
                        
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/delete-user.php?id=<?php echo $id; ?>" class="btn-danger">Delete Register</a>
                
                        </td>
                    </tr>



                                <?php
                            }
                        }
                        else{
                            //we do not have data in database
                        }
                    }



                    ?>

                   
                   </table>

                 
                 
                 
            </div>
        </div>
        <!-- Mainu Content Section Ends -->
        

    <?php include('partials/footer.php');?>