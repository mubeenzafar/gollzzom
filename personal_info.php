<?php include "header.php"; ?>
  
  
<?php include "top_nav.php"; ?>
<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3>User Profile:</h3>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#passwordModal">Change Password</button>
      </div>

      <?php include "includes/passwordModel.php"; ?>

      <?php
            $user_id = $_SESSION['user_id'];

            if(isset($_POST['change_password']))
            {
              $old_password = escapestring($_POST['old_password']);
              $new_password =  escapestring($_POST['new_password']);
              $repeat_password =  escapestring($_POST['repeat_password']);
              
            
              if(empty($old_password) || empty($new_password) || empty($repeat_password))
              {
                alert('ERROR: Please fill all of field','error');
              }
              elseif(!validate($new_password,'password'))
              {
                alert('New Password Format is incorrect','error');
              }
              elseif($new_password != $repeat_password)
              {
                alert('Error: Repeat Password do not match','error');
              }
              else
              {
                $password = md5($old_password);
                $new_password = md5($new_password);
                $q = "SELECT * from users WHERE user_id = '$user_id' LIMIT 1";
                $row =mysqli_fetch_array(query($q));
                if($password == $row['password'])
                {
                    $q = "UPDATE `users` SET `password`='$new_password' WHERE user_id = '$user_id'";
                    $result = query($q);
                    
                    if($result)
                    {
                    alert('Updated Successfully','success');
                    }
                }
                else{
                    alert('old Password is Incorrect','error');
                }
                
                
              }
            
            }



            if(isset($_POST['update']))
            {
              $gender = escapestring($_POST['gender']);
              $first_name =  escapestring($_POST['firstname']);
              $last_name =  escapestring($_POST['lastname']);
              $password = escapestring($_POST['password']);
              $address = escapestring($_POST['address']);
            
              if(empty($gender) || empty($first_name) || empty($last_name) || empty($address))
              {
                alert('ERROR: Please fill all of field','error');
              }
              elseif(empty($password)){
                alert('Please enter password to update','error');
              }
            
              else
              {
                $password = md5($password);
                $q = "SELECT * from users WHERE user_id = '$user_id' LIMIT 1";
                $row =mysqli_fetch_array(query($q));
                if($password == $row['password'])
                {
                    $q = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`password`='$password',`address`='$address',`gender`='$gender' WHERE user_id = '$user_id'";
                    $result = query($q);
                    
                    if($result)
                    {
                    alert('Updated Successfully','success');
                    }
                }
                else{
                    alert('Pawword is Incorrect','error');
                }
                
                
              }
            
            }



            
            $q="Select * from users where user_id = '$user_id' LIMIT 1";
            $row=mysqli_fetch_array(query($q));
        ?>
      <form action="" method="post" enctype="multipart/form-data">
                                <fieldset class="form-group">
                                    <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0 mr-2">Gender: </legend>
                                    
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="male" <?php if($row['gender'] == 'male') echo 'checked'; ?> >
                                        <label class="form-check-label" for="gridRadios1">
                                            Male
                                        </label>
                                        </div>
                                        <div class="form-check ml-2">
                                        <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="female" <?php if($row['gender'] == 'female') echo 'checked'; ?>>
                                        <label class="form-check-label" for="gridRadios2">
                                            Female
                                        </label>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-group">
                                    <label for="user_firstname">First Name</label>
                                    <input value="<?php echo  $row['first_name']; ?>" type="text" name="firstname" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="user_lastname">Last Name</label>
                                    <input value="<?php echo  $row['last_name']; ?>" type="text" name="lastname" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input value="<?php echo  $row['email'];; ?>" type="email" name="email" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="user_lastname">Address</label>
                                    <input value="<?php echo  $row['address']; ?>" type="text" name="address" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label for="user_password">Account Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter Your Password to Update">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <input type="submit" name="update" class="btn btn-primary" value="Update">
                                </div>

                            </form>
    </main>

  </div>
</div>



<?php include "footer.php" ?>