<?php 

if($_SERVER["REQUEST_METHOD"] == "GET") {
  if(isset($_GET["show_borr_books"])) {
    $borr_err = $borr_msg = "";
    $borr_books = array();

    require_once "../config.php";

    $sql = "SELECT lainausID, eraPaiva, fk_kirjaID, fk_userID FROM lainatut WHERE fk_userID = ?";

    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_id);

      $param_id = $_SESSION["id"];

      if($stmt->execute()) {
        $stmt->store_result();
       
        if($stmt->num_rows >= 1) {

          $stmt->bind_result($res_lainausid, $res_erapaiva, $res_kirjaid, $res_userid);

          
          while($stmt->fetch()) {
            array_push($borr_books, array("id" => $res_lainausid, "erapaiva" => $res_erapaiva, "kirjaid" => $res_kirjaid));
          }
        } else {
          $borr_err = "Et ole lainannut yhtään kirjoja.";
        }

      } else {
        $borr_err = "Jotain meni pieleen:(";
      }
      $stmt->close();

      $sql = "SELECT kirjaID, nimi FROM kirjat WHERE kirjaID = ?";

      for($i = 0; $i < count($borr_books); $i++) {
        if($stmt = $mysqli->prepare($sql)) {

          $stmt->bind_param("s", $param_kirjaid);
          $param_kirjaid = $borr_books[$i]["kirjaid"];
  
          if($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($k_id, $k_nimi);
  
            $stmt->fetch();

            $borr_books[$i]["k_nimi"] = $k_nimi;

          } else {
            $borr_err = "Jotain meni pieleen";
          }
          $stmt->close();
        } else {
          $borr_err = "Jotain meni pieleen";
        }
      }


    } else {
      $borr_err = "Jotain meni pieleen";
    }

    $mysqli->close();
  }

  if(isset($_GET["return-book"])) {

    require "../config.php";

    $sql = "DELETE FROM lainatut WHERE lainausid = ?";

    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $_GET["borr_id"]);

      if($stmt->execute()) {
        $borr_msg = "Kirja palautettu";

      } else {
        $borr_err = "Jotain meni pieleen";
      }


    } else {
      $borr_err = "Jotain meni pieleen";
    }

  }

} 