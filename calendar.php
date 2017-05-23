<?php
    session_start();
    require_once 'connect.php';
    $connection= @new mysqli($host,$db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    
    if(isset($_SESSION['fs_submit']))
    {
        unset($_SESSION['fs_submit']);
    }
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
<?php
 
            
            
class Calendar {  

    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
         $this->connection= new mysqli($this->host,$this->db_user, $this->db_password, $this->db_name);
             mysqli_query($this->connection, "SET CHARSET utf8");
             mysqli_query($this->connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
    
    private $connection;
    
    private $flag = 0;
    
    private $host="127.0.0.1";
    private $db_user="root";
    private $db_password="ojtamojtam";
    private $db_name="VirtualClinic";
    private $idLekarza = NULL;
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }   
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         $this->flag = 0;
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
        
        $sql2 = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                    
            $result2 = $this->connection->query($sql2);
            $result2Row = mysqli_fetch_assoc($result2);
                  
//******************************            PACJENT         ************************************************************************************************************************************************************************
                 
            if(!empty($result2Row['Id_pacjenta']))
            {
                if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
                
                    $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
                    
                    if($this->currentDate >= date("Y-m-d")){
                        


                        $result = $this->connection->query("Select Dzien, Id_dnia from dzien_przyjec where Dzien = '$this->currentDate'");
                        $numberOfDays = $result->num_rows;
                        $daysRow = mysqli_fetch_assoc($result);

                       if($numberOfDays>0){

                           if(isset($_POST['Id_lekarza'])){
                               $this->idLekarza = $_POST['Id_lekarza'];

                               if(isset($_POST['Id_lekarza'])){

                                   $doctorResult = $this->connection->query("Select count(*) cnt from godziny_przyjec where Id_dnia_przyjec = '$daysRow[Id_dnia]' and Id_uzytkownika = '$_POST[Id_lekarza]'");
                                   $doctorRow = mysqli_fetch_assoc($doctorResult);

                                   if($doctorRow['cnt']){

                                       $this->flag = 1;

                                   }else{$this->flag = 0;}

                               }

                           }
                        }
                    }else{$this->flag=0;}
                   $cellContent = $this->currentDay;

                   $this->currentDay++;   

           }else{
             
              $this->currentDate =null;
 
              $cellContent=null;
            
            }
                return '<li  '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                '>'.' '.($cellContent==null?'</li>':
                 '<form action="showTime.php" method="post">'.($this->flag==1?'<input type="hidden" name="idLekarza" value="'.$this->idLekarza.'"> <button class = "cover"  name="submit" type="submit" value="'.$this->currentDate.'">'.$cellContent.'</button></form></li>'
                                                                                :' <button disabled  name="day" class = "empty" type="submit" value="'.$this->currentDate.'">'.$cellContent.'</button></form></li>'));                
            }
            if(!empty($result2Row['Id_obslugi']))
            {
                                    
            }
                  
//******************************            Lekarz         ************************************************************************************************************************************************************************
         
            if(!empty($result2Row['Id_lekarza']))
            {
                 if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
                $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));

                date_default_timezone_set("Europe/Warsaw");

                if($this->currentDate > date("Y-m-d")){

                    $this->flag = 1;
                    
                    $userDaySql = "SELECT `Id_dnia_przyjec` FROM `godziny_przyjec` WHERE Id_uzytkownika = '$result2Row[Id_uzytkownika]' and Id_dnia_przyjec = (SELECT `Id_dnia` FROM `dzien_przyjec` WHERE Dzien = '$this->currentDate')";
                    $userDayResult = $this->connection->query($userDaySql);
                    $userDayRow = mysqli_fetch_assoc($userDayResult);
                    
                    $dayResult = $this->connection->query("Select Dzien from dzien_przyjec where Id_dnia = '$userDayRow[Id_dnia_przyjec]'");
                    $dayRow = mysqli_fetch_assoc($dayResult);
                    
                    if($dayRow['Dzien'] == $this->currentDate )
                    {
                        $this->flag = 2;
                    }
                }
                else{
                    $this->flag = 0;
                }
                
                $cellContent = $this->currentDay;

                $this->currentDay++;   
             
                }else{

                    $this->currentDate =null;

                    $cellContent=null;

                }
                
                return '<li  '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                '>'.' '.($cellContent==null?'</li>':
                 '<form action="time.php" method="post">'.($this->flag==1?' <button class = "cover"  name="submit" type="submit" value="'.$this->currentDate.'">'.$cellContent.'</button></form></li>'
                                                                         :($this->flag==0?' <button disabled  name="day" class = "empty" type="submit" value="'.$this->currentDate.'">'.$cellContent.'</button></form></li>'
                                                                                        :' <button class = "ready"  name="submit" type="submit" value="'.$this->currentDate.'">'.$cellContent.'</button></form></li>')));
            }
                        
                    mysqli_close($connection);
        
        
        
        
        
            
        
              /*
                 return '<li  '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                '>'.' '.($cellContent==null?'</li>':
                 '<form action="time.php" method="post">'.($this->flag==1?'<span style="background:blue"></span>':'').' <button name="day" type="submit" value="'.$cellContent.'">'.$cellContent.'</button></form></li>');*/
       }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}

