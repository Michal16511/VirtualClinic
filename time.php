<?php
    session_start();
    require_once 'connect.php';
    $connection= @new mysqli($host,$db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
   
     if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } 
    else{
            foreach ($_COOKIE as $k=>$v) {
            $_COOKIE[$k] = mysqli_real_escape_string($connection, $v);
        }       
           if (!isset($_COOKIE['id'])){header("location:index.php");exit();}
        }
        
        $sql = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
        $result = $connection->query($sql);
        $resultRow = mysqli_fetch_assoc($result);

        
        
        if(isset($resultRow['Id_lekarza'])){
            
                    if(isset($_SESSION['fs_submit'])==TRUE){

                $day = $_SESSION['fs_submit'];
            }else{

                $day = $_POST['submit'];
                $_SESSION['fs_submit'] = $day;
            }
            
            $idDniaResult = $connection->query("SELECT `Id_dnia`FROM `dzien_przyjec` WHERE Dzien = '$day'");
            $idDniaRow = mysqli_fetch_assoc($idDniaResult);

            $timeSql = "SELECT `Godzina_od`, `Godzina_do` FROM `godziny_przyjec` WHERE Id_uzytkownika = '$resultRow[Id_uzytkownika]' and Id_dnia_przyjec = '$idDniaRow[Id_dnia]'";
            $timeResult = $connection->query($timeSql);
            $timeRow = mysqli_fetch_assoc($timeResult);

            $tStart = strtotime($timeRow['Godzina_od']);
            $tEnd = strtotime($timeRow['Godzina_do']);
            
            if(isset($_POST['begin']) && isset($_POST['end'])){
                
                if(date('H:i:s',strtotime($_POST['begin']))>=date('H:i:s',(strtotime("-19 minutes", strtotime($_POST['end'])))))
                {
                    echo '<script>alert("Ropoczęcie pracy musi być wcześniej niż zakończenie minimum o 20 minut") </script>';
                }
                else{
            // Check connection

                $sql2 = "SELECT uzytkownicy.Id_uzytkownika from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";

                $result2 = $connection->query($sql2);
                $result2Row = mysqli_fetch_assoc($result2);

                 $idDniaResult = $connection->query("SELECT `Id_dnia`FROM `dzien_przyjec` WHERE Dzien = '$day'");

                $begin = date('H:i:s',strtotime($_POST['begin']));
                $end = date('H:i:s',strtotime($_POST['end']));

                $numberOfDays = $idDniaResult->num_rows;

                if($numberOfDays>0){

                    $idDniaRow = mysqli_fetch_assoc($idDniaResult);  

                    $checkSql = "SELECT COUNT(*) count FROM godziny_przyjec WHERE Id_uzytkownika='$result2Row[Id_uzytkownika]' and Id_dnia_przyjec = '$idDniaRow[Id_dnia]'";
                    $checkCount = mysqli_fetch_assoc( mysqli_query($connection, $checkSql));
                    
                    // TRANSAKCJE!!!!!
                    
                    if($connection->query("SET TRANSACTION ISOLATION LEVEL READ COMMITED")){
                        
                    }
                    
                    if($connection->query("START TRANSACTION"))
                    {
                        $error = 0;
                    }
                    if($checkCount['count'] > 0){

                        $update = "UPDATE `godziny_przyjec` SET `Godzina_od`='$begin',`Godzina_do`='$end' WHERE '$idDniaRow[Id_dnia]' = Id_dnia_przyjec and '$result2Row[Id_uzytkownika]' = godziny_przyjec.Id_uzytkownika"; 
                        
                        if($connection->query($update))
                        {
                            $_SESSION['Accepted'] = "Udało się :)";
                        }  else {
                            
                            $error=1;
                            $connection->query("ROLLBACK");
                            throw new Exception($connection->error);
                        }
                    }
                    else{
                        
                        $insert = "INSERT INTO `godziny_przyjec`(`Id_godziny`, `Id_uzytkownika`, `Godzina_od`, `Godzina_do`, `Id_dnia_przyjec`) VALUES (NULL,'$result2Row[Id_uzytkownika]','$begin','$end','$idDniaRow[Id_dnia]')";
                        
                        if($connection->query($insert))
                        {
                            $_SESSION["Accepted"] = "Udało się";
                        }else
                        {
                            $error = 1;
                            $connection->query("ROLLBACK");
                            throw new Exception($connection->error);
                        }
                    }
                    if(mysqli_error_list($connection))
                    {
                        if($connection->query("ROLLBACK"))
                        {
                            
                        }
                    }
                    else
                    {
                        $connection->query("COMMIT");
                    }
                    unset($_SESSION['fs_submit']);
                    header('Location: option.php');exit();
                }else{

                        $connection->query("INSERT INTO `dzien_przyjec`(`Id_dnia`,`Dzien`) VALUES (NULL,'$day')");
                        $idDniaResult = $connection->query("SELECT `Id_dnia`FROM `dzien_przyjec` WHERE Dzien='$day'");
                        $idDniaRow = mysqli_fetch_assoc($idDniaResult);

                        $insert = "INSERT INTO `godziny_przyjec`(`Id_godziny`, `Id_uzytkownika`, `Godzina_od`, `Godzina_do`, `Id_dnia_przyjec`) VALUES (NULL,'$result2Row[Id_uzytkownika]','$begin','$end','$idDniaRow[Id_dnia]')";
                        $connection->query($insert);

                        unset($_SESSION['fs_submit']);
                        header('Location: option.php');
                }
                    $connection->close();

                }
            }
        }else{
            
            header('Location: option.php');
        }
        
    
    
 ?>
