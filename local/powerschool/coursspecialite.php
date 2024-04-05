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
use local_powerschool\coursspecialite;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/coursspecialite.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/coursspecialite.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('coursspecialite', 'local_powerschool'));
// $PAGE->set_heading(get_string('coursspecialite', 'local_powerschool'));

if(has_capability("local/powerschool:configurationminimal",context_system::instance(),$USER->id))
{
    $PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
}
$PAGE->navbar->add(get_string('coursspecialite', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new coursspecialite();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;
    
        if (!$mform->verifcourspeciali($_POST["idcycle"],$_POST["idspecialite"],$_POST["idcampus"])) {
            # code...

            // var_dump($recordtoinsert->idcourses, $_POST["idcycle"],$_POST["idspecialite"],$_POST["credit"]);die;
            $recordtoinsert->idcycle=$_POST["idcycle"];
            $recordtoinsert->idspecialite=$_POST["idspecialite"];
            $recordtoinsert->credit=$_POST["credit"];
            $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];

            // var_dump($recordtoinsert->idanneescolaire);die;
            $recordtoinsert->idcourses=0;

            // var_dump($_POST["idspecialite"]);die;
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
                if($iddc!==false&&$iddfil!==false)
                {
                    $idcat=$value1->id;
                    // var_dump( $idcat);
                }
            }
            $vercycat=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
            foreach ($vercycat as $key => $value1cyy) {
                # code...
                $fff=explode("/",$value1cyy->path);
                $iddc=array_search($valuecam->id,$fff);
                $iddfil=array_search($idcatfil,$fff);
                $iddspp=array_search($idcat,$fff);
                // var_dump($idcat,$idcatfil,$valuecam->id,$value1cyy->path);
                if($iddc!==false&&$iddfil!==false&&$iddspp!==false)
                {
                    $idcatcy=$value1cyy->id;
                    // var_dump("Exicte");
                    // $catsperec=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
                    // $DB->insert_record('coursspecialite', $recordtoinsert);
                    // $DB->execute("INSERT INTO mdl_coursspecialite VALUES(0,'".$recordtoinsert->idcourses."','".$recordtoinsert->idspecialite."','".$recordtoinsert->idcycle."','".$recordtoinsert->credit."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','".$recordtoinsert->timemodified."')");
                }else{
                    // $DB->insert_record('coursspecialite', $recordtoinsert);
                    // redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$idcat.'&cycle='.$valuecycl->libellecycle.'&idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
                }
            }
            if($idcatcy==null || $idcatcy==0)
            {
                // var_dump( $idcatcy);
                // die;
                // var_dump( $idcatcy);
                
                //     die;
                $DB->insert_record('coursspecialite', $recordtoinsert);
                redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$idcat.'&cycle='.$valuecycl->libellecycle.'&idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
            }else{
                // var_dump("local");
                // die;
                $DB->insert_record('coursspecialite', $recordtoinsert);
                redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
            }

            exit;
        }else{
            \core\notification::add('Cette configuration a été fait précedemment enregistré regarder dans le tableau,liberez le d\'abord dans ce tableau', \core\output\notification::NOTIFY_ERROR);

            redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php?idca='.$_POST["idcampus"].'');
       
        }
     
    }

