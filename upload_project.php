<?php include "header.php"; ?>
  
  
<?php include "top_nav.php"; ?>

<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h3">Upload Project: <small style='font-size: 16px;'>Steps 1/5</small></h3>
        <small class='text-danger'> Please Enter Folowing Details:</small>
      </div>
<?php
  $project_title = '';
  $project_detail = '';
  $project_com_date = '';

  if(isset($_POST['next']))
  {
    $project_title = escapestring($_POST['project_title']);
    $project_detail = escapestring($_POST['project_detail']);
    $project_com_date = escapestring($_POST['com_date']);
    $project_catagories = implode(',', $_POST['catagories']);
    
    $user_id = $_SESSION['user_id'];

    if(empty($project_title) || empty($project_detail) || empty($project_com_date) || empty($project_catagories))
    {
      alert('Please fill all of the details','error');
    }
    else if($project_com_date > date("Y-m-d"))
    {
      alert('Date Invalid','error');
    }
    else
    {
      $q="INSERT INTO `projects`(`user_id`, `pro_com_date`, `pro_upload_date`, `pro_title`, `pro_status`, `pro_detail`,`catagories`) VALUES ('$user_id','$project_com_date',NOW(),'$project_title','unpublish','$project_detail','$project_catagories')";
      $result= query($q);
      $project_id = mysqli_insert_id($db);
      if($result)
      {
        $location='upload_project_font.php?pro_id='.$project_id;
        redirect($location);
      }
    }
  }

  if(isset($_GET['uploaded']))
  {
    alert('Congratulations: Project Uploaded Successfully','success');
  }


