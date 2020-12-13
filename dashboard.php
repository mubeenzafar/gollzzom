<?php include "header.php"; ?>


<?php include "top_nav.php"; ?>

<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
     
        <div class="row border-bottom py-3">
          <div class="col-sm-4">
            <a href="upload_project.php" class="btn btn-success btn-block">+ ADD PROJECT</a>
          </div>
          <div class="col-sm-4">
            <a href="saved_projects.php" class="btn btn-primary btn-block">VIEW PROJECTS</a>
          </div>
          <div class="col-sm-4">
            <a href="moodboards.php" class="btn btn-warning btn-block text-white">VIEW MOODBOARD</a>
          </div>
        </div>
      
  <?php
    $user_id =$_SESSION['user_id'];
    $q="SELECT * from projects WHERE `user_id` = '$user_id'";
    $saved_projects = query($q);
    $count=1;
    $total= mysqli_num_rows($saved_projects);
?>
      <div class="row mx-auto my-3" id="card-db">
          <div class="col-sm">
            <div class="card bg-primary text-white text-center">
              <div class="card-header">
                <h5>Projects Saved</h5>
              </div>
              <div class="card-body">
                <h4 class="display-3"><strong><?php echo $total; ?></strong></h4>
                <a href="saved_projects.php" class="btn btn-outline-light btn-sm">More Details</a>
              </div>
            </div>
          </div>

          <?php
              
              $q="SELECT * from projects WHERE `user_id` = '$user_id' AND `pro_status` = 'publish'";
              $publish_projects = query($q);
              $publish = mysqli_num_rows($publish_projects);
              
          ?>


          <div class="col-sm">
            <div class="card  bg-success text-white text-center">
              <div class="card-header">
                <h5>Projects Published</h5>
              </div>
              <div class="card-body">
                <h4 class="display-3 "><strong><?php echo $publish; ?></strong></h4>

                <a href="saved_projects.php" class="btn btn-outline-light btn-sm">More Details</a>
              </div>
            </div>
          </div>

          <?php
             
              $q="SELECT * from projects WHERE `user_id` = '$user_id' AND `pro_status` = 'unpublish'";
              $unpublish_projects = query($q);
              $unpublish = mysqli_num_rows($unpublish_projects);
              
          ?>
          <div class="col-sm">
            <div class="card bg-danger text-white text-center">
              <div class="card-header">
                <h5>Projects Unpublished</h5>
              </div>
              <div class="card-body">
                <h4 class="display-3"><strong><?php echo $unpublish; ?></strong></h4>
                <a href="saved_projects.php" class="btn btn-outline-light btn-sm">More Details</a>
              </div>
            </div>
          </div>
          <?php
             
              $q="SELECT * from moodboards WHERE `user_id` = '$user_id'";
              $mb_projects = query($q);
              $mb = mysqli_num_rows($mb_projects);
              
          ?>

          <div class="col-sm">
            <div class="card bg-warning text-white text-center">
              <div class="card-header">
                <h5>Projects in Moodboard</h5>
              </div>
              <div class="card-body">
                <h4 class="display-3"><strong><?php echo $mb; ?></strong></h4>
                <a href="moodboards.php" class="btn btn-outline-light btn-sm">More Details</a>
              </div>
            </div>
          </div>

          <?php
             
              $q="SELECT pro_id from feedbacks";
              $projects = query($q);
              $feedbacks=0;
              while($row = mysqli_fetch_array($projects))
              {
                $pro_id = $row['pro_id'];
                $q="SELECT `user_id` from projects WHERE `project_id` = '$pro_id' LIMIT 1";
                $pro_user = query($q);
                $pro_user_id = mysqli_fetch_array($pro_user);
                if($pro_user_id['user_id'] == $user_id)
                {
                  $feedbacks++;
                }
              
              }
              
          ?>

          <div class="col-sm">
            <div class="card bg-info text-white text-center">
              <div class="card-header">
                <h5>Feedbacks</h5>
              </div>
              <div class="card-body">
                <h4 class="display-3"><strong><?php echo $feedbacks; ?></strong></h4>
                
              </div>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-sm">
            <div class="card">
              <div class="card-header">
                <h4>Recently Added projects</h4>
              </div>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Catagoies</th>
                      <th>Date</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>

                  <?php
                      while($row = mysqli_fetch_array($saved_projects) )
                      {
                        if($count == 11)
                        {
                          break;
                        }
                    ?>
                  <tbody>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><strong><?php echo $row['pro_title']; ?></strong></td>
                      
                      <?php 
                        $catagories=explode(',',$row['catagories']);
                      
                      ?> 
                      
                      <td><?php 
                        foreach($catagories as $catagory )
                        {
                          echo "<a href='' class='badge badge-primary ml-1'>".$catagory."</a>"; 
                        }
                        ?>
                      </td>



                      <td><?php echo $row['pro_upload_date']; ?></td>
                      <td><a href="view_project.php?pro_id=<?php echo $row['project_id']; ?>"
                          class="btn btn-sm btn-primary">View</a></td>
                      <td><a href="edit_project.php?pro_id=<?php echo $row['project_id']; ?>"
                          class="btn btn-sm btn-primary">Edit</a></td>

                    </tr>
                  </tbody>
                  <?php    } ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      
  </div>
</div>



</main>



</div>
</div>

<?php include "footer.php" ?>