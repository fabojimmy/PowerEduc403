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
require_once($CFG->dirroot.'/local/powerschool/fichepaie.php');

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
$PAGE->navbar->add(get_string('rapport', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$rapport=new rapportcours();


// var_dump(mtntTotal(5,2,2024));die;
if ($rapport->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $rapport->get_data()) {

    // var_dump($_POST["idfi"]);die;
    // die;

    $recordtoinsert = new stdClass();
    $recordtoinsert = $fromform;

    // var_dump($recordtoinsert);die;
    $DB->update_record("rapportcours",$recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/rapportCours.php?id='.$_POST["idcours"].'', 'Enregistrement effectué');

}
$pp=$DB->get_records_sql("SELECT * FROM {rapportcours} WHERE idcours='".$_GET["id"]."' AND usermodified='".$USER->id."'");

//Verifier si les données sont complets


foreach($pp as $key=>$value)
{
    $time = $value->timecreated;
    
    $dated = date('d/m/Y',$time);
    
    $value->timecreated = $dated;

    if($value->validerap==1){
        $value->disabled="disabled";
        $value->activer="<span class='badge badge-success'>Valider</span>";
    }else{
        
        $value->activer="<span class='badge badge-info'>No valider</span>";
    }

    $sqlcverifier="SELECT CASE WHEN frequeappre<>'' AND feedback<>'' AND contenucouvert<>'' AND activiteclasse<>'' AND progresapprenant<>''
    AND comportappre<>'' AND questappren<>'' AND duree<>0 AND heuredebut<>0 AND heurefin<>0 AND probletechlogis<>''
    THEN 'Complet'ELSE 'INCOMPLET' END AS statt FROM {rapportcours} WHERE id=".$value->id.""
    ;

    $sta=$DB->get_records_sql($sqlcverifier);

    foreach ($sta as $key => $value1) {
        # code...
        $value->status=$value1->statt;

        if($value->status =="Complet"){
            $value->disabled="disabled";
        }
        // var_dump($value1->statt,$value->id);
    }




}
// die;

$record=array(
    "rappor"=>array_values($pp),
    "idcour"=>$_GET["id"],
    "modifrap"=>$CFG->wwwroot . '/local/powerschool/rapportCours.php',
    "afficher"=>new moodle_url('/local/powerschool/afficherrapport.php'),
);
echo $OUTPUT->header();

if($_GET["action"] == "edit"){
    
    $rapport->display();
}else
{

    echo $OUTPUT->render_from_template('local_powerschool/rapportcours',$record);
}
echo $OUTPUT->footer();