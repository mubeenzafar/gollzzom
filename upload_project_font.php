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
                 echo "<h3>Edit Fonts:</h3>";
            }
            else
            {
                echo "<h3>Upload Project: <small style='font-size: 16px;'>Steps 2/5</small></h3>";
            }
            
            ?>
            <small class='text-danger'> Please Enter Fonts Details:</small>
        </div>

        <div class="row">
            <div class="col-md-6">

            <?php
                if(isset($_POST['add_font']))
                {
                    save_font();
                }
            ?>

            <form action="upload_project_font.php?pro_id=<?php echo $_GET['pro_id'];if(isset($_GET['edit'])) echo "&edit=true"; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="inputEmail4">Font Name:</label>
                <input type="Text" class="form-control" name='font_name' id="inputEmail4">
            </div>
            
            <div class="form-group">
                <label for="exampleFormControlFile1">Upload File:</label>
                <input type="file" class="form-control-file" name="font_file" id="exampleFormControlFile1">
            </div>
            <button type="submit" name="add_font" class="btn btn-primary float-right">Add</button>
            
            </form>
        </div>

        <div class="col-md-6">
        <label for="table">Uploaded Fonts:</label>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Font Name</th>
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
                <th scope="row"><?php echo $num; ?></th>
                <td><?php echo $row['font_name']; ?></td>
                <td><a href="upload_project_font.php?pro_id=<?php echo $pro_id.'&del_id='.$row['font_id'];if(isset($_GET['edit'])) echo "&edit=true";?>" class="badge badge-danger">Delete</a></td>
                </tr>
                <?php  $num++;
                        } ?>
        </tbody>
</table>
        
        </div>

    </div>  
    <hr>
    <?php 
            if(isset($_GET['edit']))
            {
                 echo "<a class='btn btn-warning float-right' href='edit_project.php?pro_id=".$pro_id."';>Done Edit</a>";
            }
            else
            {
                echo "<a class='btn btn-warning float-right' href='upload_project_color.php?pro_id=".$pro_id."';>Next Step</a>";
            }
            
            ?>
    </main>



  </div>
</div>

<?php include "footer.php" ?>