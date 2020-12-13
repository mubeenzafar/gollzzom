<?php include "header.php"; ?>
  
  
<?php include "top_nav.php"; 
if(!isset($_GET['pro_id']))
{
  redirect('saved_projects.php');
}

?>
<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      
      <div class="d-flex justify-content-between flex-wrap flex-
      -nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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
            $project_creator = $project['user_id'];
            echo "<h3>".$project['pro_title']."</h3>";
        ?>
        
          <a href="moodboards.php?pro_id=<?php echo $pro_id; ?>&remove=true" class="btn btn-sm btn-outline-danger">Remove from Moodboard</a>
     
      
      </div>

      
      

      <div class="row">
        <div class="col-md-8">
        <h5 ><strong >Project Details:</strong></h5>
        <p ><?php echo  $project['pro_detail']; ?></p>
        <h5 ><strong >Project Gallery:</strong></h5> 
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
                <img class="demo cursor" src="project imgs/<?php echo $row['img_file']; ?>" width="100%" onclick="currentSlide(<?php echo $num; ?>)" alt="The Woods">
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

      <div class="col-md-4">
        <!-- create Profile -->
        <?php include "includes/creatorProfile.php"; ?>
      <table class="table table-striped">
            <thead class="bg-primary text-white">
                <tr>
                <th scope="col" colspan="2">Font Used:</th>
                
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
                </tr>
                <?php  $num++;
                        } ?>
        </tbody>
</table>

<table class="table table-striped">
            <thead class="bg-primary text-white">
                <tr>
                <th scope="col" colspan="2">Color Used:</th>
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
                <td><a href="#" class="badge badge-secondary" style="background-color:<?php echo $row['hex_code'];?>;"><?php echo $row['hex_code'];?></a></td>
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
                </tr>
                <?php  $num++;
                        } ?>
                    </tbody>
            </table>
            <?php include "includes/creatorProjectModal.php"; ?>
          
      </div>
      </div>
    </main>



  </div>
</div>

<?php include "footer.php" ?>