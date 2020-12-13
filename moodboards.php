<?php include "header.php"; ?>
  
  
<?php include "top_nav.php"; ?>

<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h3">Moodboard:</h3>
      </div>
      <?php
        if(isset($_GET['uploaded']))
        {
            alert('Project added Successfully','success');
        }

?>

     
      <?php
        $user_id = $_SESSION['user_id'];
        if(isset($_GET['remove']))
        {
          $pro_id = $_GET['pro_id'];
          $del_q="DELETE from moodboards where pro_id = '$pro_id' AND $user_id = '$user_id'";
          $del_res=query($del_q);
          if($del_res)
          {
            alert('Project removed successfully','success');
          }
          else
          {
            $error = mysqli_error($db);
            alert($error,'error');
          }

        }
        $count_q="Select * from moodboards where user_id = '$user_id'";
        $count=query($count_q);
        if(mysqli_num_rows($count) == 0)
        {
          alert("No Project found.",'success');
        }
        
        
        $q="SELECT * from projects";
        $res = query($q);
?>
 <div class="row">
<?php
        // $q="SELECT * from projects where user_id = '$user_id'";
        // $res = query($q);
        while($row = mysqli_fetch_array($res))
        {
          $pro_id = $row['project_id'];
          $moodboard_q="Select * from moodboards where user_id = '$user_id' AND pro_id = '$pro_id'";
          $check_mb = query($moodboard_q);
          if(mysqli_num_rows($check_mb)>0)
          {
              $row_mb = mysqli_fetch_array($check_mb);
              $add_date = $row_mb['add_date'];
              $img_query="SELECT * from project_images where pro_id = '$pro_id' LIMIT 1";
              $imgs = query($img_query);
              $first_img = mysqli_fetch_array($imgs);

          ?>
          <div class=" col-lg-6 col-xl-4">
              <div class="card mb-4 shadow-sm">
                <img class="bd-placeholder-img card-img-top" width="100%" height="300"  src="project imgs/<?php echo $first_img['img_file']; ?>" alt="">
                <div class="card-body">
                  <h5><?php echo $row['pro_title']; ?></h5>
                  
                </div>
                <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="view_moodboard_projects.php?pro_id=<?php echo $pro_id;?>" type="button" class="btn btn-sm btn-outline-primary">View</button>
                      <a href="moodboards.php?pro_id=<?php echo $pro_id; ?>&remove=true" class="btn btn-sm btn-outline-danger">Remove</a>
                      
                    </div>
                   
                  </div>
                  <small class="text-muted">Saved Date: <?php echo $add_date; ?></small>
                </div>
              </div>
            </div>
        
<?php   } }?>

        </div>
    </main>

  






  </div>
</div>

<?php include "footer.php" ?>