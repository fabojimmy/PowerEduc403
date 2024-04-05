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
require_once(__DIR__ . '/idetablisse.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/salleele.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('sallele', 'local_powerschool'));


$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/configurationmini.php');
$PAGE->navbar->add(get_string('sallele', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

//cours

//filiere
// $sql3="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
//     s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid,numerosalle,capacitesalle
//     FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
//     WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite=s.id AND i.idcampus=c.id AND i.idcycle =cy.id AND i.idcampus='".$_GET["idca"]."'";

$sql3="SELECT
s.libellespecialite,
cy.libellecycle,
GROUP_CONCAT(DISTINCT CONCAT(sa.numerosalle, ' - ', sa.capacitesalle) ORDER BY sa.numerosalle ASC SEPARATOR ', ') AS salles_occupees
FROM
{inscription} i
JOIN
{anneescolaire} a ON i.idanneescolaire = a.id
JOIN
{user} u ON i.idetudiant = u.id
JOIN
{specialite} s ON i.idspecialite = s.id
JOIN
{campus} c ON i.idcampus = c.id
JOIN
{cycle} cy ON i.idcycle = cy.id
JOIN
{salleele} saet ON u.id = saet.idetudiant
JOIN
{salle} sa ON saet.idsalle = sa.id
WHERE
etudiantpresen = 1 AND i.idcampus = '".ChangerSchoolUser($USER->id)."'
GROUP BY
s.libellespecialite, cy.libellecycle
ORDER BY
s.libellespecialite ASC, cy.libellecycle ASC;
";
$salleo=$DB->get_recordset_sql($sql3);
$sql4="SELECT
s.libellespecialite,
cy.libellecycle,
GROUP_CONCAT(DISTINCT CONCAT(sa.numerosalle, ' - ', sa.capacitesalle) ORDER BY sa.numerosalle ASC SEPARATOR ', ') AS salles_occupees
FROM
{inscription} i
JOIN
{anneescolaire} a ON i.idanneescolaire = a.id
JOIN
{user} u ON i.idetudiant = u.id
JOIN
{specialite} s ON i.idspecialite = s.id
JOIN
{campus} c ON i.idcampus = c.id
JOIN
{cycle} cy ON i.idcycle = cy.id
JOIN
{salleele} saet ON u.id = saet.idetudiant
JOIN
{salle} sa ON saet.idsalle = sa.id
WHERE
(etudiantpresen = 0 OR sa.id NOT IN (SELECT saaa.id FROM {salle} saaa, {salleele} saa WHERE saaa.id = saa.idsalle AND saa.etudiantpresen = 1 AND saaa.idcampus = '".ChangerSchoolUser($USER->id)."'))
    AND i.idcampus = '".ChangerSchoolUser($USER->id)."'
GROUP BY
s.libellespecialite, cy.libellecycle
ORDER BY
s.libellespecialite ASC, cy.libellecycle ASC;
";
$sallenonoc=$DB->get_records_sql($sql4);
// Remplacez 'valeur_idca' par la valeur de $_GET["idca"]
// var_dump($sallenonoc);die;

$salleocc = array();
foreach ($salleo as $record) {
    $salleocc[] = (array) $record;
}
$sql="SELECT * FROM {filiere} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
$sql1="SELECT * FROM {salle} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
$sql2="SELECT * FROM {campus}";
$filiere=$DB->get_records_sql($sql);
$salle=$DB->get_records_sql($sql1);
$campus=$DB->get_records_sql($sql2);
$annee=$DB->get_records_sql("SELECT * FROM {anneescolaire}");
            foreach($annee as $key => $ab)
            {
                $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
            }
$templatecontext = (object)[
    'filiere'=>array_values($filiere),
    'campus'=>array_values($campus),
    'salle'=>array_values($salle),
    'anneee'=>array_values($annee),
    'salleocc'=>array_values($salleocc),
    'ajoute'=> $CFG->wwwroot.'/local/powerschool/inscription.php',
    'affectercours'=> $CFG->wwwroot.'/local/powerschool/inscription.php',
    'ajou'=> $CFG->wwwroot.'/local/powerschool/classes/entrernote.php',
    'coursid'=> $CFG->wwwroot.'/local/powerschool/entrernote.php',
    'bulletinnote'=> $CFG->wwwroot.'/local/powerschool/bulletinnote.php',
    'root'=>$CFG->wwwroot,
    'salleele' => $CFG->wwwroot.'/local/powerschool/salleele.php',
    'salleeleretirer' => $CFG->wwwroot.'/local/powerschool/salleeleretirer.php',
    'title'=>get_string('sallele', 'local_powerschool')
 ];

 $menumini = (object)[
    'affecterprof' => $CFG->wwwroot.'/local/powerschool/affecterprof.php',
    'configurerpaie' => $CFG->wwwroot.'/local/powerschool/configurerpaiement.php',
    'coursspecialite' => $CFG->wwwroot.'/local/powerschool/coursspecialite.php',
    'tranche' => $CFG->wwwroot.'/local/powerschool/tranche.php',
    'salleele' => $CFG->wwwroot.'/local/powerschool/salleele.php',
    'message' => $CFG->wwwroot.'/local/powerschool/message.php',
    'confinot' => $CFG->wwwroot.'/local/powerschool/configurationnote.php',
    'logo' => $CFG->wwwroot.'/local/powerschool/logo.php',
    'message' => $CFG->wwwroot.'/local/powerschool/message.php',
    'materiell' => $CFG->wwwroot.'/local/powerschool/materiels.php',
    'groupe' => $CFG->wwwroot.'/local/powerschool/groupsalle.php',
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),



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
// if($CFG->theme=="boost")
//   {
//       echo'<div class="" style="margin-top:110px;"></div>';
//   }
//    elseif ($CFG->theme == 'adaptable') 
//     {
//             // Changer la couleur en bleu
//             echo'<div class="" style="margin-top:50px;"></div>';            
//      }

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/salleele', $templatecontext);


echo $OUTPUT->footer();