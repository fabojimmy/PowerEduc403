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
 */

use core\progress\display;
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/rentrernote.php');
$PAGE->set_context(\context_system::instance());
// $PAGE->set_title('Entrer les '.$_GET['libelcou'].'');
$PAGE->set_heading('Votre Programme');

// $PAGE->navbar->add('Administration du Site',  $CFG->wwwroot.'/local/powerschool/index.php'));
// $PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();


$sqllu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=2 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$lundi=$DB->get_recordset_sql($sqllu);
$sqlma = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=3 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mardi=$DB->get_recordset_sql($sqlma);
$sqlme = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=4 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mercredi=$DB->get_recordset_sql($sqlme);
$sqljeu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND idsemestre='".$_GET["idsem"]."' AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=5 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$jeudi=$DB->get_recordset_sql($sqljeu);
$sqlven = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id  AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=6 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$vendredi=$DB->get_recordset_sql($sqlven);
$sqlsad = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id  AND u.idparent='".$USER->id."'
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=7 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$samedi=$DB->get_recordset_sql($sqlsad);
// var_dump($samedi);die;

if($_GET["idsem"])
{
  $datesemver=$DB->get_records("semestre",array("id"=>$_GET["idsem"]));

    foreach($datesemver as $key => $val)
    {}
  $datedebutveri=$val->datedebutsemestre;
  $datefinveri=$val->datefinsemestre;

  $sqllu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=2 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$lundi=$DB->get_recordset_sql($sqllu);
$sqlma = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=3 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mardi=$DB->get_recordset_sql($sqlma);
$sqlme = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=4 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mercredi=$DB->get_recordset_sql($sqlme);
$sqljeu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=5 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$jeudi=$DB->get_recordset_sql($sqljeu);
$sqlven = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=6 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$vendredi=$DB->get_recordset_sql($sqlven);
$sqlsad = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc 
FROM {course} c,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i,{user} u
WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."' AND i.idetudiant=u.id
AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id AND u.idparent='".$USER->id."' AND datecours BETWEEN $datedebutveri AND $datefinveri
AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=7 GROUP BY fullname,heuredebutcours,heurefincours,dayc";


}

$progr='
<div class="table card mt-2 mb-2">
<table class="table card table-bordered">
<tr>
<th>Lundi</th>
<th>Mardi</th>
<th>Mercredi</th>
<th>Jeudi</th>
<th>Vendredi</th>
<th>Samedi</th>
</tr>
<tr>
<td >';
foreach($lundi as $key => $valuel)
{
  $sqlluno = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc  FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=2 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";
  $tarlund=array();
  $lundino=$DB->get_recordset_sql($sqlluno);
  $progr.='
  <div class="my-3 col-12 border-top" style="width:100%;"> 
 
        <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModallu'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
        <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>

        <div class="modal fade" id="exampleModallu'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ';
                
                foreach ($lundino as $key => $valuemar){
                  $valuool='<span style="font-weight:700">'.date("l d F Y",$valuemar->datecours).'<br>';
                  if(!in_array($valuoo,$tarlund))
                  {
                    array_push($tarlund,$valuool);
                      // var_dump($valuoo);die;
                      // $valuoo="";
                  }else
                  {
                      $valuool="";
                  }
                  $progr.=$valuool;               
                }
            $progr.='
              </div>
              <div class="">
                
                
              </div>
            </div>
        </div>
  </div>';
}
$progr.='</td>';
$progr.='<td>';
 foreach($mardi as $key => $valuel)
{
    $sqlmano = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc ,datecours FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=3 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";
  $tarmard=array();
  $mardino=$DB->get_recordset_sql($sqlmano);
    $progr.='
    <div class="my-3 col-12 border-top" style="width:100%;"> 
          <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModalma'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
          <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>
    
          <div class="modal fade" id="exampleModalma'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  ';
                  
                  foreach ($mardino as $key => $valuemar){
                    $valuoo='<span style="font-weight:700">'.date("l d F Y",$valuemar->datecours).'<br>';
                    if(!in_array($valuoo,$tarmard))
                    {
                      array_push($tarmard,$valuoo);
                        // var_dump($valuoo);die;
                        // $valuoo="";
                    }else
                    {
                        $valuoo="";
                    }
                    $progr.=$valuoo;               
                  }
              $progr.='
                </div>
                <div class="">
                  
                  
                </div>
              </div>
          </div>
  </div>';
}
$progr.='</td>';
       
$progr.='<td>';
 foreach($mercredi as $key => $valuel)
{
  $sqlmeno = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc ,datecours FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=4 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";
  $tarmer=array();
  $mercredino=$DB->get_recordset_sql($sqlmeno);
    
    $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> 
    <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModalmer'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
    <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>

    <div class="modal fade" id="exampleModalmer'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          ';
                    
          foreach ($mercredino as $key => $valuemar){
            $valuoomer='<span style="font-weight:700">'.date("l d F Y",$valuemar->datecours).'<br>';
            if(!in_array($valuoomer,$tarmer))
            {
              array_push($tarmer,$valuoomer);
                // var_dump($valuoo);die;
                // $valuoo="";
            }else
            {
                $valuoomer="";
            }
            $progr.=$valuoomer;               
          }
      $progr.='
          </div>
          <div class="">
            
            
          </div>
        </div>
    </div>
  </div>';
}
$progr.='</td>';
       
