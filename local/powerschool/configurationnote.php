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

use local_powerschool\configurationnote;
use local_powerschool\periode;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/configurationnote.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/configurationnote.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('confignote', 'local_powerschool'));
// $PAGE->set_heading(get_string('confignote', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('confignote', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new configurationnote();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/configurationmini.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
    if(($fromform->normal+$fromform->cc)>100)
    {
        \core\notification::add('L\'addiction du pourcentage de la normal et du controle continue ne peut pas dépasser 100%', \core\output\notification::NOTIFY_ERROR);
        redirect($CFG->wwwroot . '/local/powerschool/configurationnote.php?');
    
    }
    else{

        $DB->insert_record('configurationnote', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/configurationnote.php', 'Enregistrement effectué');
        exit;
    }
}

if($_GET['id']) {

    $DB->delete_records("configurationnote",array("id"=>$_GET['id']));
    redirect($CFG->wwwroot . '/local/powerschool/configurationnote.php', 'Information Bien supprimée');
        
}



// var_dump($mform->selectperiode());
// die;
$sqlconf="SELECT con.id,normal,cc,libellecampus FROM {configurationnote} con,{campus} c WHERE con.idcampus=c.id";
$periode = $DB->get_records_sql($sqlconf);

$templatecontext = (object)[
    'periode' => array_values($periode),
    'periodeedit' => new moodle_url('/local/powerschool/configurationnoteedit.php'),
    'periodesupp'=> new moodle_url('/local/powerschool/configurationnote.php'),
    'coursspecialite'=> new moodle_url('/local/powerschool/coursspecialite.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),
];

$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),
    'materiell' => new moodle_url('/local/powerschool/materiels.php'),
    'groupe' => new moodle_url('/local/powerschool/groupsalle.php'),
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),

    ];

echo $OUTPUT->header();

if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

$vv=$DB->get_records_sql("SELECT libelletype FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".ChangerSchoolUser($USER->id)."'");

// var_dump($vv,ChangerSchoolUser($USER->id));
// die;
foreach ($vv as $row)
{}
if($row->libelletype=="universite")
{
    $mform->display();

    echo $OUTPUT->render_from_template('local_powerschool/configurationnote', $templatecontext);
}
else
{
    \core\notification::add('Cette interface est reservée aux ecoles supperieur', \core\output\notification::NOTIFY_ERROR);

}


echo $OUTPUT->footer();