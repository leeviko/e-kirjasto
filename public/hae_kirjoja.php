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
    include_once "../php/searchFunctions.php";
    // include_once "../php/borrowFunctions.php";
    if(!isset($_SESSION["loggedin"])){
      header("location: login.php");
      exit;
    }
    $onHomePage = false;
    $onKirjatPage = false;
    $onLainatutPage = false;
    $onTilastotPage = false;
    $omaKirjasto = true;
    $onHaePage = true;
  ?>


<div class="lisaa content">
    <div class="lisaa-container container">
      <div class="lisaa-wrapper wrapper hae-kirjailijoita">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Hae kirjoja</h1>
          <p class="msgs">
            <?php 
              if($searchmsg_err) {
                echo "<span class='msg-err'>";
                  echo $searchmsg_err;
                echo "</span>";
              } else if($borr_msg) {
                echo "<span class='msg'>";
                  echo $borr_msg;
                echo "</span>";
              }
            ?>
          </p>
          <p class="msgs">
            <?php 
              if($_GET['err_msg']) {
                echo "<span class='msg-err'>";
                  echo $_GET['err_msg'];
                echo "</span>";
              } 
            ?>
          </p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <input type="text" name="search-term" class="search-form" placeholder="Hae kirjoja nimen perusteella..." />
            <input type="submit" class="form-btn btn" name="search" value="Hae" />
          </form>
          <div class="search_results main-cards">
            <?php
              if($result) {
                for($i = 0; $i < count($result); $i++) {
                  $kID = htmlspecialchars($result[$i]["kirjaID"]);
                  echo "<div>";
                    echo "<div class='book-info'>";
                      echo "<h3 class='book-name'>" . htmlspecialchars($result[$i]["nimi"]) . "</h3>";
                      echo "<p class='book-year'>" . htmlspecialchars($result[$i]["pvm"]) . "</p>";
                      echo "<p class='book-count'>" . htmlspecialchars($result[$i]["genret"]) . "</p>";        
                      echo "</div>";
                      echo "<form method='POST' action='../php/borrowFunctions.php?$kID' class='toiminnot'>";
                      require "../config.php";
                      $sql = "SELECT fk_kirjaID FROM lainatut WHERE fk_kirjaID = ?";

                      if($stmt = $mysqli->prepare($sql)){
                        $stmt->bind_param("s", $param_ckid);
                  
                        $param_ckid = $kID;
                  
                        if($stmt->execute()){
                          $stmt->store_result();
                  
                          if($stmt->num_rows == 1) {
                            echo "<input type='submit' name='lainaa-kirja' class='form-btn btn lainaa-btn' value='Lainattu' disabled>";
                          } else {
                            echo "<input type='submit' name='lainaa-kirja' class='form-btn btn lainaa-btn' value='Lainaa'>";
                          }
                        } else {
                          $borr_err = "Jotain meni pieleen:(";
                        }
                        $stmt->close();
                      }
                      $mysqli->close();
                      echo "</form>";        
                  echo "</div>";

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