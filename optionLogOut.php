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
           if (isset($_COOKIE['id'])){header("location:option.php");exit();}
        }
        
 ?>
<html>
<head>
	<title>Virtual Clinic</title>
	<meta  charset="UTF-8" />
        <style>
            
            body
            {
                background-image:url('images/doktor.jpg');
                background-size: 1700px 800px;
                
            }
            
            #container
            {     
                width: 1200px;
                height: 500px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                
            }
            
            #button
            {
                margin-left: 5%;
                margin-top: 11%;
                float:left;
                width: 200px;
                height: 600px;
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
                margin-top: 14.4%;
                float:left;
                width: 200px;
                height: 600px;
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
                float:left;
                margin-left: 10%;
                margin-top: 5%;
                 -webkit-border-radius: 150px;
                -moz-border-radius: 150px;
                border-radius:150px;
                width: 400px;
                height: 300px;
                overflow:hidden;
            }
            #container #login form
            {
                font-size: 23px;
                padding-left: 40px;
                padding-top: 20px;
                padding-bottom: 30px;
                margin-left: 80px;
                margin-top: 10px;
                margin-bottom: 30px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            #container #login #option
            {
                font-size: 23px;
                padding-left: 40px;
                padding-top: 20px;
                padding-bottom: 30px;
                margin-left: 80px;
                margin-top: 10px;
                margin-bottom: 30px;
                margin-right: auto;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                
            }
            a.button {
	font-weight: bold;
                -moz-box-shadow: 3px 4px 0px 0px #899599;
	-webkit-box-shadow: 3px 4px 0px 0px #899599;
	box-shadow: 3px 4px 0px 0px #899599;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #bab1ba));
	background:-moz-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-webkit-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-o-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:-ms-linear-gradient(top, #ededed 5%, #bab1ba 100%);
	background:linear-gradient(to bottom, #ededed 5%, #bab1ba 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#bab1ba',GradientType=0);
	background-color:#ededed;
	-moz-border-radius:15px;
	-webkit-border-radius:15px;
	border-radius:15px;
	border:1px solid #d6bcd6;
	display:inline-block;
	cursor:pointer;
	color:black;
	font-family:Arial;
	font-size:17px;
	padding:7px 25px;
	text-decoration:none;
	text-shadow:0px 1px 0px #e1e2ed;
        margin-left: 10px;
}
a.button:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #bab1ba), color-stop(1, #ededed));
	background:-moz-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-webkit-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-o-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:-ms-linear-gradient(top, #bab1ba 5%, #ededed 100%);
	background:linear-gradient(to bottom, #bab1ba 5%, #ededed 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#bab1ba', endColorstr='#ededed',GradientType=0);
	background-color:#bab1ba;
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
                 
                </br><font style="font-size: 30px;">Wybierz opcje:</font></br><p style="margin-top:40px;"></p>
                <div style="margin-left: 20px;">

                    <a href="login.php" class="button">Logowanie</a></br></br>

                    <a href="SignUpPatient.php" class="button">Rejestracja</a> </br></br>

                </div>
            </div>
        </div>
        <div id="button2">
            <a href="about.php">O nas</a>
        </div>
        <div style="clear: both;"></div>
    </div>
        
</body>
</html>