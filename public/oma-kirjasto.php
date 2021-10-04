<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="style.css"> 
  <title>Etusivu</title>
</head>
<body>
  <?php 
    include_once "../includes/navbar.inc.php";
    
    if(!isset($_SESSION["loggedin"])){
      header("location: register.php");
      exit;
    }
    $onHomePage = false;
    $onKirjatPage = false;
    $onLainatutPage = false;
    $onTilastotPage = false;
    $omaKirjasto = true;
  ?>

  <div class="home content">
    <div class="home-container container">
      <div class="wrapper">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Valikoidut kirjat</h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, consequuntur totam ipsa </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>