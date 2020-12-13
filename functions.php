<?php


use function PHPSTORM_META\type;
function downloadFont($filename)
{
    
    $filepath = 'fonts/' . $filename;
    if(!empty($filename) && file_exists($filepath)) {
        header("Cache-Control:  maxage=1");
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.urlencode($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        ob_get_clean();
        ob_clean(); // not necessary
        flush();  // not necessary
        readfile($filename);
        exit;
    } else {
        http_response_code(404);
        die();
    }
}

function alert($message,$type)
{
    if($type == 'success')
    {
        echo '<h5 class="text-success text-center my-2" role="alert">
        '.$message.'
            </h5>';
    }
    else if($type == 'error')
    {
        echo '<h5 class="text-danger text-center my-2" role="alert">
        '.$message.'
            </h5>';
    }
    
    
}

function validate($str,$type){
    if($type == 'text')
    {
        if (!preg_match("/^[a-zA-Z]{3,15}$/",$str)) {
            alert('Name error: only letters (minimum: 3 maximum: 15 characters) allowed ','error');
            return false;
        }
        else
        {
            return true;
        }
            
    }
    elseif($type == 'email')
    {
        if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
            alert('Email error: Invalid email format.','error');
            return false;
          }
          else 
          {
              return true;
          }
    }
    elseif($type == 'address')
    {
        if (strlen($str) <= 10) {
            alert('Address error: Address is too short.','error');
            return false;
          }
          else
          {
              return true;
          }
    }
    elseif($type == 'password')
    {
        if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/",$str)) {
            alert('Password error: Password should be 7 to 15 characters which contain at least one numeric digit and a special character ','error');
            return false;
          }
          else
          {
              return true;
          }
    }
}


function escapestring($string)
{
    global $db;
    return mysqli_real_escape_string($db, $string);
}


function query($query)
{
    global $db;
    return mysqli_query($db,$query);
}

function redirect($location)
{
    // header("Location: $location");
    $redirect = '<script>window.location.replace("'.$location.'")</script>';
    echo $redirect;
}

// Sign-Up function
function signUp($user)
{
    global $db;
    if(empty($user['gender']) || empty($user['first_name']) || empty($user['last_name']) || empty($user['email']) || empty($user['password']) || empty($user['address']))
    {
        alert('Error: Fill all of the Fields','error');
        $_SESSION['signUpModal']=true;
    }
    if( !validate($user['first_name'],'text') || !validate($user['last_name'],'text') || !validate($user['email'],'email') || !validate($user['address'],'address') || !validate($user['password'],'password'))
    {
        
        $_SESSION['signUpModal']=true;
    }
    
    if($user['password'] != $user['repeat_password'])
    {
        alert('Error: Password do not match','error');
        $_SESSION['signUpModal']=true;
    }
    else
    {
        $email = $user['email'];
        $q="SELECT * from users where email = '$email'";
        $check_email = query($q);
        if(mysqli_num_rows($check_email) == 0)
        {
            $password = md5($user['password']);
            $q = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `address`, `gender`) VALUES (";
            $q .= "'$user[first_name]',";
            $q .= "'$user[last_name]',";
            $q .= "'$user[email]',";
            $q .= "'$password',";
            $q .= "'$user[address]',";
            $q .= "'$user[gender]'";
            $q .=")";
            $result = query($q);
            if($result)
            {
                $_SESSION['user_id'] = mysqli_insert_id($db);
                echo '<script> alert("You sign up Successfully!"); </script>';
            }
        }
        else
        {
        alert('Email already Exists!','error');
        $_SESSION['signUpModal']=true;
        }
    }
}

// LOGIN FUNCTION
function log_in($user)
{
    if(empty($user['password']) || empty($user['email']))
    {
        alert("Please fill all of the fields",'error');
        $_SESSION['loginModal']=true;
    }
    else
    {
        $q = "SELECT * from users WHERE email = '$user[email]' LIMIT 1";
        $result = query($q);

        if(mysqli_num_rows($result) == 0)
        {
            alert('Email do not exits','error');
            $_SESSION['loginModal']=true;
        }
        else
        {
            $password=md5($user['password']);
            $row =mysqli_fetch_array($result);
            if( $row['password'] == $password)
            {
                $_SESSION['user_id']=$row['user_id'];
                alert('You are login Successfully','success');
                unset($_SESSION['loginModal']);
                unset($_SESSION['signUpModal']);
            }
            else
            {
                alert('Password is incorrect','error');
                $_SESSION['loginModal']=true;
            }
            
        }

    } 
}

