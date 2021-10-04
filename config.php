<?php 

define("DB_SERVER" ,"localhost");
define("DB_NAME" ,"kirjasto_v2");
define("DB_USERNAME" ,"");
define("DB_PASSWORD" ,"");

define("pepper", "AuwKpTRR6oCD8ALZmkJ9cD388dPU4vc5");

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli) {
  die("ERROR: connection failed: " . $mysqli->connect_error);
}
