<?php

/**CONNECTION STRING FOR DATABASE**/

$host = "HOST";
$user = "USER";
$pass = "PASSWORD";
$db = "DATABASENAME";

$connect = mysqli_connect($host, $user, $pass, $db);

//echo $connect ? "You are connected!" : "You are not connected";
