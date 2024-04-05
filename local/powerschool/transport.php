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
use local_powerschool\transport;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/transport.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/transport.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('transport', 'local_powerschool'));
$PAGE->set_heading(get_string('transport', 'local_powerschool'));

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->navbar->add(get_string('transport', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new transport();

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
    // $recordtoinsert=new stdClass();
    // $recordtoinsert->matricule=$_POST["matricule"];
    // $recordtoinsert->idconducteur=$_POST["idconducteur"];
    // $recordtoinsert->description=$_POST["description"];
    // $recordtoinsert->idcampus=$_POST["idcampus"];
    // $recordtoinsert->marque=$_POST["marque"];
    // $recordtoinsert->place=$_POST["place"];
    // $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];
    // $recordtoinsert->usermodified=$USER->id;
    // $recordtoinsert->timecreated=time();
    // $recordtoinsert->timemodified=time();
    // var_dump($recordtoinsert);die;
    $DB->insert_record('transport', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/transport.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    exit;
// }else{
//     redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Cet etudiant est déjà inscript');

// }


   


 
   
}



if($_GET['id']) {

    // $mform->supp_inscription($_GET['id']);
    $DB->delete_records("transport", array("id"=>$_GET["id"],"idcampus"=>ChangerSchoolUser($USER->id)));
    redirect($CFG->wwwroot . '/local/powerschool/transport.php?idca='.$_GET["id"].'', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();


// var_dump($i);
$message=$DB->get_records_sql("SELECT t.id,matricule,marque,place,t.description,firstname,lastname FROM {user} u,{transport} t WHERE u.id = t.idconducteur and t.idcampus='".ChangerSchoolUser($USER->id)."'");
// var_dump($message);
// die();
$templatecontext = (object)[
    'transport' => array_values($message),
    // 'nb'=>array_values($tab),
    'messagesc' => $CFG->wwwroot.'/local/powerschool/PHPMailer/email.php',
    'inscriptionpayer'=> $CFG->wwwroot.'/local/powerschool/paiement.php',
    'transportmodif'=> $CFG->wwwroot.'/local/powerschool/transportedit.php',
    'transportssup'=> $CFG->wwwroot.'/local/powerschool/transport.php',
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
    'transportl' => $CFG->wwwroot.'/local/powerschool/transport.php',
    'materiell' => $CFG->wwwroot.'/local/powerschool/materiels.php',


];

$campus=$DB->get_records("campus");
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>$CFG->wwwroot.'/local/powerschool/transports.php',
];

echo $OUTPUT->header();
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo'<div style="margin-top:25px"></div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// if($CFG->theme=="boost")
// {
//     echo "<style>body { background-color: red; }</style>";
// }
// elseif ($CFG->theme == 'adaptable') {
//     // Changer la couleur en bleu
//     echo "<style>body { background-color: blue; }</style>";
// }
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/transport', $templatecontext);


echo $OUTPUT->footer();