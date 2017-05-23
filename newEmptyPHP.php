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
       
    if((isset($_POST['submit'])==TRUE && isset($_POST['idLekarza'])==TRUE))
    {
        $_SESSION['fs_idLekarza'] = $_POST['idLekarza'];
        $_SESSION['fs_submit'] = $_POST['submit'];
    }
    elseif((isset($_SESSION['fs_submit']) && isset($_SESSION['fs_idLekarza'])))
    {
        
    }else
    {
        header("location:option.php");exit();
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
                height: 210px;
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
                height: 210px;
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
        <?php
                        $idDniaResult = $connection->query("SELECT `Id_dnia`FROM `dzien_przyjec` WHERE Dzien = '$_SESSION[fs_submit]'");
                        $idDniaRow = mysqli_fetch_assoc($idDniaResult);

                        $sql = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                        $result = $connection->query($sql);
                        $resultRow = mysqli_fetch_assoc($result);
        ?>
    <div id="button">
        <?php
             if(isset($resultRow['Id_pacjenta'])){
        ?>
            </br> <a href="chooseDoctor.php">Ponownie wybierz lekarza</a>
        <?php
             }else  if(isset($resultRow['Id_lekarza'])){
        ?>
            </br> <a href="index.php">Strona główna</a>
            
        <?php
             }
        ?>
    </div>
                     
        <div id="login">
            </br>
                    <?php
                        
                  
//******************************            Lekarz        ************************************************************************************************************************************************************************
         
                        if(isset($resultRow['Id_lekarza'])){
                            
                            echo '<form>'
                            . '<span style="color:green;font-size:24px;font:Georgia, serif;">Sprawdź czas pracy:</span></br></br>';
                                    
                            $timeSql = "SELECT `Godzina_od`, `Godzina_do` FROM `godziny_przyjec` WHERE Id_uzytkownika = '$resultRow[Id_uzytkownika]' and Id_dnia_przyjec = '$idDniaRow[Id_dnia]'";
                            $timeResult = $connection->query($timeSql);
                            $timeRow = mysqli_fetch_assoc($timeResult);

                            $tStart = strtotime($timeRow['Godzina_od']);
                            $tEnd = strtotime($timeRow['Godzina_do']);

                            echo '<span style="color:blue;">Początek:</span> '.date("H:i", $tStart);
                            echo '</br><span style="color:blue;">Koniec:&nbsp&nbsp&nbsp</span> '.date("H:i", $tEnd);
                            
                            echo '</form>';
                            
//******************************            PACJENT         ************************************************************************************************************************************************************************
                            
                        }elseif(isset($resultRow['Id_pacjenta'])){
                               
                                echo '<form method="post">'
                                . '<font size="5" font:Georgia, serif; style="margin-left:15px;">Dostępny czas:</font></br></br>'
                                        . '<input type="hidden" name="lekarzId" id = "lekarzId" value="'.$_SESSION['fs_idLekarza'].'"><select name="time" id="time">';

                                $timeSql = "SELECT `Godzina_od`, `Godzina_do` FROM `godziny_przyjec` WHERE Id_dnia_przyjec = '$idDniaRow[Id_dnia]' and Id_uzytkownika = '$_SESSION[fs_idLekarza]'";
                                $timeResult = $connection->query($timeSql);
                                $timeRow = $timeResult->fetch_assoc();

                                $tStart = strtotime($timeRow['Godzina_od']);
                                $tEnd = strtotime($timeRow['Godzina_do']);
                                
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                   
                                $getTimeResult = $connection->query("SELECT `Godzina` FROM `wizyty_lekarskie` WHERE Id_dnia ='$idDniaRow[Id_dnia]'  and Id_lekarza_prowadzacego = '$_SESSION[fs_idLekarza]'");
                                
                                $hour = array();
                                $arrayLength = 0;
                                while($getTimeRow = mysqli_fetch_assoc($getTimeResult))
                                {
                                    //echo '<script>alert("'.strtotime($getTimeRow['Godzina']).'")</script>';
                                    array_push($hour,strtotime($getTimeRow['Godzina']));
                                    $arrayLength++;
                                }
                                
                                $counterWriteOut = 0;
                                $theSame = 1;
                                
                                while($tStart < $tEnd)
                                {   
                                    for($counter = 0; $counter < $arrayLength; $counter++)
                                    {
                                        //echo '<script>alert("baza: '.$hour[$counter].' czas: '.$tStart.'")</script>';
                                        if(($hour[$counter] == $tStart) || ((strtotime(date("H:i", $tStart)) <=  strtotime(date("H:i"))) && (date("Y-m-d") > $_SESSION['fs_submit'])))
                                        {
                                            $theSame = 0;
                                        }
                                    }
                                    
                                    if($theSame != 0)
                                    {
                                        echo '<option value="'.date("H:i", $tStart).'">'.date("H:i", $tStart).'</option>';
                                        $tStart = strtotime('+ 20 minutes', $tStart);
                                        $counterWriteOut++;
                                    }else
                                    {
                                        $tStart = strtotime('+ 20 minutes', $tStart);
                                    }
                                    $theSame = 1;
                                }
                                
                                if($counterWriteOut == 0){
                                    
                                    echo '<option value="Brak dostępnych wizytk">Brak dostępnych wizyt</option>';
                                
                                }else{
                                    
                                    echo '<input type="submit" class="submit" value="Zatwierdź">';
                                }
                                
                                echo '</select>'
                                       . '</form>';
                               
                                if(isset($_POST['time']) && isset($_POST['lekarzId'])){
                                   
                                    $getTimeResult = $connection->query("SELECT count(*) as q FROM `wizyty_lekarskie` WHERE Id_dnia ='$idDniaRow[Id_dnia]'  and Id_lekarza_prowadzacego = '$_SESSION[fs_idLekarza]' and Id_uzytkownika = '$resultRow[Id_uzytkownika]'");
                                    $timeRow = mysqli_fetch_assoc($getTimeResult);
                                    
                                    if($timeRow['q'])
                                    {
                                        echo '<script>alert("Posiadasz już rezerwacje na dzisiejszy dzien")</script>';
                                    }else
                                    {
                                        $insertDateSql= "INSERT INTO `wizyty_lekarskie`(`Godzina`,`Id_dnia`, `Id_lekarza_prowadzacego`, `Id_pacjenta`, `Id_obslugi`, `Id_uzytkownika`) VALUES('$_POST[time]','$idDniaRow[Id_dnia]', '$_SESSION[fs_idLekarza]', '$resultRow[Id_pacjenta]', NULL, '$resultRow[Id_uzytkownika]')";
                                        $insertDateResult = $connection->query($insertDateSql);
                                        echo '<script> window.location.replace("option.php");</script>';
                                    }
                                    
                                }
                            }
                    ?>
        </div>
        <div id="button2">
            <a href="option.php">Opcje</a>
        </div>
        
    </div>
        
</body>
</html>
