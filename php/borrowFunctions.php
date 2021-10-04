<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["lainaa-kirja"])) {
    require_once "../config.php";

    $borr_msg = $borr_err = "";

    if(isset($_SERVER['QUERY_STRING'])) {
      $kid = $_SERVER['QUERY_STRING'];
      $borr_msg = "Lainaus onnistui";
    } else {
      $borr_err = "Lainaus epäonnistui";
      header("location: ../public/hae_kirjoja.php");
    }

    $uid = $_SESSION["id"];

    $sql = "SELECT fk_kirjaID FROM lainatut WHERE fk_kirjaID = ?";

    if($stmt = $mysqli->prepare($sql)){
      $stmt->bind_param("s", $param_ckid);

      $param_ckid = $kid;

      if($stmt->execute()){
        $stmt->store_result();

        if($stmt->num_rows == 1) {
          $borr_err = "Tämä kirja on jo lainattu";
        } 
      } else {
        $borr_err = "Jotain meni pieleen:(";
      }
      $stmt->close();
    }

    if(empty($borr_err)) {
      $sql = "INSERT INTO lainatut (lainausID, eraPaiva, fk_kirjaID, fk_userID) VALUES (?, ?, ?, ?)";
  
      if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssss", $param_lainausid, $param_erapv, $param_kirjaid, $param_userid);
  
        $param_lainausid = uniqid();
  
        $dueDate = new DateTime('now');
        $dueDate->modify('+1 month');
        $dueDate = $dueDate->format('Y-m-d h:i:s');
        $param_erapv = $dueDate;
        
        $param_kirjaid = $kid;
        $param_userid = $uid;
  
        if($stmt->execute()) {
          header("location: ../public/hae_kirjoja.php");
        } else {
          $borr_err = "Lainaus epäonnistui";
          header("location: ../public/hae_kirjoja.php?err_msg=$borr_err");
        }
  
      } else {
        $borr_err = "Lainaus epäonnistui";
        header("location: ../public/hae_kirjoja.php?err_msg=$borr_err");
      }
    } else {
      header("location: ../public/hae_kirjoja.php");
    }

  }
}
