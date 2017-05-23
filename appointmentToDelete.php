
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
        $q = $_REQUEST["q"];
        
        $sql2 = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
        $result2 = $connection->query($sql2);
        $result2Row = mysqli_fetch_assoc($result2);
        
        $appointmentSql = "SELECT `Id_wizyty`, `Id_dnia`, `Godzina`, `Id_lekarza_prowadzacego`, `Id_pacjenta` FROM `wizyty_lekarskie` WHERE Id_uzytkownika = '$result2Row[Id_uzytkownika]' and Id_lekarza_prowadzacego = '$q'";
        $appointmentResult = $connection->query($appointmentSql);
        
        $i = 1;
        if($appointmentResult->num_rows > 0)
        {
            echo '</br></br></br>'
        . '<form method="post">'
                . '<select name="Wizyta" id="Wizyta">';
        
        while($appointmentRow = mysqli_fetch_assoc($appointmentResult)) {
            
            $daySql = "SELECT `Dzien` FROM `dzien_przyjec` WHERE Id_dnia = '$appointmentRow[Id_dnia]'";
            $dayResult = $connection->query($daySql);
            $dayRow = mysqli_fetch_assoc($dayResult);
            
            if(strtotime($dayRow['Dzien']) >  time())
            {
                echo '<option value="'.$appointmentRow['Id_wizyty'].'">'.$i.'. Data: '.$dayRow['Dzien'].' Czas: '.$appointmentRow['Godzina'].'</option>';
                // echo $i.'. Data: '.$dayRow['Dzien'].' Czas: '.$appointmentRow['Godzina'].'</br>';
                $i++;
            }
        }
        echo '</select>'
        . '<input type="submit" value="zatwierdź">'
        . '</form></br></br></br>';
        }else
        {
            echo '</br></br></br>Brak Wizyt do usuniecia'
            . '</br></br></br>';
        }
        
        
        
?>