<html>

<head>
	<title>Virtual Clinic</title>
	<meta  charset="UTF-8" />
        <style>
            
            body
            {
                background-image:url('images/doktor.jpg');
                background-size: cover;
                
            }
            
            #container
            {     
                width: 1200px;
                height: 500px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                
                
            }
            
            #button
            {
                margin-left: 8%;
                margin-top: 11.1%;
                float:left;
                width: 200px;
                height: 200px;
                border-radius: 30px;
                opacity: 0.95;
                text-align: center;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                color: black;  
                overflow:hidden;
                font-size: 30;
            }
            #button2
            {
                margin-left: 15.3%;
                margin-top: 17.4%;
                float:left;
                width: 200px;
                height: 200px;
                border-radius: 30px;
                opacity: 0.95;
                text-align: center;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                color: black;  
                overflow:hidden;
                font-size: 30;
            }
            a:link
            {
                font-weight: bold;
                color: #cc0066;
                text-decoration: none;
            }
            a:visited {
            font-weight: bold;
            color: #cc0066;
            background-color: transparent;
            text-decoration: none;
            }
            a:hover {
            color: red;
            background-color: transparent;
            text-decoration: underline;
            }
            a:active {
            color: yellow;
            background-color: transparent;
            text-decoration: underline;
            }
            #container #login
            {
                font-weight: bold;
                color: #cc0066;
                float:left;
                margin-left: 9%;
                margin-top: 5%;
                width: 400px;
                height: 320px;
                overflow:hidden;
            }
            #container #login form
            {
                margin-top: 35px;
                padding-left: 0px;
                padding-top: 0px;
                padding-bottom: 30px;
                padding-right: 90px;
                margin-left: 90px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            #container #login #box
            {
                 -webkit-border-radius: 150px;
                -moz-border-radius: 100px;
                margin-top: 45px;
                padding-right: 100px;
                padding-left: 0px;
                padding-top: 0px;
                padding-bottom: 30px;
                margin-left: 125px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            #container #login form input
            {
                margin-top: 8px;
                margin-left: 0px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            a.button {
                background-color: #006AB7;
                margin-top: 80px;
                margin-left: 95px;
                 padding: 10px;
                -webkit-appearance: button;
                -moz-appearance: button;
                appearance: button;
                text-decoration: none;
                color: initial;
            }
            a.button2
            {
                color: bisque;
            }
            .submit {
	font-weight: bold;
                -moz-box-shadow: 3px 4px 0px 0px #899599;
	-webkit-box-shadow: 3px 4px 0px 0px #899599;
	box-shadow: 3px 4px 0px 0px #899599;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #bab1ba));
	background:-moz-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-webkit-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-o-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-ms-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:linear-gradient(to bottom, #ededed 5%, #bab1ba 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#bab1ba',GradientType=0);
	background-color:#ededed;
	-moz-border-radius:15px;
	-webkit-border-radius:15px;
	border-radius:15px;
	border:1px solid #d6bcd6;
	display:inline-block;
	cursor:pointer;
	color:black;
	font-family:Arial;
	font-size:17px;
	padding:7px 25px;
	text-decoration:none;
	text-shadow:0px 1px 0px #e1e2ed;
        margin-left: 0px;
}
.submit:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #bab1ba), color-stop(1, #ededed));
	background:-moz-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-webkit-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-o-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-ms-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:linear-gradient(to bottom, #bab1ba 5%, #ededed 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bab1ba', endColorstr='#ededed',GradientType=0);
	background-color:#bab1ba;
}
.submit:active {
	position:relative;
	top:1px;
}
            input { 
	width: 200px; 
	margin-bottom: 0px; 
	background: rgba(0,0,0,0.3);
	border: none;
	outline: none;
	padding: 4px;
	font-size: 13px;
	color: #fff;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
	border: 1px solid rgba(0,0,0,0.3);
	border-radius: 4px;
	box-shadow: inset 0 -5px 45px rgba(100,100,100,0.2), 0 1px 1px rgba(255,255,255,0.2);
	-webkit-transition: box-shadow .5s ease;
	-moz-transition: box-shadow .5s ease;
	-o-transition: box-shadow .5s ease;
	-ms-transition: box-shadow .5s ease;
	transition: box-shadow .5s ease;
}
select {
    color: whitesmoke;
    margin-left: 32px;
    width: 60%;
    padding: 16px 20px;
    border: none;
    border-radius: 4px;
    background-color: grey;
}
        </style>
</head>


    

<body>
    
    <div id="container">
        
    <div id="button">
        </br> <a HREF="javascript:javascript:history.go(-1)">Poprzednia Strona</a>
    </div>
  
        <div id="login">
           <form method="post">
               <span style="margin-left:15px;">Początek:</span></br> <?php echo '<input style="margin-left:25px;" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="HH:MM (Number)" type="time" name="begin" value="'.date("H:i", $tStart).'" /> </br></br>'; ?>
                     
               <span style="margin-left:20px;">Koniec:</span></br> <?php echo '<input style="margin-left:25px;" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="HH:MM (Number)" type="time" name="end" value="'.date("H:i", $tEnd).'" /> </br></br>'; ?>
                <input style="width:100px; margin-left: 25px;" type="submit" value="Akceptuj"/>
           </form>
        </div>
        <div id="button2">
            <a href="option.php">Opcje</a>
        </div>
        
    </div>
        
</body>
</html>
