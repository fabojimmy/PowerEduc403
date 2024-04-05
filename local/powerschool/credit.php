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
use local_powerschool\credit;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/idetablisse.php');
require_once($CFG->dirroot.'/local/powerschool/classes/credit.php');

global $DB;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Ajouter le credit');
$PAGE->set_heading('Ajouter le credit');


// $id = optional_param('id',null,PARAM_INT);

$mform=new credit();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php', 'annuler');

} else if ($fromform = $mform->get_data()) {

// $recordtoinsert = new credit();
       $claa=new stdClass();
       $claa->id=$fromform->idspco;
       $claa->credit=$fromform->credit;

        // var_dump($fromform->id, $fromform->idcourses,$_POST["idspecialite"],$_POST["idcycle"],$_POST["idcampus"]);die;
        $DB->update_record("coursspecialite",$claa);
        redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php?idca='.$_POST["idcampus"].'', 'Le credit a étè bien ajouté ');

}

echo $OUTPUT->header();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo'<div style="margin-top:35px"></div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

$vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_GET["idca"]."'");

foreach($vericam as $key)
{}
if($key->libelletype=="universite" || $key->libelletype=="lycee" || $key->libelletype=="college")
{

    $mform->display();
}else
{
    \core\notification::add('Votre n\'est autorisé pour cette partie', \core\output\notification::NOTIFY_ERROR);

            redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php');
       
}


// echo $OUTPUT->render_from_template('local_powerschool/coursspecialite', $templatecontext);


echo $OUTPUT->footer();
?>