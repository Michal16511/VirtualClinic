<?php

class CalendarMine
{
    public function __construct()
    {
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
// ***************************************** PROPERTY *****************************************
    
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $DaysInMonth = 0;
    private $naviHref = null;

// ***************************************** FUNCTION*****************************************

    public function writeOut()
    {
        $year = null;
        $month = null;
        
        if($year == null && isset($_GET['year'])){
            
            $year = $_GET['year'];
            
        }else if($year == null){
            
            $year = date("Y", time());
        }
        
        if($month == null && isset($_GET['month'])){
            
            $month = $_GET['month'];
            
        }else if($month == null){
            
            $month = date("m", time());
        }
        
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->daysInMonth = $this->fDaysInMonth($month,$year);
        
        $content='<div id="calendarMine">'.
                        '<div class="box">'.
                            $this->createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->createLabels().'</ul>';
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                
                                $weeksInMonth = $this->fWeeksInMonth($month,$year); 
                                
                                for($i=0; $i<$weeksInMonth; $i++){
                                    
                                    for($j=1; $j<=7; $j++){
                                        $content .= $this->fShowDays($i*7+$j);
                                    }
                                }
                            $content.='</ul>';
                            $content.='div class="clear"</div>';
                    $content.='</div';
        $content.='</div>';
        
        return $content;
    }
    
    private function fShowDays($cellNumber){
        
        if($this->currentDay==0){
            
            $firstDayOfWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            
            if(intval($cellNumber)== intval($firstDayOfWeek)){
                
                $this->currentDay=1;
            }
        }

        if(($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth)){

            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay));

            $cellContent = $this->currentDay;

            $this->currentDay++;
        }else{

            $this->currentDate =null;
            $cellContent = null;
        }
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }
}

    

?>