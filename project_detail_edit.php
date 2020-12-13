<?php include "header.php"; 
if(!isset($_GET['pro_id']) || $_GET['pro_id']=='')
{
  redirect("saved_projects.php");
}

?>
  
  
<?php include "top_nav.php"; ?>

<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h3">Edit Project: <small style='font-size: 16px;'>Steps 1/5</small></h3>
        <small class='text-danger'> Please Enter Folowing Details:</small>
        
      </div>
<?php
  
  $pro_id = $_GET['pro_id'];
  $q="SELECT * FROM `projects` WHERE project_id = '$pro_id' LIMIT 1";
  $res = query($q);
  $row = mysqli_fetch_array($res);
  $project_title = $row['pro_title'];
  $project_detail = $row['pro_detail'];
  $project_com_date = $row['pro_com_date'];
  

  if(isset($_POST['next']))
  {
    $project_id = $_GET['pro_id'];
    $project_title = escapestring($_POST['project_title']);
    $project_detail = escapestring($_POST['project_detail']);
    $project_com_date = escapestring($_POST['com_date']);
    $user_id = $_SESSION['user_id'];

    if(empty($project_title) || empty($project_detail) || empty($project_com_date))
    {
      alert('Please fill all of the details','error');
    }
    else
    {
      $q="UPDATE `projects` SET `pro_com_date`='$project_com_date',`pro_title`='$project_title',`pro_detail`='$project_detail' WHERE project_id = '$pro_id'";
      $result= query($q);
      if($result)
      {
        alert("Updated Successfully","success");
        // $location='upload_project_font.php?pro_id='.$project_id;
        // //redirect($location);
      }
    }
  }

  if(isset($_GET['uploaded']))
  {
    alert('Congratulations: Project Uploaded Successfully','success');
  }


?>

      <form method='post' action='project_detail_edit.php?pro_id=<?php echo $_GET['pro_id'];?>'>
      <div class="form-group">
          <label for="inputEmail4">Project Title:</label>
          <input type="Text" class="form-control" name='project_title' id="inputEmail4" value='<?php echo $project_title; ?>'>
      </div>
      <div class="form-group">
        <label for="inputAddress">Project Details:</label>
        <textarea  class="form-control" name="project_detail" id="" cols="30" rows="10"><?php echo $project_detail; ?></textarea>
      </div>
      <div class="form-group col-4">
        <label for="inputAddress2">Completed Date:</label>
        <input value='<?php echo $project_com_date; ?>' type="date" name="com_date" class="form-control" id="inputAddress2" >
      </div>
      <hr>
      <a href="edit_project.php?pro_id=<?php echo $pro_id; ?>"  class="btn btn-warning float-right ml-2">Done Edit</a>
      <button name='next' type="submit" class="btn btn-primary float-right">Update</button>
      
    </form>
      
    </main>



  </div>
</div>

<?php include "footer.php" ?>