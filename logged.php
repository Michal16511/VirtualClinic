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
        }
    
 ?>
<html>

<head>
	<title>Virtual Clinic</title>
	<meta  charset="UTF-8" />
        
        <link href="css/logged.css" rel="stylesheet" type="text/css" />
</head>


    

<body>
    
    <div id="container">
        
    <div id="button">
        </br> <a href="index.php">Strona Główna</a>
    </div>
  
        <div id="login">
           
                 </br>
                 <a href="option.php" class="button"> Jesteś już zalogowany/a.</br> Przejdź do opcji użytkownika.</a> 
           
        </div>
        <div id="button2">
            <a href="about.php">O nas</a>
        </div>
        
    </div>
        
</body>
</html>