?>
<html>
<head>   
    <style>

body
            {
                background-size: 1700px 870px;
                background-image:url('images/kalendarz.jpg');
            }
.cover{
    background-color:#44c767;
    border:1px solid #18ab29;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:Arial;
    font-size:17px;
    text-decoration:none;
    text-shadow:0px 1px 0px #2f6627;
    text-align:center;
    height: 80px;
    width: 80px;
    cursor: pointer;
}
.cover:hover
{
    background-color:#5cbf2a;
}

.ready{
    -moz-box-shadow:inset 0px 1px 0px 0px #97c4fe;
	-webkit-box-shadow:inset 0px 1px 0px 0px #97c4fe;
	box-shadow:inset 0px 1px 0px 0px #97c4fe;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #3d94f6), color-stop(1, #1e62d0));
	background:-moz-linear-gradient(top, #3d94f6 5%, #1e62d0 100%);
	background:-webkit-linear-gradient(top, #3d94f6 5%, #1e62d0 100%);
	background:-o-linear-gradient(top, #3d94f6 5%, #1e62d0 100%);
	background:-ms-linear-gradient(top, #3d94f6 5%, #1e62d0 100%);
	background:linear-gradient(to bottom, #3d94f6 5%, #1e62d0 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#3d94f6', endColorstr='#1e62d0',GradientType=0);
	background-color:#3d94f6;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #337fed;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
    font-family:Arial;
    font-size:17px;
    text-decoration:none;
    text-shadow:0px 1px 0px #2f6627;
    text-align:center;
    height: 80px;
    width: 80px;
    cursor: pointer;
    background: #0040ff;
}
.ready:hover
{
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #1e62d0), color-stop(1, #3d94f6));
	background:-moz-linear-gradient(top, #1e62d0 5%, #3d94f6 100%);
	background:-webkit-linear-gradient(top, #1e62d0 5%, #3d94f6 100%);
	background:-o-linear-gradient(top, #1e62d0 5%, #3d94f6 100%);
	background:-ms-linear-gradient(top, #1e62d0 5%, #3d94f6 100%);
	background:linear-gradient(to bottom, #1e62d0 5%, #3d94f6 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#1e62d0', endColorstr='#3d94f6',GradientType=0);
	background-color:#1e62d0;
}

.empty{
    text-align:center;
    height: 80px;
    width: 80px;
    color: black;
}

div#calendar{
  float:left;
  margin-left: 90px;
  padding:0px;
  width: 602px;
  font-family:Helvetica, "Times New Roman", Times, serif;
}
form{
    margin-top: 0px;
}
div#calendar div.box{
    position:relative;
    top:0px;
    left:0px;
    width:100%;
    height:40px;
    background-color:   #4d4d4d ;      
}
 
div#calendar div.header{
    
    line-height:40px;  
    vertical-align:middle;
    position:absolute;
    left:11px;
    top:0px;
    width:582px;
    height:40px;   
    text-align:center;
}
 
div#calendar div.header a.prev,div#calendar div.header a.next{ 
    position:absolute;
    top:0px;   
    height: 17px;
    display:block;
    cursor:pointer;
    text-decoration:none;
    color:#FFF;
}
 
div#calendar div.header span.title{
    color:#FFF;
    font-size:18px;
}
 
 
div#calendar div.header a.prev{
    left:0px;
}
 
div#calendar div.header a.next{
    right:0px;
}
 
 
 
 
/*******************************Calendar Content Cells*********************************/
div#calendar div.box-content{
    border:1px solid #787878 ;
    border-top:none;
    
    background-color: #999999;
}

div#calendar ul.label{
    border:2.5px solid #18ab29;
    float:left;
    margin: 0px;
    padding: 0px;
    margin-top:0px;
    margin-left: 0px;
}
 
div#calendar ul.label li{
    margin:0px;
    padding:0px;
    margin-right:5px;  
    float:left;
    list-style-type:none;
    width:80px;
    height:40px;
    line-height:40px;
    vertical-align:middle;
    text-align:center;
    color:#000;
    font-size: 15px;
    background-color: transparent;
}
 
 
div#calendar ul.dates{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-left: 5px;
    margin-bottom: 5px;
    
}
 
