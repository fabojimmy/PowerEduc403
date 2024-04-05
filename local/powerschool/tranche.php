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
use local_powerschool\specialite;
use local_powerschool\tranche;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/tranche.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/tranche.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une '.get_string('tranche', 'local_powerschool'));
// $PAGE->set_heading('Enregistrer une '.get_string('tranche', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/configurationmini.php');
$PAGE->navbar->add(get_string('tranche', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new tranche();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
    if($recordtoinsert->id&&$recordtoinsert->action=="edit") {

        $mform->update_tranche($recordtoinsert->id,$recordtoinsert->libelletranche);
        redirect($CFG->wwwroot . '/local/powerschool/tranche.php', 'Bien modifier');
        
    }
    else
    {
        $DB->insert_record('tranche', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/tranche.php', 'Enregistrement effectué');
        exit;
    }
}

if($_GET['id']&&$_GET["action"]=="delete") {

    $mform->supp_tranche($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/tranche.php', 'Information Bien supprimée');
        
}
if ($_GET['id']&&$_GET['action']=="edit") {
    // Add extra data to the form.
    global $DB;
    $newspecialite = new tranche();
    $specialite = $newspecialite->get_tranche($_GET['id']);
    if (!$specialite) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($specialite);
}


$sql = "SELECT * FROM {tranche} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";

$tranche = $DB->get_records_sql($sql);

// $specialite = $DB->get_records('specialite', null, 'id');

// var_dump($specialites);
// die;

$templatecontext = (object)[
    'tranche' => array_values($tranche),
    'trancheedit' => $CFG->wwwroot.'/local/powerschool/tranche.php',
    'tranchesupp'=> $CFG->wwwroot.'/local/powerschool/tranche.php',
    'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php',
];

$menumini = (object)[
    'affecterprof' => $CFG->wwwroot.'/local/powerschool/affecterprof.php',
    'configurerpaie' => $CFG->wwwroot.'/local/powerschool/configurerpaiement.php',
    'coursspecialite' => $CFG->wwwroot.'/local/powerschool/coursspecialite.php',
    'salleele' => $CFG->wwwroot.'/local/powerschool/salleele.php',
    'tranche' => $CFG->wwwroot.'/local/powerschool/tranche.php',
    'confinot' => $CFG->wwwroot.'/local/powerschool/configurationnote.php',
    'logo' => $CFG->wwwroot.'/local/powerschool/logo.php',
    'message' => $CFG->wwwroot.'/local/powerschool/message.php',
    'materiell' => $CFG->wwwroot.'/local/powerschool/materiels.php',
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),


];


// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'salle' => $CFG->wwwroot.'/local/powerschool/salle.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'specialite' => $CFG->wwwroot.'/local/powerschool/specialite.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
//     'bulletin' => $CFG->wwwroot.'/local/powerschool/bulletin.php'),
// ];



echo $OUTPUT->header();

if (!$_GET['id']&&!$_GET['action']=="edit") {
    if($CFG->theme=="boost")
{
    echo'<div class="" style="margin-top:110px;"></div>';
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo'<div class="" style="margin-top:50px;"></div>';
    
}
    echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
    echo html_writer::start_tag("div",array("style"=>"margin-top:80px"));
    echo html_writer::end_tag("div");
}
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/tranche', $templatecontext);


echo $OUTPUT->footer();