<?php

class Project{
    public $id;
    public $project_name;
    public $hours_total;
    public $minutes_total;
    public $hours_month;
    public $minutes_month;
    public $hours_today;
    public $minutes_today;

    public function setId($id){ $this->id = $id;}

    public function setProjectName($project_name){ $this->project_name = $project_name;}

    public function setHoursTotal($hours_total){ 

        $timeToshow = ($hours_total / 3600);
        $hours = floor($timeToshow);
        $mins = round(($timeToshow - $hours) * 60);
        
        $this->hours_total = $hours;
        $this->minutes_total = $mins;
    }

    public function setHoursMonth( $hours_month ){ 
        $timeToshow = ($hours_month / 3600);
        $hours = floor($timeToshow);
        $mins = round(($timeToshow - $hours) * 60);
        
        $this->hours_month = $hours;
        $this->minutes_month = $mins;
    }

    public function setHoursToday($hours_today){ 

        $timeToshow = ($hours_today / 3600);
        $hours = floor($timeToshow);
        $mins = round(($timeToshow - $hours) * 60);
        
        $this->hours_today = $hours;
        $this->minutes_today = $mins;
    }


    public function getId(){ return $this->id;}

    public function getProjectName(){ return $this->project_name;}

    public function getHoursTotal(){ return $this->hours_total;}

    public function getHoursMonth(){ return $this->hours_month;}

    public function getHoursToday(){ return $this->hours_today;}


}