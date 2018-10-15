<?php
/**
 * Created by PhpStorm.
 * User: JULIO
 * Date: 9/11/2018
 * Time: 8:01 PM
 */
//error_reporting(E_ALL);
// Include mysql connection file.
require_once('databaseconnect.php');

session_start(); // Start the session.


$_SESSION['gongee'] = '123456789'; // Add a value to the session.

$gong_id = $_SESSION['gongee']; // set a variable to the session with the value.


// GET the video title and video id that is coming from jQuery... app.js file.
/*$video_title = $_GET['video_title'];
$video_id = $_GET['video_id'];*/

$song_name2  = $_GET['song_name2'];
$youtube_id  = $_GET['youtube_id'];

// Escape any unwanted characters before inserting to the database.
$escape_video_title_string = mysqli_real_escape_string($connect, $song_name2);

$select_query = mysqli_query($connect, "SELECT * FROM gonglive WHERE gong_id = '".$gong_id."'");
$select_numrows = mysqli_num_rows($select_query);

if($select_numrows > 0){
    $row = mysqli_fetch_assoc($select_query);
        $db_id = $row['id'];

        if($db_id === $gong_id){

            $arr = ["result" => "This user already exists", "msg" => "error"];
            $json = json_encode($arr);
            echo $json;

        } else{
            // UPDATE USER VIDEO TITLE GOES HERE

            // Insert data into the database.
            mysqli_query($connect, "UPDATE gonglive SET gongees = '".$escape_video_title_string."' WHERE gong_id = '".$gong_id."' ");

            // Check if the data has been inserted.
            if(mysqli_affected_rows($connect) > 0){
                $arr = ["result" => "Data UPDATED!", "msg" => "success"];
                $json = json_encode($arr);
                echo $json;
            }else{
                $arr = ["result" => "Something went wrong. Data was NOT updated!", "msg" => "error", "mysqli_error" => mysqli_error($connect)];
                $json = json_encode($arr);
                echo $json;
            }
        }

}else{
    // CREATE NEW USER HERE IF THE PERSON DOESN'T EXIST.

    // Insert data into the database.
    mysqli_query($connect, "INSERT INTO gonglive (gong_id, gongees) VALUES ('".$gongee."', '".$escape_video_title_string."')");

    // Check if the data has been inserted.
    if(mysqli_affected_rows($connect) > 0){
        $arr = ["result" => "Data inserted.", "msg" => "success"];
        $json = json_encode($arr);
        echo $json;
    }else{
        $arr = ["result" => "Data NOT inserted.", "msg" => "error"];
        $json = json_encode($arr);
        echo $json;
    }
}

// Close the database connection.
mysqli_close($connect);