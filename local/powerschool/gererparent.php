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
use local_powerschool\filiere;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

// require_once($CFG->dirroot.'/local/powerschool/classes/filiere.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/gerer.php'));
$PAGE->set_context(\context_system::instance());
// $PAGE->set_title('Enregistrer une filiere');
// $PAGE->set_heading('Enregistrer une filiere');

// $PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
// $PAGE->navbar->add(get_string('Filiere', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new filiere();



// if ($mform->is_cancelled()) {

//     redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

// } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


// $recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;

//     // var_dump($fromform);
//     // die;
//  if (!$mform->verifiliere($recordtoinsert->libellefiliere)) {
//     # code...
//     $DB->insert_record('filiere', $recordtoinsert);
//     redirect($CFG->wwwroot . '/local/powerschool/filiere.php', 'Enregistrement effectué');
//     exit;
// } else {
//      redirect($CFG->wwwroot . '/local/powerschool/filiere.php', 'Cette filiere execite');
//  }
 
// }

// if($_GET['id']) {

//     $mform->supp_filiere($_GET['id']);
//     redirect($CFG->wwwroot . '/local/powerschool/filiere.php', 'Information Bien supprimée');
        
// }



// var_dump($mform->selectfiliere());
// die;
// $filiere = $DB->get_records('filiere', null, 'id');

// $templatecontext = (object)[
//     'filiere' => array_values($filiere),
//     'filiereedit' => new moodle_url('/local/powerschool/filiereedit.php'),
//     'filieresupp'=> new moodle_url('/local/powerschool/filiere.php'),
//     'specialite' => new moodle_url('/local/powerschool/specialite.php'),
// ];
$espace="";
if($CFG->theme=="boost")
{

}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    $espace='<p style="margin-top:-150px"></p>';
    
}
$menu = (object)[
    // 'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'paiement' => new moodle_url('/local/powerschool/paiementpersoparent.php'),
    'note' => new moodle_url('/local/powerschool/bulletinnotepersoparent.php'),
    'absence' => new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
    'programme' => new moodle_url('/local/powerschool/programmepersoparent.php'),
    'espace'=>$espace
];


echo $OUTPUT->header();

$OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// if($CFG->theme=="boost")
// {
// }
// elseif ($CFG->theme == 'adaptable') {
//     // Changer la couleur en bleu
//     echo "<style>
            
//     </style>";
//     echo $OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// }


echo $OUTPUT->render_from_template('local_powerschool/gerer', $templatecontext);


echo $OUTPUT->footer();