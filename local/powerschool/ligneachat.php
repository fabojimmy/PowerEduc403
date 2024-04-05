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
use local_powerschool\ligneachat;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/ligneachat.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/ligneachat.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('materiel', 'local_powerschool'));
// $PAGE->set_heading(get_string('materiel', 'local_powerschool'));

$PAGE->navbar->add(get_string('materiel', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/materiels.php');
$PAGE->navbar->add(get_string('ligneachat', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new ligneachat();

// var_dump($PAGE);die;

if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/configurationmini.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data() ) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
// if (!$mform->veri_insc($recordtoinsert->idetudiant)) {
    # code..

    // var_dump($_POST["idcampus"]);die;
    $recordtoinsert=new stdClass();

    $recordtoinsert->quantite=$_POST["quantite"];
    $recordtoinsert->prixuni=$_POST["prixuni"];
    $recordtoinsert->sommetota=$_POST["prixuni"]*$_POST["quantite"];
    $recordtoinsert->idmateriels=$_POST["idmateriels"];
    $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];
    $recordtoinsert->usermodified=$USER->id;
    $recordtoinsert->timecreated=time();
    $recordtoinsert->timemodified=time();
    // var_dump($recordtoinsert);die;
    // $DB->insert_record('ligneachat', $recordtoinsert);
    $DB->execute("INSERT INTO mdl_ligneachat VALUE (0,'".$recordtoinsert->quantite."','".$recordtoinsert->prixuni."','".$recordtoinsert->sommetota."','".$recordtoinsert->idmateriels."','".ChangerSchoolUser($USER->id)."','". $recordtoinsert->usermodified."','".$recordtoinsert->idanneescolaire."','".time()."','".time()."')");
    redirect($CFG->wwwroot . '/local/powerschool/ligneachat.php?idac='.$_POST["idmateriels"].'', 'Enregistrement effectué');
    exit;
// }else{
//     redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Cet etudiant est déjà inscript');

// }


   


 
   
}



if($_GET['id']) {

    // $mform->supp_inscription($_GET['id']);
    $DB->delete_records("ligneachat", array("id"=>$_GET["id"]));
    redirect($CFG->wwwroot . '/local/powerschool/ligneachat.php', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();


// var_dump($i);
// var_dump($inscription);
// die;
$message=$DB->get_records_sql("SELECT * FROM {ligneachat} l,{materiels} m WHERE l.idmateriels=m.id AND l.idmateriels='".$_GET["idac"]."' AND m.idcampus='".ChangerSchoolUser($USER->id)."'");
// die;
$somme=$DB->get_records_sql("SELECT SUM(sommetota) as sommateriel FROM {ligneachat} l,{materiels} m WHERE l.idmateriels=m.id AND l.idmateriels='".$_GET["idac"]."' AND m.idcampus='".ChangerSchoolUser($USER->id)."'");
$templatecontext = (object)[
    'ligneachat' => array_values($message),
    'somme' => array_values($somme),
    // 'nb'=>array_values($tab),
    'messagesc' => $CFG->wwwroot.'/local/powerschool/PHPMailer/email.php',
    'inscriptionpayer'=> $CFG->wwwroot.'/local/powerschool/paiement.php',
    'ligneachatsup'=> $CFG->wwwroot.'/local/powerschool/ligneachat.php',
    'idca'=>ChangerSchoolUser($USER->id)
    // 'imprimer' => $CFG->wwwroot.'/local/powerschool/imp.php'),
];
// $campus=$DB->get_records('campus');
// $campuss=(object)[
//         'campus'=>array_values($campus),
//         'confpaie'=>$CFG->wwwroot.'/local/powerschool/affecterprof.php'),
//     ];
$menumini = (object)[
    'affecterprof' => $CFG->wwwroot.'/local/powerschool/affecterprof.php',
    'configurerpaie' => $CFG->wwwroot.'/local/powerschool/configurerpaiement.php',
    'coursspecialite' => $CFG->wwwroot.'/local/powerschool/coursspecialite.php',
    'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php',
    'salleele' => $CFG->wwwroot.'/local/powerschool/salleele.php',
    'message' => $CFG->wwwroot.'/local/powerschool/message.php',
    'logo' => $CFG->wwwroot.'/local/powerschool/logo.php',
    'confinot' => $CFG->wwwroot.'/local/powerschool/configurationnote.php',
    'materiell' => $CFG->wwwroot.'/local/powerschool/ligneachat.php',
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),

    

];

$campus=$DB->get_records("campus");
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>$CFG->wwwroot.'/local/powerschool/ligneachat.php',
];

echo $OUTPUT->header();
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// if($CFG->theme=="boost")
// {
//     echo'<div class="" style="margin-top:110px;"></div>';
// }
// elseif ($CFG->theme == 'adaptable') {
//     // Changer la couleur en bleu
//     echo'<div class="" style="margin-top:50px;"></div>';
    
// }
// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo'<div style="margin-top:55px"></div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/ligneachat', $templatecontext);


echo $OUTPUT->footer();