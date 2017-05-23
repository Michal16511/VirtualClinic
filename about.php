<!DOCTYPE html >

<?php
 session_start();
 if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
 {
     header("Location: main.php");
     exit();
 }
 if(isset($_SESSION['error'])) echo $_SESSION['error'];
 ?>
<html>

<head>
	<title>Virtual Clinic</title>
	<meta  charset="UTF-8" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	  <div id="background">
			  <div id="page">
					 <div class="header">
						<div class="footer">
							<div class="body">
							  
									<div id="sidebar">
									    <a href="index.html"><img id="logo" src="images/logo.gif" width="154" height="74" alt="" title=""/></a>
									
										
										<ul class="navigation">
										    <li><a href="index.php">Strona Główna</a></li>
											<li><a href="about.php">O nas</a></li>
											<li class="last" ><a href="option.php">Opcje</a></li>
											
										</ul>
										<div class="footenote">
										  <span>&copy; Copyright &copy; 2016.</span>
										  <span><a href="index.html">Virtual Clinic</a> all rights reserved</span>
										</div>
										
									</div>
									<div id="content" >
                                                                            <div class="content">
                                                                                <ul>
                                                                                  <li>
                                                                                    <h2>Dzień dobry</h2>
                                                                                    <p>Nasza aplikacja internetowa jest udogodnieniem dla Państwa korzystania z usług naszego ośrodka zdrowia.</p>
                                                                                  </li>
                                                                                  <li>
                                                                                    <h2>Możliwość przeglądania wizyt u lekarza.</h2>
                                                                                    <p>Wprowadzamy nową funkcjonalność, która umożliwi Państwu przeglądanie wszelkich wizyt oraz przebytych chorób, a to wszystko w zasięgu kilku kliknięć :D</p>
                                                                                  </li>
                                                                                  <li>
                                                                                    <h2>Możliwość przeglądania wizyt u lekarza.</h2>
                                                                                    <p>Wprowadzamy nową funkcjonalność, która umożliwi Państwu przeglądanie wszelkich wizyt oraz przebytych chorób, a to wszystko w zasięgu kilku kliknięć :D</p>
                                                                                  </li>
                                                                                  <li>
                                                                                    <h2>Możliwość przeglądania wizyt u lekarza.</h2>
                                                                                    <p>Wprowadzamy nową funkcjonalność, która umożliwi Państwu przeglądanie wszelkich wizyt oraz przebytych chorób, a to wszystko w zasięgu kilku kliknięć :D</p>
                                                                                  </li>
                                                                                  <li>
                                                                                    <h2>Możliwość przeglądania wizyt u lekarza.</h2>
                                                                                    <p>Wprowadzamy nową funkcjonalność, która umożliwi Państwu przeglądanie wszelkich wizyt oraz przebytych chorób, a to wszystko w zasięgu kilku kliknięć :D</p>
                                                                                  </li>
                                                                                </ul>
                                                                            </div>
									</div>
                                                            </div>
						</div>
					 </div>
					 <div class="shadow">&nbsp;</div> 
			  </div>    
	  </div>    
</body>
</html>