?>

      <form method='post' action='upload_project.php'>
        <div class="row">
          <div class="col-sm-8">
            <div class="form-group">
            <label for="inputEmail4">Project Title:</label>
            <input type="Text" class="form-control" name='project_title' id="inputEmail4" value='<?php echo $project_title ?>'>
        </div>

          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="inputAddress2">Completed Date:</label>
              <input value='<?php echo $project_com_date ?>' type="date" name="com_date" class="form-control" id="inputAddress2" >
            </div>
          </div>
        </div>
      
      
      <div class="form-group">
        <label for="inputAddress">Project Details:</label>
        <textarea  class="form-control" name="project_detail" id="" cols="30" rows="10"><?php echo $project_detail ?></textarea>
      </div>
      
    
        <div class="row">
          <div class="col-sm">
          <div class="form-group">
            <label for="exampleFormControlSelect2">Select Catagories: <small class="text-danger">*Multiple</small></label>
            <select multiple required class="form-control" name="catagories[]" id="exampleFormControlSelect2" >
              <option value='3D Art'>3D Art</option><option value='3D Modeling'>3D Modeling</option><option value='Advertising'>Advertising</option><option value='Advertising Photography'>Advertising Photography</option><option value='Animation'>Animation</option><option value='App Design'>App Design</option><option value='Apparel'>Apparel</option><option value='AR/VR'>AR/VR</option><option value='Architecture'>Architecture</option><option value='Architecture Concept'>Architecture Concept</option><option value='Architecture Photography'>Architecture Photography</option><option value='Architecture Visualization'>Architecture Visualization</option><option value='Art Direction'>Art Direction</option><option value='Automotive Design'>Automotive Design</option><option value='Beauty Photography'>Beauty Photography</option><option value='Branding'>Branding</option><option value='Calligraphy'>Calligraphy</option><option value='Character Design'>Character Design</option><option value='Cinematography'>Cinematography</option><option value='Collage'>Collage</option><option value='Coloring'>Coloring</option><option value='Comic'>Comic</option><option value='Concept Art'>Concept Art</option><option value='Copywriting'>Copywriting</option><option value='Costume Design'>Costume Design</option><option value='Crafts'>Crafts</option><option value='Creative Direction'>Creative Direction</option><option value='Culinary Arts'>Culinary Arts</option><option value='Digital Art'>Digital Art</option><option value='Digital Painting'>Digital Painting</option><option value='Directing'>Directing</option><option value='Drawing'>Drawing</option><option value='Editing'>Editing</option><option value='Editorial Design'>Editorial Design</option><option value='Environmental Graphics'>Environmental Graphics</option><option value='Exhibition Design'>Exhibition Design</option><option value='Fashion'>Fashion</option><option value='Fashion Design'>Fashion Design</option><option value='Fashion Illustration'>Fashion Illustration</option><option value='Fashion Photography'>Fashion Photography</option><option value='Fashion Retouching'>Fashion Retouching</option><option value='Fashion Styling'>Fashion Styling</option><option value='Film'>Film</option><option value='Fine Arts'>Fine Arts</option><option value='Flower Arrangement'>Flower Arrangement</option><option value='Food Photography'>Food Photography</option><option value='Food Styling'>Food Styling</option><option value='Furniture Design'>Furniture Design</option><option value='Game Design'>Game Design</option><option value='GIF Animation'>GIF Animation</option><option value='Graffiti'>Graffiti</option><option value='Graphic Design'>Graphic Design</option><option value='Icon Design'>Icon Design</option><option value='Illustration'>Illustration</option><option value='Industrial Design'>Industrial Design</option><option value='Infographic'>Infographic</option><option value='Information Architecture'>Information Architecture</option><option value='Interaction Design'>Interaction Design</option><option value='Interior Design'>Interior Design</option><option value='Jewelry Design'>Jewelry Design</option><option value='Label Design'>Label Design</option><option value='Landscape Design'>Landscape Design</option><option value='Lettering'>Lettering</option><option value='Logo Design'>Logo Design</option><option value='Makeup'>Makeup</option><option value='Makeup Arts'>Makeup Arts</option><option value='Model Test Photography'>Model Test Photography</option><option value='Modeling'>Modeling</option><option value='Motion Graphics'>Motion Graphics</option><option value='Music'>Music</option><option value='Music Packaging'>Music Packaging</option><option value='Packaging'>Packaging</option><option value='Painting'>Painting</option><option value='Paperworks'>Paperworks</option><option value='Pattern Design'>Pattern Design</option><option value='Performing Arts'>Performing Arts</option><option value='Photography'>Photography</option><option value='Photography Styling'>Photography Styling</option><option value='Photojournalism'>Photojournalism</option><option value='Poster Design'>Poster Design</option><option value='Product Design'>Product Design</option><option value='Product Photography'>Product Photography</option><option value='Programming'>Programming</option><option value='Projection Mapping'>Projection Mapping</option><option value='Props Design'>Props Design</option><option value='Retouching'>Retouching</option><option value='Sculpting'>Sculpting</option><option value='Set Design'>Set Design</option><option value='Shoe Design'>Shoe Design</option><option value='Sketching'>Sketching</option><option value='Sound Design'>Sound Design</option><option value='Storyboarding'>Storyboarding</option><option value='Street Art'>Street Art</option><option value='Students'>Students</option><option value='Styleframing'>Styleframing</option><option value='Surface Design'>Surface Design</option><option value='T-Shirt Design'>T-Shirt Design</option><option value='Textile Design'>Textile Design</option><option value='Toy Design'>Toy Design</option><option value='Type Design'>Type Design</option><option value='Typography'>Typography</option><option value=' UI/UX'> UI/UX</option><option value='Visual Effects'>Visual Effects</option><option value='Visualization'>Visualization</option><option value='Web Design'>Web Design</option><option value='Window Design'>Window Design</option><option value='Woodworking'>Woodworking</option><option value='Writing'>Writing</option>              
            </select>
          </div>
          </div>
      </div>
      <hr>
      <button name='next' type="submit" class="btn btn-primary float-right">Next</button>
    </form>
      
    </main>



  </div>
</div>

<?php include "footer.php" ?>