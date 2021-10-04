<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="../public/style.css"> 
  <title>E-Kirjasto - Lisää kirjailijoita</title>
</head>
<body>
<?php 
  include_once "../includes/navbar.inc.php";
  include_once "../php/addFunctions.php";
  include_once "../php/editFunctions.php";
  
  if($admin === false) {
    header("location: ../public/login.php");
  }
  
  $onLisaaKirjailija = true;
  $onLisaaKirja = false;
  $onKayttajat = false;
  $onDashboard = false;
  ?>
  <div class="lisaa content">
    <div class="lisaa-container container">
      <div class="lisaa-wrapper wrapper hae-kirjailijoita">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Kaikki kirjailijat</h1>
          <p class="msgs">
            <?php 
              if($editmsg_err) {
                echo "<span class='msg-err'>";
                  echo $editmsg_err;
                echo "</span>";
              } else if($editmsg) {
                echo "<span class='msg'>";
                  echo $editmsg;
                echo "</span>";
              }
            ?>
            <span class="del-msg">
              <?php 
              if($delmsg_err) {
                echo "<span class='msg-err'>";
                  echo $delmsg_err;
                echo "</span>";
              } elseif($delmsg) {
                echo "<span class='msg'>";
                  echo $delmsg;
                echo "</span>";
              }
              ?>
            </span>
          </p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <input type="submit" class="show btn" name="show_authors" value="Näytä kirjailijat >">
          </form>
          <div class="authors main-cards">
            <?php 
              if($authors) {
                for($i = 0; $i < count($authors); $i++) {
                  echo "<div class='author main-card'>";
                  echo "<form method='POST' action=" . htmlspecialchars($_SERVER["PHP_SELF"]) . ">";
                    echo "<h3 class='author-nimi'>" . htmlspecialchars($authors[$i]["etunimi"]) . " " . htmlspecialchars($authors[$i]["sukunimi"]) . "</h3>";
                    echo '<p class="info author-id"><span>Kirjailijan ID: </span><input name="author_id" class="edit-input" type="text" value="' . htmlspecialchars($authors[$i]["id"]) . '" readonly/></p>';
                    echo "<div class='toiminnot'>";
                      echo "<input type='submit' name='del-author' class='edit-btn ban-btn btn' value='Poista' />";
                    echo "</div>";

                  echo "</form>";
                  echo "</div>";

                }
              }
            ?>
          </div>                                            
        </div>
        <div class="lisaa-wrapper lisaa-kirjailijoita right-side">
          <h1 class="add-title">Lisää kirjailija</h1>
          <form class="add sign-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="etunimi">Etunimi</label>
            <input class="input" type="text" name="etunimi">
            <label for="sukunimi">Sukunimi</label>
            <input class="input" type="text" name="sukunimi">
            <input type="submit" name="add_author" class="btn" value="Lisää kirjailija" />
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>