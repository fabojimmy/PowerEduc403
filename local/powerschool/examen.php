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
use local_powerschool\Date\Month;
use local_powerschool\programme;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/programme.php');
require_once($CFG->dirroot.'/local/powerschool/classes/date.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/programme.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Programme de Cours');
$PAGE->set_heading('Programme de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('examen', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// die;
$mform=new programme();




if($_GET['id']) {

    $DB->delete_records("examen",["id" =>$_GET['id']]);
    redirect($CFG->wwwroot . '/local/powerschool/examen.php', 'Information Bien supprimée');
        
}


    // var_dump($programmes);
    // die;
// $programme = $DB->get_records('programme', null, 'id');
$idca = (empty($_GET["idca"])) ? 1 : $_GET["idca"];
$idfi = (empty($_GET["filiere"])) ? 1 : $_GET["filiere"];
$idsp = (empty($_GET["specialite"])) ? 1 : $_GET["specialite"];
$idcy = (empty($_GET["cycle"])) ? 1 : $_GET["cycle"];
$idan = (empty($_GET["annee"])) ? 1 : $_GET["annee"];
$idsa = (empty($_GET["salle"])) ? 1 : $_GET["salle"];


$campus=$DB->get_records('campus');
$sqllu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id AND p.idanneescolaire=$idan
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=2 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$lundi=$DB->get_recordset_sql($sqllu);
$sqlma = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id AND p.idanneescolaire=$idan
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=3 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mardi=$DB->get_recordset_sql($sqlma);
$sqlme = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=4 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$mercredi=$DB->get_recordset_sql($sqlme);
$sqljeu = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id AND p.idanneescolaire=$idan
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=5 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

// die;
$jeudi=$DB->get_recordset_sql($sqljeu);
$sqlven = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id AND p.idanneescolaire=$idan
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=6 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$vendredi=$DB->get_recordset_sql($sqlven);
$sqlsad = "SELECT fullname,DATE_FORMAT(FROM_UNIXTIME(p.datecours),'%D %b %Y') as datec,heuredebutcours,heurefincours,numerosalle,MONTH(FROM_UNIXTIME(p.datecours)) AS mois,DAYOFWEEK(FROM_UNIXTIME(p.datecours)) AS dayc FROM {course} c, {specialite} sp,{cycle} cy,{salle} sa, {examen} p
WHERE p.idcourses = c.id  AND p.idspecialite = sp.id AND p.idanneescolaire=$idan
AND p.idcycle = cy.id AND idcycle=$idcy AND idspecialite=$idsp AND sa.idcampus=$idca
AND sa.id=p.idsalle AND p.idsalle=$idsa AND DAYOFWEEK(FROM_UNIXTIME(p.datecours))=7 GROUP BY fullname,heuredebutcours,heurefincours,dayc";

$samedi=$DB->get_recordset_sql($sqlsad);
// var_dump($oo);
$progr='
<div class="mt-2 mb-2">
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
    $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div  style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px ">'.$valuel->fullname.'</em> 
    <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->mois.'/'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
 $progr.='<td>';
  foreach($mardi as $key => $valuel)
 {
   $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->fullname.'</em> 
   <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->datec.'/'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
        
 $progr.='<td>';
  foreach($mercredi as $key => $valuel)
 {
   $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->fullname.'</em> 
   <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
        
 $progr.='<td>';
  foreach($jeudi as $key => $valuel)
 {
   $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->fullname.'</em> 
    <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
        
 $progr.='<td>';
  foreach($vendredi as $key => $valuel)
 {
   $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->fullname.'</em> 
   <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
        
 $progr.='<td>';
  foreach($samedi as $key => $valuel)
 {
   $progr.='<div class="my-3 col-12 border-top" style="width:100%;"> <div style="font-weight:650">Cours :</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->fullname.'</em> 
   <br> <div style="font-weight:650">Heure:</div> <em class="badge badge-warning mx-4" style="font-size:14px">'.$valuel->heuredebutcours.'h-'.$valuel->heurefincours.'h </em><br> <div style="font-weight:650"> Salle:</div> <em class="badge badge-info mx-4" style="font-size:14px">'.$valuel->numerosalle.'</em></div>';
 }
 $progr.='</td>';
        
       $progr.='</tr>
   </table>
</div>';
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/programme.php'),
            ]; 

            $campus=$DB->get_records("campus");
            $filiere=$DB->get_records("filiere",array("idcampus"=>ChangerSchoolUser($USER->id)));
            $cycle=$DB->get_records("cycle",array("idcampus"=>ChangerSchoolUser($USER->id)));
            $specialite=$DB->get_records_sql("SELECT s.id,s.libellespecialite FROM {filiere} f,{specialite} s WHERE f.id=s.idfiliere AND f.idcampus='".ChangerSchoolUser($USER->id)."'");
            $semestre=$DB->get_records("semestre");
            $annee=$DB->get_records("anneescolaire");
            // die;
            foreach($annee as $key =>$ab)
            {
                $time = $ab->datedebut;
                            $timef = $ab->datefin;
            
                            $dated = date('Y',$time);
                            $datef = date('Y',$timef);
            
                            $ab->datedebut = $dated;
                            $ab->datefin = $datef;
            }
        
            

            //

            $sql = "SELECT p.id,sp.libellespecialite,cy.libellecycle,c.fullname,heuredebutcours,heurefincours FROM {course} c,{specialite} sp,{cycle} cy, {examen} p,{filiere} f WHERE p.idcourses = c.id AND p.idspecialite = sp.id
            AND f.id=sp.idfiliere AND p.idcycle = cy.id  AND cy.idcampus='".ChangerSchoolUser($USER->id)."'";
        // die;
           

    if($idfi)
    {
        $sql.=" AND f.id='".$idfi."'";
    }
    if($idcy)
    {
        $sql.=" AND p.idcycle='".$idcy."'";
        // var_dump($sql_inscrip);
        // die;
    }
    if($idan)
    {
        $sql.=" AND p.idanneescolaire='".$idan."'";
    }
    if($idsp)
    {
        $sql.=" AND p.idspecialite='".$idsp."'";
    }

    // var_dump($sql);die;
    $programmes = $DB->get_records_sql($sql);

    foreach($programmes as $key){
            
        $time = $key->datecours;

        $date = date('d-M-Y',$time);
        $timed = date('H:m',$time);
        $timef = date('H:m',$time);

        $key->datecours = $date;

        $group=$DB->get_records("groupapprenant",array("id" =>$key->idgroupapprenant));
        foreach($group as $keyse)
        {
            
            $key->numerogroup = $keyse->numerogroup;
        }
        $salle=$DB->get_records("salle",array("id" =>$key->idsalle));
        foreach($salle as $keyse)
        {
            
            $key->numerosalle = $keyse->numerosalle;
        }

        // $key->heurefincours = $timef;

    }
$tarpr[]=(array)$programmes;
$templatecontext = (object)[
    'programme' => array_values((array)$programmes),
    'annee' => array_values($annee),
    'campus' => array_values($campus),
    'filiere1' => array_values($filiere),
    'cycle1' => array_values($cycle),
    'specialite1' => array_values($specialite),
    'programmeedit' => new moodle_url('/local/powerschool/programmeedit.php'),
    'examensupp'=> new moodle_url('/local/powerschool/examen.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'periode' => new moodle_url('/local/powerschool/periode.php'),
    'idca' =>ChangerSchoolUser($USER->id),
    'programexame'=>$progr,
    'postefo'=> new moodle_url('/local/powerschool/examen.php'),
    'wwwroote'=>$CFG->wwwroot
];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     // 'notes' => new moodle_url('/local/powerschool/note.php'),
//     'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
//     'gerer' => new moodle_url('/local/powerschool/gerer.php'),
//     'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
//     'statistique' => new moodle_url('/local/powerschool/statistique.php'),

// ];
$menu = (object)[
    'statistique' =>  $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' =>  $CFG->wwwroot.'/local/powerschool/reglages.php',
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' =>  $CFG->wwwroot.'/local/powerschool/seance.php',
    'programme' =>  $CFG->wwwroot.'/local/powerschool/programme.php',

    'inscription' =>  $CFG->wwwroot.'/local/powerschool/inscription.php',
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' =>  $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'configurermini' =>  $CFG->wwwroot.'/local/powerschool/configurationmini.php',
    'listeetudiant' =>  $CFG->wwwroot.'/local/powerschool/listeetudiant.php',
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),

];

// var_dump($CFG->wwwroot);die;

echo $OUTPUT->header();

// $mois = $_GET['mois'] ;
// $annee = $_GET['annee'];
// $month = new Month($mois??null,$annee??null);
// $start = $month->getStartingDay();
// $getWeeks = $month->getWeeks();
// $getMonth = $month->toString();

// $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

// $end = (clone $start)->modify('+'.(6 + 7 * ($getWeeks - 1)).'days');
// var_dump($month->toString());

// $events = $month->getEvents($start,$end);
// $eventsByDay = $month->getEventsByDay($start,$end);


// var_dump($start);
// var_dump($getWeeks);
// var_dump($end);


// die;



if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
// echo $OUTPUT->render_from_template('local_powerschool/tableau', $getWeeks);

// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
if(has_capability("local/powerschool:programme",context_system::instance(),$USER->id))
{
    // echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

    // echo "<div class='mx-5'></div>";
    // $mform->display();
    echo $OUTPUT->render_from_template('local_powerschool/examen', $templatecontext);
}
else{
    \core\notification::add("Vous avez pas autorisation", \core\output\notification::NOTIFY_ERROR);

}



// echo '<div class="d-flex flex-row align-items-center justify-content-between mx-sm-5">
//             <h1>'.$getMonth. '</h1>
//         <div>  
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->previousmonth()->month.'&annee='.$month->previousmonth()->year.'" class="btn btn-primary"> &lt;</a>
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->nextmonth()->month.'&annee='.$month->nextmonth()->year.'" class="btn btn-primary">&gt;</a>
//         </div>
//      </div>';

// echo ' <div class="table card mt-2 mb-2">
// <table class="calendar__table">';

// for($i = 0 ; $i < $getWeeks; $i++){

//     echo '<tr>';

//     foreach($month->days as $k => $day)
//     {
//         $date = (clone $start)->modify("+".($k + $i * 7)."days");
//         $eventForDay = $eventsByDay[$date->format('Y-m-d')] ?? [];

//         echo '<td>';
//         if($i === 0)
//         {
//         echo '<div> <strong>'.$day.' </strong></div>';
//         }
//       echo '<div> <strong>'.$date->format('d').' </strong></div>';

//       foreach($eventForDay as  $event){


//         $eventday = $event->fullname;
//         $heuredebut = $event->heuredebutcours;
//         $heurefin = $event->heurefincours;
//         echo '<div>'
//         .$heuredebut.'h -'.$heurefin.'h :   '.'<a href="#?id='.$event->id.'">'.$eventday.'</a>
//         </div>';
//       }
//        '</td>';
//     }
//     echo '</tr>';
// }
// echo ' </table>
//         </div>';



echo $OUTPUT->footer();