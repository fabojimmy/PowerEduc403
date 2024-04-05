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
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/Toutbulletin.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Bulletins');
// $PAGE->set_heading('Bulletin');

$PAGE->navbar->add('Administration du Site',  $CFG->wwwroot.'/local/powerschool/index.php');
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();




// if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //   $_POST["idsp"];
    //   $_POST["idcy"];
      $sql1="SELECT idetudiant FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{user} as u,{filiere} as fi,
      {specialite} as sp,{cycle} as cy,{courssemestre} cse,{bulletin} bu, {campus} ca,{typecampus} tcp 
      WHERE tcp.id=ca.idtypecampus AND bu.idspecialite=sp.id AND bu.idcycle=cy.id AND bu.idcampus=ca.id AND li.idbulletin=bu.id AND af.id=li.idaffecterprof AND cse.id=af.idcourssemestre 
      AND co.idcourses=scou.id AND u.id=li.idetudiant AND cy.id=co.idcycle AND sp.id=co.idspecialite AND fi.id=sp.idfiliere
      AND cse.idcoursspecialite=co.id AND sp.id='". $_GET["idsp"]."' AND cy.id='".$_GET["idcy"]."'";

      $bulletins=$DB->get_records_sql($sql1);

    //   foreach($bulletins as $key=>$bulletin){
    //     redirect($CFG->wwwroot . '/local/powerschool/recu/facture/Toutbulletin.php?idetu='.$bulletin->idetudiant.'', 'Bien supp');

    //   }
           
// }

// var_dump($bulletins,$_GET["idsp"]);die;



// $inscription =$tab = array();

//cours

//filiere
// $sql="SELECT * FROM {filiere}";
// $filiere=$DB->get_records_sql($sql);

$templatecontext = (object)[
    'bulletins'=>array_values($bulletins),
    'bulletin'=> $CFG->wwwroot.'/local/powerschool/recu/facture/Toutbulletin.php',
    // 'affectercours'=> $CFG->wwwroot.'/local/powerschool/inscription.php'),
    // 'ajou'=> $CFG->wwwroot.'/local/powerschool/classes/entrernote.php'),
    // 'coursid'=> $CFG->wwwroot.'/local/powerschool/entrernote.php'),
    // 'bulletinnote'=> $CFG->wwwroot.'/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'idsp'=>$_GET["idsp"],
    'idcy'=>$_GET["idcy"],

 ];

// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'salle' => $CFG->wwwroot.'/local/powerschool/salle.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'specialite' => $CFG->wwwroot.'/local/powerschool/specialite.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
//     'programme' => $CFG->wwwroot.'/local/powerschool/programme.php'),
//     'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),

// ];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/Toutbullutin', $templatecontext);


echo $OUTPUT->footer();