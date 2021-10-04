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

<nav class="sidebar">
  <div class="side-items">
    <div class="links">
      <?php 
        if($admin === false) {
          if($omaKirjasto === false) {
            echo '<div class="nav-item"><a href="index.php">Etusivu</a></div>';
            echo '<div class="nav-item"><a href="tietoa.php">Tietoa</a></div>';
          } else {
            echo '<div class="nav-item"><a href="hae_kirjoja.php">Hae kirjoja</a></div>';
            echo '<div class="nav-item"><a href="lainatut.php">Lainatut kirjat</a></div>';
          }
        } else {
          echo '<div class="nav-item"><a href="../admin/lisaa-kirjoja.php">Lisää kirjoja</a></div>';
          echo '<div class="nav-item"><a href="../admin/lisaa-kirjailijoita.php">Lisää kirjailijoita</a></div>';
          echo '<div class="nav-item"><a href="../admin/kayttajat.php">Käyttäjät</a></div>';
        }
      ?>
    </div>
    <p class="cc">© 2021 E-kirjasto</p>
  </div>
</nav>