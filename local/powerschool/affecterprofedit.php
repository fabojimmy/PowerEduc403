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
use local_powerschool\affecterprof;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/affecterprof.php');

global $DB;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Modifier un affecterprof');
$PAGE->set_heading('Modifier un affecterprof');


$id = optional_param('id',null,PARAM_INT);

$mform=new affecterprof();




$recordtoinsert = new affecterprof();

    if($fromform->id) {

        $recordtoinsert->update_affecterprof($fromform->id, $fromform->idcoursspecialite, $fromform->idprof);
        redirect($CFG->wwwroot . '/local/powerschool/affecterprof.php', 'Bien modifier');
        
    }
    if (!empty($_POST["professeur"])&& !empty($_POST["specialite"])&& !empty($_POST["cycle"])&& !empty($_POST["cours"]) && !empty($_POST["semestre"])) {
        //  var_dump("df");die;
             $cours=$DB->get_records_sql("SELECT cse.id as idcouse FROM {coursspecialite} as csp,{courssemestre} cse WHERE csp.id=cse.idcoursspecialite AND idsemestre='".$_POST["semestre"]."' AND idcourses='".$_POST["cours"]."' AND idspecialite='".$_POST["specialite"]."' AND idcycle='".$_POST["cycle"]."'");
             foreach ($cours as $key => $value) {
                 
            }
            $recordtoinsert = new stdClass();
            $recordtoinsert->idcourssemestre = $value->idcouse;
            // var_dump($recordtoinsert->idcourssemestre);die;
             $recordtoinsert->idprof =$_POST["professeur"];
            //  var_dump($_POST["professeur"],$_POST["specialite"],$_POST["cycle"],$_POST["cours"],$_POST["semestre"],$recordtoinsert->idcourssemestre,$recordtoinsert->idprof,$USER->id);die;
           
             $DB->execute("UPDATE mdl_affecterprof SET idcourssemestre='".$recordtoinsert->idcourssemestre."',idprof='".$recordtoinsert->idprof."',usermodified='".$USER->id."',timecreated='".time()."',timemodified='".time()."' WHERE id='".$_POST["id"]."'");
            //  $DB->insert_record('affecterprof', $recordtoinsert);
            redirect($CFG->wwwroot . '/local/powerschool/affecterprof.php', 'Enregistrement effectué');

        }


if ($id) {
    // Add extra data to the form.
    global $DB;
    $newaffecterprof = new affecterprof();
    $affecterprof = $newaffecterprof->get_affecterprof($id);
    if (!$affecterprof) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($affecterprof);
}

$sql="SELECT us.id as userid,firstname,lastname FROM {user} as us,{role_assignments} WHERE us.id=userid AND roleid=4";
$professeur=$DB->get_records_sql($sql);
//specialite
$sql="SELECT sp.id,libellespecialite FROM {specialite} sp,{filiere} f WHERE sp.idfiliere=f.id AND idcampus='".$_GET["idca"]."'";
$specialite=$DB->get_records_sql($sql);

$affecter=$DB->get_recordset_sql("SELECT af.id as idaffe,libellecycle,libellespecialite,libellesemestre,fullname,firstname,lastname FROM {coursspecialite} as csp,{courssemestre} cse,{affecterprof} af,
                            {semestre} se,{specialite} sp,{cycle} cy,{course} cou,{user} as us,{filiere} f WHERE sp.idfiliere=f.id AND csp.id=cse.idcoursspecialite AND us.id=idprof
                            AND idsemestre=se.id AND idcourses=cou.id AND idspecialite=sp.id AND idcycle=cy.id AND af.idcourssemestre=cse.id AND f.idcampus='".$_GET["idca"]."'");
// $affecterprof = $DB->get_recordset_sql('affecterprof', null, 'id');
$affecterprof = array();
foreach ($affecter as $record) {
    $affecterprof[] = (array) $record;
}

$templatecontext = (object)[
    'affecterprof' => array_values($affecterprof),
    'professeur' => array_values($professeur),
    'specialite' => array_values($specialite),
    'affecterprofedit' => new moodle_url('/local/powerschool/affecterprofedit.php'),
    'affecterprofsupp'=> new moodle_url('/local/powerschool/affecterprof.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'courssemestre' => new moodle_url('/local/powerschool/affecterprofedi.php'),
    'root'=>$CFG->wwwroot,
    'id'=>$_GET["id"]
];
echo $OUTPUT->header();
// $mform->display();
echo $OUTPUT->render_from_template('local_powerschool/affecterprofedit', $templatecontext);

echo $OUTPUT->footer();



// if ($fromform->id) {

//     $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->dstefin);
//     redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');
    
   
// }