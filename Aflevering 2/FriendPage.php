<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <?php
    require_once '/var/www/wits.ruc.dk/db.php';
    $userid = $_GET["userid"];
    $authorInfo = get_user($userid);
    $fNavn = $authorInfo["firstname"];
    $eNavn = $authorInfo['lastname'];
    echo "<title>$fNavn $eNavn's Page</title>"
    ?>
</head>
<body>
<header class="banner">
</header>
<div class="center">
    <div class="containerCol" style="padding-top: 125px;width: 60%; justify-content: center; align-items: center;">
        <div class="topbar" style="justify-content: space-between">
            <?php
            $userid = $_GET["userid"];
            $authorInfo = get_user($userid);
            $fNavn = $authorInfo["firstname"];
            $eNavn = $authorInfo['lastname'];
            $dateJoin = $authorInfo['date'];
            echo "<div style='justify-content: start;font-size: large;flex-basis: 20%;'> Brugerid: $userid</div>";
            echo "<div>$fNavn $eNavn</div>";
            echo "<div style='justify-content: end;font-size: large;flex-basis: 20%;text-align: end;'>Dato tilføjet: $dateJoin</div>";
            ?>

        </div>
        <div class="containerRow" style="justify-content: center; width: 95%;">
            <div class="sidebar">
                <ul>
                    <li><a href="Dashboard.php"> Dashboard</a></li>
                    <li><a href="#"> Personal Page</a></li>
                    <li><a href="Users.php"> Users</a></li>
                </ul>
            </div>
            <div class="feed">
                <?php
                $postAmount = get_pids_by_uid($_GET["userid"]);
                foreach($postAmount as $pid) {

                    // -------- Info til Opslaget -------- //
                    $postInfo = get_post($pid); //
                    $imageId = get_iids_by_pid($pid);

                    // -------- Variabler -------- //

                    $postdate = $postInfo['date'];
                    $titel = $postInfo['title'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post'>";

                    //Navn, tid og Titel på oplæg
                    echo "<div class='containerRow' style='gap: 10px; background-color: lightslategray'>";
                    echo "<div class='posttitle' style='flex-grow: 4;padding: 1.5%'><a href='Dashboard.php#$pid'>$titel</a></div>";
                    echo "<div class='posttime' style='align-items: center; justify-content: end;padding: 1.5%;font-size: medium'>$postdate</div>";
                    echo "</div>"; // AFlutter containerRow

                    // Hent alle billeder der er tildelt oplægget
                    if ($imageId > 0) {
                        echo "<div class='postimage'>";
                        foreach ($imageId as $iids) {
                            $imageinfo = get_image($iids);
                            $imageLink = $imageinfo['path'];
                            echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; height: 200px;' >";
                        }
                        echo "</div>"; // Afslutter postimage
                    }
                    echo "</div>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>