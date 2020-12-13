<?php 
include "header.php"; 

?>

<?php include "top_nav.php"; 
if(!isset($_GET['pro_id']))
{
  redirect('saved_projects.php');
}

?>
<div class="container-fluid">
  <div class="row">

    <?php 
      include "side_nav.php";
      include "includes/feedbackModal.php"; 
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

      <div class=" pt-3 pb-2 mb-3 border-bottom">
        <div class="row">
          <?php
          
          if(isset($_GET['del_project']))
          {
            delete_project($_GET['pro_id']);
          }
            $pro_id = $_GET['pro_id'];
            $project_query="Select * from projects WHERE project_id = '$pro_id' LIMIT 1";
            $get_project=query($project_query);
            $total = mysqli_num_rows($get_project);
            $project = mysqli_fetch_array($get_project);
            echo "<div class='col-lg-8'><h3>".$project['pro_title']."</h3></div>";
        ?>
          <div class="ml-auto mr-4">

            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#feedbackModal">View
              Feedbacks</button>
            <a href="edit_project.php?pro_id=<?php echo $pro_id; ?>" class="btn btn-outline-primary">Edit Project</a>
            <a href="view_project.php?pro_id=<?php echo $pro_id; ?>&del_project='true'"
              class="btn btn-outline-danger">Delete Project</a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">

          <p><?php echo  $project['pro_detail']; ?></p>
          <h5><strong>Project Gallery:</strong></h5>

          <div class="row mb-2">
            <?php
              $pro_id = $_GET['pro_id'];
              $q="Select * from project_images WHERE pro_id = '$pro_id' LIMIT 10";
              $result=query($q);
              $num =1;
              $total = mysqli_num_rows($result);
              while($row = mysqli_fetch_array($result))
              {
            ?>
            <div class="column mt-1 ml-3">
              <img class="demo cursor" src="project imgs/<?php echo $row['img_file']; ?>" width="100%"
                onclick="currentSlide(<?php echo $num; ?>)" alt="The Woods">
                <a href="project imgs/<?php echo $row['img_file']; ?>" class="badge badge-primary"
                    download="project imgs/<?php echo $row['img_file']; ?>">Downloads</a>
            </div>

            <?php $num++; }; ?>

          </div>
          <hr>

          <?php
            $q="Select * from project_images WHERE pro_id = '$pro_id'";
            $result=query($q);
            $num =1;
            $total = mysqli_num_rows($result);
            while($row = mysqli_fetch_array($result))
            { 
          ?>
          <!-- Full-width images with number text -->
          <div class="mySlides">
            <img src="project imgs/<?php echo $row['img_file']; ?>" style="width:100%">
          </div>
          <?php  }; ?>


          <hr>


        </div>

        <!-- Fonts Display -->

        <?php

          if(!empty($_GET['font_file']))
          {
              $filename = basename($_GET['font_file']);
              downloadFont($filename);
          }

      ?>
        <div class="col-md-4">
          <table class="table table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col" colspan="2">Font Used </th>

              </tr>
            </thead>
            <tbody>
              <?php

                    if(isset($_GET['del_id']))
                    {
                        delete_font($_GET['del_id']);
                    }
                    
                    $pro_id = $_GET['pro_id'];
                    $q="Select * from fonts Where project_id = '$pro_id'";
                    $result = query($q);
                    $num=1;
                    echo mysqli_error($db);
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
              <tr>
                <td><strong><?php echo $num .". ". $row['font_name']; ?></strong></td>
                <td><a href="fonts/<?php echo $row['font_file']; ?>" class="badge badge-secondary"
                    download="<?php echo $row['font_file']; ?>">Download</a></td>
              </tr>
              <?php  $num++;
                        } ?>
            </tbody>
          </table>

          <table class="table table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col" colspan="2">Color Used</th>
              </tr>
            </thead>
            <tbody>
              <?php

                    if(isset($_GET['del_id']))
                    {
                        delete_font($_GET['del_id']);
                    }
                    
                    $pro_id = $_GET['pro_id'];
                    $q="Select * from colors Where pro_id = '$pro_id'";
                    $result = query($q);
                    $num=1;
                    echo mysqli_error($db);
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
              <tr>
                <td><strong><?php echo $num .". ". $row['color_name']; ?></strong></td>
                <td><a href="#" class="badge badge-secondary"
                    style="background-color:<?php echo $row['hex_code'];?>;"><?php echo $row['hex_code'];?></a></td>
              </tr>
              <?php  $num++;
                        } ?>
            </tbody>
          </table>

          <table class="table table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col" colspan="3">Assets: </th>
              </tr>
            </thead>
            <tbody>
              <?php
                    if(isset($_GET['del_id']))
                    {
                        delete_font($_GET['del_id']);
                    }
                    $pro_id = $_GET['pro_id'];
                    $q="Select * from assets Where pro_id = '$pro_id'";
                    $result = query($q);
                    $num=1;
                    echo mysqli_error($db);
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
              <tr>
                <td><strong><?php echo $num .". ". $row['file_name']; ?></strong></td>
                <td><strong><?php echo $row['file']; ?></strong></td>
                <td><a href="project assets/<?php echo $row['file']; ?>" class="badge badge-secondary"
                    download="">Downloads</a></td>
              </tr>
              <?php  $num++;
                        } ?>
            </tbody>
          </table>

          <!-- Feedbacks -->
          <div class="card">
            <div class="card-header bg-primary text-white">
              <strong>Recent Feedbacks:</strong>
            </div>
            <div class="card-body">
              <?php
          
          $pro_id = $_GET['pro_id'];
          $query = " SELECT * FROM feedbacks WHERE pro_id = '$pro_id'";
          $query .=" AND `status`='Approved'";
          $query .=" ORDER BY fb_id DESC LIMIT 3";
      
          $get_fb_query = query($query);
          if(!$get_fb_query)
          {
              alert(mysqli_error($conn),'error');
          }

          if(mysqli_num_rows($get_fb_query) == 0)
          {
            echo  '<p class="card-text"> No feedback yet!</p>';
          }
          
          while($row = mysqli_fetch_assoc($get_fb_query))
          {
              $date = $row['date'];
              $feedback= $row['feedback'];
              $fb_user_id = $row['user_id'];
              $user_name = mysqli_fetch_array(query("SELECT * from users WHERE `user_id`='$fb_user_id'"));
          ?>
              <h5 class="card-title"> <?php echo $feedback; ?> </h5>
              <small>Date: <?php echo $date; ?></small>
              <p class="card-text"> By: <strong><?php echo $user_name['first_name'].' '.$user_name['last_name']; ?>
                </strong> </p>
              <hr>
              <?php   } ?>
            </div>
          </div>


        </div>
      </div>
    </main>



  </div>
</div>

<?php include "footer.php" ?>