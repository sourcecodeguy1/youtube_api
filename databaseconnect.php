<?php

/**CONNECTION STRING FOR DATABASE**/

$host = "localhost";
$user = "root";
$pass = "";
$db = "gonglive";

$connect = mysqli_connect($host, $user, $pass, $db);

//echo $connect ? "You are connected!" : "You are not connected";
