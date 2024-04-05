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
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/semestre.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer les differentes parties de l\'année scolaire');
$PAGE->set_heading('Enregistrer les differentes parties de l\'année scolaire');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->navbar->add(get_string('semestre', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new semestre();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 $campuss=$DB->get_records("campus");
  if($campuss)
  {

      if (!$mform->verifisemestre($fromform->libellesemestre) ) {
             if (!$mform->verifientreannee($fromform->datedebutsemestre,$fromform->datefinsemestre)) {
                 $trueDe=$DB->get_records_sql("SELECT MAX(id), datefinsemestre FROM {semestre}");
                 $trueDA=$DB->get_records_sql("SELECT MAX(id), datefin FROM {anneescolaire}");
                 // var_dump($trueDe);die;
 
                 foreach($trueDe as $key=>$value)
                 {
 
                 }
                 foreach($trueDA as $key=>$value1)
                 {
 
                 }
                 date("Y-m-d",$value->datefinsemestre);
                 date("Y-m-d",$value1->datefin);
                 // var_dump(date("Y-m-d",$value1->datefin),$value->datefinsemestre,$value1->datefin);
                 // var_dump(date("Y-m-d",$value->datefinsemestre),date("Y-m-d",$value1->datefin),date("Y-m-d",$fromform->datedebutsemestre));
                 // die;
                 
                 if(($value->datefinsemestre<=$fromform->datedebutsemestre && $fromform->datedebutsemestre<=$value1->datefin))
                 {  
                     
                     $DB->insert_record('semestre', $recordtoinsert);
                     redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'Enregistrement effectué'); 
                 }else{
                     \core\notification::add('Mettez la date du prochaine Semestre a la suite de la precedante', \core\output\notification::NOTIFY_ERROR);
                     // redirect($CFG->wwwroot . '/local/powerschool/semestre.php');
                 }
 
             }else{
                 // redirect($CFG->wwwroot . '/local/powerschool/semestre.php', ' -Soit votre date de debut et de date de fin est egale..<br/>
                 
                 // -Soit vos dates que vous avez entrés n\'est pas dans l\'année scolaire...<br/>
                 // -Soit vos dates existent...<br/>
                 // -Soit vos etes de l\'année scolaire...<br/> ');
                 \core\notification::add(' -Soit votre date de debut et de date de fin est egale..<br/>
                 
                 -Soit vos dates que vous avez entrés n\'est pas dans l\'année scolaire...<br/>
                 -Soit vos dates existent...<br/>
                 -Soit vos etes de l\'année scolaire...<br/> ', \core\output\notification::NOTIFY_ERROR);
 
             }
         // exit;
      } 
      else {
         // redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'Ce semestre execite déjà');
         \core\notification::add('Ce semestre execite déjà', \core\output\notification::NOTIFY_ERROR);
 
      }
  }
  else {
    // redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'Ce semestre execite déjà');
    \core\notification::add('Enregistrer un Etablissement', \core\output\notification::NOTIFY_ERROR);

 } 
        
        
}

if($_GET['id']) {

    $mform->supp_semestre($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/semestre.php', 'Information Bien supprimée');
        
}

$sql="SELECT * from {anneescolaire} a ,{semestre} s WHERE s.idanneescolaire = a.id  ";


// $semestre = $DB->get_records('semestre', null, 'id');

$semestres = $DB->get_records_sql($sql);


foreach($semestres as $key ){


    $timead = $key->datedebut;
    $timeaf = $key->datefin;
    $time = $key->datedebutsemestre;
    $times = $key->datefinsemestre;

    $datead = date('Y',$timead);
    $dateaf = date('Y',$timeaf);
    $datedebut = date('d-M-Y',$time);
    $datefin = date('d-M-Y',$times);

    $key->datedebut = $datead;
    $key->datefin = $dateaf;
    $key->datedebutsemestre = $datedebut;
    $key->datefinsemestre= $datefin;

    // var_dump($semestres);
    // die;
}



$templatecontext = (object)[
    'semestre' => array_values($semestres),
    // 'datedebutsem' => $datedebut,
    // 'datefinsem' => $datefin,
    'semestreedit' => $CFG->wwwroot.'/local/powerschool/semestreedit.php',
    'semestresupp'=> $CFG->wwwroot.'/local/powerschool/semestre.php',
    'campus' => $CFG->wwwroot.'/local/powerschool/campus.php',
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


echo $OUTPUT->skip_link_target();
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/semestre', $templatecontext);


echo $OUTPUT->footer();