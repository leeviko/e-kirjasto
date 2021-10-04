<?php

// Katso onko jo kirjautuneena
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

require_once "../config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $username = $email = $password = $confirm_password = "";
  $username_err = $email_err = $confirm_password_err = $password_err = $register_err = "";

  if(empty(trim($_POST["username"]))) {
    $username_err = "Syötä käyttäjätunnus";
  } else {

    $sql = "SELECT username FROM kayttajat WHERE username = ?";

    if($stmt = $mysqli->prepare($sql)){
      $stmt->bind_param("s", $param_username);

      $param_username = trim($_POST["username"]);

      if($stmt->execute()){
        $stmt->store_result();

        if($stmt->num_rows == 1) {
          $username_err = "Tämä käyttäjätunnus on jo varattu";
        } else {
          $username = htmlspecialchars(trim($_POST["username"]));
        }
        
      } else {
        $register_err = "Jotain meni pieleen:(";
      }
      $stmt->close();
    }
  } 

  if(empty(trim($_POST["email"]))) {
    $email_err = "Syötä sähköpostiosoite";
  } else {
    $email = trim($_POST["email"]);

    // Tarkasta email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Virheellinen sähköpostimuoto ";
    } else {
      $sql = "SELECT email FROM kayttajat WHERE email = ?";

      if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s", $param_email);

        $param_email = trim($_POST["email"]);

        if($stmt->execute()){
          $stmt->store_result();

          if($stmt->num_rows == 1) {
            $email_err = "Tämä sähköposti on jo käytössä";
          } else {
            $email = trim($_POST["email"]);
          }
          
        } else {
          $register_err = "Jotain meni pieleen:(";
        }
        $stmt->close();
      }
    }
  } 

  if(empty(trim($_POST["password"]))) {
    $password_err = "Syötä salasana";
  } else {
    $password = trim($_POST["password"]);
  } 

  if(empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Vahvista salasana";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
      $confirm_password_err = "Salasanat eivät täsmää.";
    }

  } 


  if(empty($username_err) && empty($email_err) && empty($password_err)){

    $sql = "INSERT INTO kayttajat (username, email, userPwd, userID) VALUES (?, ?, ?, ?)";

    if($stmt = $mysqli->prepare($sql)){

      $stmt->bind_param("ssss", $param_username, $param_email, $pwd_hashed, $param_id);

      $param_username = htmlspecialchars($username);
      $param_email = htmlspecialchars($email);
      $param_id = uniqid();

      $pwd_peppered = hash_hmac("sha256", $password, pepper);
      $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
      if($stmt->execute()){
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $param_id;
        $_SESSION["username"] = $username;
        $_SESSION["admin"] = false;

        header("location: oma-kirjasto.php");
      } else {
        $register_err = "Jotain meni pieleen:(";
      }
      $stmt->close();
    }
  }
  $mysqli->close();
}