
<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

// -------- Gruppe Login -------- //
//add_user("nordic", "Oscar Lillebæk", "Pihl", "Kato1234");

// -------- Erklering a globale variabler -------- //
$loguid = $logpass = $loginfo = $logFName = $logEName = $login = $failedlogA = $failedlogB = "";

if(isset($_POST["logOut"])){
    session_unset();
    unset($_POST);
}

// -------- Tjekke om du allerede har logget in tidligere -------- //
if (isset($_SESSION["UserID"])){
    $loginfo = get_user($_SESSION["UserID"]);
    $loguid = $_SESSION["UserID"];
    $logFName = $loginfo["firstname"];
    $logEName = $loginfo["lastname"];
    $login = true;
}

// -------- Modtagelse a Form -------- //
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["loguid"])){
        $logpass = $_POST["logpass"];
        $loguid = $_POST["loguid"];
        $DBCheck = get_uids();
        if (in_array($loguid, $DBCheck)) {
            $login = login($loguid, $logpass);
            if ($login) {$_SESSION["UserID"] = $loguid; header("Location: Dashboard.php");}else{$failedlogA = true;}
        }
        else{$failedlogB = true;}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="Functions.js"></script>
    <title>Dashboard</title>
</head>
<body>

<header class="banner" style="<?PHP //if ($login){echo "height: 4vh";} ?>">

<?PHP
    // -------- Ur -------- //
    echo "<div class='clock'><div id='clock' ></div></div>";

    // -------- Log in Form -------- //
    if ($login == false) { // Viser kun formen hvis man ikke er logget ind
        echo '<form class="login" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">'; // Starter formen sender svarene som formen indsamler. Bruger PHP til at sende til den nuværende side.
            echo "<div style='align-self: center'> <div class='loginLabel'> User ID: </div> <input type='text' name='loguid'> </div>";
            echo "<div style='align-self: center'> <div class='loginLabel'> Password: </div> <input type='password' name='logpass'> </div>";

            // -------- Fejlmeddellse for at man fejler i at logge ind  -------- //
            if ($failedlogA){
                echo "<div style='align-self: center; background-color: #525e6b;padding: 5px'>Invalid Password </div>";
            }
            if ($failedlogB){
                echo "<div style='align-self: center;background-color: #525e6b;padding: 5px'>Invalid UserID or Password</div>";
            }

            echo "<button name='submit' value='Log ind'> Log ind <i class='fa fa-sign-in'></i> </button>";
        echo "</form>";
        echo "<div class='nULink'> <a href='NewUser.php'><div style='align-self: center'>Opret bruger <i class='fa fa-user-plus'></i></div></a></div>";
    }

    // -------- Log UD Form -------- //
    if ($login) { // Viser kun formen hvis man er logget ind
        echo "<div style='flex-basis: 80%'></div>";
        echo '<div class="navLogout"> <form class="logOut" method="post" > <button type="submit" name="logOut" value="Log ud"> Log ud <i class="fa fa-sign-out"></i> </button> </form></div>';
    }
?>
    <script>
        ClockUpdate();
        setInterval(ClockUpdate, 1000);
        function ClockUpdate() {
            const clock = document.getElementById("clock");
            const now = new Date();
            text = now.toLocaleTimeString();
            clock.style.alignSelf = "center";
            clock.innerHTML = text;
        }
    </script>

</header>


<div class='center' style="<?PHP //if ($login){echo "height: 96vh";} ?>">
    <div class="containerCol" style="width: 70%;align-self: center">
        <div class="topbar">
            <?PHP
                // -------- Visuelt ændring på Forsiden for at vise brugeren er logget ind -------- //
                if ($login){
                    echo "Velkommen tilbage $logFName $logEName";
                } else{
                    echo "Velkommen til Forsiden";
                }
            ?>
        </div>

        <div class="containerRow" style="width: 95%;align-self: center">
            <div class="sidebar">
                <div class="sidelist">
                    <a class="active" href="Dashboard.php">Dashboard</a>
                    <?PHP if ($login){echo "<a href='PersonalPage.php'>Personal Page</a>";} ?>
                    <a href="Users.php">Users</a>
                </div>
            </div>

            <div class="mainContent">
                <?php
                if ($login) {
                    echo <<<END
                        <div class='newPost' id="newPost">
                        <button class='accordion' id='newPostButton' style="border: " onclick='NewPost()'>Skriv et nyt opslag <i class="fa fa-plus"></i></button>
                        <div class='panel'>
                            <form class='nPForm' method='post' action='UploadOpslag.php' enctype='multipart/form-data'>
                                <div class='nPFElement'> <label class='Rubrik'>Titel på dit oplag:</label> <input type='text' name='nPtitel' style='flex-grow: 1'> </div>
                                <div class='nPFElement'> <label class='Rubrik'>Indholdet af dit oplag:</label> <textarea name='nPtext' style='width: 95%;height: 200px;resize: none;overflow: auto'> </textarea></div>
                                <div class='nPFElement'> <label class='Rubrik'>Billeder</label> <input accept='.png,.jpeg,.jpg,.gif,.svg' type='File' id='files' name='nPImage[]' multiple> <output id='list' class='imageGal'></output> </div>
                                <input type='submit' name='submit' class='accordion' value='Slå op'>
                            </form>
                        </div>
                    </div>
            END;
                }
                ?>
                    <script>
                        function NewPost(){
                            var border = document.getElementById("newPost");
                            var show = document.getElementById("newPostButton");
                            var panel = show.nextElementSibling;
                            if (panel.style.display === "block") {
                                show.innerHTML = 'Skriv et nyt opslag <i class="fa fa-plus"></i>';
                                panel.style.display = "none";
                            } else {
                                show.innerHTML = 'Skriv et nyt opslag <i class="fa fa-minus"></i>';
                                panel.style.display = "block";
                            }
                        }

                        document.getElementById('files').addEventListener('change', PreviewImages, false);
                        function PreviewImages (evt){
                            list = document.getElementById('list');
                            list.innerHTML = "";
                            for(var file of evt.target.files){ //Skal afklares
                                var span = document.createElement('span');
                                span.id = "newimage";
                                var src = URL.createObjectURL(file);
                                span.innerHTML = `<img style="height: 100px;margin: 10px"`+` src="${src}" title="${escape(file.name)}">`
                                list.insertBefore(span,null);
                            }
                        }
                    </script>

                <div class="feed"> <!-- Selve området oplagene er lagt -->
                    <?php
                        $postAmount = get_pids(); // Få fat i alle opslags id. Dette giver os også mængden af oplag, så vi kan bruge foreach loop til at løbe igennem alle oplagene på databasen
                        foreach($postAmount as $pid) { // Løber igennem alle opslagene og bruger den daværende id for hvert løb som variablen $pid

                            // -------- Info til Opslaget -------- //
                            $postInfo = get_post($pid); // Henter alle info der forekommer i opslaget. Man kan se hvad den henter i https://wits.ruc.dk/api.html
                            $authorID = $postInfo['uid'];
                            $authorInfo = get_user($postInfo['uid']); // Henter bruger info via den bruger id vi lige har hentet fra oplagets infomation
                            $imageId = get_iids_by_pid($pid); // Pga. der kan være flere billeder skal vi først have alle iids raleteret til opslaget

                            // -------- Variabler -------- //
                            $fNavn = $authorInfo["firstname"];
                            $eNavn = $authorInfo['lastname'];
                            $postdate = $postInfo['date'];
                            $titel = $postInfo['title'];
                            $posttext = $postInfo['content'];

                            // -------- HTMl til opslaget -------- //
                            echo "<div class='post'>"; // Starter selve opbygningen af opslaget

                                //Navn, tid og Titel på oplæg
                                echo "<div class='containerRow' style='gap: 10px; background-color: lightslategray;; height: 65px'>"; // Styrer orienteringen, placering og størelsen af hele titelbaren.
                                    echo "<div class='postnametime'>"; // Orientere navn og tid over og under hinanden
                                        echo "<div class='postname'><a href='FriendPage.php?userid=$authorID'>$fNavn $eNavn</a></div>";
                                        echo "<div class='posttime'>$postdate</div>";
                                    echo "</div>"; // Afslutter postnametime
                                    echo "<div class='posttitle'>$titel</div>";// Centrere tekst lodret i forhold til Parent komponent

                                    if ($login) {
                                        echo '<div class="dropdown">';
                                                echo '<button class="dropbtn"><i class="fa fa-plus"></i></button>';
                                                echo '<div class="dropdown-content">';
                                                        echo '<div><button onclick="NewComment('.$pid.')">Skriv Kommentar</button></div>';
                                                    if ($authorID == $loguid) {
                                                        echo '<form method="post" action="/~stud-olp/Hoved_MiniProjekt/RedigerOpslag.php"> <input type="submit" name="button" value="Rediger opslag"> <input type="hidden" name="postID" value="'.$pid. '"> </form>'; // VGV
                                                        echo '<form method="post" > <input style="color: red" type="submit" name="deletePost"  value="Slet oplsag" > <input type="hidden" name="postIDDel" value="'.$pid. '"> </form>';
                                                        if(isset($_POST["postIDDel"])){ // Deletes Post

                                                        }
                                                    }
                                                echo '</div>';
                                        echo '</div>';
                                    }

                                echo "</div>"; // Afslutter containerRow

                                // Hent alle billeder der er tildelt oplægget
                                echo "<div class='postimage'>"; // Laver en kasse til billederne.
                                    foreach ($imageId as $iids) { // Bruger de tidligere hentede billed id'er basseret på oslaget. De bruges ligeoms vi bruger post id'er i den større foreach.
                                        $imageinfo = get_image($iids); // Henter alt information på billidet
                                        $imageLink = $imageinfo['path']; // Hvert billede indholder en url til hvor billedet ligger på nettet.
                                        echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; max-height: 200px;' >"; // Indsætter og skalerer billedet.
                                    }
                                echo "</div>"; // Afslutter postimage

                                // Indsæt oplæggets tekst
                                echo "<div class='posttext'>$posttext</div>"; // Indsætter bare teksten

                                // -------- Info Til kommentarer -------- //
                                // Denne del forløber på samme møde som den store foreach bare med kommentar id i stedet for opslags id
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
                                        if ($authorID == $loguid || $cauthorID == $loguid) {
                                            echo '<div class="dropdown" style="align-self: flex-end; padding: 0;flex-basis: 10%">';
                                                echo '<button class="dropbtn" style="height: 18px; font-size: 18px"><i class="fa fa-plus"></i></button>';
                                                echo '<div class="dropdown-content">';
                                                    echo <<<END
                                                         <form method="post" action="/~stud-olp/Hoved_MiniProjekt/CommentHandler.php"> 
                                                         <input style="color: red" type="submit" name="deleteComment"  value="Slet kommentar" > 
                                                         <input type="hidden" name="commentIDDel" value="$cids">
                                                         <input type="hidden" name="postID" value="$pid">
                                                         </form>
                                                    END;
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                        echo "</div>";
                                        echo "<div class='commentText'>$commentText</div>";
                                    echo "</div>"; // Afslutter comment
                                }

                                // -------- Tekstbox til at skrive en ny kommentar -------- //
                                echo <<<END
                                    <div id="nC$pid" class="newComment">
                                        <form method="post" action="/~stud-olp/Hoved_MiniProjekt/CommentHandler.php">
                                        <input type='text' name='nCText' style='flex-grow: 5' required>
                                        <input type="hidden" name="postID" value="$pid">
                                        <input type='submit' name='submit' class='accordion' value='Slå op' style="flex-basis: 5%">
                                        </form>
                                    </div>  
                                END; // Slutningen af ny commentar

                                echo "<div></div>"; // Spacing på bunden af opslaget
                            echo "</div>"; // Afslutter Post
                            echo "<div id='$pid'></div>"; // Giver muligheden for at hoppe til et specifikt post.
                    }
                    ?>
                    <script>
                        function NewComment(pid){
                            console.log(pid);
                            var panel = document.getElementById("nC"+pid);
                            if (panel.style.display === "block") {
                                panel.style.display = "none";
                            } else {
                                panel.style.display = "block";
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>