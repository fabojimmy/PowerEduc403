<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 */

namespace local_powerschool\Date;

use Exception;
use moodleform;
use stdClass;


require_once($CFG->libdir.'/formslib.php');


class Month {

    public $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    private  $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','November','Decembre'];
    public $month;
    public $year;
    public $semestre;

    /**
     * @throws Exception
     */
    public function __construct(?int $month = null, ?int $year = null, ?string $semestre){
    
        if ( $month === null || $month < 1 || $month > 12 ) 
        {
            $month = date('m');
            // throw new Exception("le mois $month n'est pas valide ");
        }

        if ($year < 1970 || $year === null ) 
        {
            
            $year = date('Y');
            // var_dump($year);
            // die;
            // throw new Exception("l'année est inferieur à 1970 ");
        }
        if($semestre === null){
            $semestre = 1;
        }

       
        $this->month = $month;
        $this->year = $year;
        $this->semestre = $semestre;
    }

    /**
     * retourne le 1er jour du mois
     */
    public function getStartingDay ():\DateTime{

        return new \DateTime("{$this->year}-{$this->month}-01");

    }

    public function toString():string
    {
        return $this->months[$this->month-1].' '.$this->year;
    }

    /**
     * retourne le nombre de semaine dans le mois
     */
    public function getWeeks ():int 
    {
        $start =  $this->getStartingDay();
        $end = (clone $start)->modify('+1 month -1 day');
       $weeks = intval($end->format('W'))-intval($start->format('W')) + 1;


        if ($weeks <0 ){
            $weeks = intval($end->format('W'));
        }
        


        return $weeks;
    }
    
    /**
     * nous informe des jours presents dans le mois en cours
     */
    public function withinMonth (\DateTime $date):bool{
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }


    /**
     * obtenir le mois suivant
     */
    public function nextmonth ():Month{
        
        $month = $this->month + 1 ;
        $year = $this->year ;
        $semestre = $this->semestre;
        if ($month>12)
        {
            $month = 1;
            $year += 1;
        }

        return new Month($month,$year,$semestre);
    }


    /**
     * obtenir le mois precedent
     */
    public function previousmonth ():Month{
        
        $month = $this->month - 1 ;
        $year = $this->year ;
        $semestre = $this->semestre;
        if ($month<1)
        {
            $month = 12;
            $year -= 1;
        }

        return new Month($month,$year,$semestre);
    }

    /**
     * recuperer les evenements situé entre 2 dates
     */
    public function getEvents (\DateTime $start, \DateTime $end , ?string $semestre = null,$idca,$specialite=null,$cycle=null,$salle=null):array{

        
    global $DB;

    if ($semestre === null){

           $sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p,{salle} saa
            WHERE saa.id=p.idsalle AND p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id
            AND p.idcycle = cy.id  ";

    }
    else if($specialite==null && $cycle==null && $salle==null){

        $sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p,{salle} saa WHERE p.idcourses = c.id  AND p.idspecialite = sp.id
        AND saa.id=p.idsalle AND p.idcycle = cy.id AND idcampus='".$idca."'  AND FROM_UNIXTIME(datecours) BETWEEN '{$start->format('Y-m-d 00:00:00')} ' AND '{$end->format('Y-m-d 23:59:59')}' ";
      
    }else{
        $sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p
        WHERE p.idcourses = c.id AND p.idspecialite = sp.id
        AND p.idcycle = cy.id AND idcycle='".$cycle."' AND idspecialite='".$specialite."' AND sa.idcampus='".$idca."'  AND FROM_UNIXTIME(datecours) BETWEEN '{$start->format('Y-m-d 00:00:00')} ' AND '{$end->format('Y-m-d 23:59:59')} ' 
        AND sa.id=p.idsalle AND p.idsalle=$salle";
        // $sql = "SELECT * FROM {course} c,{programme} p,{semestre} s,{cycle} cy,{specialite} sp 
        // WHERE p.idsemestre=s.id AND p.idcycle=cy.id AND sp.id=p.idspecialite AND p.idcourses = c.id
        // AND p.idcycle='".$cycle."' AND idcampus='".$idca."'  AND FROM_UNIXTIME(datecours) BETWEEN '{$start->format('Y-m-d 00:00:00')} ' AND '{$end->format('Y-m-d 23:59:59')} ' AND idsemestre=$semestre AND p.idspecialite=$specialite";

    }
        $req= $DB->get_records_sql($sql);
        $tar=(array)$req;
        // $dates = date('d/m/Y H:i:s',$req);

		                       
        // var_dump($req);
        // die;
        return $tar;
    }

    public function getEventsByDay (\DateTime $start, \DateTime $end, ?string $semestre = null,$idca,$specialite=null,$cycle=null,$salle){

        $events = $this->getEvents($start,$end,$semestre,$idca,$specialite,$cycle,$salle);
        $days = [];

        foreach($events as $event)
        {
            $date = explode(' ', date('Y-m-d H:i:s',$event->datecours))[0];

            // var_dump($event->datecours);

            if(!isset($days[$date])){
                $days[$date] = [$event];

            } else{
                $days[$date][] = $event;
            }
        }

            return $days;
        }

}