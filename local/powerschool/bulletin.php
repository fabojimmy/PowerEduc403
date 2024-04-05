<?php
// This file is part of powereduc Course Rollover Plugin
//
// powereduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// powereduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with powereduc.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/rentrernote.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Entrer les '.$_GET['libelcou'].'');
$PAGE->set_heading('Bulletin de Notes');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('bulletin', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

//cours

//filiere
$sql="SELECT * FROM {filiere} WHERE idcampus='".$_GET["idca"]."'";
$filiere=$DB->get_records_sql($sql);
$campus=$DB->get_records("campus");
$templatecontext = (object)[
    'filiere'=>array_values($filiere),
    'campus'=>array_values($campus),
    'ajoute'=> $CFG->wwwroot.'/local/powerschool/inscription.php',
    'affectercours'=> $CFG->wwwroot.'/local/powerschool/inscription.php',
    'ajou'=> $CFG->wwwroot.'/local/powerschool/classes/entrernote.php',
    'coursid'=> $CFG->wwwroot.'/local/powerschool/entrernote.php',
    'bulletinnote'=> $CFG->wwwroot.'/local/powerschool/bulletinnote.php',
    'campuslien'=> $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'root'=>$CFG->wwwroot,
    'idca'=>$_GET["idca"],

 ];

//  $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'salle' => $CFG->wwwroot.'/local/powerschool/salle.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
//     'programme' => $CFG->wwwroot.'/local/powerschool/programme.php'),
//     // 'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),
//     'bulletin' => $CFG->wwwroot.'/local/powerschool/bulletin.php'),
//     'configurermini' => $CFG->wwwroot.'/local/powerschool/configurationmini.php'),
//     'gerer' => $CFG->wwwroot.'/local/powerschool/gerer.php'),
//     'modepaie' => $CFG->wwwroot.'/local/powerschool/modepaiement.php'),
//     'statistique' => $CFG->wwwroot.'/local/powerschool/statistique.php'),


// ];

$menu = (object)[
    'statistique' =>  $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' =>  $CFG->wwwroot.'/local/powerschool/reglages.php',
    // 'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
    'seance' =>  $CFG->wwwroot.'/local/powerschool/seance.php',
    'programme' =>  $CFG->wwwroot.'/local/powerschool/programme.php',

    'inscription' =>  $CFG->wwwroot.'/local/powerschool/inscription.php',
    // 'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),
    'bulletin' =>  $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'configurermini' =>  $CFG->wwwroot.'/local/powerschool/configurationmini.php',
    'listeetudiant' =>  $CFG->wwwroot.'/local/powerschool/listeetudiant.php',
    // 'gerer' => $CFG->wwwroot.'/local/powerschool/gerer.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),
];

echo $OUTPUT->header();

if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
if(has_capability("local/powerschool:bulletin",context_system::instance(),$USER->id))
{

    echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
    echo $OUTPUT->render_from_template('local_powerschool/bulletin', $templatecontext);
}
else
{
    \core\notification::add("Vous avez pas autorisation", \core\output\notification::NOTIFY_ERROR);

}
// $mform->display();




echo $OUTPUT->footer();