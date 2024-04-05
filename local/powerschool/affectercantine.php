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
use local_powerschool\affectercantine;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/affectercantine.php');
require_once(__DIR__ . '/idetablisse.php');
global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/affectercantine.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une Sous Cantine');
$PAGE->set_heading('Enregistrer une Sous Cantine');

// $PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('affectercantine', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new affectercantine();


// $specialiteprimary=[
//    $libelle=> "Sil",
//    $libelle=>"CP",
//    $libelle=> "CE1",
//    $libelle=> "CE2",
//    $libelle=> "CM1",
//    $libelle=>"CM2",
// ];

if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;


        if (!$mform->veriaffectercantine($recordtoinsert->idserveur,$recordtoinsert->idanneescolaire)) {
            // var_dump($recordtoinsert->idcampus);die;
            if($_POST['action'] == 'edit'){
                // var_dump($_POST['action']);
                // die;
                $mform->update_affectercantine($recordtoinsert);

                redirect($CFG->wwwroot . '/local/powerschool/affectercantine.php', 'Modification effectué');
                exit;
            }
            else
            {
                 $DB->insert_record('affectercantine', $recordtoinsert);
                redirect($CFG->wwwroot . '/local/powerschool/affectercantine.php', 'Enregistrement effectué');
                exit;
            }
        }else{
            // redirect($CFG->wwwroot . '/local/powerschool/affectercantine.php', 'Cette affectercantine execite dans ce campus');
            \core\notification::add('Il existe dans cette cantine', \core\output\notification::NOTIFY_ERROR);
            
        }

     
    }

if($_GET['id']&&$_GET['action']=="delete") {

    $mform->supp_affectercantine($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/affectercantine.php', 'Information Bien supprimée');
        
}
if ($_GET['id']&&$_GET['action']=="edit")
{
        // Add extra data to the form.
        global $DB;
        $id = $_GET['id'];
        $newaffectercantine = new affectercantine();
        $affectercantine = $newaffectercantine->get_affectercantine($id);
        if (!$affectercantine) {
            throw new invalid_parameter_exception('Message not found');
        }
        $mform->set_data($affectercantine);
}


$sql = "SELECT af.id,libellesouscantine,libellecantine,firstname,lastname FROM {affectercantine} af ,{cantine} c,{souscantine} s,{user} u WHERE u.id=idserveur AND  s.idcantine=c.id AND af.idsouscantine AND c.idcampus = '".ChangerSchoolUser($USER->id)."' ";


// $affectercantine = $DB->get_records('affectercantine', null, 'id');

$affectercantines = $DB->get_records_sql($sql);


// var_dump($affectercantines);
// die;

$templatecontext = (object)[
    'affectercantine' => array_values($affectercantines),
    // 'specialiteprimary' => array_values($specialiteprimary),
    'affectercantineedit' => new moodle_url('/local/powerschool/affectercantine.php'),
    'affectercantinesupp'=> new moodle_url('/local/powerschool/affectercantine.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'affectercantine' => new moodle_url('/local/powerschool/affectercantine.php'),
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
echo'<div class="secondary-navigation d-print-none" style="margin-top:10px">
<nav class="moremenu navigation observed">
    <ul id="moremenu-643fd15bea2a0-nav-tabs" role="menubar" class="nav more-nav nav-tabs">
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.new moodle_url('/local/powerschool/cantine.php').'" tabindex="0" aria-current="true">
                                   Cantine
                                </a>
                    </li>
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.new moodle_url('/local/powerschool/souscantine.php').'" tabindex="0" aria-current="true">
                                  Sous Cantine
                                </a>
                    </li>
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.new moodle_url('/local/powerschool/affectercantine.php').'" tabindex="0" aria-current="true">
                                  Affecter serveur/se
                                </a>
                    </li>
    </ul>
</nav>
</div>';
$mform->display();
if(!$_GET['action'] == 'edit')
{

    echo $OUTPUT->render_from_template('local_powerschool/affectercantine', $templatecontext);
}




echo $OUTPUT->footer();