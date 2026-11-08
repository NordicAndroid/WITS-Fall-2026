<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

// -------- Check om du har skrevet postet-------- //
if (isset($_SESSION["UserID"]) && isset($_POST["nCText"])) {
    $uID = $_SESSION["UserID"];
    $pID = $_POST["postID"];
    $cText = $_POST["nCText"];
    add_comment($uID,$pID,$cText);
    header("Location: Dashboard.php#$pID");
    exit;
}

if(isset($_POST["commentIDDel"])){ // Deletes comment
    $pID = $_POST["postID"];
    $cid = $_POST["commentIDDel"];
    delete_comment($cid);
    header("Location: Dashboard.php#$pID");
}
?>


echo "<button type='submit' name='logOut' value='Log ind'> Log ind <i class='fa fa-sign-in'></i> </button>";