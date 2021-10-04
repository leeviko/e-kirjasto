<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
  
  if(isset($_GET["search"])) {
    $searchmsg = $searchmsg_err = "";
    $result = array();
    
    require_once "../config.php";
    
    if(empty(trim($_GET["search-term"]))) {
      // $searchmsg_err = "Haku ei voi olla tyhjä";
    } else {
      $searchTerm = htmlspecialchars($_GET["search-term"]);
    }
    
    $sql = "SELECT kirjaID, nimi, julkaisuVuosi, sivuMaara, fk_kirjailijaID, lukuMaara, genret FROM kirjat WHERE nimi LIKE ?";
    
    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_term);

      $param_term = "%$searchTerm%";

      if($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($res_kirjaID, $res_nimi, $res_pvm, $res_sivumaara, $res_kirjailijaID, $res_lukumaara, $res_genret);
        while($stmt->fetch()) {
          array_push($result, array(
                                "kirjaID" => $res_kirjaID,
                                "nimi" => $res_nimi, 
                                "pvm" => $res_pvm, 
                                "sivumaara" => $res_sivumaara, 
                                "lukumaara" => $res_lukumaara, 
                                "genret" => $res_genret
                              ));
        }
          
      } else {
        $searchmsg_err = "Haku epäonnistui";
      }
      $stmt->close();
    } else {
      $searchmsg_err = "Haku epäonnistui";
    }

    $mysqli->close();
  }
}