function sign_out(){
    unset($_SESSION['user_id']);
    unset($_SESSION['loginModal']);
    unset($_SESSION['signUpModal']);
    redirect('index.php');
}



function save_font()
{
    $pro_id =$_GET['pro_id'];
    $font_name = $_POST['font_name'];
    $target_dir = "fonts/";
    $target_file = $target_dir . basename($_FILES["font_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(empty($font_name))
    {
        alert('Please Enter a Valid Font Name','error');
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["font_file"]["size"] > 1000000) {
    alert('Please upload File less than 1MB','error');
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "ttf" && $imageFileType != "otf" ) {
        alert("Sorry, only otf & ttf files are allowed.","error");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        alert("Sorry, your file was not uploaded.",'error');
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["font_file"]["tmp_name"], $target_file)) {
        $file_name = basename( $_FILES["font_file"]["name"]);
        $q="INSERT INTO `fonts`(`project_id`, `font_name`, `font_file`) VALUES ('$pro_id','$font_name','$file_name')";
        $res = query($q);
        if($res)
        {
            $mesg="The file ". htmlspecialchars( basename( $_FILES["font_file"]["name"])). " has been uploaded.";
            alert($mesg,'success');
        }
    } else {
        alert("Sorry, there was an error uploading your file.","error");
    }
                }
}

function delete_font($font_id)
{
    $q="DELETE FROM `fonts` WHERE font_id = '$font_id'";
    $res = query($q);

    if($res)
    {
        alert('Font deleted succfully','success');
    }
    else
    {
        alert('Font not deleted','error');
    }
    
}

function save_color()
{
    global $db;
    $pro_id =$_GET['pro_id'];
    $color_name = $_POST['color_name'];
    $hexcode = $_POST['hexcode'];
 
    if(empty($color_name) || empty($hexcode))
    {
        alert('Please Enter a Valid Color','error');
    }
    else
    {
        $q="INSERT INTO `colors`(`pro_id`, `color_name`, `hex_code`) VALUES ('$pro_id','$color_name','$hexcode')";
        $res = query($q);
        if($res)
        {
            $mesg="color added!";
            alert($mesg,'success');
        }
        else {
            $error = mysqli_error($db);
            alert($error,"error");
        }
    }
}

function delete_color($color_id)
{
    $q="DELETE FROM `colors` WHERE color_id = '$color_id'";
    $res = query($q);

    if($res)
    {
        alert('color deleted succfully','success');
    }
    else
    {
        alert('color not deleted','error');
    }
    
}

function delete_asset($asset_id)
{
    $q="DELETE FROM `assets` WHERE asset_id = '$asset_id'";
    $res = query($q);

    if($res)
    {
        alert('Asset deleted succfully','success');
    }
    else
    {
        alert('Asset not deleted','error');
    }
    
}

function save_asset()
{
    $pro_id =$_GET['pro_id'];
    $file_name = $_POST['file_name'];
    $target_dir = "project assets/";
    $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(empty($file_name))
    {
        alert('Please Enter a Valid File Name','error');
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["upload_file"]["size"] > 10000000) {
    alert('Please upload File less than 10MB','error');
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "ai" && $imageFileType != "psd" && $imageFileType != "svg" && $imageFileType != "pdf" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"     ) {
        alert("Sorry, only ai, psd, svg, pdf, png, jpeg, jpg & jpeg files are allowed.","error");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        alert("Sorry, your file was not uploaded.",'error');
    // if everything is ok, try to upload file
    } else {
    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
        $upload_file = basename( $_FILES["upload_file"]["name"]);
        $q="INSERT INTO `assets`(`pro_id`, `file_name`, `file`) VALUES ('$pro_id','$file_name','$upload_file')";
        $res = query($q);
        if($res)
        {
            $mesg="The file ". htmlspecialchars( basename( $_FILES["upload_file"]["name"])). " has been uploaded.";
            alert($mesg,'success');
        }
    } else {
        alert("Sorry, there was an error uploading your file.","error");
    }
                }
    
}

