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
use local_powerschool\cycle;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/cycle.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/cycle.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un cycle');
$PAGE->set_heading('Enregistrer un cycle');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('cycle', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new cycle();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {


$recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;
$recordtoinsert->libellecycle=$_POST["libellecycle"];
$recordtoinsert->nombreannee=$_POST["nombreannee"];
$recordtoinsert->idcampus=$_POST["idcampus"];
$recordtoinsert->usermodified=$USER->id;
$recordtoinsert->timemodified=time();
$recordtoinsert->timecreated=time();
    // var_dump($recordtoinsert);
    // die;
    if (!$mform->verificycle($_POST["libellecycle"],$_POST["idcampus"])) {
        # code...

        
        $DB->insert_record('cycle', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/cycle.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
        exit;
    }else{
        \core\notification::add('Ce cycle execite déjà', \core\output\notification::NOTIFY_ERROR);
        redirect($CFG->wwwroot . '/local/powerschool/cycle.php?idca='.$_POST["idcampus"].'');

    }
 
}

if($_GET['id']) {

    $mform->supp_cycle($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/cycle.php', 'Information Bien supprimée');
        
}



// var_dump($mform->selectcycle());
// die;
$cycle = $DB->get_records('cycle',array("idcampus"=>ChangerSchoolUser($USER->id)));
$campus = $DB->get_records('campus');

$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/cycle.php'),
            ]; 

            $rolecasql="SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".ChangerSchoolUser($USER->id)."'";
            $campusr=$DB->get_records_sql($rolecasql);
            foreach($campusr as $key=>$campu)
            {}
            if($campu->libelletype=="college"||$campu->libelletype=="lycee"||$campu->libelletype=="primaire")
            {
                $table2='
                              <input type="checkbox" class="toutly">
                                <tr>
                                    <td><input type="checkbox" name="cycle[]" class="checkboxItem" value="standard">standard</td>
                                </tr>';
                            
            }

$templatecontext = (object)[
    'cycle' => array_values($cycle),
    'table2' => $table2,
    'cycleedit' => new moodle_url('/local/powerschool/cycleedit.php'),
    'cyclesupp'=> new moodle_url('/local/powerschool/cycle.php'),
    'coursspecialite'=> new moodle_url('/local/powerschool/coursspecialite.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),
    'root' => $CFG->wwwroot,
    'idca' => ChangerSchoolUser($USER->id),
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
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
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
$menu = (object)[
    'statistique' => new moodle_url('/local/powerschool/statistique.php'),
    'reglage' => new moodle_url('/local/powerschool/reglages.php'),
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),

    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
    'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/cycle', $templatecontext);


echo $OUTPUT->footer();