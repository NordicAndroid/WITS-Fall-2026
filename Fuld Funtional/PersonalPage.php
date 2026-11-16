<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

// -------- Erklering a globale variabler -------- //
$userid = $authorInfo = $fNavn = $eNavn = $dateJoin = $login = "";

if(isset($_SESSION["UserID"])){
    $userid = $_SESSION["UserID"];
    $authorInfo = get_user($userid);
    $fNavn = $authorInfo["firstname"];
    $eNavn = $authorInfo['lastname'];
    $dateJoin = $authorInfo['date'];
    $login = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php echo "<title>$fNavn $eNavn's Page</title>" ?>
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
    <div class="containerCol" style="width: 70%;align-self: center">
        <div class="topbar" style="justify-content: space-between">
            <?php
            echo "<div style='margin-left: 1vw'>$fNavn $eNavn</div>";
            echo "<div style='justify-content: end;font-size: large;flex-basis: 20%;text-align: end;margin-right: 1vw'>Dato tilføjet: $dateJoin</div>";
            ?>

        </div>
        <div class="containerRow" style="justify-content: center; width: 95%;align-self: center;margin-left: 2vw">
            <div class="sidebar">
                <div class="sidelist">
                    <a  href="Dashboard.php"> <div><i class="fa fa-home"></i></div><p>Hovedside</p></a>
                    <?PHP if ($login){echo "<a class='active' href='PersonalPage.php'><div><i class='fa fa-user''></i></div><p>Personlig Side</p></a>";} ?>
                    <a href="Users.php"><div><i class="fa fa-users" style="font-size: 1vw;"></i></div><p>Brugere</p></a>
                </div>
            </div>
            <div class="feed" style="gap: 15px; margin-left: 2vw">
                <?php
                $postAmount = get_pids_by_uid($_SESSION["UserID"]);
                foreach($postAmount as $pid) {

                    // -------- Info til Opslaget -------- //
                    $postInfo = get_post($pid); //
                    $imageId = get_iids_by_pid($pid);

                    // -------- Variabler -------- //
                    $postdate = $postInfo['date'];
                    $titel = $postInfo['title'];
                    $posttext = $postInfo['content'];

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
                                echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; max-height: 200px;' >";
                        }
                            echo "</div>"; // Afslutter postimage

                        // Indsæt oplæggets tekst
                        echo "<div class='posttext'>$posttext</div>"; // Indsætter bare teksten

                        $commentId = get_cids_by_pid($pid);
                        foreach ($commentId as $cids) {
                            $commentInfo = get_comment($cids);
                            $cauthorID = $commentInfo['uid'];
                            $cauthorInfo = get_user($cauthorID);
                            $cfNavn = $cauthorInfo["firstname"];
                            $ceNavn = $cauthorInfo['lastname'];
                            $commentDate = $commentInfo['date'];
                            $commentText = $commentInfo['content'];

                            // -------- HTML til kommentarer -------- //
                            echo "<div class='comment'>";
                            echo "<div class='commentUserInfo'> <div style='flex-grow: 1'>$cfNavn $ceNavn / $commentDate</div>";
                            echo '</div>';
                            echo "<div class='commentText'>$commentText</div>";
                            echo "</div>"; // Afslutter comment
                        }
                    echo "<div></div>";
                    echo "</div>";
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>