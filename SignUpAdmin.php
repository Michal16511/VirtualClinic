<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
 session_start();
require_once 'connect.php';

    if(isset($_POST['email']))
    {
        $allIsOk = TRUE;
        
        $nick = $_POST['nick'];
        
        if((strlen($nick)<3) || (strlen($nick)>20) )
        {
            $allIsOk = FALSE;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
        }
        
        if(ctype_alnum($nick)== FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_nick'] = "Nick może się składać tylko z liter i cyfr (bez polskich znaków).";
        }
        $check = "/^[A-ZĄĘÓŁŚŻŹĆŃ\"\'\?\-]{1}+[A-ZĄĘÓŁŚŻŹĆŃ\"\'\?\- a-ząęółśżźćń]+$/";
        $checkName = "/^[a-zA-ZaáâäaaąčćęeéeëeiiíîiłńoóôöoouúuüuuyýżźnçčšśŚžAÁÂÄAAĄĆČEĘEÉEËIÍÎIIŁŃOÓÔÖOOUÚUÜUUYÝŻŹNßÇOAČŠŽ??'-]+$/";
        $checkStreet = "/^[a-zA-Z0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšśŚžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚ. ÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂\/ð'-]+$/";
        $checkPostCode = "/^\d{2}-\d{3}$/";
        $checkPlace = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšśŚžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚ ÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð-]+$/";
        $name=$_POST['name'];
         if(preg_match($checkName, $name) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_name'] = "Imie może się składać tylko z liter i cyfr (Z polskimi znakami), oraz pierwsza litera musi być duża.";
        }
        if(strlen($name)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_name'] = "To pole nie może pozostać puste.";
        }
            
         $surname=$_POST['surname'];
         if(preg_match($checkName, $surname) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_surname'] = "Nazwisko może się składać tylko z liter i cyfr, oraz pierwsza litera musi być duża.";
        }
        if(strlen($surname)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_surname'] = "To pole nie może pozostać puste.";
        }
        
         $place=$_POST['place'];
         if(preg_match($checkPlace, $place) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_place'] = "Miejscowość może się składać tylko z liter, musi zawierać minimum 2 znaki, oraz pierwsza litera musi być duża.";
        }
        if(strlen($place)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_place'] = "To pole nie może pozostać puste.";
        }
        
        $street=$_POST['street'];
         if(preg_match($checkStreet, $street) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_street'] = "Ulica może się składać tylko z liter i cyfr (Z polskimi znakami), musi zawierać minimum 2 znaki, oraz pierwsza litera musi być duża.";
        }
        if(strlen($street)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_street'] = "To pole nie może pozostać puste.";
        }

        $houseNumber = $_POST['houseNumber'];
        
        if($houseNumber < 1)
        {
            $allIsOk = FALSE;
            $_SESSION['e_houseNumber'] = "Numer domu musi być wartością dodatnią";
        }
        
        
        
        $phoneNumber = $_POST['phoneNumber'];
        
         if(preg_match("/^[1234567890]+$/", $phoneNumber) == FALSE) 
         {    
             $allIsOk = FALSE;
             $_SESSION['e_phoneNumber'] = "Numer telefonu musi zawierać same cyfry.";
         }
        if((strlen($phoneNumber)<9) || (strlen($phoneNumber) > 11))
        {
            $allIsOk = FALSE;
            $_SESSION['e_phoneNumber'] = "Numer telefonu musi zawierać od 9 do 12 cyfr.";
        }
        
        $dateOfBirth = $_POST['dateOfBirth'];
        
        if($dateOfBirth > date("Y-m-d",time()))
        {
            $allIsOk = FALSE;
            $_SESSION['e_dateOfBirth'] = "Data urodzenia nie może być datą z przyszłości";
        }
        if($dateOfBirth == 0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_dateOfBirth'] = "Data urodzenia nie może być pusta";
        }
        
        $email=$_POST['email'];
        $emailb= filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($emailb, FILTER_VALIDATE_EMAIL)== false) || $email!= $emailb)
        {
            $allIsOk = FALSE;
            $_SESSION['e_email'] = "Podaj poprawny adres email";
        
        }
        
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        
        if((strlen($password1)<8) || (strlen($password1)>20) )
        {
            $allIsOk = false;
            $_SESSION['e_password'] = "Hasło musi mieć od 8 do 20 znaków";
        }
        
        if($password1 != $password2)
        {
            $allIsOk = false;
            $_SESSION['e_password'] = "Podane hasła są różne";
        
        }
        
         $postalCode = $_POST['postalCode'];
        if(preg_match($checkPostCode, $postalCode) == FALSE) 
         {    
             $allIsOk = FALSE;
             $_SESSION['e_postalCode'] = "Kod pocztowy musi zawierać same cyfry i myślnik np: 23-210";
         }
        if($postalCode < 1)
        {
            $allIsOk = FALSE;
            $_SESSION['e_postalCode'] = "Kod pocztowy musi być wartością dodatnią";
        }
        $secret = "6LcW6AwUAAAAALjIZp1o_JdBw-ZzUCDW1yNerqqH";
	/*$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$answer = json_decode($check);
		
		if ($answer->success==false)
		{
			$allIsOk=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
        */
        /*if(!isset($_POST['regulamin']))
        {
            $allIsOk = false;
            $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
        }*/
        
        $_SESSION['fs_nick'] = $nick;
        $_SESSION['fs_email'] =  $email;
        $_SESSION['fs_password1'] =  $password1;
        $_SESSION['fs_password2'] =  $password2;
        $_SESSION['fs_name'] =  $name;
        $_SESSION['fs_surname'] =  $surname;
        $_SESSION['fs_place'] =  $place;
        $_SESSION['fs_street'] =  $street;
        $_SESSION['fs_houseNumber'] =  $houseNumber;
        
        $_SESSION['fs_dateOfBirth'] = $dateOfBirth;
        $_SESSION['fs_phoneNumber'] = $phoneNumber;
        $_SESSION['fs_postalCode'] = $postalCode;
        if(isset($_POST['regulamin']))$_SESSION['fs_regulamin'] = TRUE;
        
        
        // SALT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
             $connection= new mysqli($host,$db_user, $db_password, $db_name);
             mysqli_query($connection, "SET CHARSET utf8");
             mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
             
            
             if ($connection->connect_errno!=0) 
                 {
                    throw new Exception(mysqli_connect_errno());
                 } 
                 else
                 {
                    $postalCode = htmlentities($postalCode);
                    $postalCode = mysqli_real_escape_string($connection, $postalCode);
                    
                    $phoneNumber = htmlentities($phoneNumber);
                    $phoneNumber = mysqli_real_escape_string($connection, $phoneNumber);
                    
                    
                    $houseNumber = htmlentities($houseNumber);
                    $houseNumber = mysqli_real_escape_string($connection, $houseNumber);
                    
                    $street = htmlentities($street);
                    $street = mysqli_real_escape_string($connection, $street);
                    
                    $place = htmlentities($place);
                    $place = mysqli_real_escape_string($connection, $place);
                    
                    $surname = htmlentities($surname);
                    $surname = mysqli_real_escape_string($connection, $surname);
                    
                    $name = htmlentities($name);
                    $name = mysqli_real_escape_string($connection, $name);
                    
                    $password2 = htmlentities($password2);
                    $password2 = mysqli_real_escape_string($connection, $password2);
                    
                    $password1 = htmlentities($password1);
                    $password1 = mysqli_real_escape_string($connection, $password1);
                    
                    $nick = htmlentities($nick);
                    $nick = mysqli_real_escape_string($connection, $nick);
                    
                    $email = htmlentities($email);
                    $email = mysqli_real_escape_string($connection, $email);
                    
                    $salt = uniqid(mt_rand(), true);
                    $stringToHash = $password1.$salt;
                    $passwordHash = sha1($stringToHash);

                     $result = $connection->query("Select Id_uzytkownika from uzytkownicy where E_mail='$email'");

                     if(!$result)  throw new Exception( $connection->error);
                     
                     $numberOfEmails = $result->num_rows;
                     if($numberOfEmails>0)
                     {
                         $allIsOk = false;
                         $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email";
                     }
                    
                      $result = $connection->query("Select Id_uzytkownika from uzytkownicy where Login='$nick'");

                     if(!$result)  throw new Exception( $connection->error);
                     
                     $numberOfNicks = $result->num_rows;
                     if($numberOfNicks>0)
                     {
                         $allIsOk = false;
                         $_SESSION['e_nick']="Istnieje już konto przypisane do tego loginu.";
                     }
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                     
                if( $allIsOk == TRUE)
                {
                    
                    
                    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                
                    $placeResult = $connection->query("SELECT `Id_miejscowosci`FROM `miejscowosci` WHERE Nazwa='$place'");
                    
                    if(!$placeResult)  throw new Exception( $connection->error);
                     
                     $numberOfplace = $placeResult->num_rows;
                     
                     if($numberOfplace>0)
                     {
                         $placeRow = mysqli_fetch_assoc($placeResult);
                     }else
                     {
                        $connection->query("INSERT INTO `miejscowosci`(`Nazwa`) VALUES ('$place')");
                        $placeResult = $connection->query("SELECT `Id_miejscowosci`FROM `miejscowosci` WHERE Nazwa='$place'");
                        $placeRow = mysqli_fetch_assoc($placeResult);
                        
                        if(!$placeResult)  throw new Exception( $connection->error);
                     }
                
                    $postalCodeResult = $connection->query("SELECT `Id_kodu_pocztowego` FROM `kodypocztowe` WHERE Kod_pocztowy='$postalCode'");
                    
                    if(!$postalCodeResult)  throw new Exception( $connection->error);
                     
                     $numberOfpostalCode = $postalCodeResult->num_rows;
                     
                     if($numberOfpostalCode>0)
                     {
                         
                         $postalCodeRow = mysqli_fetch_assoc($postalCodeResult);
                     
                     }else
                     {
                        $connection->query("INSERT INTO `kodypocztowe`(`Kod_pocztowy`, `Id_miejscowosci`) VALUES ('$postalCode', '$placeRow[Id_miejscowosci]')");
                        $postalCodeResult = $connection->query("SELECT `Id_kodu_pocztowego` FROM `kodypocztowe` WHERE Kod_pocztowy='$postalCode'");
                        $postalCodeRow = mysqli_fetch_assoc($postalCodeResult);
                        
                        if(!$postalCodeResult)  throw new Exception( $connection->error);
                     }
                     
                    $streetResult = $connection->query("SELECT `Id_ulicy` FROM `ulice` WHERE Nazwa='$street'");
                    
                    if(!$streetResult)  throw new Exception( $connection->error);
                     
                     $numberOfStreets = $streetResult->num_rows;
                     
                     if($numberOfStreets>0)
                     {
                         $streetRow = mysqli_fetch_assoc($streetResult);
                     }else
                     {
                        $connection->query("INSERT INTO `ulice`(`Nazwa`, `Id_kodu_pocztowego`) VALUES ('$street', '$postalCodeRow[Id_kodu_pocztowego]')");
                        $streetResult = $connection->query("SELECT `Id_ulicy` FROM `ulice` WHERE Nazwa='$street'");
                        $streetRow = mysqli_fetch_assoc($streetResult);
                        
                        if(!$streetResult)  throw new Exception( $connection->error);
                     } 
                     
                    if($connection->query("INSERT INTO `uzytkownicy`(`Id_uzytkownika`, `Imie`, `Nazwisko`, `E_mail`, `Login`, `Haslo`,    `Password_hash`,`Salt`, `Numer_telefonu`, `Data_urodzenia`, `Numer_domu`,     `Id_ulicy`,              `Id_pacjenta`, `Id_lekarza`, `Id_obslugi`, `Id_admina`)"     
                                                         . " VALUES (     NULL,       '$name', '$surname', '$email', '$nick','$password1','$passwordHash','$salt','$phoneNumber',    '$dateOfBirth',  '$houseNumber' ,'$streetRow[Id_ulicy]',        NULL,         NULL,         NULL,     '1')"))      
                    {
                        $_SESSION['signUpAccepted'] = true;
                        header('Location: Welcome.php');
                    }
                    else
                    {
                         throw new Exception($connection->error);
                    }
                }
                        
                         $connection->close();
                 }
        } catch (Exception $ex) {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<span style="color:red;"></br>Informacja developerska: '.$ex.'</span>';
        }
    }
     
 ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Załóż konto</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        
        <link href="css/angelika.css" rel="stylesheet" type="text/css"/>
    </head>
    
    
    <body>
    
        <div id="container">
        
            <div id="button">
                <a href="index.php">Strona Główna</a>
            </div>
            
            <div id="login">
                
                <form method="post">
                    Nickname:</br> <input type="text" value="<?php 
                        if(isset($_SESSION['fs_nick']))
                        {
                            echo $_SESSION['fs_nick'];
                            unset($_SESSION['fs_nick']);
                        }

                         ?>" name="nick" /> </br> 
                    <?php
                        if( isset($_SESSION['e_nick']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_nick'].'</span></div>';
                            unset($_SESSION['e_nick']);
                        }
                    ?>

                    E-mail:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_email']))
                    {
                        echo $_SESSION['fs_email'];
                        unset($_SESSION['fs_email']);
                    }
                    ?>" name="email" /> </br> 

                    <?php
                        if( isset($_SESSION['e_email']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_email'].'</span></div>';
                            unset($_SESSION['e_email']);
                        }
                    ?>

                    Hasło:</br> <input type="password" value="<?php
                    if(isset($_SESSION['fs_password1']))
                    {
                        echo $_SESSION['fs_password1'];
                        unset($_SESSION['fs_password1']);
                    }
                    ?>"  name="password1" /> </br>

                        <?php
                        if( isset($_SESSION['e_password']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_password'].'</span></div>';
                            unset($_SESSION['e_password']);
                        }
                    ?>

                    Powtórz hasło:</br> <input type="password" value="<?php
                    if(isset($_SESSION['fs_password2']))
                    {
                        echo $_SESSION['fs_password2'];
                        unset($_SESSION['fs_password2']);
                    }
                    ?>"  name="password2" /> </br>

                    Imie:</br> <input type="text"  value="<?php
                    if(isset($_SESSION['fs_name']))
                    {
                        echo $_SESSION['fs_name'];
                        unset($_SESSION['fs_name']);
                    }
                    ?>"  name="name" /> </br>
                    <?php
                        if(isset($_SESSION['e_name']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_name'].'</span></div>';
                            unset($_SESSION['e_name']);
                        }
                    ?>

                    Nazwisko:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_surname']))
                    {
                        echo $_SESSION['fs_surname'];
                        unset($_SESSION['fs_surname']);
                    }
                    ?>"  name="surname" /> </br>
                    <?php
                        if(isset($_SESSION['e_surname']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_surname'].'</span></div>';
                            unset($_SESSION['e_surname']);
                        }
                    ?>

                    Miejscowość:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_place']))
                    {
                        echo $_SESSION['fs_place'];
                        unset($_SESSION['fs_place']);
                    }
                    ?>"  name="place" /> </br>
                     <?php
                        if(isset($_SESSION['e_place']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_place'].'</span></div>';
                            unset($_SESSION['e_place']);
                        }
                    ?>
                    
                    Kod pocztowy:</br> <input type="text" pattern="[0-9]{2}\-[0-9]{3}" title="Format xx-xxx" value="<?php
                    if(isset($_SESSION['fs_postalCode']))
                    {
                        echo $_SESSION['fs_postalCode'];
                        unset($_SESSION['fs_postalCode']);
                    }
                    ?>"   name="postalCode" /> </br>
                    <?php
                        if(isset($_SESSION['e_postalCode']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_postalCode'].'</span></div>';
                            unset($_SESSION['e_postalCode']);
                        }
                    ?>
                    
                    Ulica:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_street']))
                    {
                        echo $_SESSION['fs_street'];
                        unset($_SESSION['fs_street']);
                    }
                    ?>"  name="street" /> </br>
                     <?php
                        if(isset($_SESSION['e_street']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_street'].'</span></div>';
                            unset($_SESSION['e_street']);
                        }
                    ?>

                    Numer domu:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_houseNumber']))
                    {
                        echo $_SESSION['fs_houseNumber'];
                        unset($_SESSION['fs_houseNumber']);
                    }
                    ?>"   name="houseNumber" /> </br>
                    <?php
                        if(isset($_SESSION['e_houseNumber']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_houseNumber'].'</span></div>';
                            unset($_SESSION['e_houseNumber']);
                        }
                    ?>

                    Data urodzenia:</br> <input type="date" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" title="YYYY-MM-DD" value="<?php
                    if(isset($_SESSION['fs_dateOfBirth']))
                    {
                        echo  $_SESSION['fs_dateOfBirth'];
                        unset($_SESSION['fs_dateOfBirth']);
                    }
                    ?>"  name="dateOfBirth" /> </br>
                     <?php
                        if(isset($_SESSION['e_dateOfBirth']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_dateOfBirth'].'</span></div>';
                            unset($_SESSION['e_dateOfBirth']);
                        }
                    ?>

                    Numer telefonu:</br> <input type="text" value="<?php
                    if(isset($_SESSION['fs_phoneNumber']))
                    {
                        echo  $_SESSION['fs_phoneNumber'];
                        unset($_SESSION['fs_phoneNumber']);
                    }
                    ?>"  name="phoneNumber" /> </br>
                    <?php
                        if(isset($_SESSION['e_phoneNumber']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_phoneNumber'].'</span></div>';
                            unset($_SESSION['e_phoneNumber']);
                        }
                    ?>
                    


                    <!--<div class="g-recaptcha" data-sitekey="6LcW6AwUAAAAAJw26ym23eIE9uv915JI6_9k0xyj"></div>-->

                    <?php
                     /*   if( isset($_SESSION['e_bot']))
                        {
                            echo '<div class="error"><span>'.$_SESSION['e_bot'].'</span></div>';
                            unset($_SESSION['e_bot']);
                        }*/
                    ?>
                    
                    
                    <input type="submit" value="Zarejestruj się"/>
                </form>

            </div>
            
           <div id="button2">
               <a href="option.php">Opcje</a>
            </div>
    </div>
        
    </body>
</html>