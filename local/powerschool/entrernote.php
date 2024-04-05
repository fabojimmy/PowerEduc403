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
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/rentrernote.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Entrer les '.$_GET['libelcou'].'');
$PAGE->set_heading('Entrer notes de '.$_GET['libelcou'].'');

// $PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add("Entrer Note", $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

//cours
$sql="SELECT c.id as idcourse,fullname FROM {coursspecialite} as cs,{course} as c,{affecterprof} as af,{courssemestre} as cse WHERE cse.idcoursspecialite=cs.id AND af.idcourssemestre=cse.id AND idprof='".$USER->id."' AND c.id=cs.idcourses AND idspecialite='".$_GET["idsp"]."' AND idcycle='".$_GET["idcy"]."' AND idsemestre='".$_GET["idsem"]."' AND af.idsalle='".$_GET["idsa"]."' AND af.quit=0";
$cours=$DB->get_records_sql($sql);

//etudiants
$sql_etudiant = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus,u.id as userid
                    FROM {inscription} i, {anneescolaire} a, {user} u, {campus} c
                    WHERE i.idanneescolaire=a.id AND i.idspecialite='".$_GET["idsp"]."' AND i.idetudiant=u.id 
                    AND i.idcampus=c.id AND i.idcycle ='".$_GET["idcy"]."'";


//affecterprof
$sql_courspe="SELECT cs.id as idcsem FROM {coursspecialite} csp,{courssemestre} cs,{course} cou WHERE cou.id=csp.idcourses AND fullname='".$_GET["libelcou"]."' AND csp.id=cs.idcoursspecialite AND idspecialite='".$_GET['idsp']."' AND idcycle='".$_GET['idcy']."'";

$courspe = $DB->get_records_sql($sql_courspe);
foreach ($courspe as $key => $value1) {
    
    $sql_prof="SELECT * FROM {affecterprof} WHERE idcourssemestre='".$value1->idcsem."' AND idprof='".$USER->id."' AND idsalle='".$_GET["idsa"]."'";
    $prof = $DB->get_records_sql($sql_prof);
    foreach ($prof as $key => $value2) {
        // var_dump($value2->id);
    }
}
$veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.$_GET["idca"].'');
        foreach($veriEta as $valueEt){}
if($valueEt->libelletype=="universite")
 {
    $sql_etuu="SELECT u.id as userid, u.firstname, u.lastname,note1,note2,note3 FROM {listenote} l LEFT JOIN {affecterprof} af ON l.idaffecterprof=af.id LEFT JOIN {courssemestre} couss ON couss.id=af.idcourssemestre
        LEFT JOIN {coursspecialite} coursspe ON coursspe.id=couss.idcoursspecialite
        LEFT JOIN {course} c ON c.id=coursspe.idcourses LEFT JOIN {user} u ON u.id=l.idetudiant WHERE af.id='".$value2->id."' AND af.quit=0 AND idgroupapprenant='".$_GET["idgr"]."'";

 }
 else
 {
    $sql_etuu="SELECT u.id as userid, u.firstname, u.lastname,note1,note2,note3 FROM (((((({listenote} l LEFT JOIN {affecterprof} af ON l.idaffecterprof=af.id)LEFT JOIN {courssemestre} couss ON couss.id=af.idcourssemestre)
        LEFT JOIN {coursspecialite} coursspe ON coursspe.id=couss.idcoursspecialite)
        LEFT JOIN {course} c ON c.id=coursspe.idcourses) LEFT JOIN {user} u ON u.id=l.idetudiant) LEFT JOIN {salleele} saa ON saa.idetudiant=u.id) WHERE af.id='".$value2->id."' AND saa.idsalle='".$_GET["idsa"]."' AND af.quit=0 AND saa.etudiantpresen=1";

 }
$etudiants = $DB->get_records_sql($sql_etuu);
// var_dump($etudiants);die;

// $sql_etuu="SELECT u.id as userid, u.firstname, u.lastname,note1,note2,note3 FROM {user} as u ,{listenote} as l,{affecterprof} af,{courssemestre} cse,{coursspecialite} csp,{course} cour 
// WHERE l.idetudiant=u.id AND csp.id=cse.idcoursspecialite AND cse.id=af.idcourssemestre AND af.id=l.idaffecterprof AND cour.id=csp.idcourses AND idaffecterprof='".$value2->id."' AND fullname='".$_GET["libelcou"]."'";

// var_dump($etudiants);die;

// foreach($etudiants as $key =>$valuee){

//     $sql_note="SELECT note1,note2,note3 FROM {listenote} as l,{affecterprof} af,{courssemestre} cse,{coursspecialite} csp,{course} cour
//     WHERE csp.id=cse.idcoursspecialite AND cse.id=af.idcourssemestre AND af.id=l.idaffecterprof AND cour.id=csp.idcourses AND fullname='".$_GET["libelcou"]."' AND
//     l.idetudiant='".$valuee->userid."' AND idaffecterprof='".$value2->id."'";
//     $notee[] = $DB->get_records_sql($sql_note);
// }

// var_dump($etudiants);die;
// var_dump($courspe);die;


// die;
$test=$DB->get_records("quiz",array("course"=>$_GET["idcour"]));
$lesson=$DB->get_records("lesson",array("course"=>$_GET["idcour"]));
$templatecontext = (object)[
    'cours'=>array_values($cours),
    'lesson'=>array_values($lesson),
    'test'=>array_values($test),
    // 'notee'=>array_values($notee),
    'etudiants'=>array_values($etudiants),
    'ajoute'=> new moodle_url('/local/powerschool/inscription.php'),
    'modifiernote'=> new moodle_url('/local/powerschool/entrernote.php'),
    'ajout'=> new moodle_url('/local/powerschool/classes/entrernote.php'),
    'coursid'=> new moodle_url('/local/powerschool/entrernote.php'),
    'idsp'=>$_GET['idsp'],
    'idca'=>$_GET['idca'],
    'idsem'=>$_GET['idsem'],
    'idcy'=>$_GET['idcy'],
    'idan'=>$_GET['idan'],
    'idcour'=>$_GET['idcour'],
    'libelcou'=>$_GET['libelcou'],
    'idaff'=>$value2->id,
    'note'=>$_GET["note"],
    'idbu'=>$_GET["idbu"],
    'idsa'=>$_GET["idsa"],
    'idgr'=>$_GET["idgr"],
    // 'imprimer' => new moodle_url('/local/powerschool/imp.php'),
];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'specialite' => new moodle_url('/local/powerschool/specialite.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),
    'notes' => new moodle_url('/local/powerschool/note.php'),

];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();
if($CFG->theme=="boost")
{
    echo'<div class="" style="margin-top:110px;"></div>';
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo'<div class="" style="margin-top:-90px;"></div>';
    
}

echo $OUTPUT->render_from_template('local_powerschool/entrernote', $templatecontext);


echo $OUTPUT->footer();