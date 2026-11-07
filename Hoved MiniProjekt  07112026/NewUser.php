<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

$login = "";

if(isset($_SESSION["UserID"])){
    $login = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Rediger Opslag</title>
</head>
<body>
<header class="banner">

</header>

<div class='center'>
    <div style="width: 60%; display: flex; align-self: center">
        <?php
        if($login){echo "<h1 style='font-size: 40px'> Du er allerede logget in og bliver sendt tilbage til hovedsiden </h1>"; header("refresh: 4; url=Dashboard.php");}



        ?>
    </div>
