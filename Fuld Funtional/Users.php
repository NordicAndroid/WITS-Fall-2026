<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

// -------- Tjek om man er logget ind -------- //
$login = false;
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

<title>Brugerliste</title>
</head>
<body>
<header class="banner" style="justify-content: start;">
    <div class='clock' ><div id='clock'></div>
        <script>
            ClockUpdate();
            setInterval(ClockUpdate, 1000);
            function ClockUpdate() {
                const clock = document.getElementById("clock");
                const now = new Date();
                const text = now.toLocaleTimeString();
                clock.style.alignSelf = "center";
                clock.innerHTML = text;
            }
        </script>
</header>
<div class="center">
    <div class="containerCol" style="width: 70%; align-self: center">
        <div class="topbar" style="justify-content: center">
           Brugerliste
        </div>
        <div class="containerRow" style="justify-content: center; width: 95%;align-self: center; margin-left: 2vw">

            <div class="sidebar">
                <div class="sidelist">
                    <a  href="Dashboard.php"> <div><i class="fa fa-home"></i></div><p>Hovedside</p></a>
                    <?PHP if ($login){echo "<a href='PersonalPage.php'><div><i class='fa fa-user''></i></div><p>Personlig Side</p></a>";} ?>
                    <a class="active" href="Users.php"><div><i class="fa fa-users" style="font-size: 1vw;"></i></div><p>Brugere</p></a>
                </div>
            </div>

            <div class="feed" style="gap: 15px; margin-left: 2vw">
                <?php
                $userAmount = get_uids(); // Henter alle brugerID
                foreach($userAmount as $uid) {

                    // -------- Info til Bruger-------- //
                    $userInfo = get_user($uid); // Henter brugerens informationer

                    // -------- Variabler -------- //
                    $fNavn = $userInfo["firstname"];
                    $eNavn = $userInfo['lastname'];
                    $dateJoin = $userInfo['date'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post' style='justify-content: space-between;flex-direction: row'>";
                    echo "<div style='font-size: x-large; margin-left: 1vw'><a href='FriendPage.php?userid=$uid'>$fNavn $eNavn</a></div>";
                    echo "<div style='justify-content: end;font-size: medium;flex-basis: 20%;text-align: end;padding: 1.5%'>Dato tilføjet: $dateJoin</div>";
                    echo "</div>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>
