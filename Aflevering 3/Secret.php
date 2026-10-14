
<?PHP
    $cookie_name = "username";
   if (isset($_COOKIE[$cookie_name])){
       $uid = $loginfo = $logFName = $logEName = "";

       // -------- Forbindelse til Databasen -------- //
       require_once '/var/www/wits.ruc.dk/db.php';
       $uid = $_COOKIE[$cookie_name];
       $loginfo = get_user($uid);
       $logFName = $loginfo["firstname"];
       $logEName = $loginfo["lastname"];
       echo "Du har fundet hemeligheden efter at have logget ind. Dit navn er: $logFName $logEName";
   }
   else{
       echo "Du har tilgået denne hjemmeside uden at logge ind og vil derfor blive taget tilbage til forsiden om 10 Sek.";
       header("refresh:10; url=Dashboard.php"); // Sender en ilbage til forsiden hvor brugeren kan logge ind igen.
   }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Secret</title>
</head>
</html>