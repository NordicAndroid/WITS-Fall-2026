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
            Velkommen Tilbage Fnavn Enavn
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
                $postAmount = get_pids();
                foreach($postAmount as $pid) {

                    // -------- Info til Opslaget -------- //
                    $postInfo = get_post($pid); //
                    $authorInfo = get_user($postInfo['uid']);
                    $imageId = get_iids_by_pid($pid);

                    // -------- Variabler -------- //
                    $fNavn = $authorInfo["firstname"];
                    $eNavn = $authorInfo['lastname'];
                    $postdate = $postInfo['date'];
                    $titel = $postInfo['title'];
                    $posttext = $postInfo['content'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post'>";

                    //Navn, tid og Titel på oplæg
                    echo "<div class='containerRow' style='gap: 10px; background-color: lightslategray;'>";
                    echo "<div class='postnametime'>";
                    echo "<div class='postname'>$fNavn $eNavn</div>";
                    echo "<div class='posttime'>$postdate</div>";
                    echo "</div>"; // Afslutter postnametime
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

                    // Indsæt oplæggets tekst
                    echo "<div class='posttext'>$posttext</div>"; // Indsætter bare teksten

                    // -------- Info Til kommentarer -------- //
                    $commentId = get_cids_by_pid($pid);
                    foreach ($commentId as $cids) {
                        $commentInfo = get_comment($cids);
                        $cauthorInfo = get_user($commentInfo['uid']);
                        $cfNavn = $cauthorInfo["firstname"];
                        $ceNavn = $cauthorInfo['lastname'];
                        $commentDate = $commentInfo['date'];
                        $commentText = $commentInfo['content'];

                        // -------- HTML til kommentarer -------- //
                        echo "<div class='comment'>";
                        echo "<div class='commentUserInfo'>$cfNavn $ceNavn / $commentDate</div>";
                        echo "<div class='commentText'>$commentText</div>";
                        echo "</div>";
                    }

                    echo "<div>"; // Spacing på bunden af opslaget
                    echo "</div>";
                    echo "<div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>s