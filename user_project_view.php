<?php 

include "connection.php";
include "functions.php";

include "includes/index_head.php";
include "includes/top_nav.php";
?>


<main role="main" class="my-5">
  <div class="album bg-light py-5">

    <div class="container">
      <a href="index.php">Go back to Home</a>
      <?php
      if(isset($_SESSION['user_id']))
      {
        $user_id=$_SESSION['user_id'];
      }
      if(isset($_GET['add_mood_board']))
      {
        $pro_id = $_GET['pro_id'];   
        addMoodboard($pro_id,$user_id);

      }
      if(isset($_POST['add_feedback']))
      {
          $pro_id = $_GET['pro_id'];
          $feedback=$_POST['feedback'];
            Addfeedback($pro_id,$user_id,$feedback);
      }
                   
?>
      <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="row">
          <?php
            
            
            $pro_id = $_GET['pro_id'];
            $project_query="Select * from projects WHERE project_id = '$pro_id' LIMIT 1";
            $get_project=query($project_query);
            $total = mysqli_num_rows($get_project);
            $project = mysqli_fetch_array($get_project);
            $project_creator = $project['user_id'];
            echo "<div class='col-md-10'><h3>".$project['pro_title']."</h3></div>";
            if(isset($_SESSION['user_id']))
            {
                echo  "<div class='col-md-2 '><a href='user_project_view.php?add_mood_board=true&pro_id=".$project['project_id']."' class='btn btn-sm btn-outline-primary'>Save to Moodboard</a></div>";
            }
            else
            {
                echo  "<div class='col-md-2 '><button class='btn btn-sm btn-outline-primary' data-toggle='modal' data-target='#loginModal'>Login to Save</button></div>";
            }
              
              
          ?>


        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <h5><strong>Project Details:</strong></h5>
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
            <div class="column mt-1 mx-3 ">
              <img class="demo cursor" src="project imgs/<?php echo $row['img_file']; ?>" width="100%"
                onclick="currentSlide(<?php echo $num; ?>)" alt="The Woods">
            </div>

            <?php $num++; }; ?>

          </div>
          <h5 class="d-inline">Catagories:</h5>
          <?php 
                $catagories=explode(',',$project['catagories']);
                foreach($catagories as $catagory)
                {
                  echo "<a target='_blank' href='index.php?search_cat=".$catagory."' class='badge badge-primary ml-1'>".$catagory."</a>"; 
                }
              ?>
                <hr>
        </div>

        <div class="col-md-4">
          <!-- create Profile -->
          <?php include "includes/creatorProfile.php"; ?>

          <table class="table table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col" colspan="2">Font Used</th>

              </tr>
            </thead>
            <tbody>
              <?php
                      
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
              </tr>
              <?php  $num++;
                        } ?>
            </tbody>
          </table>


        </div>

      </div>
      <div class="row">
        <div class="col-md-8">
          <!-- Feedbacks -->
          <?php include "includes/feedbacks.php"; ?>
          <!-- Creator More Projects Modal -->
          <?php include "includes/creatorProjectModal.php"; ?>
        </div>

      </div>
    </div>

</main>

<?php include "includes/footer.php" ?>