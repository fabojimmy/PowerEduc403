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
use local_powerschool\absencejustifier;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ .'/../../group/lib.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/absencejustifier.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/absencejustifier.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('absencejustifier de Cours');
$PAGE->set_heading('absencejustifier de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('absencejustifier', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new absencejustifier();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
// var_dump($_POST["idcycle"]);die;
// $datesea=$_POST["date_naissance"];
// $date_naissance= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);

    // if (!$mform->veri_insc($_POST["idetudiant"])) {
    //     # code...


        $DB->insert_record('absencejustifier', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/listeetuabsenadmin.php?idca='.$_POST["idcampus"].'', 'La justification a été bien effectué');
        exit;
    // }else{
    //     \core\notification::add('Cet etudiant est déjà inscrit', \core\output\notification::NOTIFY_ERROR);
    //     redirect($CFG->wwwroot . '/local/powerschool/absencejustifier.php');

    // }
   
}





// $absencejustifier =$tab = array();


$templatecontext = (object)[
    // 'absencejustifier' => array_values($absencejustifier),
    // 'campus' => array_values($campus),
    // 'semestre' => array_values($semestre),
    // 'annee' => array_values($annee),
    // 'nb'=>array_values($tab),
    'absencejustifieredit' => new moodle_url('/local/powerschool/absencejustifieredit.php'),
    'absencejustifierpayer'=> new moodle_url('/local/powerschool/paiement.php'),
    'affectercours'=> new moodle_url('/local/powerschool/absencejustifier.php'),
    'inpf'=> new moodle_url('/local/powerschool/absencejustifier.php'),
    'suppins'=> new moodle_url('/local/powerschool/absencejustifier.php'),
    'idca'=>ChangerSchoolUser($USER->id),
    'roote'=>$CFG->wwwroot,
    // 'imprimer' => new moodle_url('/local/powerschool/imp.php'),
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
//     'absencejustifier' => new moodle_url('/local/powerschool/absencejustifier.php'),
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
// $menu = (object)[
//     'statistique' => new moodle_url('/local/powerschool/statistique.php'),
//     'reglage' => new moodle_url('/local/powerschool/reglages.php'),
//     // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),

//     'absencejustifier' => new moodle_url('/local/powerschool/absencejustifier.php'),
//     // 'notes' => new moodle_url('/local/powerschool/note.php'),
//     'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
//     'listeetudiant' => new moodle_url('/local/powerschool/listeetudiant.php'),
//     // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

//     //navbar
//     'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
//     'reglagenavr'=>get_string('reglages', 'local_powerschool'),
//     'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
//     'seancenavr'=>get_string('seance', 'local_powerschool'),
//     'programmenavr'=>get_string('programme', 'local_powerschool'),
//     'absencejustifiernavr'=>get_string('absencejustifier', 'local_powerschool'),
//     'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
//     'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),

// ];

echo $OUTPUT->header();

// if(has_capability("local/powerschool:absencejustifier",context_system::instance(),$USER->id))
// {
    // echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
    // echo '<div style="margin-top:10px";><wxcvbn</div>';
    // echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
    // if(has_capability("local/powerschool:voirapprenantabsencejustifier",context_system::instance(),$USER->id))
    // {

        $mform->display();
    // }
    // else
    // {
    //     \core\notification::add("Vous avez pas autorisation", \core\output\notification::NOTIFY_ERROR);
        
    // }
    
    
//     echo $OUTPUT->render_from_template('local_powerschool/absencejustifier', $templatecontext);
// }
// else{
//     \core\notification::add("Vous avez pas autorisation", \core\output\notification::NOTIFY_ERROR);

// }


echo $OUTPUT->footer();