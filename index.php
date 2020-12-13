<?php 

include "connection.php";
include "functions.php";
include "includes/index_head.php";
include "includes/top_nav.php";

?>
<main role="main">

  <?php include "includes/jumbotron.php"; ?>

  <div class="album py-5 bg-light p-4">

    <div class="container">
      <div class="row">
        <div class="col-sm">
          <form method="post" action="index.php">
            <div class="input-group mb-3">
            <select  class="form-control" name="search_cat" id="exampleFormControlSelect2" >
            <option value='' >Search by Catagory</option>
              <option value='3D Art' >3D Art</option><option value='3D Modeling'>3D Modeling</option><option value='Advertising'>Advertising</option><option value='Advertising Photography'>Advertising Photography</option><option value='Animation'>Animation</option><option value='App Design'>App Design</option><option value='Apparel'>Apparel</option><option value='AR/VR'>AR/VR</option><option value='Architecture'>Architecture</option><option value='Architecture Concept'>Architecture Concept</option><option value='Architecture Photography'>Architecture Photography</option><option value='Architecture Visualization'>Architecture Visualization</option><option value='Art Direction'>Art Direction</option><option value='Automotive Design'>Automotive Design</option><option value='Beauty Photography'>Beauty Photography</option><option value='Branding'>Branding</option><option value='Calligraphy'>Calligraphy</option><option value='Character Design'>Character Design</option><option value='Cinematography'>Cinematography</option><option value='Collage'>Collage</option><option value='Coloring'>Coloring</option><option value='Comic'>Comic</option><option value='Concept Art'>Concept Art</option><option value='Copywriting'>Copywriting</option><option value='Costume Design'>Costume Design</option><option value='Crafts'>Crafts</option><option value='Creative Direction'>Creative Direction</option><option value='Culinary Arts'>Culinary Arts</option><option value='Digital Art'>Digital Art</option><option value='Digital Painting'>Digital Painting</option><option value='Directing'>Directing</option><option value='Drawing'>Drawing</option><option value='Editing'>Editing</option><option value='Editorial Design'>Editorial Design</option><option value='Environmental Graphics'>Environmental Graphics</option><option value='Exhibition Design'>Exhibition Design</option><option value='Fashion'>Fashion</option><option value='Fashion Design'>Fashion Design</option><option value='Fashion Illustration'>Fashion Illustration</option><option value='Fashion Photography'>Fashion Photography</option><option value='Fashion Retouching'>Fashion Retouching</option><option value='Fashion Styling'>Fashion Styling</option><option value='Film'>Film</option><option value='Fine Arts'>Fine Arts</option><option value='Flower Arrangement'>Flower Arrangement</option><option value='Food Photography'>Food Photography</option><option value='Food Styling'>Food Styling</option><option value='Furniture Design'>Furniture Design</option><option value='Game Design'>Game Design</option><option value='GIF Animation'>GIF Animation</option><option value='Graffiti'>Graffiti</option><option value='Graphic Design' >Graphic Design</option><option value='Icon Design'>Icon Design</option><option value='Illustration'>Illustration</option><option value='Industrial Design'>Industrial Design</option><option value='Infographic'>Infographic</option><option value='Information Architecture'>Information Architecture</option><option value='Interaction Design'>Interaction Design</option><option value='Interior Design'>Interior Design</option><option value='Jewelry Design'>Jewelry Design</option><option value='Label Design'>Label Design</option><option value='Landscape Design'>Landscape Design</option><option value='Lettering'>Lettering</option><option value='Logo Design'>Logo Design</option><option value='Makeup'>Makeup</option><option value='Makeup Arts'>Makeup Arts</option><option value='Model Test Photography'>Model Test Photography</option><option value='Modeling'>Modeling</option><option value='Motion Graphics'>Motion Graphics</option><option value='Music'>Music</option><option value='Music Packaging'>Music Packaging</option><option value='Packaging'>Packaging</option><option value='Painting'>Painting</option><option value='Paperworks'>Paperworks</option><option value='Pattern Design'>Pattern Design</option><option value='Performing Arts'>Performing Arts</option><option value='Photography'>Photography</option><option value='Photography Styling'>Photography Styling</option><option value='Photojournalism'>Photojournalism</option><option value='Poster Design'>Poster Design</option><option value='Product Design'>Product Design</option><option value='Product Photography'>Product Photography</option><option value='Programming'>Programming</option><option value='Projection Mapping'>Projection Mapping</option><option value='Props Design'>Props Design</option><option value='Retouching'>Retouching</option><option value='Sculpting'>Sculpting</option><option value='Set Design'>Set Design</option><option value='Shoe Design'>Shoe Design</option><option value='Sketching'>Sketching</option><option value='Sound Design'>Sound Design</option><option value='Storyboarding'>Storyboarding</option><option value='Street Art'>Street Art</option><option value='Students'>Students</option><option value='Styleframing'>Styleframing</option><option value='Surface Design'>Surface Design</option><option value='T-Shirt Design'>T-Shirt Design</option><option value='Textile Design'>Textile Design</option><option value='Toy Design'>Toy Design</option><option value='Type Design'>Type Design</option><option value='Typography'>Typography</option><option value=' UI/UX'> UI/UX</option><option value='Visual Effects'>Visual Effects</option><option value='Visualization'>Visualization</option><option value='Web Design'>Web Design</option><option value='Window Design'>Window Design</option><option value='Woodworking'>Woodworking</option><option value='Writing'>Writing</option>              
            </select>
              <div class="input-group-append">
                <button class="btn btn-outline-success " name='search_cat_btn' type="submit">Search</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      <?php

            if(isset($_POST['search_cat_btn']) && !empty($_POST['search_cat']))
            {
              $search = $_POST['search_cat'];
              
              echo "Results: <a href='#' class='badge badge-primary ml-1'>".$search."</a>"; 
               
              
            }
            if(isset($_GET['search_cat']))
            {
              $search = $_GET['search_cat'];
              echo "Results: <a href='#' class='badge badge-primary ml-1'>".$search."</a>";
            }
          ?>
      <hr>

      <?php
        if(isset($_POST['search_btn']) && !empty($_POST['search']))
        {
          $search = $_POST['search'];
          
          $q="SELECT * from projects where `pro_status`='Publish' AND (pro_title OR pro_detail LIKE '%$search%')";
        }
        else if(isset($_POST['search_cat_btn']) && !empty($_POST['search_cat']))
        {
          $search = $_POST['search_cat'];
          $q="SELECT * from projects where `pro_status`='Publish' AND (catagories LIKE '%$search%') ";
        }
        else if(isset($_GET['search_cat']))
        {
          $search = $_GET['search_cat'];
          $q="SELECT * from projects where `pro_status`='Publish' AND (catagories LIKE '%$search%') ";
        }
        else
        {
          $q="SELECT * from projects WHERE `pro_status`='Publish' ORDER BY RAND()";
        }
        
        $res = query($q);
        if(isset($_POST['search_btn']) && !empty($_POST['search']))
        {
          $total=mysqli_num_rows($res) . " Project Founds";
          alert($total,'success');
        }

        if(isset($_GET['add_mood_board']))
        {
          $pro_id = $_GET['pro_id']; 
          $user_id = $_SESSION['user_id'];  
          $q= "SELECT * from moodboards WHERE pro_id = '$pro_id' AND user_id = '$user_id'";
          $check_mb =query($q);
          if(mysqli_num_rows($check_mb) > 0)
          {
            alert('Already added','error');
          }
          else
          {
            $q="INSERT INTO `moodboards`(`user_id`, `pro_id`,add_date) VALUES ('$user_id','$pro_id',now())";
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
        if(mysqli_num_rows($res)>0)
        {
      ?>
      <div class="row">
        <?php
          while($row = mysqli_fetch_array($res))
          {
            $pro_id = $row['project_id'];
            $img_query="SELECT * from project_images where pro_id = '$pro_id' LIMIT 1";
            $imgs = query($img_query);
            $first_img = mysqli_fetch_array($imgs);

      ?>
        <div class="col-md-6 col-lg-4" id="index-card">
          <div class="card mb-4 shadow-sm">
            <img class="bd-placeholder-img card-img-top" width="100%"
              src="project imgs/<?php echo $first_img['img_file']; ?>" alt="">
            <div class="card-body">

            
              <h5><?php echo $row['pro_title']; ?></h5>
              <?php 
                $catagories=explode(',',$row['catagories']);
                foreach($catagories as $catagory)
                {
                  echo "<a href='index.php?search_cat=".$catagory."' class='badge badge-secondary ml-1'>".$catagory."</a>"; 
                }
              ?>
              <div class="d-flex justify-content-between align-items-center">

              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-md-4">
                  <a href="user_project_view.php?pro_id=<?php echo $row['project_id']; ?>" type="button"
                    class="btn btn-sm btn-primary btn-block">View</a>

                </div>
                <div class="col-md-8">
                  <?php
                            if(isset($_SESSION['user_id']))
                            {
                                echo  "<a href='index.php?add_mood_board=true&pro_id=".$row['project_id']."' class='btn btn-sm btn-primary btn-block' >Save to Moodboard</a>";
                            }
                            else
                            {
                              echo  '<button class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#loginModal">Login to Save</button>';
                            }
                            
                          ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm">
                  <small class="text-muted float-right">Upload date: <?php echo $row['pro_upload_date']; ?></small>
                </div>
              </div>


            </div>
          </div>
        </div>

        <?php  }   }
else{
  alert("No record found.",'success');
}
?>
      </div>
    </div>
  </div>


</main>


<?php include "includes/footer.php" ?>