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
use local_powerschool\programme;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/programme.php');

global $DB;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Modifier une programme');
$PAGE->set_heading('Modifier une programme');


$id = optional_param('id',null,PARAM_INT);

$mform=new programme();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'annuler');

} else if ($fromform = $mform->get_data()) {

$recordtoinsert = new programme();

    if($fromform->id) {

        $ggg=$_POST["datecours"];
   
        $fromform->datecours= strtotime($ggg["day"]."-".$ggg["month"]."-".$ggg["year"]);
        // $fromform
        // var_dump($_POST["datecours"]);
        // die;

        $fromform->idspecialite=$_POST["idspecialite"];
        $fromform->idcycle=$_POST["idcycle"];
        $recordtoinsert->update_programme($fromform->id,$fromform->idanneescolaire, $fromform->idcourses,$fromform->idsemestre,$fromform->idspecialite,$fromform->idcycle,$fromform->datecours,$fromform->heuredebutcours,$fromform->heurefincours);
        redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Bien modifier');
        
    }

}

if ($id) {
    // Add extra data to the form.
    global $DB;
    $newprogramme = new programme();
    $programme = $newprogramme->get_programme($id);
    if (!$programme) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($programme);
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();



// if ($fromform->id) {

//     $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->dstefin);
//     redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');
    
   
// }