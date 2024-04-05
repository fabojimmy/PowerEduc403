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
use local_powerschool\rapportcours;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/rapportcours.php');
require_once($CFG->dirroot.'/local/powerschool/idetablisse.php');

global $DB;
global $USER;

require_login();
// $context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('reglages', 'local_powerschool'));
$PAGE->set_heading(get_string('reglages', 'local_powerschool'));

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('rapportprofadmin', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');


$filiere=$DB->get_records("filiere",array("idcampus"=>ChangerSchoolUser($USER->id)));
$specialite=$DB->get_records_sql("SELECT s.id,libellespecialite FROM {filiere} f,{specialite} s WHERE f.id=s.idfiliere AND f.id='".$_GET["idfi"]."'");
$cycle=$DB->get_records_sql("SELECT cy.id,cy.libellecycle FROM {coursspecialite} csp,{cycle} cy WHERE csp.idcycle=cy.id AND csp.idspecialite='".$_GET["idsp"]."'");
$cours=$DB->get_records_sql("SELECT cou.id,cou.fullname FROM {coursspecialite} csp,{course} cou WHERE csp.idcourses=cou.id AND csp.idspecialite='".$_GET["idsp"]."' AND csp.idcycle='".$_GET["idcy"]."'");
$professeur=$DB->get_records_sql("SELECT u.id,u.firstname,u.lastname FROM {coursspecialite} csp,{courssemestre} css,{affecterprof} aff,{user} u WHERE css.idcoursspecialite=csp.id AND u.id=aff.idprof AND aff.idcourssemestre=css.id AND csp.idcourses='".$_GET["idcou"]."'");

$idcou = (empty($_GET["idcou"])) ? 1 : $_GET["idcou"];
$idpro = (empty($_GET["idpro"])) ? 1 : $_GET["idpro"];

$tarrapp=[];


$pp=$DB->get_records_sql("SELECT * FROM {rapportcours} WHERE idcours='".$idcou."' AND usermodified='".$idpro."' AND validerap=0");
            
foreach($pp as $key=>$value)
{
    $time = $value->timecreated;
    
    $dated = date('d/m/Y',$time);
    
    $value->timecreated = $dated;


    $sqlcverifier="SELECT CASE WHEN frequeappre<>'' AND feedback<>'' AND contenucouvert<>'' AND activiteclasse<>'' AND progresapprenant<>''
    AND comportappre<>'' AND questappren<>'' AND duree<>0 AND heuredebut<>0 AND heurefin<>0 AND probletechlogis<>''
    THEN 'Complet'ELSE 'INCOMPLET' END AS statt,id FROM {rapportcours} WHERE id='".$value->id."'"
    ;

    $sta=$DB->get_record_sql($sqlcverifier);

    if($sta->statt=="Complet"){

        array_push($tarrapp,$value);
    }


}

if($_GET["action"] == "edit" && !empty($_GET["idrap"]))
{
    // var_dump($_GET["idrap"]);die;
    // $DB->update_record("rapportcours", array("id" => $_GET["idrap"],
    //                                             "validerap"=>1));

    $DB->execute('UPDATE `mdl_rapportcours` SET `validerap`=1 WHERE id='.$_GET["idrap"].'');
    \core\notification::add('Ce rapport a été validé ', \core\output\notification::NOTIFY_SUCCESS);

}


$record=array(
    "rappor"=>array_values($tarrapp),
    "filiere"=>array_values($filiere),
    "specialite"=>array_values($specialite),
    "cycle"=>array_values($cycle),
    "cours"=>array_values($cours),
    "professeur"=>array_values($professeur),
    "idcy"=>$_GET["idcy"],
    "idsp"=>$_GET["idsp"],
    "idfi"=>$_GET["idfi"],
    "idcou"=>$_GET["idcou"],
    "confpaie"=>new moodle_url('/local/powerschool/rapportprofadmin.php'),
    "afficher"=>new moodle_url('/local/powerschool/afficherrapport.php'),
    "modifier"=>new moodle_url('/local/powerschool/rapportprofadmin.php'),
);
echo $OUTPUT->header();
// $rapport->display();
echo $OUTPUT->render_from_template('local_powerschool/rapportprofadmin',$record);
echo $OUTPUT->footer();