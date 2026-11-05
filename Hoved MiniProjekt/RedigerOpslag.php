<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

// -------- Erklering a globale variabler -------- //
$pID = $pinfo = $ptitel = $pteskt = $imageids = $notYourPost = "";

// -------- Check om du har skrevet postet-------- //
if (isset($_SESSION["UserID"])) {
    $pID = $_POST["postID"];
    var_dump($_POST["postID"]);
    $pinfo = get_post($pID);
    if ($pinfo['uid'] = $_SESSION["UserID"]){
        $ptitel = $pinfo["title"];
        $pteskt = $pinfo["content"];
        $imageids = get_iids_by_pid($pID);
    }
    else{$notYourPost = true;}

}
var_dump($_POST);
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
        echo "<div class='newPost'>";
                echo "<div style='background-color: white; width: 100%'>";
                    echo "<form class='nPForm' method='post' enctype='multipart/form-data' style='margin: 0'>";
                        echo "<div class='nPFElement'> <label class='Rubrik'>Titel på dit oplag:</label> <input type='text' name='nPtitel' style='flex-grow: 1' value='".$ptitel."'> </div>";
                        echo "<div class='nPFElement'> <label class='Rubrik'>Indholdet af dit oplag:</label> <textarea name='nPtext' style='width: 95%;height: 200px;resize: none;overflow: auto'>".$pteskt."</textarea></div>";
                        echo "<div class='nPFElement'> <label class='Rubrik'>Billeder</label> <input accept='.png,.jpeg,.jpg,.gif,.svg' type='File' id='files' name='nPImage[]' multiple> <output id='list' class='imageGal'></output> </div>";

                        // Hent alle billeder der er tildelt oplægget
                        echo "<div class='postimage' style='width: 100%'>";
                            foreach ($imageids as $iids) {
                                $imageinfo = get_image($iids); // Henter alt information på billidet, som et array.
                                $imageLink = $imageinfo['path']; // Hvert billede har en path i dens array, som fortæller os hvor billedet ligger på serveren.
                                echo "<img src='$imageLink' alt='Image Url not responding' style='flex-shrink: 1; max-height: 200px;' >"; // Indsætter og nedskalerer billedet hvis det er for stort.
                            }
                        echo "</div>"; // Afslutter postimage

                        echo "<input type='submit' name='submit' class='accordion' value='Slå op'>";
                        echo "<input type='submit' name='submit' class='accordion' value='Fortryd' formaction='/~stud-olp/Hoved_MiniProjekt/Dashboard.php'>"; // VGV
                    echo "</form>";
                echo "</div>";
        echo "</div>";
        ?>
    </div>
    <?php

    if (isset($_POST["nPtitel"])) {
        $titel = $_POST["nPtitel"];
        $content = $_POST["nPtext"];
        var_dump($_POST);
        modify_post($pID, $titel, $content); // VGV

        if (isset($_FILES['nPImage']['tmp_name'][0])) {
            $imageTotal = count($_FILES['nPImage']['name']);
            var_dump($_FILES['nPImage']['tmp_name']);
            for ($i = 0; $i < $imageTotal; $i++) {
                echo $_FILES['nPImage']['tmp_name'][$i];
                echo $_FILES['nPImage']['type'][$i];
                $imageID = add_image($_FILES['nPImage']['tmp_name'][$i], $_FILES['nPImage']['type'][$i]);
                add_attachment($pID, $imageID);
            }
        }
        header("Location: Dashboard.php");
    }
    ?>
</div>
<script>
    document.getElementById('files').addEventListener('change', PreviewImages, false);
    function PreviewImages (evt){
        list = document.getElementById('list');
        list.innerHTML = "";
        for(var file of evt.target.files){
            var span = document.createElement('span');
            span.id = "newimage";
            var src = URL.createObjectURL(file);
            span.innerHTML = `<img style="height: 100px;margin: 10px"`+` src="${src}" title="${escape(file.name)}">`
            list.insertBefore(span,null);
        }
    }
</script>



</body>
