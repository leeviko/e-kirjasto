<?php

if($_SERVER["REQUEST_METHOD"] == "GET") {
  if(isset($_GET["show_users"])) {
    $users = array();
    require "../config.php";

    $sql = "SELECT userID, username, admin, email FROM kayttajat";

    if($stmt = $mysqli->prepare($sql)) {
      if($stmt->execute()) {
        $stmt->store_result();

          $stmt->bind_result($id_res, $username_res, $admin_res, $email_res);
          while ($stmt->fetch()) {
            array_push($users, array("id" => $id_res, "username" => $username_res, "admin" => $admin_res, "email" => $email_res));
          }
      } else {
        $haku_err = "Virhe etsiessä käyttäjiä:(";
        echo $haku_err;
        
      }
      $stmt->close();
    } else {
      $haku_err = "Virhe etsiessä kirjailijoita:(";
      echo $haku_err;
    }
    $mysqli->close();

  }

  if(isset($_GET["show_authors"])) {
    $authors = array();
    require "../config.php";
  
    $sql = "SELECT kirjailijaID, etunimi, sukunimi FROM kirjailijat";
  
    if($stmt = $mysqli->prepare($sql)) {
      if($stmt->execute()) {
        $stmt->store_result();
  
          $stmt->bind_result($id_res, $etunimi_res, $sukunimi_res);
          while ($stmt->fetch()) {
            array_push($authors, array("id" => $id_res, "etunimi" => $etunimi_res, "sukunimi" => $sukunimi_res));
          }
      } else {
        $haku_err = "Virhe etsiessä kirjalijoita:(";
        echo $haku_err;
        
      }
      $stmt->close();
    } else {
      $haku_err = "Virhe etsiessä kirjailijoita:(";
      echo $haku_err;
    }
    $mysqli->close();

  }

  if(isset($_GET["show_books"])) {
    $books = array();
    require "../config.php";

    $sql = "SELECT kirjaID, nimi, julkaisuVuosi, sivuMaara, fk_kirjailijaID, lukuMaara, genret FROM kirjat";

    if($stmt = $mysqli->prepare($sql)) {
      if($stmt->execute()) {
        $stmt->store_result();

          $stmt->bind_result($id_res, $name_res, $julkaisupvm_res, $sivumaara_res, $kirjailijaID_res, $lukumaara_res, $genret_res);
          
          
          
          while ($stmt->fetch()) {
            array_push($books, array(
                                "id" => $id_res, 
                                "nimi" => $name_res,
                                "julkaisuvuosi" => $julkaisupvm_res, 
                                "sivumaara" => $sivumaara_res, 
                                "kirjailijaid" => $kirjailijaID_res, 
                                "lukumaara" => $lukumaara_res, 
                                "genret" => $genret_res
                              ));
          }

      } else {
        $haku_err = "Virhe etsiessä kirjoja:(";
        echo $haku_err;
        
      }
      $stmt->close();
    } else {
      $haku_err = "Virhe etsiessä kirjoja:(";
      echo $haku_err;
    }
    $mysqli->close();
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["add_author"])) {
    $author_err = $etunimi_err = $sukunimi_err = "";

    if(empty(trim($_POST["etunimi"]))) {
      $etunimi_err = "Kirjoita kirjailijan etunimi";
    } elseif(empty(trim($_POST["sukunimi"]))) {
      $sukunimi_err = "Kirjoita kirjailijan sukunimi";
    }

    if(empty($etunimi_err) && empty($sukunimi_err)) {
      require "../config.php";

      $sql = "SELECT etunimi, sukunimi FROM kirjailijat WHERE etunimi = ? AND sukunimi = ?";

      if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ss", $param_etunimi, $param_sukunimi);

        $param_etunimi = htmlspecialchars($_POST["etunimi"]);
        $param_sukunimi = htmlspecialchars($_POST["sukunimi"]);

        if($stmt->execute()) {
          $stmt->store_result();

          if($stmt->num_rows == 1) {
            $author_err = "Tämä kirjailija on jo tietokannassa";
          } else {
            try {
              addAuthor(trim($_POST["etunimi"]), trim($_POST["sukunimi"]));
            } catch(Exception $err) {
              $author_err = $err;
            }
          }

        } else {
          $author_err = "Jotain meni pieleen :(12";
          echo $author_err;
        }
        $stmt->close();
      } else {
        $author_err = "Jotain meni pieleen :(23";
        echo $author_err;
      }
      $mysqli->close();
    } else {
      echo "jiksdfjiksdjfk";
    }

  }

  if(isset($_POST["add_book"])) {
    $book_err = $nimi_err = $pvm_err = $sivumaara_err = $lukumaara_err = $genret_err = $kirjailija_err = "";

    if(empty(trim($_POST["nimi"]))) {
      $nimi_err = "Kirjoita kirjan nimi";
    } elseif(empty(trim($_POST["julkaisupvm"]))) {
      $pvm_err = "Kirjoita julkaisuvuosi";
    } elseif(empty(trim($_POST["sivumaara"]))) {
      $sivumaara_err = "Kirjoita sivumäärä";
    } elseif(empty(trim($_POST["lukumaara"]))) {
      $lukumaara_err = "Kirjoita lukumäärä"; 
    } elseif(empty(trim($_POST["genre1"])) || empty(trim($_POST["genre2"]))) {
      $genret_err = "Kirjoita ainakin yksi genre";
    } elseif(empty(trim($_POST["kirjailija"]))) {
      $kirjailija_err = "Kirjoita kirjailija";
    } 

    if(empty($nimi_err) && empty($pvm_err) && empty($sivumaara_err) && empty($lukumaara_err) && empty($genret_err) && empty($kirjailija_err)) {
      require "../config.php";

      if(!empty($_POST["genre1"]) && !empty($_POST["genre2"])) {
        $genret = htmlspecialchars($_POST["genre1"] . ", " . $_POST["genre2"]);
      } elseif(!empty($_POST["genre1"])) {
        $genret = htmlspecialchars($_POST["genre1"]);
      } elseif(!empty($_POST["genre2"])) {
        $genret = htmlspecialchars($_POST["genre2"]);
      }

      $kirjailijaPalat = explode(" ", $_POST["kirjailija"]);
      if(count($kirjailijaPalat) < 2) {
        $kirjailija_err = "Kirjailijaa ei löytynyt tai formaatti ei ollut oikea";
      } else {
        $kirjailijaEtunimi = $kirjailijaPalat[0];
        $kirjailijaSukunimi = $kirjailijaPalat[1];
      }

      $sql = "SELECT kirjailijaID, etunimi, sukunimi FROM kirjailijat WHERE etunimi = ? AND sukunimi = ?";

      if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ss", $param_etunimi, $param_sukunimi);

        $param_etunimi = htmlspecialchars($kirjailijaEtunimi);
        $param_sukunimi = htmlspecialchars($kirjailijaSukunimi);

        if($stmt->execute()) {
          $stmt->store_result();

          if($stmt->num_rows == 1) {

            $stmt->bind_result($id_res, $etunimi_res, $sukunimi_res);
            if($stmt->fetch()) {
              try {
                addBook(trim($_POST["nimi"]), trim($_POST["julkaisupvm"]), trim($_POST["sivumaara"]), trim($_POST["lukumaara"]), $genret, $id_res);
              } catch(Exception $err) {
                $book_err = $err;
              }

            }
          } else {
            $book_err = "Kirjailijaa ei löytynyt tai formaatti ei ollut oikea";
          }

        } else {
          $book_err = "Jotain meni pieleen :(2";
          echo $book_err;
        }
        $stmt->close();
      } else {
        $book_err = "Jotain meni pieleen :(3";
        echo $book_err;
      }
      $mysqli->close();

    }

  }
}


