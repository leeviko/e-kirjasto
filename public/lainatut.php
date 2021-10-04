<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="style.css">
  <title>Lainatut kirjat</title>
</head>
<body>
  <?php 
  include_once "../includes/navbar.inc.php";
  include_once "../php/borrowed.php";
  
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
  }

  $onHomePage = false;
  $onKirjatPage = false;
  $onLainatutPage = true;
  $onTilastotPage = false;
  $omaKirjasto = true;
  
  ?>
  <div class="lisaa content">
    <div class="lisaa-container container">
      <div class="lisaa-wrapper wrapper hae-kirjailijoita">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Lainaamasi kirjat</h1>
          <p class="msgs">
            <?php 
              if($borr_err) {
                echo "<span class='msg-err'>";
                  echo $borr_err;
                echo "</span>";
              } else if($borr_msg) {
                echo "<span class='msg'>";
                  echo $borr_msg;
                echo "</span>";
              }
              
            ?>
          </p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <input type="submit" class="show btn" name="show_borr_books" value="Näytä >">
          </form>
          <div class="books main-cards">
            <?php 
              if($borr_books) {
                for($i = 0; $i < count($borr_books); $i++) {
                  echo '<form method="GET" action=' . htmlspecialchars($_SERVER["PHP_SELF"]) . '>';
                    echo '<h1><input name="book_name" class="borr-info edit-input" type="text" value="' . htmlspecialchars($borr_books[$i]["k_nimi"]) . '" readonly/></h1>';
                    // echo '<h1 class="info book-name"><input name="book_name" class="edit-input" type="text" value="' . $books[$i]["nimi"] . '" /></h1>';
                    echo '<h3> Eräpäivä: ' . htmlspecialchars($borr_books[$i]["erapaiva"]) . '</h3>';
                    echo '<p><input name="borr_id" class="borr-info edit-input" type="text" value="' . htmlspecialchars($borr_books[$i]["id"]) . '" readonly/></p>';

                    echo "<div class='toiminnot'>";
                      echo "<input type='submit' name='return-book' class='form-btn btn' value='Palauta' />";
                    echo "</div>";
                  echo "</form>";
                }
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>  
</body>
</html>