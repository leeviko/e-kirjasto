<?php

// Katso onko jo kirjautuneena
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

require_once "../config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $password = "";
  $username_err  = $password_err = $login_err = "";

  if(empty(trim($_POST["username"]))){
    $username_err = "Syötä käyttäjätunnus";
  } else{
    $username = htmlspecialchars(trim($_POST["username"]));
  }

  if(empty(trim($_POST["password"]))){
    $password_err = "Syötä salasanasi";
  } else{
    $password = htmlspecialchars(trim($_POST["password"]));
    $peppered_pwd = hash_hmac("sha256", $password, pepper);
  }

  if(empty($username_err) && empty($password_err)) {

    $sql = "SELECT userID, username, userPwd, admin FROM kayttajat WHERE username = ?";

    if($stmt = $mysqli->prepare($sql)){
      $stmt->bind_param("s", $param_username);

      $param_username = $username;

      if($stmt->execute()){

        $stmt->store_result();

        if($stmt->num_rows == 1){

          $stmt->bind_result($id, $username, $hashed_pwd, $isAdmin);
          if($stmt->fetch()){

            if(password_verify($peppered_pwd, $hashed_pwd)){

              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["admin"] = $isAdmin;
              if($isAdmin) {
                header("location: ../admin/admin-dashboard.php");
              } else {
                header("location: oma-kirjasto.php");

              }
            } else {
              $login_err = "Väärä käyttäjätunnus tai salasana"; 
            }
          } else {
            $login_err = "Jotain meni pieleen:("; 
          }
        } else {
          $login_err = "Väärä käyttäjätunnus tai salasana"; 
        }
      } else {
        $login_err = "Jotain meni pieleen:("; 
      }
      $stmt->close();
    }
  }
  $mysqli->close();
}