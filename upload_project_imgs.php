<?php include "header.php"; ?>  
<?php include "top_nav.php"; ?>
<?php
if(!isset($_GET['pro_id']))
{
    redirect('upload_project.php');
}

?>
<div class="container-fluid">
  <div class="row">

    <?php include "side_nav.php" ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <?php 
            if(isset($_GET['edit']))
            {
                 echo "<h3>Edit Images: </h3>";
            }
            else
            {
                echo "<h3>Upload Project: <small style='font-size: 16px;'>Steps 5/5</small></h3>";
            }
            
            ?>
            <small class='text-danger'> Upload Project Cover images (Minimum:1 Maximum:8  Maximum-size: 1MB Format: JPG & PNG Dimensions: 1920*1280px ):</small>
        </div>

        
            <?php
                if(isset($_POST['add_img']))
                {
                    save_img();
                }

                if(isset($_GET['uploaded']) )
                {
                    $pro_id=$_GET['pro_id'];
                    $q="SELECT * from project_images where pro_id = '$pro_id'";
                    $res=query($q);
                    if(mysqli_num_rows($res) == 0)
                    {
                        alert('Upload at least one Image','error');
                    }
                    else
                    {
                        if(isset($_GET['edit']))
                        {
                            $location = 'edit_project.php?uploaded=true&pro_id='.$_GET['pro_id'];
                            redirect($location);
                        }
                        else
                        {
                            redirect('saved_projects.php?uploaded=true');
                        }
                        
                    }
                }
            ?>
            <div class="row">
                <div class="col">
                <form action="upload_project_imgs.php?pro_id=<?php echo $_GET['pro_id'];if(isset($_GET['edit'])) echo "&edit=true"; ?>" method="post" enctype="multipart/form-data"> 
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload Image:</label>
                    <input type="file" class="form-control-file" name="upload_file" id="exampleFormControlFile1">
                </div>
                <button type="submit" name="add_img" class="btn btn-primary">Add</button>
                
                </form>
                </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <label for="table">Uploaded Images:</label>
            </div>
        </div>
        <hr>
        <?php
            if(isset($_GET['del_id']))
            {
                delete_pro_img($_GET['del_id']);
            }
        ?>
        <div class="row">
        <?php
            $pro_id = $_GET['pro_id'];
            $q="Select * from project_images Where pro_id = '$pro_id'";
            $result = query($q);
            $num=1;
            echo mysqli_error($db);
            while($row = mysqli_fetch_array($result))
            {
        ?>
        <div class="col-sm-4 col-md-2">
                <div class="thumbnail">
                <a href="/w3images/lights.jpg">
                    <img src="project imgs/<?php echo $row['img_file']; ?>" alt="Lights" style="width:100%">
                    <div class="caption">
                    <p><a class="btn btn-block btn-danger" href="upload_project_imgs.php?pro_id=<?php echo $_GET['pro_id'].'&del_id='.$row['img_id'];if(isset($_GET['edit'])) echo "&edit=true"; ?>">Delete</a></p>
                    </div>
                </a>
                </div>
        </div>      

        <?php   } ?>
        </div>
                

    </div>  
    <hr>  
    <?php 
            if(isset($_GET['edit']))
            {
                 echo "<a class='btn btn-warning float-right' href='upload_project_imgs.php?pro_id=".$pro_id."&uploaded=true&edit=true';>Done Edit</a>";
            }
            else
            {
                echo "<a class='btn btn-warning float-right' href='upload_project_imgs.php?uploaded=true&pro_id=".$pro_id."'>Done Upload</a>";
            }
            
            ?>
    </main>



  </div>
</div>

<?php include "footer.php" ?>