function addAuthor($fname, $lname) {
  require "../config.php";
  
  $sql = "INSERT INTO kirjailijat (kirjailijaID, etunimi, sukunimi) VALUES (?, ?, ?)";

  if($stmt = $mysqli->prepare($sql)) {
    
    $stmt->bind_param("sss", $param_id, $param_fname, $param_lname);

    $param_id = uniqid();
    $param_fname = $fname;
    $param_lname = $lname;

    if($stmt->execute()){
      header("location: lisaa-kirjailijoita.php");
    } else {
      $add_err = "Jotain meni pieleen:(";
      echo $add_err;
    }
    $stmt->close();
  } else {
    $add_err = "Jotain meni pieleen:(";
    echo $add_err;
  }
  
  $mysqli->close();
}

function addBook($name, $publishDate, $pageCnt, $amount, $genret, $kirjailijaID) {
  require "../config.php";

  $sql = "INSERT INTO kirjat (kirjaID, nimi, julkaisuVuosi, sivuMaara, lukuMaara, genret, fk_kirjailijaID) VALUES (?, ?, ?, ?, ?, ?, ?)";

  if($stmt = $mysqli->prepare($sql)) {

    $stmt->bind_param("sssiiss", $param_id, $param_name, $param_date, $param_pageCnt, $param_amount, $param_genret, $param_kirjailijaID);

    $param_id = uniqid();
    $param_name = htmlspecialchars($name);
    $param_date = htmlspecialchars($publishDate);
    $param_pageCnt = htmlspecialchars($pageCnt);
    $param_amount = htmlspecialchars($amount);
    $param_genret = htmlspecialchars($genret);
    $param_kirjailijaID = htmlspecialchars($kirjailijaID);

    if($stmt->execute()){
      header("location: lisaa-kirjoja.php");
    } else {
      $add_err = "Jotain meni pieleen:(55";
    }
    $stmt->close();
  }

  $mysqli->close();
}

