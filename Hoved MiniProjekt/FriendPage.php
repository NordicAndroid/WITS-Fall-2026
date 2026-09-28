<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
<header class="banner">
</header>
<div class="center">
    <div class="containerCol" style="padding-top: 125px;width: 60%; justify-content: center; align-items: center;">
        <div class="topbar">
            <?php

            ?>
        </div>
        <div class="containerRow" style="justify-content: center; width: 95%;">
            <div class="sidebar">
                <ul>
                    <li><a href="#"> Personal Page</a></li>
                    <li><a href="#"> Friends</a></li>
                    <li><a href="#"> Users</a></li>

                </ul>
            </div>
            <div class="feed">
                <?php
                require_once '/var/www/wits.ruc.dk/db.php';
                $postAmount = get_pids_by_uid($_GET["userid"]);
                foreach($postAmount as $pid) {

                    // -------- Info til Opslaget -------- //
                    $postInfo = get_post($pid); //
                    $authorInfo = get_user($postInfo['uid']);
                    $imageId = get_iids_by_pid($pid);

                    // -------- Variabler -------- //

                    $postdate = $postInfo['date'];
                    $titel = $postInfo['title'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post'>";
                    echo "<div>";
                    echo "</div>";

                    //Navn, tid og Titel på oplæg
                    echo "<div class='containerRow' style='gap: 10px; background-color: lightslategray;'>";
                    echo "<div class='posttime'>$postdate</div>";
                    echo "<div class='posttitle'>$titel</div>";
                    echo "</div>"; // AFlutter containerRow

                    // Hent alle billeder der er tildelt oplægget
                    echo "<div class='postimage'>";
                    foreach ($imageId as $iids) {
                        $imageinfo = get_image($iids);
                        $imageLink = $imageinfo['path'];
                        echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; height: 200px;' >";
                    }
                    echo "</div>"; // Afslutter postimage

                    echo "</div>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>s