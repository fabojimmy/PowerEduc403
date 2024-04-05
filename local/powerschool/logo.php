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
use local_powerschool\configurerpaiement;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/configurerpaiement.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/logo.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Ajouter logo');
$PAGE->set_heading('Ajouter logo');

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/configurationmini.php');
$PAGE->navbar->add(get_string('logo', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$campus=$DB->get_records("campus");
$templatecontext = (object)[
    'campus' => array_values($campus),
    'logo' => $CFG->wwwroot.'/local/powerschool/classes/addlogo.php',
    'configedit' => $CFG->wwwroot.'/local/powerschool/logoedit.php',
    'configsupp'=> $CFG->wwwroot.'/local/powerschool/configurerpaiement.php',
];

// $menu = (object)[
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
// ];

$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>$CFG->wwwroot.'/local/powerschool/affecterprof.php',
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


];
echo $OUTPUT->header();

if($CFG->theme=="boost")
  {
      echo'<div class="" style="margin-top:110px;"></div>';
  }
   elseif ($CFG->theme == 'adaptable') {
            // Changer la couleur en bleu
            echo'<div class="" style="margin-top:50px;"></div>';            
        }

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/logo', $templatecontext);


echo $OUTPUT->footer();