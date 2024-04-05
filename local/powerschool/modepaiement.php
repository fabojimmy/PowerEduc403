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
use local_powerschool\modepaiement;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/modepaiement.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/modepaiement.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une modepaiement');
$PAGE->set_heading('Enregistrer une modepaiement');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->navbar->add(get_string('modepaiement', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new modepaiement();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 
        $DB->insert_record('modepaiement', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/modepaiement.php', 'Enregistrement effectué');
        exit;
}

if($_GET['id']) {

    $mform->supp_modepaiement($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/modepaiement.php', 'Information Bien supprimée');
        
}



$modepaiement = $DB->get_records('modepaiement', null, 'id');

$templatecontext = (object)[
    'modepaiement' => array_values($modepaiement),
    'modepaiementedit' => $CFG->wwwroot.'/local/powerschool/modepaiementedit.php',
    'modepaiementsupp'=> $CFG->wwwroot.'/local/powerschool/modepaiement.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
];

// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'modepaiement' => $CFG->wwwroot.'/local/powerschool/modepaiement.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
// ];

$menu = (object)[
    'statistique' => $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' => $CFG->wwwroot.'/local/powerschool/reglages.php',
    // 'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
    'seance' => $CFG->wwwroot.'/local/powerschool/seance.php',
    'programme' => $CFG->wwwroot.'/local/powerschool/programme.php',

    'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php',
    // 'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),
    'bulletin' => $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'configurermini' => $CFG->wwwroot.'/local/powerschool/configurationmini.php',
    // 'gerer' => $CFG->wwwroot.'/local/powerschool/gerer.php'),

];
echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/modepaiement', $templatecontext);


echo $OUTPUT->footer();