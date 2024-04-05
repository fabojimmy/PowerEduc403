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
use local_powerschool\semestre;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/semestre.php');

global $DB;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Modifier une semestre');
$PAGE->set_heading('Modifier une semestre');


$id = optional_param('id',null,PARAM_INT);

$mform=new semestre();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'annuler');

} else if ($fromform = $mform->get_data()) {

$recordtoinsert = new semestre();

    if($fromform->id) {

        $recordtoinsert->update_semestre($fromform->id, $fromform->numerosemestre,$fromform->libellesemestre,$fromform->datedebutsemestre,$fromform->datefinsemestre,$fromform->idanneescolaire);
        redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'Bien modifier');
        
    }

}

if ($id) {
    // Add extra data to the form.
    global $DB;
    $newsemestre = new semestre();
    $semestre = $newsemestre->get_semestre($id);
    if (!$semestre) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($semestre);
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();



// if ($fromform->id) {

//     $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->dstefin);
//     redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');
    
   
// }