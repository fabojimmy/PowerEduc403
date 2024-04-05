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
use local_powerschool\souscantine;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/souscantine.php');
require_once(__DIR__ . '/idetablisse.php');
global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/souscantine.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une Sous Cantine');
$PAGE->set_heading('Enregistrer une Sous Cantine');

// $PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('souscantine', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new souscantine();


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


        if (!$mform->verisouscantine($recordtoinsert->libellesouscantine,$recordtoinsert->idcantine,$recordtoinsert->idanneescolaire)) {
            // var_dump($recordtoinsert->idcampus);die;
            if($_POST['action'] == 'edit'){
                // var_dump($_POST['action']);
                // die;
                $mform->update_souscantine($recordtoinsert);

                redirect($CFG->wwwroot . '/local/powerschool/souscantine.php', 'Modification effectué');
                exit;
            }
            else
            {
                 $DB->insert_record('souscantine', $recordtoinsert);
                redirect($CFG->wwwroot . '/local/powerschool/souscantine.php', 'Enregistrement effectué');
                exit;
            }
        }else{
            // redirect($CFG->wwwroot . '/local/powerschool/souscantine.php', 'Cette souscantine execite dans ce campus');
            \core\notification::add('Elle existe dans cette cantine', \core\output\notification::NOTIFY_ERROR);
            
        }

     
    }

if($_GET['id']&&$_GET['action']=="delete") {

    $mform->supp_souscantine($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/souscantine.php', 'Information Bien supprimée');
        
}
if ($_GET['id']&&$_GET['action']=="edit")
{
        // Add extra data to the form.
        global $DB;
        $id = $_GET['id'];
        $newsouscantine = new souscantine();
        $souscantine = $newsouscantine->get_souscantine($id);
        if (!$souscantine) {
            throw new invalid_parameter_exception('Message not found');
        }
        $mform->set_data($souscantine);
}


$sql = "SELECT s.id,libellesouscantine,libellecantine FROM {souscantine} s ,{cantine} c WHERE s.idcantine=c.id AND c.idcampus = '".ChangerSchoolUser($USER->id)."' ";


// $souscantine = $DB->get_records('souscantine', null, 'id');

$souscantines = $DB->get_records_sql($sql);


// var_dump($souscantines);
// die;

$templatecontext = (object)[
    'souscantine' => array_values($souscantines),
    // 'specialiteprimary' => array_values($specialiteprimary),
    'souscantineedit' => $CFG->wwwroot.'/local/powerschool/souscantine.php',
    'souscantinesupp'=> $CFG->wwwroot.'/local/powerschool/souscantine.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
];

// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'souscantine' => $CFG->wwwroot.'/local/powerschool/souscantine.php'),
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
echo'<div class="secondary-navigation d-print-none" style="margin-top:10px">
<nav class="moremenu navigation observed">
    <ul id="moremenu-643fd15bea2a0-nav-tabs" role="menubar" class="nav more-nav nav-tabs">
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.$CFG->wwwroot.'/local/powerschool/cantine.php'.'" tabindex="0" aria-current="true">
                                   Cantine
                                </a>
                    </li>
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.$CFG->wwwroot.'/local/powerschool/souscantine.php'.'" tabindex="0" aria-current="true">
                                  Sous Cantine
                                </a>
                    </li>
                    <li data-key="siteadminnode" class="nav-item" role="none" data-forceintomoremenu="false">
                                <a role="menuitem" class="nav-link" href="'.$CFG->wwwroot.'/local/powerschool/affectercantine.php'.'" tabindex="0" aria-current="true">
                                  Affecter serveur/se
                                </a>
                    </li>
    </ul>
</nav>
</div>';

$mform->display();
if(!$_GET['action'] == 'edit')
{

    echo $OUTPUT->render_from_template('local_powerschool/souscantine', $templatecontext);
}




echo $OUTPUT->footer();