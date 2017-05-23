<?php
    session_start();
    
    if((!isset($_POST['login'])) || (!isset($_POST['password'])) )
    {
        header("Location: index.php");
        exit();
    }
  require_once 'connect.php';  
    
    $connection= @new mysqli($host,$db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } 
    else{
        $password = $_POST['password'];
        $password = htmlentities($password);
        $password = mysqli_real_escape_string($connection, $password);
        
        $_POST['login'] = htmlentities($_POST['login']);
        $_POST['login'] = mysqli_real_escape_string($connection, $_POST['login']);
        
        $selectSalt = mysqli_fetch_assoc(mysqli_query($connection,"SELECT `Salt`FROM `uzytkownicy` WHERE Login ='{$_POST['login']}' "));
        $salt = $selectSalt['Salt'];
        
        $passwordWithSalt = $password.$salt;
        
        
        $hashPassword = sha1($passwordWithSalt);
      
        
        $q = mysqli_fetch_assoc( mysqli_query($connection, "select count(*) cnt, Id_uzytkownika, Id_pacjenta, Id_obslugi, Id_lekarza, Id_admina from uzytkownicy where login='{$_POST['login']}' and Password_hash = '{$hashPassword}';"));
        
        if ($q['cnt']) 
        {   
            $id = md5(rand(-10000,10000) . microtime()) . md5(crc32(microtime()) . $_SERVER['REMOTE_ADDR']);
            mysqli_query($connection, "delete from sesja where Id_uzytkownika = '$q[Id_uzytkownika]';"); 	
            if(!empty($q['Id_pacjenta']))
            {
                mysqli_query($connection, "insert into sesja (Id_uzytkownika, id, Ip, Web, Id_pacjenta, Id_obslugi, Id_lekarza) values ('$q[Id_uzytkownika]','$id','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]','$q[Id_pacjenta]',NULL,NULL)");
            }
            if(!empty($q['Id_obslugi']))
            {
                mysqli_query($connection, "insert into sesja (Id_uzytkownika, id, Ip, Web, Id_pacjenta, Id_obslugi, Id_lekarza) values ('$q[Id_uzytkownika]','$id','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]',NULL,'$q[Id_obslugi]',NULL)");
            }
            if(!empty($q['Id_lekarza']))
            {
                mysqli_query($connection, "insert into sesja (Id_uzytkownika, id, Ip, Web, Id_pacjenta, Id_obslugi, Id_lekarza) values ('$q[Id_uzytkownika]','$id','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]',NULL,NULL,'$q[Id_lekarza]')");
            }
            if(!empty($q['Id_admina']))
            {
                mysqli_query($connection, "insert into sesja (Id_uzytkownika, id, Ip, Web, Id_pacjenta, Id_obslugi, Id_lekarza, Id_admina) values ('$q[Id_uzytkownika]','$id','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]',NULL,NULL,NULL,'$q[Id_admina]')");
            }
            if (! mysqli_errno($connection))
            {
                setcookie("id", $id);
                echo "zalogowano pomyślnie!";
                header("location:logged.php");
            } 
            else 
            {
                    header("location:login.php?value=alert2");
                    echo "błąd podczas logowania! "; echo '<a href="index.php">Powrót do menu głównego</a>';
                    
            }

        } 
        else 
        {
            header("location:login.php?value=alert2");
            echo "Błędnie wprowadzono dane logowania, prosze spróbować ponownie "; echo '<a href="login.php">Zaloguj</a>';
        } 
        
        }
             mysqli_close($connection);
?>