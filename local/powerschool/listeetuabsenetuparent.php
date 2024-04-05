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
// use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/listeetuabsenetu.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('absenceetu', 'local_powerschool'));
$PAGE->set_heading(get_string('absenceetu', 'local_powerschool'));

// $PAGE->navbar->add(get_string('statistique', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('absenceetu', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();


// $inscription =$tab = array();

//absence

$sql="SELECT sbet.id,u.firstname,u.lastname,a.datedebut,a.datefin,sbet.idprof,c.fullname,sbet.timecreated,sbet.heuredebutcours,sbet.nombreheure
FROM {absenceetu} sbet,{user} u,{anneescolaire} a,{course} c,{coursspecialite} cs,{courssemestre} css,{cycle} cy,{specialite} sp
WHERE u.id=sbet.idetudiant AND c.id=sbet.idcourses AND a.id=sbet.idanneescolaire AND sbet.idspecialite=sp.id AND sbet.idetudiant='".$_GET["idenf"]."' AND u.idparent='".$USER->id."'
AND sbet.idcycle=cy.id AND cs.idcourses=c.id AND cs.id=css.idcoursspecialite AND css.idsemestre='".$_GET["idsem"]."' AND sbet.id NOT IN (SELECT idabsenceetu FROM {absencejustifier})";

// $_GET["idsem"]==1;
if($_GET["idsem"])
{
    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);
    // die;
}else
{
    $cours=[];
}
// die;

foreach ($cours as $key => $value1) {
    $user=$DB->get_records("user",array("id"=>$value1->idprof));
    foreach($user as $key => $vauser)
    {}
    $value1->timecreated=date("d-m-Y",$value1->timecreated);
// var_dump($vauser->fullname,$value1->idprof);die;
    $value1->professeur=$vauser->firstname;
    $value1->dateannee=date("Y",$value1->datedebut).'-'.date("Y",$value1->datefin);

}
//filiere
$semestre=$DB->get_records("semestre");
$enfant=$DB->get_records("user",array("idparent"=>$USER->id));
$templatecontext = (object)[
    'semestre'=>array_values($semestre),
    'enfant'=>array_values($enfant),
    // // 'campus'=>array_values($campus),
    'cours'=>array_values($cours),
    // 'annee'=>array_values($annee),
    'absence'=> new moodle_url('/local/powerschool/absenceetu.php'),
    'courssemestre'=> new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
    'enfantabse'=> new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
    // 'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    // 'ajou'=> new moodle_url('/local/powerschool/classes/entrernote.php'),
    // 'coursid'=> new moodle_url('/local/powerschool/entrernote.php'),
    // 'bulletinnote'=> new moodle_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'idca'=>$_GET["idca"],
    'idsem'=>$_GET["idsem"],
    // 'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'salleeleretirer' => new moodle_url('/local/powerschool/absenceetu.php'),

 ];
 $menu = (object)[
    'programme' => new moodle_url('/local/powerschool/programmepersoparent.php'),
    'paiement' => new moodle_url('/local/powerschool/paiementpersoparent.php'),
    'note' => new moodle_url('/local/powerschool/bulletinnotepersoparent.php'),
    'absence' => new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
];

//  $menumini = (object)[
//     'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
//     'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
//     'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salleele' => new moodle_url('/local/powerschool/salleele.php'),
// ];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'specialite' => new moodle_url('/local/powerschool/specialite.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),

// ];

// $campus=$DB->get_records('campus');
$campuss=(object)[
        // 'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/listeetuabsenprof.php'),
    ];
echo $OUTPUT->header();

// echo '<div style="margin-top:80px";><wxcvbn</div>';
echo $OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/listeetuabsenetuparent', $templatecontext);


echo $OUTPUT->footer();