$progr.='<td>';
 foreach($jeudi as $key => $valuel)
{
  $sqljeuno = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc,datecours  FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=5 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";

  $tarjeu=array();
  $jeudino=$DB->get_recordset_sql($sqljeuno);
    $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> 

    <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModaljeu'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
    <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>

    <div class="modal fade" id="exampleModaljeu'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          ';
                      
          foreach ($jeudino as $key => $valuemar){
            $valuoojeu='<span style="font-weight:700">'.date("l d F Y",$valuemar->datecours).'<br>';
            if(!in_array($valuoojeu,$tarjeu))
            {
              array_push($tarjeu,$valuoojeu);
                // var_dump($valuoo);die;
                // $valuoo="";
            }else
            {
                $valuoojeu="";
            }
            $progr.=$valuoojeu;               
          }
      $progr.='
          </div>
          <div class="">
            
            
          </div>
        </div>
    </div>
  </div>';
}
$progr.='</td>';
       
$progr.='<td>';
 foreach($vendredi as $key => $valuel)
{
  $sqlvenno = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc,datecours  FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=6 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";

  $vendredino=$DB->get_recordset_sql($sqlvenno);
  $tarvend=array();
  $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> 

  <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModalven'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
  <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>

  <div class="modal fade" id="exampleModalven'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        ';
                    
        foreach ($vendredino as $key => $valueven){
          $valuooven='<span>'.date("d/m/Y",$valueven->datecours).'-'.$valueven->fullname.'-'.$valueven->heuredebutcours.'h-'.$valueven->heurefincours.'</span><br>';
          if(!in_array($valuooven,$tarvend))
          {
            array_push($tarvend,$valuooven);
              // var_dump($valuoo);die;
              // $valuoo="";
          }else
          {
              $valuooven="";
          }
          $progr.=$valuooven;               
        }
    $progr.='
        </div>
        <div class="">
          
          
        </div>
      </div>
  </div>
</div>';
}
$progr.='</td>';
       
$progr.='<td>';
 foreach($samedi as $key => $valuel)
{
  $sqlsadno = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc  FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy,{salle} sa, {programme} p,{inscription} i
  WHERE p.idcourses = c.id AND p.idspecialite = sp.id AND i.idetudiant='".$_GET['idenf']."'
  AND p.idcycle = cy.id AND i.idcycle=cy.id AND i.idspecialite=sp.id 
  AND sa.id=p.idsalle AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=7 
  AND fullname='".$valuel->fullname."' AND heuredebutcours='".$valuel->heuredebutcours."' AND heurefincours='".$valuel->heurefincours."'";
  
  $samedino=$DB->get_recordset_sql($sqlsadno);
  $tarsamm=array();
    $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> 

    <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px"><a href=# data-toggle="modal" data-target="#exampleModalsam'.$valuel->heuredebutcours.'">'.$valuel->fullname.'</a></em> 
    <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>
  
    <div class="modal fade" id="exampleModalsam'.$valuel->heuredebutcours.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Jour de cours</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          ';
                        
          foreach ($samedino as $key => $valuemar){
            $valuoosam='<span style="font-weight:700">'.date("l d F Y",$valuemar->datecours).'<br>';
            if(!in_array($valuoosam,$tarsamm))
            {
              array_push($tarsamm,$valuoosam);
                // var_dump($valuoo);die;
                // $valuoo="";
            }else
            {
                $valuoosam="";
            }
            $progr.=$valuoosam;               
          }
      $progr.='
          </div>
          <div class="">
            
            
          </div>
        </div>
     </div>
  </div>';
}
$progr.='</td>';
       
      $progr.='</tr>
   </table>
</div>';
$menu = (object)[
   'programme' => new moodle_url('/local/powerschool/programmepersoparent.php'),
   'paiement' => new moodle_url('/local/powerschool/paiementpersoparent.php'),
   'note' => new moodle_url('/local/powerschool/bulletinnotepersoparent.php'),
   'absence' => new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
];
$semestre=$DB->get_records("semestre");
$enfant=$DB->get_records("user",array("idparent"=>$USER->id));
// var_dump($semestre);
// die;
$templatecontext=[
    "programme"=>$progr,
    "semestre"=>array_values($semestre),
    'enfant'=>array_values($enfant),
    'enfantabse'=> new moodle_url('/local/powerschool/programmepersoparent.php'),
    "courssemestre"=>$CFG->wwwroot.'/local/powerschool/programmepersoparent.php',
    "idsem"=>$_GET['idsem'],
];
echo $OUTPUT->header();

if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
echo $OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// $mform->display();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/programmepersoparent', $templatecontext);


echo $OUTPUT->footer();

?>