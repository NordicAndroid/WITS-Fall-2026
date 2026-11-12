<?php
// -------- Starter session -------- //
session_start();

// -------- Forbindelse til databasen for hele dokumentet-------- //
require_once '/var/www/wits.ruc.dk/db.php';

$login = false;

if(isset($_SESSION["UserID"])){
    $login = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Ny Bruger</title>
</head>
<body>
<header class="banner" style="justify-content: start;">
    <div class='clock' ><div id='clock'></div></div>
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

<div class='center' style="align-items: center">
        <?php
        if($login){echo "<h1 style='font-size: 40px'> Du er allerede logget in og bliver sendt tilbage til hovedsiden </h1>"; header("refresh: 4; url=Dashboard.php");}

        if(isset($_GET["error"])){echo "Failed to create User";}

        if($login == false){
        echo <<<END
        <div style="width: 60vw; margin: 3vh">
            <div class="post" style="gap: 0">
                <div class="nUTitel">Lav en ny bruger</div>
                <form class="nUForm" method="post" action="CreateUser.php">
                    <div><p>Bruger id</p><input type="text" name="nUID" required></div>
                    <div><p>Fornavn</p><input type="text" name="nUFName" required></div>
                    <div><p>Efternavn</p><input type="text" name="nULName"></div>
                    <div><p>Kodeord</p><input type="password" name="nUPass" required id="pass" value=""></div>
                    <div><p>Gentag Kodeord</p><input type="password" name="nUPassGen" required id="passGen" value=""></div>
                    <div id="Error1" style="display: none;height: 4vh"><p style="margin-right: 3px">Error</p> Dit kodeord skal være mere end 6 tegn og indeholde store og små bogstaver <br> og et heltal.  </div>
                    <div id="Error2" style="display: none"><p style="margin-right: 3px">Error</p> Kodeord er ikke ens.</div>
                    <input type="hidden" id="caseCheck" required>
                    <input type="hidden" id="sameCheck" required>
                    <input type='submit' name='submit' class='accordion' value='Opret Bruger' style="padding: 1vh 0;font-size: 2vh">
                </form>                
            </div>
        </div>

END;
        }
        ?>
    <script>
        document.getElementById('pass').addEventListener('change', passwordRequrement, false);
        function passwordRequrement(){
            let password = document.getElementById("pass").value;
            let error1 = document.getElementById("Error1");
            let check = document.getElementById("caseCheck");
            if(/[A-Z]/.test(password) && /[a-z]/.test(password) && /[0-9]/.test(password) && /*/[^A-Za-z0-9]/.test(password) &&*/ password.length > 6){error1.style.display = "none";check.required = "true"}
            else{error1.style.display = "flex";check.required = "false"}
            console.log(check.required);
        }

        document.getElementById('passGen').addEventListener('change', CheckPassMatch, false);
        function CheckPassMatch(){
            let password = document.getElementById("pass");
            let repeat = document.getElementById("passGen");
            let error2 =  document.getElementById("Error2");
            let check = document.getElementById("sameCheck");
            if (password.value === repeat.value){error2.style.display = "none";check.required = "true"}
            else{error2.style.display = "flex";check.required = "false"}
            console.log(check.required);
        }
    </script>
</div>
