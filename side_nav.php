<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
    <li class="nav-item dropdown border-bottom">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img src="imgs/img_avatar.png" alt="Avatar" class="avatar">
          <?php 
            $user_id = $_SESSION['user_id'];
            $q="SELECT * from users where `user_id` = '$user_id' LIMIT 1";
            $user_rec = query($q);
            $user = mysqli_fetch_array($user_rec);
            echo "<strong>".$user['first_name']."</strong> ".$user['last_name'];
          ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="personal_info.php">User Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="dashboard.php?sign_out=true">Sign out</a>

        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <span data-feather="home"></span>
          Dashboard <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="saved_projects.php">
          <span data-feather="file-text"></span>
          Projects
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="moodboards.php">
          <span data-feather="file-text"></span>
          Moodboard
        </a>
      </li>
    </ul>
  </div>
</nav>