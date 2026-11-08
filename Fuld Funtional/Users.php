<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php
    require_once '/var/www/wits.ruc.dk/db.php';
    ?>
<title>User Database</title>
</head>
<body>
<header class="banner"></header>
<div class="center">
    <div class="containerCol" style="width: 60%; align-self: center">
        <div class="topbar" style="justify-content: center">
           User Database
        </div>
        <div class="containerRow" style="justify-content: center; width: 95%;align-self: center">
            <div class="sidebar">
                <ul>
                    <li><a href="Dashboard.php"> Dashboard</a></li>
                    <li><a href="#"> Personal Page</a></li>
                    <li><a href="Users.php"> Users</a></li>
                </ul>
            </div>
            <div class="feed" style="gap: 15px">
                <?php
                $userAmount = get_uids();
                foreach($userAmount as $uid) {

                    // -------- Info til Bruger-------- //
                    $userInfo = get_user($uid); //

                    // -------- Variabler -------- //
                    $fNavn = $userInfo["firstname"];
                    $eNavn = $userInfo['lastname'];
                    $dateJoin = $userInfo['date'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post' style='justify-content: space-between;flex-direction: row'>";
                    echo "<div style='justify-content: end;font-size: medium;flex-basis: 20%;padding: 1.5%'> Brugerid: $uid</div>";
                    echo "<div style='font-size: x-large'><a href='FriendPage.php?userid=$uid'>$fNavn $eNavn</a></div>";
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
