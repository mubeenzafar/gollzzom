<?php include "header.php"; ?>
<?php include "top_nav.php"; ?>
<div class="container-fluid">
  <div class="row">
    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-lg-nowrap align-items-center py-2 mb-3 border-bottom">
        <h3 class="h3">Saved Projects</h3>
        <form class="form-inline " method="post" action="saved_projects.php">
        <input class="form-control mr-sm-2 mx-auto" type="text" name='search' placeholder="Search" aria-label="Search" required>
        <button class="btn btn-outline-success my-2 my-sm-0" name='search_btn' type="submit">Search</button>
        <a href="upload_project.php" class='btn btn-outline-primary ml-2'>Add New Project</a>
      </form>
      </div>
      <?php
        if(isset($_GET['uploaded']))
        {
            alert('Project added Successfully','success');
        }

?>

     
      <?php
        $user_id = $_SESSION['user_id'];


        if(isset($_POST['search_btn']) && !empty($_POST['search']))
        {
          $search = $_POST['search'];
          $q="SELECT * from projects where (pro_title OR pro_detail LIKE '%$search%') AND user_id = '$user_id' ";
        }
        else
        {
          $q="SELECT * from projects where user_id = '$user_id'";
        }
        if(isset($_GET['status']))
        {
          $pro_id=$_GET['pro_id'];
          $status=$_GET['status'];
          if($status == 'publish')
          {
            $img_query="SELECT * from project_images where pro_id = '$pro_id' LIMIT 1";
            $imgs = query($img_query);
            if(mysqli_num_rows($imgs) > 0)
            { 
              $stats_update_query = query("UPDATE projects SET `pro_status`='$status' WHERE project_id='$pro_id'");
              alert('Project Publish successfully','success');
            }
            else
            {
              alert('Error: Upload at least one image to publish the project','error');
            }

          }
          else
          {
            $stats_update_query = query("UPDATE projects SET `pro_status`='$status' WHERE project_id='$pro_id'");
            alert('Project Unpublish successfully','success');
          }

          
        }
        
        $res = query($q);
        if(mysqli_num_rows($res) == 0)
        {
          alert("No Project found.",'success');
        }
        if(isset($_POST['search_btn']) && !empty($_POST['search']))
        {
          $total=mysqli_num_rows($res) . " Project Founds";
          alert($total,'success');
        }
        
        

?>
<div class="row">
<?php
        // $q="SELECT * from projects where user_id = '$user_id'";
        // $res = query($q);
        while($row = mysqli_fetch_array($res))
        {
          $pro_id = $row['project_id'];
          $img_query="SELECT * from project_images where pro_id = '$pro_id' LIMIT 1";
          $imgs = query($img_query);
          $first_img = mysqli_fetch_array($imgs);
      ?>
      <div class="col-lg-4 col-md-6">
          <div class="card mb-4 shadow-sm">
            <img class="bd-placeholder-img card-img-top" width="100%" src="project imgs/<?php echo $first_img['img_file']; ?>" alt="">
            <div class="card-body">
              <h5><?php echo $row['pro_title']; ?></h5>
            </div>
            <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="view_project.php?pro_id=<?php echo $pro_id;?>" type="button" class="btn btn-sm btn-outline-primary">View</button>
                  <a href="edit_project.php?pro_id=<?php echo $pro_id; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  <?php
                    if($row['pro_status']=='publish')
                    {
                      echo '<a href="saved_projects.php?pro_id='.$pro_id.'&status=unpublish" class="btn btn-sm btn-outline-danger">Unpublish</a>';
                    }
                    else
                    {
                      echo '<a href="saved_projects.php?pro_id='.$pro_id.'&status=publish" class="btn btn-sm btn-outline-success">Publish</a>';
                    }
                  ?>
                </div>
                
              </div>
            <small class="text-muted">Upload Date: <?php echo $row['pro_upload_date']; ?></small>
            </div>
          </div>
        </div>
        
          <?php   } ?>

        </div>
    </main>
  </div>
</div>

<?php include "footer.php" ?>