/** overall width = width+padding-right**/
div#calendar ul.dates li{
    margin:0px;
    padding:0px;
    margin-right:5px;
    margin-top: 5px;
    line-height:80px;
    vertical-align:middle;
    float:left;
    list-style-type:none;
    width:80px;
    height:80px;
    font-size:25px;
    color:#000;
    text-align:center; 
}
 
:focus{
    outline:none;
}
 
div.clear{
    clear:both;
}     

#button
            {
                margin-left: 8%;
                margin-top: 10.1%;
                float:left;
                width: 200px;
                height: 100px;
                border-radius: 30px;
                opacity: 0.95;
                text-align: center;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                color: black;   
                opacity: 0.5;
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
                opacity: 0.5;
                overflow:hidden;
                font-size: 30;
            }
            a:link
            {
                color: blue;
                text-decoration: none;
            }
            a:visited {
            color: blue;
            background-color: transparent;
            text-decoration: none;
            }
            a:hover {
            color: red;
            background-color: transparent;
            text-decoration: underline;
            }
            a:active {
            color: blue;
            background-color: transparent;
            text-decoration: underline;
            }
</style>
</head>

<body>
    <div id="button">
        </br> <a href="index.php">Strona Główna</a>
    </div>
<?php

 
$calendar = new Calendar();
 
echo $calendar->show();
?>
    <div id="button">
        </br> <a href="option.php">Opcje</a>
    </div>
    <div style="clear: both;"></div>
    <?php
    $sql2 = "SELECT uzytkownicy.Id_pacjenta, uzytkownicy.Id_lekarza, uzytkownicy.Id_obslugi, uzytkownicy.Id_uzytkownika  from uzytkownicy, sesja where sesja.Id_uzytkownika = uzytkownicy.Id_uzytkownika and sesja.id = '{$_COOKIE['id']}' and sesja.Web = '{$_SERVER['HTTP_USER_AGENT']}' and sesja.Ip = '{$_SERVER['REMOTE_ADDR']}';";
                    
            $result2 = $connection->query($sql2);
            $result2Row = mysqli_fetch_assoc($result2);
                  
//******************************            Lekarz         ************************************************************************************************************************************************************************
                 
            if(!empty($result2Row['Id_lekarza'])){
                echo '<div style="margin-left: 450px;color: blue;">Legenda:</br>Kolor niebieski oznacza ustalone już dni pracy</br>'
                . '   Kolor zielony oznacza dostępne dni do ustalenia dyżuru</br>'
                . '   Kolor szary oznacza brak możliwości wyboru dnia</div>';
            }
            if(!empty($result2Row['Id_pacjenta'])){
                echo '<div style="margin-left: 450px;color: blue;">Legenda:</br>Kolor zielony oznacza dostępne dni do ustalenia wizyty</br>'
                . '   Kolor szary w danym dniu oznacza brak możliwości wyboru dnia</div>';
            }
    ?>
 
</body>
</html> 