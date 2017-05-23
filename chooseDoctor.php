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
           
           $sql = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                        $result = $connection->query($sql);
                        $resultRow = mysqli_fetch_assoc($result);
                        if(isset($resultRow['Id_lekarza'])){
                            header("Location:option.php");
                        }
                        
        }
        
    if(isset($_SESSION['fs_submit'])==TRUE){
    }
 ?>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
        </style>
        <script src="jquery-3.1.1.min.js"></script>
</head>


    

<body>
    <div id="container">
        
    <div id="button">
        </br> <a href="index.php">Strona Główna</a>
    </div>
        
        <div id="login">
         </br>
                    <?php
                        $sql = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                        $result = $connection->query($sql);
                        $resultRow = mysqli_fetch_assoc($result);
                  
//******************************            Obsluga        ************************************************************************************************************************************************************************
         
                        if(isset($resultRow['Id_obslugi'])){
                            
                            echo '<form method="post">'
                            . 'Wybierz lekarza:</br></br>'
                                    . '<select name="doctor" id="doctor">';
                            
                            $doctorSql = "SELECT `Id_uzytkownika` FROM `godziny_przyjec`";
                            $doctorResult = $connection->query($doctorSql);
                            
                                    if ($doctorResult->num_rows > 0) {
                                        
                                        while($doctorRow = mysqli_fetch_assoc($doctorResult)) {
                                            
                                            $nameSql = "SELECT `Imie`, `Nazwisko` FROM `uzytkownicy` WHERE Id_uzytkownika = '$doctorRow[Id_uzytkownika]'";
                                            $nameResult = $connection->query($nameSql);
                                            $nameRow = mysqli_fetch_assoc($nameResult);
                                            
                                            echo '<option value="'.$nameRow['Imie'].$nameRow['Nazwisko'].'">Początek: '.$nameRow['Imie'].$nameRow['Nazwisko'].'</option>';
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                            
                            echo '</select>'
                                   . '</form>';
                            
//******************************            PACJENT         ************************************************************************************************************************************************************************
                            
                        }elseif(isset($resultRow['Id_pacjenta'])){
                                   ?> <div class="form-group form-group-sm">
                                        <div class="col-sm-14"><?php
                                    echo '<form method="post" action="calendar.php">'
                                . '<font size="5" font:Georgia, serif;>Wybierz lekarza:</font></br></br>'
                                        . '<select name="Id_lekarza" class="form-control">';

                                $doctorSql = "SELECT DISTINCT `Id_uzytkownika` FROM `godziny_przyjec`";
                                $doctorResult = $connection->query($doctorSql);

                                        if ($doctorResult->num_rows > 0) {

                                            while($doctorRow = mysqli_fetch_assoc($doctorResult)) {

                                                $nameSql = "SELECT `Imie`, `Nazwisko`, `Id_uzytkownika` FROM `uzytkownicy` WHERE Id_uzytkownika = '$doctorRow[Id_uzytkownika]'";
                                                $nameResult = $connection->query($nameSql);
                                                $nameRow = mysqli_fetch_assoc($nameResult);

                                                echo '<option value="'.$nameRow['Id_uzytkownika'].'">'.$nameRow['Imie'].' '.$nameRow['Nazwisko'].'</option>';
                                            }
                                            
                                        } else {
                                            echo "Brak lekarzy";
                                        }

                                echo '</select>';
                                        if ($doctorResult->num_rows > 0) {
                                            echo '<input style="margin-top:10px;" class="submit" type="submit" value="Zatwierdź wybór">';
                                        }
                                       echo '</form>';
                                       ?>
                                        </div>
                                   </div>
                                            <?php
                                if(isset($_POST['doctor'])){

                                        echo '<script> window.location.replace("stuffCalendar.php");</script>';
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
