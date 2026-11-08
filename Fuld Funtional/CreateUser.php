<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

$uID = $_POST['nUID'];
$uFName = $_POST['nUFName'];
$uLName = $_POST['nULName'];
$uPW = $_POST['nUPass'];
add_user($uID,$uFName,$uLName,$uPW);

$check = get_user($uID);

if (isset($check)) {
    $_SESSION["UserID"] = $uID;
    header("Location: Dashboard.php");
}else{header("Location: NewUser.php?error=failed");}


