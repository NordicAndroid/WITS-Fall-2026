<?php
session_start();
require_once '/var/www/wits.ruc.dk/db.php';

$postTitel = $_POST["nPtitel"];
$postText = $_POST["nPtext"];

$postID = add_post($_SESSION["UserID"], $postTitel, $postText);
$postInfo = get_post($postID);


If(isset($_FILES['nPImage']['tmp_name'][0])){
    $imageTotal = count($_FILES['nPImage']['name']);
    for( $i=0 ; $i < $imageTotal ; $i++ ){
        echo $_FILES['nPImage']['tmp_name'][$i];
        echo $_FILES['nPImage']['type'][$i];
        $imageID = add_image($_FILES['nPImage']['tmp_name'][$i],$_FILES['nPImage']['type'][$i]);
        add_attachment($postID,$imageID);
    }
}

header("Location: Dashboard.php");
exit;

