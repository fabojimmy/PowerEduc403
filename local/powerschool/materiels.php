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
use local_powerschool\materiels;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/materiels.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/materiels.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('materiel', 'local_powerschool'));
// $PAGE->set_heading(get_string('materiel', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/configurationmini.php');
$PAGE->navbar->add(get_string('materiel', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new materiels();

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
    $recordtoinsert->libellemate=$_POST["libellemate"];
    $recordtoinsert->idcampus=$_POST["idcampus"];
    $recordtoinsert->description=$_POST["description"];
    $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];
    $recordtoinsert->usermodified=$USER->id;
    $recordtoinsert->timecreated=time();
    $recordtoinsert->timemodified=time();
    // var_dump($recordtoinsert);die;
    $DB->insert_record('materiels', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/materiels.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    exit;
// }else{
//     redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Cet etudiant est déjà inscript');

// }


   


 
   
}



if($_GET['id']) {

    // $mform->supp_inscription($_GET['id']);
    $DB->delete_records("materiels", array("id"=>$_GET["id"]));
    redirect($CFG->wwwroot . '/local/powerschool/materiels.php?idca='.$_GET["id"].'', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();


// var_dump($i);
// var_dump($inscription);
// die;
$message=$DB->get_records("materiels",array("idcampus"=>ChangerSchoolUser($USER->id)));
$templatecontext = (object)[
    'materiels' => array_values($message),
    // 'nb'=>array_values($tab),
    'ajouterachat' => $CFG->wwwroot.'/local/powerschool/ligneachat.php',
    'inscriptionpayer'=> $CFG->wwwroot.'/local/powerschool/paiement.php',
    'materielssup'=> $CFG->wwwroot.'/local/powerschool/materiels.php',
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
    'materiell' => $CFG->wwwroot.'/local/powerschool/materiels.php',
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),

    

];

$campus=$DB->get_records("campus");
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>$CFG->wwwroot.'/local/powerschool/materiels.php',
];

echo $OUTPUT->header();
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
if($CFG->theme=="boost")
{
    echo'<div class="" style="margin-top:110px;"></div>';
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo'<div class="" style="margin-top:50px;"></div>';
    
}
echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo'<div style="margin-top:55px"></div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/materiels', $templatecontext);


echo $OUTPUT->footer();