if($_GET['id']) {

    $mform->supp_coursspecialite($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php?idca='.$_GET['idca'].'', 'Information Bien supprimée');
        
}


// if(has_capability("local/powerschool:activation",$modulecontext,$USER->id) )
// {

    $sql = "SELECT cs.id,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,credit,abreviationspecialite,cy.nombreannee,libellesemestre,cs.idspecialite,css.idsemestre,idfiliere,nombreheure,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f,{courssemestre} css,{semestre} see
            WHERE see.id=css.idsemestre AND s.idfiliere=f.id AND css.idcoursspecialite=cs.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".ChangerSchoolUser($USER->id)."' AND idcourses NOT IN(SELECT id FROM {course})";
    // $sql = "SELECT cs.id,fullname,libellespecialite,libellecycle,credit,shortname,abreviationspecialite,cy.nombreannee FROM {course} c, {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f
    //         WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND cs.idcourses = c.id AND f.idcampus='".$_GET["idca"]."'";

    $sql1 = "SELECT cs.id,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,abreviationspecialite,cs.idspecialite,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f
            WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".ChangerSchoolUser($USER->id)."' AND cs.id NOT IN (SELECT idcoursspecialite FROM {courssemestre})";

    $sql2 = "SELECT cs.id,nombreannee,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,abreviationspecialite,cs.idspecialite,fullname,shortname,libellesemestre,nombreheure,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f,{course} c,{courssemestre} css,{semestre} sem
            WHERE sem.id=css.idsemestre AND cs.id=css.idcoursspecialite AND c.id =cs.idcourses AND s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".ChangerSchoolUser($USER->id)."'";
// }
// else{
//     $gg=$DB->get_records("user",array("id"=>$USER->id));
    
//             foreach($gg as $kk)
//             {}
            
//             // $camp=$DB->get_records("campus",array("id"=>$kk->idcampuser));
//     $sql = "SELECT cs.id,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,credit,abreviationspecialite,cy.nombreannee,libellesemestre,cs.idspecialite,css.idsemestre,idfiliere,nombreheure,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f,{courssemestre} css,{semestre} see
//             WHERE see.id=css.idsemestre AND s.idfiliere=f.id AND css.idcoursspecialite=cs.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".$kk->idcampuser."' AND idcourses NOT IN(SELECT id FROM {course})";
//     // $sql = "SELECT cs.id,fullname,libellespecialite,libellecycle,credit,shortname,abreviationspecialite,cy.nombreannee FROM {course} c, {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f
//     //         WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND cs.idcourses = c.id AND f.idcampus='".$_GET["idca"]."'";

//     $sql1 = "SELECT cs.id,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,abreviationspecialite,cs.idspecialite,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f
//             WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".$kk->idcampuser."' AND cs.id NOT IN (SELECT idcoursspecialite FROM {courssemestre})";

//     $sql2 = "SELECT cs.id,nombreannee,cy.id as idcy,s.id as idsp,f.idcampus,libellespecialite,libellecycle,abreviationspecialite,cs.idspecialite,fullname,shortname,libellesemestre,nombreheure,credit FROM {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f,{course} c,{courssemestre} css,{semestre} sem
//             WHERE sem.id=css.idsemestre AND cs.id=css.idcoursspecialite AND c.id =cs.idcourses AND s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND f.idcampus='".$kk->idcampuser."'";
// //  die;

// }
// $sql = "SELECT cs.id,fullname,libellespecialite,libellecycle,credit,shortname,abreviationspecialite,nombreannee FROM {course} c, {specialite} s, {cycle} cy , {coursspecialite} cs,{filiere} f
//         WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND cs.idcourses = c.id AND idcampus='".$_GET["idca"]."'";


// $coursspecialite = $DB->get_records('coursspecialite', null, 'id');

// $tarcoursspecialite=array();
$coursspecialites1 = $DB->get_records_sql($sql1);
$coursspecialites2 = $DB->get_records_sql($sql2);
$coursspecialites = $DB->get_recordset_sql($sql);

foreach ($coursspecialites as $key => $value) {
    $value->farr="fffff";
    
    $cycle=$DB->get_records("cycle",array("id"=>$value->idcy));
    foreach ($cycle as $key => $valuecycl) {
        # code...
    }
    $semestre=$DB->get_records("semestre",array("id"=>$value->idsemestre));
    foreach ($semestre as $key => $valuesemes) {
        # code...
    }
    // var_dump($semestre);
    $camp=$DB->get_records("campus",array("id"=>$value->idcampus));
    foreach ($camp as $key => $valuec) {
        # code...
    }
    $categcamp=$DB->get_records("course_categories",array("name"=>$valuec->libellecampus,"depth"=>1));
    foreach ($categcamp as $key => $valuecam) {
        # code...
    }
    
    $specia=$DB->get_records("specialite",array("id"=>$value->idspecialite));
    foreach ($specia as $key => $value2) {
        # code...
    }
    
    // var_dump($value2->libellespecialite);
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
    $categsp=$DB->get_records("course_categories",array("name"=>$value2->libellespecialite,"depth"=>3));
    foreach ($categsp as $key => $value1) {
        # code...
        // var_dump($categsp);
        $fff=explode("/",$value1->path);
        $iddc=array_search($valuecam->id,$fff);
        $iddfil=array_search($idcatfil,$fff);
        // var_dump( $iddfil,$iddc);
        if($iddc!==false && $iddfil!==false)
        {
            $idcatsp=$value1->id;
            // var_dump( $idcatsp);
        }
    }
    $categcyc=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
    foreach ($categcyc as $key => $value1cyc) {
        # code...
        $fff=explode("/",$value1cyc->path);
        $iddc=array_search($valuecam->id,$fff);
        $iddfil=array_search($idcatfil,$fff);
        $iddsp=array_search($idcatsp,$fff);
        // var_dump($value1cyc->name);
        if($iddc!==false && $iddfil!==false && $iddsp!==false)
        {
        //   if($cycle->libellecycle==$value1cyc->libellecycle)
        //    {
               $idcatcy=$value1cyc->id;
            //    var_dump( $idcatcy);
        //    }
        }
    }
    $categsemes=$DB->get_records("course_categories",array("name"=>$valuesemes->libellesemestre,"depth"=>5));
    foreach ($categsemes as $key => $value1semes) {
        // var_dump($value1semes->path);
        # code...
        $fff=explode("/",$value1semes->path);
        $iddc=array_search($valuecam->id,$fff);
        $iddfil=array_search($idcatfil,$fff);
        $iddsp=array_search($idcatsp,$fff);
        $iddcy=array_search($idcatcy,$fff);
        // var_dump( $idcatcy,$idcatsp,$idcatfil,$valuecam->id);
        // var_dump($value1semes->path);
        if($iddc!==false && $iddfil!==false && $iddsp!==false && $iddcy!==false)
        {

               $idcatsems=$value1semes->id;
            //    var_dump( $idcatsems);
           $value->idcatsem=$idcatsems;
        //    var_dump( $value->idcatsem,$value1semes->path);
        }
    }
       $tarcoursspecialite[]=(array)$value;
}
// die;
if(empty($tarcoursspecialite))
{
    $tarcoursspecialite[]="select";
}
$templatecontext = (object)[
    'coursspecialite' => array_values($tarcoursspecialite),
    'coursspecialite1' => array_values($coursspecialites1),
    'coursspecialite2' => array_values($coursspecialites2),
    'coursspecialiteedit' => new moodle_url('/local/powerschool/coursspecialiteedit.php'),
    'coursspecialitesupp'=> new moodle_url('/local/powerschool/coursspecialite.php'),
    'creditt'=> new moodle_url('/local/powerschool/credit.php'),
    'cours'=> new moodle_url('/course/edit.php'),
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'affectersemes' => new moodle_url('/local/powerschool/courssemestre.php'),
    'idca'=>$_GET["idca"]
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
//     'notes' => new moodle_url('/local/powerschool/note.php'),

// ];

$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),
    'materiell' => new moodle_url('/local/powerschool/materiels.php'),
    'groupe' => new moodle_url('/local/powerschool/groupsalle.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),
    'rapport' => new moodle_url('/local/powerschool/rapportprofadmin.php'),

];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/coursspecialite.php'),
    ];
echo $OUTPUT->header();

if(has_capability("local/powerschool:configurationminimal",context_system::instance(),$USER->id))
{
     if($CFG->theme=="boost")
        {
            echo'<div class="" style="margin-top:110px;"></div>';
        }
        elseif ($CFG->theme == 'adaptable') {
            // Changer la couleur en bleu
            echo'<div class="" style="margin-top:50px;"></div>';
            
        }
        echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
        echo'<div class="" style="margin-bottom:40px;"></div>';
}
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
if(has_capability("local/powerschool:coursspecialite",context_system::instance(),$USER->id))
{

//    echo"<div class='mt-5'></div>";
   echo'<div>'. $mform->display().'</div>';
    
    
    echo $OUTPUT->render_from_template('local_powerschool/coursspecialite', $templatecontext);
}
else
{
    \core\notification::add("Vous avez pas autorisation",\core\output\notification::NOTIFY_ERROR);
}


echo $OUTPUT->footer();