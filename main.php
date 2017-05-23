<?php
    /* session_start();
     if(!isset($_SESSION['logged']))
     {
         header("Location: index.php");
         exit();
     }*/
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

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
    
           if (!isset($_COOKIE['id'])){header("location:index.php");exit();}
           
           $sql = "select Id_uzytkownika from sesja where id = '{$_COOKIE['id']}' and Web = '$_SERVER[HTTP_USER_AGENT]' and Ip = '$_SERVER[REMOTE_ADDR]';";
           $sql2 = "SELECT uzytkownicy.Imie, uzytkownicy.Nazwisko from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and id = '{$_COOKIE['id']}' and Web = '$_SERVER[HTTP_USER_AGENT]' and Ip = '$_SERVER[REMOTE_ADDR]';";
            $q = mysqli_fetch_assoc(mysqli_query($connection,$sql));
            $q2 = mysqli_fetch_assoc(mysqli_query($connection, $sql2));
            if (!empty($q['Id_uzytkownika']))
                {
                    
                    echo "Witaj " . $q2['Imie'];
                } 
            else 
                {
                      header("location:index.php");exit();
                }
        }
    ?>
        <a href="logout.php">Wyloguj sie </a>
    </body>
</html>