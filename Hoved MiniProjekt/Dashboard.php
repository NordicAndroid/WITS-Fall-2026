<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
<header class="banner"> <!-- Starten på en navigationsbar -->
</header>
<div class="center"> <!-- Centrere hele siden efter navigationsbaren -->
<div class="containerCol" style="padding-top: 125px;width: 60%; justify-content: center; align-items: center;"> <!-- style kommandoen trumfer det der står i style.css -->
    <div class="topbar"> <!-- Generisk velkommen når personen har logget ind -->
        Velkommen Tilbage Fnavn Enavn <!-- Placeholder: Kan ændres når vi for lavet log in systemet -->
    </div>
    <div class="containerRow" style="justify-content: center; width: 95%;"> <!-- Er ikke helt sikker på om vi kommer til at bruge denne endnu. Er der bare for nu-->
        <div class="sidebar">
            <ul>
                <li><a href="#"> Personal Page</a></li>
                <li><a href="#"> Friends</a></li>
                <li><a href="#"> Users</a></li>

            </ul>
        </div>
        <div class="feed"> <!-- Selve området oplagene er lagt -->
            <?php
                require_once '/var/www/wits.ruc.dk/db.php';
                $postAmount = get_pids(); // Få fat i alle opslags id. Dette giver os også mængden af oplag, så vi kan bruge foreach loop til at løbe igennem alle oplagene på databasen
                foreach($postAmount as $pid) { // Løber igennem alle opslagene og bruger den daværende id for hvert løb som variablen $pid

                    // -------- Info til Opslaget -------- //
                    $postInfo = get_post($pid); // Henter alle info der forekommer i opslaget. Man kan se hvad den henter i https://wits.ruc.dk/api.html
                    $authorInfo = get_user($postInfo['uid']); // Henter bruger info via den bruger id vi lige har hentet fra oplagets infomation
                    $imageId = get_iids_by_pid($pid); // Pga. der kan være flere billeder skal vi først have alle iids raleteret til opslaget

                    // -------- Variabler -------- //
                    $fNavn = $authorInfo["firstname"];
                    $eNavn = $authorInfo['lastname'];
                    $postdate = $postInfo['date'];
                    $titel = $postInfo['title'];
                    $posttext = $postInfo['content'];

                    // -------- HTMl yil opslaget -------- //
                    echo "<div class='post'>"; // Starter selve opbygningen af opslaget

                    //Navn, tid og Titel på oplæg
                    echo "<div class='containerRow' style='gap: 10px; background-color: lightslategray;'>"; // Styrer orienteringen, placering og størelsen af hele titelbaren.
                    echo "<div class='postnametime'>"; // Orientere navn og tid over og under hinanden
                    echo "<div class='postname'>$fNavn $eNavn</div>";
                    echo "<div class='posttime'>$postdate</div>";
                    echo "</div>"; // Afslutter postnametime
                    echo "<div class='posttitle'>$titel</div>"; // Centrere tekst lodret i forhold til Parent komponent
                    echo "</div>"; // AFlutter containerRow

                    // Hent alle billeder der er tildelt oplægget
                    echo "<div class='postimage'>"; // Laver en kasse til billedet.
                    foreach ($imageId as $iids) { // Bruger de tidligere hentede billed id'er basseret på oslaget. De bruges ligeoms vi bruger post id'er i den større foreach.
                        $imageinfo = get_image($iids); // Henter alt information på billidet
                        $imageLink = $imageinfo['path']; // Hvert billede indholder en url til hvor billedet ligger på nettet.
                        echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; height: 200px;' >"; // Indsætter og skalerer billedet.
                    }
                    echo "</div>"; // Afslutter postimage

                    // Indsæt oplæggets tekst
                    echo "<div class='posttext'>$posttext</div>"; // Indsætter bare teksten

                    // -------- Info Til kommentarer -------- //
                    // Denne del forløber på samme møde som den store foreach bare med kommentar id i stedet for opslags id
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
</html>