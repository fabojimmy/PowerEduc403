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
use local_powerschool\periode;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/periode.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/periode.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un periode');
$PAGE->set_heading('Le nombre Etudiant');

// $PAGE->navbar->add('Administration du Site',  $CFG->wwwroot.'/local/powerschool/index.php'));
// $PAGE->navbar->add(get_string('periode', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new periode();


$sqlsommeetufilsp="SELECT i.id,libellecycle,libellespecialite,count(i.idetudiant) as nombetu  FROM {inscription} i,{user} u,{cycle} cy,{specialite} sp
                   WHERE u.id=i.idetudiant AND cy.id=i.idcycle AND sp.id=i.idspecialite AND idspecialite ='".$_GET["idsp"]."' AND idcycle='".$_GET["idcy"]."' 
                   AND i.idanneescolaire='".$_GET["idan"]."'";

$etudiant=$DB->get_records_sql($sqlsommeetufilsp);

foreach($etudiant as $key=>$valsom)
{
    // $sommeperso="SELECT SUM(montant) as entrees FROM {paiement} pa WHERE idinscription='".$valsom->id."'";
    // $somme=$DB->get_records_sql($sommeperso);

    // foreach($somme as $key =>$valso)
    // {
    // }
    // $valsom->somme=$valso->entrees;
}

// $sommeapayersql="SELECT SUM(somme) as somme FROM {filierecycletranc} WHERE idfiliere='".$_GET["idfi"]."' AND idcycle='".$_GET["idcy"]."'";
// $sommesss=$DB->get_records_sql($sommeapayersql);
// foreach($sommesss as $key=>$valll)
// {
// }
// var_dump($etudiant,$_GET["idcy"],$_GET["idsp"],$_GET["idan"]);die;
$templatecontext = (object)[
    'etudiant' => array_values($etudiant),
    'periodeedit' => $CFG->wwwroot.'/local/powerschool/periodeedit.php',
    'periodesupp'=> $CFG->wwwroot.'/local/powerschool/periode.php',
    'coursspecialite'=> $CFG->wwwroot.'/local/powerschool/coursspecialite.php',
    'programme' => $CFG->wwwroot.'/local/powerschool/programme.php',
    'sommeapayer'=>$valll->somme
];



echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/listenombreapp', $templatecontext);


echo $OUTPUT->footer();