function save_img()
{
    $pro_id =$_GET['pro_id'];
    $target_dir = "project imgs/";
    $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $q="Select * from project_images where pro_id = '$pro_id'";
    $res=query($q);
    
    if(mysqli_num_rows($res) < 8)
    {
        // Check file size
        if ($_FILES["upload_file"]["size"] > 3000000) {
        alert('Please upload File less than 3MB','error');
        $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "webp" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            alert("Upload only png, jpg & jpeg files.","error");
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            alert("Sorry, your file was not uploaded.",'error');
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
            $upload_file = basename( $_FILES["upload_file"]["name"]);
            $q="INSERT INTO `project_images`(`pro_id`, `img_file`) VALUES ('$pro_id','$upload_file')";
            $res = query($q);
            if($res)
            {
                $mesg="The file ". htmlspecialchars( basename( $_FILES["upload_file"]["name"])). " has been uploaded.";
                alert($mesg,'success');
            }
        } else {
            alert("Sorry, there was an error uploading your file.","error");
        }
                    }
    }
    else
    {
        alert('Maximum limit Exceed','error');
    }  
}
function addMoodboard($pro_id,$user_id)
{
    global $db;
    $q= "SELECT * from moodboards WHERE pro_id = '$pro_id' AND user_id = '$user_id'";
    $check_mb =query($q);
    if(mysqli_num_rows($check_mb) > 0)
    {
        alert('Already added','error');
    }
    else
    {
        $q="INSERT INTO `moodboards`(`user_id`, `pro_id`,add_date) VALUES ('$user_id','$pro_id',NOW())";
        $res_insert=query($q);
        if($res_insert)
        {
        alert('Successfully added to moodboard','success');
        }
        else
        {
        $error=mysqli_error($db);
        alert($error,'error');
        }
    }
}

function Addfeedback($pro_id,$user_id,$feedback)
{
    global $db;
    if(!empty($feedback))
            {
                $query = "INSERT into feedbacks(pro_id, `user_id`,feedback,`status`,`date`)";
                $query .= "VALUES('$pro_id', '$user_id', '$feedback', 'Approved',now())";

                $add_comment_query = query($query);
                if(!$add_comment_query)
                {
                    alert(mysqli_error($db),'error');
                }
                else
                {
                  alert('Feedback added successfully','success');
                }
              }
              else
              {
                alert('ERROR: Feedback is empty','error');
              }
}

function delete_pro_img($img_id)
{
    $q="DELETE FROM `project_images` WHERE img_id = '$img_id'";
    $res = query($q);

    if($res)
    {
        alert('Image deleted succfully','success');
    }
    else
    {
        alert('Image not deleted','error');
    }
    
}

function delete_project($pro_id)
{
    $q="SELECT * FROM `fonts` WHERE project_id = '$pro_id'";
    $fonts = query($q);
    while($row = mysqli_fetch_array($fonts))
    {
        delete_font($row['font_id']);
    }

    $q="SELECT * FROM `colors` WHERE pro_id = '$pro_id'";
    $colors = query($q);
    while($row = mysqli_fetch_array($colors))
    {
        delete_color($row['color_id']);
    }

    $q="SELECT * FROM `assets` WHERE pro_id = '$pro_id'";
    $assets = query($q);
    while($row = mysqli_fetch_array($assets))
    {
        delete_asset($row['asset_id']);
    }

    $q="SELECT * FROM `project_images` WHERE pro_id = '$pro_id'";
    $project_images = query($q);
    while($row = mysqli_fetch_array($project_images))
    {
        delete_pro_img($row['img_id']);
    }

    $q="SELECT * FROM `feedbacks` WHERE pro_id = '$pro_id'";
    $feedbacks = query($q);
    while($row = mysqli_fetch_array($feedbacks))
    {
        $fb_id = $row['fb_id'];
        $q="DELETE FROM `feedbacks` WHERE fb_id = '$fb_id'";
        $feedbacks = query($q);
    }
   
    $q="DELETE FROM `projects` WHERE project_id = '$pro_id'";
    $res = query($q);

    if($res)
    {
        redirect('saved_projects.php');
    }
    
    
}



?>