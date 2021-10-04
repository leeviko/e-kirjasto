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
  $onLisaaKirja = false;
  $onKayttajat = true;
  $onDashboard = false;
  ?>
  <div class="lisaa content">
    <div class="lisaa-container container">
      <div class="lisaa-wrapper wrapper hae-kirjailijoita">
        <?php include_once "../includes/sidebar.inc.php"; ?>
        <div class="home-content main-content">
          <h1 class="main-title title">Käyttäjät</h1>
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
            <input type="submit" class="show btn" name="show_users" value="Näytä käyttäjät >">
          </form>
          <div class="users main-cards">
            <?php 
              if($users) {
                for($i = 0; $i < count($users); $i++) {
                  echo "<div class='user main-card'>";
                  echo "<form method='POST' action=" . htmlspecialchars($_SERVER["PHP_SELF"]) . ">";
                    echo "<h3 class='user-name'>" . htmlspecialchars($users[$i]["username"]) . "</h3>";
                    echo '<p class="info user-name"><span>Käyttäjänimi: </span><input name="user_name" class="edit-input" type="text" value="' . htmlspecialchars($users[$i]["username"]) . '" readonly/></p>';
                    echo '<p class="info user-email"><span>Käyttäjän email: </span><input name="user_email" class="edit-input" type="text" value="' . htmlspecialchars($users[$i]["email"]) . '" readonly/></p>';
                    echo '<p class="info user-id"><span>Käyttäjän ID: </span><input name="user_id" class="edit-input" type="text" value="' . htmlspecialchars($users[$i]["id"]) . '" readonly/></p>';
                    echo '<p class="info user-admin"><span>Admin: </span><input name="user_admin" class="edit-input" type="text" value="' . htmlspecialchars($users[$i]["admin"]) . '" readonly/></p>';

                    echo "<div class='toiminnot'>";
                      echo "<input type='submit' name='del-user' class='edit-btn ban-btn btn' value='Poista' />";
                    echo "</div>";
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