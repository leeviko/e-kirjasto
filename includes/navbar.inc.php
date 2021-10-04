<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if(!isset($_SESSION["loggedin"])){
    $logged = false;
    $admin = false;
  } elseif($_SESSION["loggedin"] === true) {
    $logged = true;
    if($_SESSION["admin"] === 1) {
      $admin = true;
    } else {
      $admin = false;
    }
  } else {
    $logged = false;
    $admin = false;
  }
?>


<nav class="navbar">
  <div class="nav-items">
    <div class="nav-item vasen"><?php echo $logged ? "Tervetuloa, " . htmlspecialchars($_SESSION['username']) : "E-Kirjasto" ?></div>
    <div class="links">
      <?php 
        if($admin === false) {
          echo !$logged ? "" : "<div class='nav-item highlight'><a href='oma-kirjasto.php'>Oma Kirjasto</a></div>";
          echo "<div class='nav-item'><a href='index.php'>Etusivu</a></div>";
          echo $logged ? "<div class='nav-item normal'><a href='../php/logout.php'>Kirjaudu Ulos</a></div>" : "<div class='nav-item normal'><a href='../public/login.php'>Kirjaudu Sisään</a></div>";
          echo !$logged ? "<div class='nav-item highlight'><a href='register.php'>Rekisteröidy</a></div>" : "";
        } else {
          echo "<div class='nav-item highlight'><a href='../admin/admin-dashboard.php'>Admin Dashboard</a></div>";
          echo "<div class='nav-item'><a href='../php/logout.php'>Kirjaudu Ulos</a></div>";
        }
      
      ?>
    </div>
  </div>
</nav>