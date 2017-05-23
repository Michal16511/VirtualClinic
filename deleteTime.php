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
    

    $sql2 = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                    
    $result2 = $connection->query($sql2);
    $result2Row = mysqli_fetch_assoc($result2);

//******************************            Lekarz         ************************************************************************************************************************************************************************
                        
    if(!empty($result2Row['Id_lekarza'])){
        
        if(isset($_POST['idLekarza'])==TRUE && isset($_POST['submit'])==TRUE)
        {
            $idLekarza = $_POST['idLekarza'];
            $day = $_POST['submit'];
            $idDniaResult = $connection->query("SELECT `Id_dnia`FROM `dzien_przyjec` WHERE Dzien = '$day'");
            $idDniaRow = mysqli_fetch_assoc($idDniaResult);
            
            $isPatientResult = $connection->query("SELECT `Id_wizyty`FROM `wizyty_lekarskie` WHERE wizyty_lekarskie.Id_lekarza_prowadzacego ='$idLekarza'  and Id_dnia ='$idDniaRow[Id_dnia]'");
            
            if((mysqli_num_rows($isPatientResult)>0) || ($day < date("Y-m-d")) )
            {
                header("location:stuffCalendar.php?value=alert");
            }
            else{
                
                $connection->query("DELETE FROM `godziny_przyjec` WHERE Id_uzytkownika='$idLekarza' and Id_dnia_przyjec = '$idDniaRow[Id_dnia]'");
                header("location:stuffCalendar.php?value=1");
            }
            
        }
        else {header("location:option.php");}
    }else{
        header("location:option.php");
    }
?>