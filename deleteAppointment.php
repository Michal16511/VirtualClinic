<?php
    session_start();
    require_once 'connect.php';
    $connection= @new mysqli($host,$db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } 
    else{
            foreach ($_COOKIE as $k=>$v) {
            $_COOKIE[$k] = mysqli_real_escape_string($connection, $v);
        }       
           if (!isset($_COOKIE['id'])){header("location:optionLogOut.php");exit();}
        }
                    $sql2 = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                    
                    $result2 = $connection->query($sql2);
                    $result2Row = mysqli_fetch_assoc($result2);
                    $value = 1;
//******************************            PACJENT         ************************************************************************************************************************************************************************
                 
                        if(!empty($result2Row['Id_obslugi'])){
                            
                            header("location:option.php");
                        }
//******************************            Lekarz         ************************************************************************************************************************************************************************
                                 
                        if(!empty($result2Row['Id_lekarza'])){
                            
                            header("location:option.php");
                        }
                        
                 
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                               //SELECT DISTINCT `Id_lekarza_prowadzacego` FROM `wizyty_lekarskie` WHERE Id_uzytkownika = '$result2Row[Id_uzytkownika]' and Id_dnia in (SELECT Id_dnia from dzien_przyjec where dzien_przyjec.Dzien > CURRENT_DATE())
                                //$appointmentSql = "SELECT DISTINCT `Id_lekarza_prowadzacego` FROM `wizyty_lekarskie` WHERE Id_uzytkownika = '$result2Row[Id_uzytkownika]' and Id_dnia";
                                $appointmentSql = "SELECT DISTINCT `Id_lekarza_prowadzacego` FROM `wizyty_lekarskie` WHERE Id_uzytkownika = '$result2Row[Id_uzytkownika]' and Id_dnia in (SELECT Id_dnia from dzien_przyjec where dzien_przyjec.Dzien > CURRENT_DATE())";
                                $appointmentResult = $connection->query($appointmentSql);

                                        
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
                background:no-repeat;
                background-image:url('images/doktor.jpg');
                background-size: 1700px 880px;
                
            }
            
            
            
            #button
            {
                margin-left: 8%;
                margin-top: 15.3%;
                float:left;
                width: 200px;
                height: 150px;
                border-radius: 10px;
                opacity: 0.95;
                text-align: center;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                 
                overflow:hidden;
                font-size: 30;
            }
            
            #button2
            {
                margin-left: 5.3%;
                margin-top: 16.9%;
                float: left;
                width: 200px;
                height: 60px;
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
           
            #container
            {
                margin-left: 90px;
                margin-top: 10px;
                margin-bottom: 30px;
                
            }
            
            a.button {
                width: 200px;
                background-color: #006AB7;
                margin-top: 0px;
                margin-left: 40px;
                -webkit-appearance: button;
                -moz-appearance: button;
                appearance: button;
                text-align: center;
                text-decoration: none;
                color: initial;
            }
            #doctor
            {
                padding-left: 0px;
                background-image: url('images/login.jpg');
                float:left;
                margin-left: 13%;
                margin-top: 10%;
                 -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                border-radius: 50px;
                width: 450px;
                height: 200px;
                overflow:hidden;
            }
            #doctor #Id_lekarza
            {
                margin-top:80px;
            }
            #click{
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                border-radius:30px;
                cursor:pointer;
                appearance: button;
                background: #80d4ff;
                padding:10px;
                margin-top:11px;
                margin-left: 170px;
                width: 90px;
                height: 40px;
                clear:both;
            }
            #panel
            {
                margin-top: 10px;
                text-align: center;
                background-image: url('images/login.jpg');
                float:left;
                margin-left: 500px;
                border-radius: 150px;
                -webkit-border-radius: 50px;
                -moz-border-radius: 50px;
                width: 450px;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script> 
        
            $(document).ready(function(){
                $("#click").click(function(){
                    
                    var Id_lekarza = $("#Id_lekarza").val();
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("panel").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "appointmentToDelete.php?q=" + Id_lekarza, true);
                    xmlhttp.send();
                        $("#panel").slideToggle("slow");
                });
            });
        
        </script>
</head>

<body>
    <div id="container">
        <div id="button">
           <a href="index.php">Strona Główna</a>
        </div>
         
            <div id="doctor">
                <div class="form-group form-group-sm">
                    
                
                    <?php
                       if (mysqli_num_rows($appointmentResult) > 0) {
                           echo '<div class="col-sm-5">';
                           echo '<select name="Id_lekarza" style ="margin-left:130px; margin-top: 65px;" class="form-control" id="Id_lekarza">';
                           
                            while($appointmentRow = mysqli_fetch_assoc($appointmentResult)) {

                                $nameSql = "SELECT `Imie`, `Nazwisko`, `Id_uzytkownika` FROM `uzytkownicy` WHERE Id_uzytkownika = '$appointmentRow[Id_lekarza_prowadzacego]'";
                                $nameResult = $connection->query($nameSql);
                                $nameRow = mysqli_fetch_assoc($nameResult);

                                echo '<option value="'.$nameRow['Id_uzytkownika'].'">'.$nameRow['Imie'].' '.$nameRow['Nazwisko'].'</option>';
                            }?>
                           
                        <?php
                        }else{
                            echo '<div>';
                            echo '<p style="margin-top:45px; margin-left: 20px;font-weight: bold;
                color: #cc0066; font-size:25px;">Brak wizyt do usunięcia</p>'
                            . '<p style="margin-top:15px;font-weight: bold;
                color: #cc0066; margin-left: 55px;">Można usunąć tylko te wizyty,</br> które się jeszcze nie odbyły</p>';
                        }
                    
                echo '</select>';
                  
                       if (mysqli_num_rows($appointmentResult) > 0) 
                       {
                      
                            echo'<div id="click">Zatwierdź</div>';
                       }
                ?>
            </div>
                </div>
            </div>
            
            
     
        <div id="button2">
            <a href="option.php">Opcje</a>
        </div>
        <div style="clear: both;"></div>
        
        <div id="panel"></div>
        
        
    </div>
</body>
</html>
<?php
        if(isset($_POST['Wizyta']))
        {
           $connection->query("DELETE FROM `wizyty_lekarskie` WHERE Id_wizyty = '$_POST[Wizyta]'");
           echo '<script>alert("Udalo sie usunac wizyte.")</script>';
           echo '<script>window.location.replace("option.php")</script>';
        }
?>