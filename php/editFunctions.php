<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["edit-book"])) {
    require "../config.php";  
    $book_name = trim($_POST["book_name"]);
    $bookid = trim($_POST["book_id"]);
    $book_pvm = trim($_POST["book_pvm"]);
    $book_pagecnt = trim($_POST["book_pagecnt"]);
    $book_cnt = trim($_POST["book_cnt"]);
    $book_genres = trim($_POST["book_genres"]);

    $edited_books = array();
    $books_props = array();


    $e_name = $e_pvm = $e_pagecnt = $e_cnt = $e_genres = "";
    $editmsg_err = $editmsg = $delmsg_err = $delmsg = "";

    $sql = "SELECT kirjaID, nimi, julkaisuVuosi, sivuMaara, lukuMaara, genret FROM kirjat WHERE kirjaID = ?";
    
    if($stmt = $mysqli->prepare($sql)){
      $stmt->bind_param("s", $param_bookid);
      
      $param_bookid = $bookid;
      
      if($stmt->execute()){
        
        $stmt->store_result();
        $stmt->bind_result($b_id, $b_name, $b_date, $b_pagecnt, $b_cnt, $b_genres);
        if($stmt->fetch()) {
          if($stmt->num_rows > 0) {

            $b_name == $book_name ?  "" : $e_name = $b_name;
            $b_date == $book_pvm ? "" : $e_pvm = $b_date;
            $b_pagecnt == $book_pagecnt ? "" : $e_pagecnt = $b_pagecnt;
            $b_cnt == $book_cnt ? "" : $e_cnt = $b_cnt;
            $b_genres == $book_genres ? "" : $e_genres = $b_genres;
            
            // $sql = "UPDATE kirjat 
            //         SET nimi = $b_name, julkaisuVuosi = $b_date, sivuMaara = $b_pagecnt, lukuMaara = $b_cnt, genret = $b_genres 
            //         WHERE kirjaID = $b_id
            //        ";
            
            // if($stmt = $mysqli->prepare($sql)) {
            //   echo "lol";
            // } else {
            //   echo "rip";
            // }

            // array_push($books_props, array( $e_name, $e_pvm, $e_pagecnt, $e_cnt, $e_genres ));
            $sql = "UPDATE kirjat SET nimi = ?, julkaisuVuosi = ?, sivuMaara = ?, lukuMaara = ?, genret = ? WHERE kirjaID = ?";
        
        
            if($stmt = $mysqli->prepare($sql)) {
              $stmt->bind_param("siiiss", $param_bname, $param_bdate, $param_bpagecnt, $param_bcnt, $param_bgenres, $param_bid);

              $param_bname = $book_name;
              $param_bdate = $book_pvm;
              $param_bpagecnt = $book_pagecnt;
              $param_bcnt = $book_cnt;
              $param_bgenres = $book_genres;
              $param_bid = $bookid;

              if($stmt->execute()) {
                $editmsg = "Muokattu onnistuneesti";
              } else {
                $editmsg_err = "Muokkaaminen epäonnistui1";
              }


            } else {
              $editmsg_err = "Muokkaaminen epäonnistui2";
            }


            // for($a = 0; $a < 5; $a++) {
            //   if ($books_props[0][$a]) {
            //     // array_push($edited_books, $books_props[0][$a]);
            //   }
            // }
          } else {
            echo "asdss";
          }
        } else {
          echo "lol get fucked";
        }
        
        
      } else {
        echo "Jotain meni pieleen:("; 
      }
      $stmt->close();

    } else {
      echo "Jotain meni pieleen=(";
    }


    $mysqli->close();
  } 

  if(isset($_POST["del-book"])) {
    require "../config.php";

    $sql = "DELETE FROM kirjat WHERE kirjaID = ?";

    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_bid);

      $param_bid = trim($_POST["book_id"]);

      if($stmt->execute()) {
        $delmsg = "Poistettu onnistuneesti";
      } else {
        $delmsg_err = "Poistaminen epäonnistui";
      }
      
    } else {
      $delmsg_err = "Poistaminen epäonnistui";
    }
  }

  if(isset($_POST["del-author"])) {
    require "../config.php";

    $sql = "DELETE FROM kirjailijat WHERE kirjailijaID = ?";

    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_aid);

      $param_aid = trim($_POST["author_id"]);

      if($stmt->execute()) {
        $delmsg = "Poistettu onnistuneesti";
      } else {
        $delmsg_err = "Poistaminen epäonnistui";
      }
      
    } else {
      $delmsg_err = "Poistaminen epäonnistui";
    }
  }

  if(isset($_POST["del-user"])) {
    require "../config.php";

    $sql = "DELETE FROM kayttajat WHERE userID = ?";

    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_uid);

      $param_uid = trim($_POST["user_id"]);

      if($stmt->execute()) {
        $delmsg = "Poistettu onnistuneesti";
      } else {
        $delmsg_err = "Poistaminen epäonnistui";
      }
      
    } else {
      $delmsg_err = "Poistaminen epäonnistui";
    }
  }

}
