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
        $check = '/^[A-ZĄĘÓŁŚŻŹĆŃ]{1}+[A-ZĄĘÓŁŚŻŹĆŃ a-ząęółśżźćń]+$/';
        $name=$_POST['name'];
         if(preg_match($check, $name) == FALSE)
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
         if(preg_match($check, $surname) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_surname'] = "Nazwisko może się składać tylko z liter i cyfr (Z polskimi znakami), oraz pierwsza litera musi być duża.";
        }
        if(strlen($surname)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_surname'] = "To pole nie może pozostać puste.";
        }
        
         $place=$_POST['place'];
         if(preg_match($check, $place) == FALSE)
        {
            $allIsOk = FALSE;
            $_SESSION['e_place'] = "Miejscowość może się składać tylko z liter i cyfr (Z polskimi znakami), musi zawierać minimum 2 znaki, oraz pierwsza litera musi być duża.";
        }
        if(strlen($place)==0)
        {
            $allIsOk = FALSE;
            $_SESSION['e_place'] = "To pole nie może pozostać puste.";
        }
        
        $street=$_POST['street'];
         if(preg_match($check, $street) == FALSE)
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
        
        $checkNumber = '/^[1234567890]+$/';
        $pesel = $_POST['pesel'];
        if(preg_match($checkNumber, $pesel) == FALSE)
         {
             $allIsOk = FALSE;
             $_SESSION['e_pesel'] = "Pesel musi zawierać same cyfry.";
         }
        if(strlen($pesel)!=11)
        {
            $allIsOk = FALSE;
            $_SESSION['e_pesel'] = "Pesel musi zawierać 11 cyfr.";
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
        
        $secret = "6LcW6AwUAAAAALjIZp1o_JdBw-ZzUCDW1yNerqqH";
	$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$answer = json_decode($check);
		
		if ($answer->success==false)
		{
			$allIsOk=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
        
        if(!isset($_POST['regulamin']))
        {
            $allIsOk = false;
            $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
        }
        
        $_SESSION['fs_nick'] = $nick;
        $_SESSION['fs_email'] =  $email;
        $_SESSION['fs_password1'] =  $password1;
        $_SESSION['fs_password2'] =  $password2;
        $_SESSION['fs_name'] =  $name;
        $_SESSION['fs_surname'] =  $surname;
        $_SESSION['fs_place'] =  $place;
        $_SESSION['fs_street'] =  $street;
        $_SESSION['fs_houseNumber'] =  $houseNumber;
        $_SESSION['fs_pesel'] = $pesel;
        $_SESSION['fs_dateOfBirth'] = $dateOfBirth;
        $_SESSION['fs_phoneNumber'] = $phoneNumber;
        if(isset($_POST['regulamin']))$_SESSION['fs_regulamin'] = TRUE;
        
        // SALT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $salt = uniqid(mt_rand(), true);
        $stringToHash = $password1.$salt;
        $passwordHash = sha1($stringToHash);
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
             $connection= new mysqli($host,$db_user, $db_password, $db_name);
             if ($connection->connect_errno!=0) 
                 {
                    throw new Exception(mysqli_connect_errno());
                 
                 } 
                 else
                 {
                    
                     $result = $connection->query("Select Id_pacjenta from pacjenci where E_mail='$email'");

            if(!$result)  throw new Exception( $connection->error);
                     
                     $numberOfEmails = $result->num_rows;
                     if($numberOfEmails>0)
                     {
                         $allIsOk = false;
                         $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email";
                     }
                    
                      $result = $connection->query("Select Id_pacjenta from pacjenci where Login='$nick'");

            if(!$result)  throw new Exception( $connection->error);
                     
                     $numberOfNicks = $result->num_rows;
                     if($numberOfNicks>0)
                     {
                         $allIsOk = false;
                         $_SESSION['e_nick']="Istnieje już konto przypisane do tego loginu.";
                     }
                      
                     
                        if( $allIsOk == TRUE)
                        {
                            
                           if($connection->query("INSERT INTO `pacjenci`(`Id_pacjenta`, `Imie`, `Nazwisko`, `Pesel`, `Data_urodzenia`, `Login`, `Numer_telefonu`, `Id_ulicy`, `Numer_domu`, `Haslo`, `E_mail`, `Salt`, `Password_hash`) VALUES (NULL,'$name','$surname','$pesel','$dateOfBirth','$nick',$phoneNumber,NULL,'$houseNumber','$password1','$email' ,'$salt','$passwordHash')"))
                           {
                               
                               $_SESSION['signUpAccepted'] = true;
                               header('Location: welcome.php');
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
            echo '</br>Informacja developerska: '.$ex;
        }
    }
     
 ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Załóż konto</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
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
                    echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                    unset($_SESSION['e_nick']);
                }
            ?>
            
            E-mail:</br> <input type="text" value="<?php
            if(isset($_SESSION['fs_email']))
            {
                echo $_SESSION['fs_email'];
                unset($_SESSION['fs_email']);
            }
            ?> " name="email" /> </br> 
            
            <?php
                if( isset($_SESSION['e_email']))
                {
                    echo '<div class="error">'.$_SESSION['e_email'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_password'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_name'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_place'].'</div>';
                    unset($_SESSION['e_place']);
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
                    echo '<div class="error">'.$_SESSION['e_street'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_houseNumber'].'</div>';
                    unset($_SESSION['e_houseNumber']);
                }
            ?>
           
            Pesel:</br> <input type="text" value="<?php
            if(isset($_SESSION['fs_pesel']))
            {
                echo $_SESSION['fs_pesel'];
                unset($_SESSION['fs_pesel']);
            }
            ?>"  name="pesel" /> </br>
            <?php
                if(isset($_SESSION['e_pesel']))
                {
                    echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
                    unset($_SESSION['e_pesel']);
                }
            ?>
            
            Data urodzenia:</br> <input type="date" value="<?php
            if(isset($_SESSION['fs_dateOfBirth']))
            {
                echo  $_SESSION['fs_dateOfBirth'];
                unset($_SESSION['fs_dateOfBirth']);
            }
            ?>"  name="dateOfBirth" /> </br>
             <?php
                if(isset($_SESSION['e_dateOfBirth']))
                {
                    echo '<div class="error">'.$_SESSION['e_dateOfBirth'].'</div>';
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
                    echo '<div class="error">'.$_SESSION['e_phoneNumber'].'</div>';
                    unset($_SESSION['e_phoneNumber']);
                }
            ?>
            </br> 
            <label>
                <input type="checkbox" value="<?php
            if(isset($_SESSION['fs_regulamin']))
            {
                echo "checked";
                unset($_SESSION['fs_regulamin']);
            }
            ?>"  name="regulamin" />  Akceptuję regulamin
            </label>
            
             <?php
                if( isset($_SESSION['e_regulamin']))
                {
                    echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                    unset($_SESSION['e_regulamin']);
                }
            ?>
            
            </br>
            
            <div class="g-recaptcha" data-sitekey="6LcW6AwUAAAAAJw26ym23eIE9uv915JI6_9k0xyj"></div>
            
            <?php
                if( isset($_SESSION['e_bot']))
                {
                    echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                    unset($_SESSION['e_bot']);
                }
            ?>
            </br>
            
            <input type="submit" value="Zarejestruj się"/>
        
        </form>
    
    </body>
</html>