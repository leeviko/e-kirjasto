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

  $onLisaaKirjailija = false;
  $onLisaaKirja = true;
  $onKayttajat = false;
  $onDashboard = false;
  ?>
  <div class="lisaa content">
    <div class="lisaa-container container">
      <div class="lisaa-wrapper wrapper hae-kirjailijoita">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Kaikki kirjat</h1>
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
            <input type="submit" class="show btn" name="show_books" value="Näytä kirjat >">
          </form>
          <div class="books main-cards">
            <?php 
              if($books) {
                for($i = 0; $i < count($books); $i++) {
                  echo "<div class='book main-card'>";
                    echo '<form method="POST" action=' . htmlspecialchars($_SERVER["PHP_SELF"]) . '>';
                      echo '<h3>' . htmlspecialchars($books[$i]["nimi"]) . '</h3>';
                      echo '<p class="info book-name"><span>Nimi: </span><input name="book_name" class="edit-input" type="text" value="' . htmlspecialchars($books[$i]["nimi"]) . '" /></p>';
                      echo '<p class="info book-id"><span>Kirjan ID: </span><input name="book_id" class="edit-input" type="text" value="' . htmlspecialchars($books[$i]["id"]) . '" readonly/></p>';
                      echo '<p class="info book-kirjailijaid"><span>Kirjailijan ID: </span><input name="book_authorid" class="edit-input" type="text" value="' . htmlspecialchars($books[$i]["kirjailijaid"]) . '" readonly/></p>';
                      echo '<p class="info book-pvm"><span>Julkaisuvuosi: </span><input name="book_pvm" class="edit-input" type="number" value="' . htmlspecialchars($books[$i]["julkaisuvuosi"]) . '" /></p>';
                      echo '<p class="info book-pagecnt"><span>Sivumäärä: </span><input name="book_pagecnt" class="edit-input" type="number" value="' . htmlspecialchars($books[$i]["sivumaara"]) . '"  /></p>';
                      echo '<p class="info book-cnt"><span>Varastossa: </span><input name="book_cnt" class="edit-input" type="number" value="' . htmlspecialchars($books[$i]["lukumaara"]) . '"  /></p>';
                      echo '<p class="info book-genres tag"><span>Genret: </span><input name="book_genres" class="edit-input" type="text" value="' . htmlspecialchars($books[$i]["genret"]) . '"  /></p>';
                      
                      echo "<div class='toiminnot'>";
                        echo "<input type='submit' name='edit-book' class='edit-btn btn' value='Muokkaa'>";
                        echo "<input type='submit' name='del-book' class='edit-btn ban-btn btn' value='Poista' />";
                      echo "</div>";

                    echo "</form>";
                  echo "</div>";
                }
              }
            ?>
          </div>
        </div>
        <div class="lisaa-wrapper lisaa-kirjoja right-side">
          <h1 class="add-title">Lisää kirja</h1>
          <form class="sign-form add" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nimi">Nimi</label>
            <input class="input" type="text" name="nimi">
            <label for="julkaisupvm">Julkaisuvuosi</label>
            <input class="input" type="text" name="julkaisupvm">
            
            <div class="half-input">
              <div class="half-input-wrapper">
                <label for="sivumaara">Sivumäärä</label>
                <input class="input half first" type="text" name="sivumaara">
              </div>
              <div class="half-input-wrapper">
                <label for="lukumaara">Lukumäärä</label>
                <input class="input half" type="number" name="lukumaara">
              </div>
            </div>
            <div class="half-input">
              <div class="half-input-wrapper"> 
                <label for="genre1">Genre 1</label>
                <input class="input half first" type="text" name="genre1">
              </div>
              <div class="half-input-wrapper">
                <label for="genre2">Genre 2</label>
                <input class="input half" type="text" name="genre2">
              </div>
            </div>              

            <label for="kirjailija">Kirjailijan etunimi ja sukunimi</label>
            <input class="input" type="text" name="kirjailija">
            <input type="submit" name="add_book" class="add-btn btn" value="Lisää kirja" />
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>