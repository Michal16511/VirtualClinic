<?php
    session_start();
    require_once 'connect.php';
    $connection= @new mysqli($host,$db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    

    // Check connection
    if ($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    } 
    else{
            foreach ($_COOKIE as $k=>$v) {
            $_COOKIE[$k] = mysqli_real_escape_string($connection, $v);
        }       
           if (!isset($_COOKIE['id'])){header("location:optionLogOut.php");exit();}
        }
        
    $sql2 = "SELECT sesja.Id_sesji,uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika, uzytkownicy.Id_admina  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                    
    $result2 = $connection->query($sql2);
    $result2Row = mysqli_fetch_assoc($result2);
    $value = 1;    
    
     if(!empty($result2Row['Id_sesji']))
    {
    
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
                height: 100px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                
            }
            
            #button
            {
                margin-left: 8%;
                margin-top: 14.3%;
                float:left;
                width: 200px;
                height: 100px;
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
                margin-top: 6.2%;
                float:left;
                width: 200px;
                height: 100px;
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
                text-decoration: none;
                float:left;
                margin-left: 15%;
                margin-top: 3%;
                 -webkit-border-radius: 150px;
                -moz-border-radius: 150px;
                border-radius:150px;
                width: 300px;
                height: 100px;
                overflow:hidden;
            }
            #container #box
            {
                float:left;
                margin-left: 15%;
                margin-top: 3%;
                 -webkit-border-radius: 0px;
                -moz-border-radius: 0px;
                width: 300px;
                height: 500px;
                overflow:hidden;
            }
            
            #container #login #option
            {
                font-size: 31px;
                padding-left: 0px;
                padding-top: 24px;
                padding-bottom: 0px;
                margin-left: 42px;
                margin-top: 10px;
                margin-bottom: 30px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            a.button {
                    margin-left: 20px;
                    text-align: center;
                    width: 200px;
                    background-color:#44c767;
                    -moz-border-radius:28px;
                    -webkit-border-radius:28px;
                    border-radius:28px;
                    border:1px solid #18ab29;
                    display:inline-block;
                    cursor:pointer;
                    color:#ffffff;
                    font-family:Arial;
                    font-size:17px;
                    padding:16px 31px;
                    text-decoration:none;
                    text-shadow:0px 1px 0px #2f6627;
            }
             a.button:hover {
                    background-color:#5cbf2a;
            }
             a.button:active {
                    position:relative;
                    top:1px;
            }
            
            
        </style>
</head>

<body>
    
    <div id="container">
        
        <div id="button">
            </br> <a href="index.php">Strona Główna</a>
        </div>
  
        <div id="login">
            <div id="option">
                 Wybierz opcje:</br></br></br>
            </div>
           
        </div>
        
        <div id="box">
            <a href="logout.php" class="button">Wyloguj się</a></br></br>
            <?php
                    
//******************************            PACJENT         ************************************************************************************************************************************************************************
                 
                        if(!empty($result2Row['Id_pacjenta']))
                        {
                            echo '<a href="chooseDoctor.php" class="button">Rejestracja wizyty</a></br></br>';    
                            echo '<a href="appointment.php" class="button">Wyświetl swoje wizyty</a></br></br>';  
                            echo '<a href="deleteAppointment.php" class="button">Usuń wizyte</a></br></br>';
                        }else if(!empty($result2Row['Id_obslugi']))
                        {
                                    
                        }else
//******************************            Lekarz         ************************************************************************************************************************************************************************
                                 
                        if(!empty($result2Row['Id_lekarza']))
                        {
                            echo '<a href="calendar.php" class="button">Dodaj/Edytuj czas pracy</a></br></br>';
                            echo '<a href="stuffCalendar.php" class="button">Zobacz dni pracy</a></br></br>';
                            echo '<a href="stuffCalendar.php?value='.$value.'" class="button">Usuń dzień pracy</a></br></br>';
                        }
                        
//******************************            Admin        ************************************************************************************************************************************************************************
                             
                        else if(!empty($result2Row['Id_admina']))
                        {
                             echo '<a href="signUpDoctor.php" class="button">Dodaj Lekarza</a></br></br>';    
                             echo '<a href="signUpAdmin.php" class="button">Dodaj Admina</a></br></br>';    
                        }
                 ?>
            
        </div>
        
        <div id="button2">
            <a href="about.php">O nas</a>
        </div>
              
        <div style="clear: both;"></div>
    </div>
    
</body>
</html>

<?php }else{
    
unset($_COOKIE['id']);
setcookie ("id", "", time() - 3600);
header("location:index.php"); 

}
?>