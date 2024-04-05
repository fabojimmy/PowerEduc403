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
use local_powerschool\seance;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/seance.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/seance.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('seance de Cours');
$PAGE->set_heading('seance de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('seance', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new seance();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();



    // var_dump($fromform);
    // die;
   if (!$recordtoinsert->heuredebutseance===$recordtoinsert->heurefinseance || !($recordtoinsert->heurefinseance<$recordtoinsert->heuredebutseance)) {

    $datesea=$_POST["dateseance"];
    $recordtoinsert->dateseance= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);
    // var_dump($recordtoinsert->dateseance,$_POST["dateseance"]);die;
    // $timecreated=$_POST["timecreated"];
   
    // $recordtoinsert->timecreated= strtotime($timecreated["day"]."-".$timecreated["month"]."-".$timecreated["year"]);
    // $timemodified=$_POST["timemodified"];
    // $recordtoinsert->timemodified= strtotime($timemodified["day"]."-".$timemodified["month"]."-".$timemodified["year"]);
    // var_dump($recordtoinsert->timemodified."-". $recordtoinsert->timecreated."-".$recordtoinsert->dateseance);die;
       $recordtoinsert->usermodified=$_POST["usermodified"];
       $recordtoinsert->idspecialite=$_POST["idspecialite"];
       $recordtoinsert->idcycle=$_POST["idcycle"];
    //    $recordtoinsert->idsemestre=$_POST["idsemestre"];
       $recordtoinsert->timemodified=$_POST["timemodified"];
       $recordtoinsert->timecreated=$_POST["timecreated"];
       $recordtoinsert->idcourses=$_POST["idcourses"];
       $recordtoinsert->idsalle=$_POST["idsalle"];
       $recordtoinsert->heuredebutseance=$_POST["heuredebutseance"];
       $recordtoinsert->heurefinseance=$_POST["heurefinseance"];
       //    $recordtoinsert->dateseance=$_POST["dateseance"];
       $recordtoinsert->idsemestre=$_POST["idsemestre"];
    //    var_dump($recordtoinsert->idsemestre);die;

       $recordtoinsert->idspecialite=$_POST["idspecialite"];
       //    $recordtoinsert->timecreated=$_POST["timecreated"];
       //    $recordtoinsert->timemodified=$_POST["timemodified"];
       $sqlsemestre = "SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."' AND $recordtoinsert->dateseance BETWEEN  datedebutsemestre AND datefinsemestre";
       $bdu=$DB->get_records_sql($sqlsemestre);

    // var_dump($_POST["idcycle"]);die;
      if($bdu)
      {

          $DB->insert_record('seance', $recordtoinsert);
          redirect($CFG->wwwroot . '/local/powerschool/seance.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
      }else{

          \core\notification::add('Entrée une date qui appartient dans le semestre que vous avez choisi', \core\output\notification::NOTIFY_ERROR);
          redirect($CFG->wwwroot . '/local/powerschool/seance.php?idca='.$_POST["idcampus"].'');
      }
       exit;
    }else{
       redirect($CFG->wwwroot . '/local/powerschool/seance.php', 'Entré bien les heures');

   }
}

if($_GET['id']) {

    $mform->supp_seance($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/seance.php', 'Information Bien supprimée');
        
}



$seance = $DB->get_records('seance', null, 'id');

$templatecontext = (object)[
    'seance' => array_values($seance),
    'seanceedit' => new moodle_url('/local/powerschool/seanceedit.php'),
    'seancesupp'=> new moodle_url('/local/powerschool/seance.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'idca'=>$_GET["idca"]
];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/seance.php'),
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

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),

];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/seance', $templatecontext);


echo $OUTPUT->footer();