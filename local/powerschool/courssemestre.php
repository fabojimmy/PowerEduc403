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
use local_powerschool\courssemestre;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/courssemestre.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/courssemestre.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une partie de l\'année scolaire à cette configuration ');
$PAGE->set_heading('Enregistrer une partie de l\'année scolaire à cette configuration');

$PAGE->navbar->add(get_string('coursspecialite', 'local_powerschool'),  new moodle_url('/local/powerschool/coursspecialite.php?idca='.ChangerSchoolUser($USER->id).''));
$PAGE->navbar->add(get_string('courssemestre', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new courssemestre();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
    // if(!$mform->veri_semes($_POST["idspc"],$_POST["idsemestre"]))
    // {
    //    var_dump($_POST["idspc"],$_POST["idsemestre"]);die;
    
            $semestre=$DB->get_records("semestre",array("id"=>$_POST["idsemestre"]));
            foreach ($semestre as $key => $valuesem) {
                # code...
            }

            $cycle=$DB->get_records("cycle",array("id"=>$_POST["idcycle"]));
            foreach ($cycle as $key => $valuecycl) {
                # code...
            }
            
            $camp=$DB->get_records("campus",array("id"=>$_POST["idcampus"]));
            foreach ($camp as $key => $value) {
                # code...
            }
            $categcamp=$DB->get_records("course_categories",array("name"=>$value->libellecampus,"depth"=>1));
            foreach ($categcamp as $key => $valuecam) {
                # code...
            }

            $specia=$DB->get_records("specialite",array("id"=>$_POST["idspecialite"]));
            foreach ($specia as $key => $value2) {
                # code...
            }
            $filiere=$DB->get_records("filiere",array("id"=>$value2->idfiliere));
            foreach ($filiere as $key => $value3) {
                # code...
            }
            $categfil=$DB->get_records("course_categories",array("name"=>$value3->libellefiliere,"depth"=>2));
            // var_dump($filiere);
            foreach ($categfil as $key => $valuefil) {
                # code...
                $fff=explode("/",$valuefil->path);
                $iddc=array_search($valuecam->id,$fff);
                if($iddc!==false)
                {
                    $idcatfil=$valuefil->id;
                    // var_dump( $idcatfil);
                }
            }
            $categ=$DB->get_records("course_categories",array("name"=>$value2->libellespecialite,"depth"=>3));
            foreach ($categ as $key => $value1) {
                # code...
                $fff=explode("/",$value1->path);
                $iddc=array_search($valuecam->id,$fff);
                $iddfil=array_search($idcatfil,$fff);
                if($iddc!==false && $iddfil!==false)
                {
                    $idcat=$value1->id;

                    // var_dump($idcat);
                }
            }
            $categcy=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
            // var_dump( $categcy);
            // die;
            foreach ($categcy as $key => $value1cy) {
                # code...
                $fffcy=explode("/",$value1cy->path);
                $iddc=array_search($valuecam->id,$fffcy);
                $iddfil=array_search($idcatfil,$fffcy);
                $iddsp=array_search( $idcat,$fffcy);
                if($iddc!==false&&$iddfil!==false&&$iddsp!==false)
                {
                    $idcatcy=$value1cy->id;
                    // var_dump($idcatcy);
                }
            }
            $categsem=$DB->get_records("course_categories",array("name"=>$valuesem->libellesemestre,"depth"=>5));
            // var_dump( $categcy);
            // die;
            foreach ($categsem as $key => $value1sem) {
                # code...
                $fffsem=explode("/",$value1sem->path);
                $iddc=array_search($valuecam->id,$fffsem);
                $iddfil=array_search($idcatfil,$fffsem);
                $iddsp=array_search( $idcat,$fffsem);
                $iddcy=array_search( $idcatcy,$fffsem);
                if($iddc!==false&&$iddfil!==false&&$iddsp!==false&&$iddcy!==false)
                {
                    $idcatsem=$value1sem->id;
                    var_dump($idcatcy);
                }
            }
            // var_dump( $idcat);die;
//  die;
if($idcatsem==null || $idcatsem==0)
{

    $DB->insert_record('courssemestre', $recordtoinsert);
    redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$idcatcy.'&semestre='.$valuesem->libellesemestre.'', 'Enregistrement effectué');
}else{
    // var_dump("rien");die;
    $DB->insert_record('courssemestre', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/courssemestre.php?idcosp='.$_POST["idcoursspecialite"].'', 'Enregistrement effectué');
}
}
// else{
//     // var_dump("kgvb,;bv;,nb");die;
//     \core\notification::add('Cette configuration a été fait précedemment enregistré regarder dans le tableau,liberez le d\'abord dans ce tableau', \core\output\notification::NOTIFY_ERROR);

//     redirect($CFG->wwwroot . '/local/powerschool/courssemestre.php?idcosp='.$_POST["idspc"].'');
// }

        // exit;
// }

if($_GET['id']) {

    $mform->supp_courssemestre($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/courssemestre.php?idcosp='.$_GET["idcosp"].'', 'Information Bien supprimée');
        
}


$sql = "SELECT cs.id as idcose,libellesemestre,nombreheure,idcoursspecialite as idcosp FROM  {semestre} s, {courssemestre} cs WHERE cs.idsemestre = s.id AND cs.idcoursspecialite = '".$_GET["idcosp"]."' ";


$courssemestres = $DB->get_records_sql($sql);

// var_dump($courssemestres);
// die;
// $courssemestre = $DB->get_records('courssemestre', null, 'id');

$templatecontext = (object)[
    'courssemestre' => array_values($courssemestres),
    'courssemestreedit' => new moodle_url('/local/powerschool/courssemestreedit.php'),
    'courssemestresupp'=> new moodle_url('/local/powerschool/courssemestre.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),

];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    'notes' => new moodle_url('/local/powerschool/note.php'),

];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/courssemestre', $templatecontext);


echo $OUTPUT->footer();