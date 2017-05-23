
<?php

    session_start();
   // session_unset();
    
    
   // header("Location: index.php");
 ?>


<?php


	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
            $fmn = $_SERVER[HTTP_USER_AGENT];

            if ($connection->query("delete from sesja where id = '$_COOKIE[id]' and web = '$fmn'"))
            {
                setcookie("id",0,time()-1);
                unset($_COOKIE['id']);				
            }
            else
            {
                throw new Exception($connection->error);
            }		
	}				
	header('Location: index.php');

?>