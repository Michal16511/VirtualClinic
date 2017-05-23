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
        echo $_POST['time'];
        
        if(isset($_POST['time'])){
                                     
            $insertDateSql= "INSERT INTO `wizyty_lekarskie`(`Id_dnia`, `Godzina`, `Id_lekarza`, `Id_pacjenta`, `Id_obslugi`, `Id_uzytkownika`) VALUES('$idDniaRow[Id_dnia]', '$_POST[time]', '$resultRow[Id_pacjenta]', NULL, '$resultRow[Id_uzytkownika]')";
                               $connection->query($insertDateSql);
            header("location:index.php");
        }
                                 
                                 
        
   
?>