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
use local_powerschool\Date\Month;
use local_powerschool\programme;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/programme.php');
require_once($CFG->dirroot.'/local/powerschool/classes/date.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/programme.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Programme de Cours');
$PAGE->set_heading('Programme de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('programme', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// die;
$mform=new programme();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/statistique.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {

    // if ($mform->isDisabled('idsemestre')) {
    //     // L'élément 'idsemestre' est désactivé
    //     // Faites ce que vous avez à faire lorsque l'élément est désactivé
    //     die;
    // }

$recordtoinsert = new stdClass();

// var_dump($_POST["idsemestre"]);die;
// $recordtoinsert = $fromform;

    // var_dump($recordtoinsert);
    // var_dump($mform->definir_semestre($recordtoinsert->datecours));
    // die;

  
        // $periode = $mform->periode($recordtoinsert->idperiode);

        
        $recordtoinsert->heuredebutcours=$_POST["heuredebutcours"];            
        $recordtoinsert->heurefincours=$_POST["heurefincours"]; 
        // $recordtoinsert->idsalle=$_POST["idsalle"]; 
        $recordtoinsert->idcourses=$_POST["idcourses"]; 
        $recordtoinsert->idspecialite=$_POST["idspecialite"]; 
        $recordtoinsert->idcycle=$_POST["idcycle"]; 
        $recordtoinsert->idsalle=$_POST["idsalle"]; 
        $recordtoinsert->idprof=$_POST["idprof"]; 
        $recordtoinsert->idgroupapprenant=$_POST["idgroupapprenant"]; 
        $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"]; 
        
        $recordtoinsert->heurconfir=$recordtoinsert->heurefincours-$recordtoinsert->heuredebutcours; 
        $recordtoinsert->usermodified=$USER->id; 
        $recordtoinsert->timecreated=time(); 
        $recordtoinsert->timemodified=time(); 
        
        // var_dump($_POST["idprof"]);die;
        $datesea=$_POST["datecours"];
        $recordtoinsert->datecours= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);
        
        $verda=$datesea["day"]."-".$datesea["month"]."-".$datesea["year"];

        // var_dump($verda);
        // die;

        if(empty($_POST["datefincours"])&&empty($_POST["datecours"])&&!empty($_POST["idsemestre"]))
        {

            $veridat=$DB->get_records_sql("SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."'");
            
            foreach($veridat as $key => $val)
            {}
          
            $verda=date("d-n-Y",$val->datedebutsemestre);

            // var_dump($verda);
            // die;
        }


if($_POST["typepro"]=="pro")
{
    // die;
    
            $veriprofss=$DB->get_records_sql("SELECT * FROM {user} u,{coursspecialite} cs,{courssemestre} css,{affecterprof} af,{specialite} s,{filiere} f,{cycle} cy
            WHERE cy.id=cs.idcycle AND cs.idspecialite=s.id AND css.idcoursspecialite=cs.id AND css.id=af.idcourssemestre AND s.idfiliere=f.id AND af.idprof=u.id AND f.idcampus='".$_POST["idcampus"]."' 
            AND s.id='".$_POST["idspecialite"]."' AND cy.id='".$_POST["idcycle"]."' AND u.id='".$_POST["idprof"]."' AND idcourses='".$_POST["idcourses"]."'");
            $verappart=$DB->get_records_sql("SELECT * FROM {programme} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND DATE_FORMAT(FROM_UNIXTIME(datecours), '%e-%c-%Y')='".$verda."' AND heuredebutcours='".$_POST["heuredebutcours"]."' AND idsalle='".$_POST["idsalle"]."'");
            // var_dump($veriprofss,$_POST["idcampus"],$_POST["idprof"],$_POST["idspecialite"],$_POST["idcourses"],$_POST["idcycle"]);die;
            // var_dump($verappart,$verda,$_POST["idspecialite"],$_POST["idcycle"],$_POST["idsemestre"]);die;
        if(!$verappart){
        
            // if(!empty($_POST["idsemestre"]))
            // {
            //     $semver = $mform->definir_semestre($recordtoinsert->datecours,$_POST["idsemestre"]);

            //     \core\notification::add('Cette Date n\'est pas dans ce semestre', \core\output\notification::NOTIFY_ERROR);
            //     redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');

            // }
            // else
            // {
                $tardateocc=array();
                $tarr=array();
                $tareven=array();
                $even=new stdClass();
                // if(!empty($_POST["idsemestre"]) && !empty($_POST["datecours"]))
                // {
                //     $semver = $mform->definir_semestre($recordtoinsert->datecours,$_POST["idsemestre"]);
            
                //     \core\notification::add('Cette Date n\'est pas dans ce semestre', \core\output\notification::NOTIFY_ERROR);
                //     redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
            
                // }
                for($i=0;$i<=$_POST["nobresemaine"];$i++)
                {

                    $dateffin=$_POST["datefincours"];
                    
                    // var_dump($i,$recordtoinsert);
                    $datesea=$_POST["datecours"];
                    $recordtoinsert->datecours= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);
                    $dateseafin=$_POST["datefincours"];
                    $recordtoinsert->datefincours= strtotime($dateseafin["day"]."-".$dateseafin["month"]."-".$dateseafin["year"]);

                    // var_dump($_POST["datefincours"],$_POST["datecours"."\n"]);
                    // $date = $recordtoinsert->datecours ;
                    if($_POST["tjr"]==1)
                    {
                        $date =  $key->datedebutsemestre + ($i * 86400);
                    }
                    else{
                        $date =  $key->datedebutsemestre + ($i * 604800);
                    }
                    // $date =  strtotime('next monday', $recordtoinsert->datecours + ($i*7*24*3600));
                    // var_dump($date."\n");
                    
                    $datetestfin = date('d-M-Y',$recordtoinsert->datefincours);
                    // var_dump(date("Y/m/d",$recordtoinsert->datecours));
                    // var_dump($recordtoinsert->datefincours,$date);
                    // var_dump($datetest,$datetestfin);

                    //semestre seulement
                    if(empty($_POST["datefincours"])&&empty($_POST["datecours"] && !empty($_POST["idsemestre"])))
                    {
                        $veridat=$DB->get_records_sql("SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."'");
                        
                        foreach($veridat as $key)
                        {}
                        if($_POST["tjr"]==1)
                        {
                            $date =  $key->datedebutsemestre + ($i * 86400);
                        }
                        else{
                            $date =  $key->datedebutsemestre + ($i * 604800);
                        }
                        $dateffin=$key->datefinsemestre;
                        $datetestfin =  date('d-M-Y',$key->datefinsemestre);
                        // $recordtoinsert->datecours=$date;
                    }
                    // var_dump($_POST["tjr"]);die;
                    //semestre et date debut cours seulement
                    if(empty($_POST["datefincours"])&&!empty($_POST["datecours"] && !empty($_POST["idsemestre"])))
                    {
                        $veridat=$DB->get_records_sql("SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."'");
                        
                        foreach($veridat as $key)
                        {}
                        if($date>=$key->datedebutsemestre && $date<=$key->datefinsemestre)
                        {

                            $date =   $date;
                            $dateffin=$key->datefinsemestre;
                            $datetestfin =  date('d-M-Y',$key->datefinsemestre);
                        }
                        else
                        {
                            redirect($CFG->wwwroot . '/local/powerschool/programme.php','Erreur le debut doit inferieur ou égal à la date debut du semestre',null,\core\output\notification::NOTIFY_INFO);

                        }
                        // $recordtoinsert->datecours=$date;
                    }
                    //semestre et date de fin cours seulement
                    if(!empty($_POST["datefincours"]) && empty($_POST["datecours"]) && !empty($_POST["idsemestre"]))
                    {
                        $veridat=$DB->get_records_sql("SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."'");
                        
                        foreach($veridat as $key)
                        {}
                        if($_POST["tjr"]==1)
                        {
                            $date =  $key->datedebutsemestre + ($i * 86400);
                        }
                        else{
                            $date =  $key->datedebutsemestre + ($i * 604800);
                        }
                        
                        // var_dump($_POST["datefincours"],$_POST["datecours"],empty($_POST["datecours"]),!empty($_POST["datefincours"]),!empty($_POST["idsemestre"]));
                        // die;
                        $dateffin=$recordtoinsert->datefincours;
                        // die;
                        $datetestfin =  date('d-M-Y',$recordtoinsert->datefincours);
                        // $recordtoinsert->datecours=$date;
                    }

                    
                    



                    $datetest = date('d-M-Y',$date);
                    


                    // var_dump($datetest);
                    if($date<=$dateffin)
                    {
                        // var_dump($datetest,$datetestfin,$date<=$key->datefinsemestre);
                        // die;
                        
                            // die;
                            $semm = $mform->definir_semestref($date);
                            $recordtoinsert->idsemestre = $semm;
                            // var_dump($semm,$i,$_POST["datefincours"],$_POST["datecours"]);
                        
                        $verappartint=$DB->get_records_sql("SELECT * FROM {programme} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND DATE_FORMAT(FROM_UNIXTIME(datecours), '%e-%c-%Y')='".$date."' AND heuredebutcours='".$_POST["heuredebutcours"]."' AND heurefincours='".$_POST["heurefincours"]."'");
                        
                        if(empty($verappartint))
                        {
                            $recordtoinsert->datecours=$date;
                
                        }
                        else
                        {
                            array_push($tardateocc,$date."-".$_POST["heuredebutcours"]);
                        }
                        
                    }
                
                    // var_dump($_POST["disable_datefincours"],$_POST["datecours"],$_POST["datefincours"]);die;

                    // var_dump( $recordtoinsert->idsemestre."---".$date."-sds-".$_POST["idsemestre"]);
                    // die;
                if($recordtoinsert->heuredebutcours==$recordtoinsert->heurefincours)
                {
                    \core\notification::add('Heure de début et de fin sont pareil', \core\output\notification::NOTIFY_ERROR);
                    redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
                    exit;
                }
                else{

                    $even->name=$_POST["name"];
                    $even->description=$_POST["description"];
                    $even->eventtype=$_POST["eventtype"];
                    $even->timestart=$date;
                    $even->courseid=$_POST["idcourses"];
                    
                    array_push($tarr,$recordtoinsert);
                    
                    // var_dump($i,$tarr);
                    $veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.ChangerSchoolUser($USER->id).'');
                    foreach($veriEta as $valueEt){}
                    if($valueEt->libelletype=="universite")
                    {
                        $even->groupid=$_POST["idgroupapprenant"];
                        $verappartgroup=$DB->get_records_sql("SELECT * FROM {programme} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND DATE_FORMAT(FROM_UNIXTIME(datecours), '%e-%c-%Y')='".$verda."' AND heuredebutcours='".$_POST["heuredebutcours"]."' AND idsalle='".$_POST["idsalle"]."' AND idgroupapprenant='".$_POST["idgroupapprenant"]."'");
                        
                        $heurtotalpro=$DB->get_records_sql("SELECT sum(heurconfir) as totoheur FROM {programme} WHERE idanneescolaire='".$_POST["idanneescolaire"]."' AND idprof='".$_POST["idprof"]."' AND idcourses='".$_POST["idcourses"]."'");

                        foreach($heurtotalpro as $pop)
                        {}
                        $courssp=$DB->get_records_sql("SELECT * FROM {coursspecialite} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND idcourses='".$_POST["idcourses"]."'");

                        foreach($courssp as $valueK)
                        {}
                        $courssem=$DB->get_records_sql("SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$valueK->id."' AND idsemestre='".$_POST["idsemestre"]."'");
                        foreach($courssem as $valuesem)
                        {}

                    
                        $affecprof=$DB->get_records_sql("SELECT * FROM {affecterprof} WHERE idprof='".$_POST["idprof"]."' AND idcourssemestre='".$valuesem->id."'");
                        
                        foreach($affecprof as $affval)
                        {}
                        // var_dump($affecprof);die;
                        if($affval->heurecours==$pop->totoheur)
                        {

                            redirect($CFG->wwwroot . '/local/powerschool/programme.php','Erreur',\core\output\notification::NOTIFY_ERROR);
                        }
                        if($verappartgroup)
                        {
                            \core\notification::add('Ce groupe a été déjà programme pour cette seance dans cette salle');
                        }

                                if($veriprofss)
                                {
                                    
                                    $DB->insert_records('programme', $tarr);
                                    $tarr=array();
                                    $event = new calendar_event($even);
                                    $event->update($even);
                                }
                                else
                                {
                                    \core\notification::add('Soit cet enseignant n\'appartient pas à cette specialité
                                    <br> Soit il\'enseigne pas à ce cours', \core\output\notification::NOTIFY_ERROR);
                                    redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca');
                                }

                    }
                    else
                    {
                        $heurtotalpro=$DB->get_records_sql("SELECT sum(heurconfir) as totoheur FROM {programme} WHERE idanneescolaire='".$_POST["idanneescolaire"]."' AND idprof='".$_POST["idprof"]."' AND idcourses='".$_POST["idcourses"]."'");

                        foreach($heurtotalpro as $pop)
                        {}
                        $courssp=$DB->get_records_sql("SELECT * FROM {coursspecialite} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND idcourses='".$_POST["idcourses"]."'");

                        foreach($courssp as $valueK)
                        {}
                        $courssem=$DB->get_records_sql("SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$valueK->id."' AND idsemestre='".$_POST["idsemestre"]."'");
                        foreach($courssem as $valuesem)
                        {}

                    
                        $affecprof=$DB->get_records_sql("SELECT * FROM {affecterprof} WHERE idprof='".$_POST["idprof"]."' AND idcourssemestre='".$valuesem->id."'");
                        
                        foreach($affecprof as $affval)
                        {}
                        // var_dump($affecprof);die;
                        if($affval->heurecours==$pop->totoheur)
                        {

                            redirect($CFG->wwwroot . '/local/powerschool/programme.php','Erreur',\core\output\notification::NOTIFY_ERROR);
                        }
                        // die;
                                $veriprof=$DB->get_records_sql("SELECT * FROM {salleele} sa,{inscription} i WHERE sa.idsalle='".$_POST["idsalle"]."'
                                AND sa.idetudiant=i.idetudiant AND i.idspecialite='".$_POST["idspecialite"]."' AND i.idcycle='".$_POST["idcycle"]."'");
                                    if($veriprof)
                                    {
                                        if($veriprofss)
                                        {
                                            // die;
                                            $even->groupid=$_POST["idsalle"];
            
                                            $DB->insert_records('programme', $tarr);
                                            $tarr=array();
                                            // $event = new calendar_event($even);
                                            // $event->update($even);
                                        }
                                        else
                                        {
            
                                            \core\notification::add('Soit cet enseignant n\'appartient pas à cette specialité
                                            <br> Soit il\'enseigne pas à ce cours', \core\output\notification::NOTIFY_ERROR);
                                            redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
                                        
                                        }
                                    } 
                                    else 
                                    {
                                        $speci=$DB->get_records_sql("SELECT * FROM {specialite} WHERE id='".$_POST["idspecialite"]."'");
            
                                        foreach ($speci as $key => $value) {
                                            # code...
                                        }
                                        \core\notification::add('Cette salle n\'appertient pas à cette specialité '.$value->libellespecialite.'', \core\output\notification::NOTIFY_ERROR);
                                        redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
                                    
                                        exit;
                                    }
                    }

                }

                //     // $date = $date->modify("+".($i)."week");
                
                    

                
                // //    var_dump($recordtoinsert);
                // exit;
                
                
                
            // }
            // die;
            }
            if(empty($tardateocc))
            {
                redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Enregistrement effectué');
            }else
            {
                redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Enregistrement effectué<br> les dates qui ne sont pas enregistrés cas ils sont occupées '.$tardateocc);
            }
        }else
        {
            \core\notification::add('Cette Seance est déjà occupée', \core\output\notification::NOTIFY_ERROR);
            redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');

        }
}
else if($_POST["typepro"]=="exa")
{
    $exm=new StdClass();
    $exm->heuredebutcours=$_POST["heuredebutcours"];            
    $exm->heurefincours=$_POST["heurefincours"]; 
    $exm->datecours=$recordtoinsert->datecours; 
    $exm->datefincours=$recordtoinsert->datecours; 
    // $recordtoinsert->idsalle=$_POST["idsalle"]; 
    $exm->idcourses=$_POST["idcourses"]; 
    $exm->idspecialite=$_POST["idspecialite"]; 
    $exm->idcycle=$_POST["idcycle"]; 
    $exm->idsalle=$_POST["idsalle"]; 
    $exm->idprof=$_POST["idprof"]; 
    $exm->idgroupapprenant=$_POST["idgroupapprenant"]; 
    $exm->idanneescolaire=$_POST["idanneescolaire"];     
    $exm->usermodified=$USER->id; 
    $exm->timecreated=time(); 
    $exm->timemodified=time(); 
    $exm->idprof=0; 

        // var_dump( $exm);die;
        $DB->insert_record("examen",$exm);


}
        // die;
        
}

if($_GET['id']) {

    $mform->supp_programme($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Information Bien supprimée');
        
}

$sql = "SELECT * FROM {course} c,{specialite} sp,{cycle} cy, {programme} p WHERE p.idcourses = c.id AND p.idspecialite = sp.id
        AND p.idcycle = cy.id  AND cy.idcampus='".ChangerSchoolUser($USER->id)."'";
    // die;
    $programmes = $DB->get_records_sql($sql);

    foreach($programmes as $key){
        
        $time = $key->datecours;

        $date = date('d-M-Y',$time);
        $timed = date('H:m',$time);
        $timef = date('H:m',$time);

        $key->datecours = $date;

        $semestre=$DB->get_records("semestre",array("id" =>$key->idsemestre));
        foreach($semestre as $keyse)
        {
            
            $key->libellesemestre = $keyse->libellesemestre;
        }
        $group=$DB->get_records("groupapprenant",array("id" =>$key->idgroupapprenant));
        foreach($group as $keyse)
        {
            
            $key->numerogroup = $keyse->numerogroup;
        }
        $salle=$DB->get_records("salle",array("id" =>$key->idsalle));
        foreach($salle as $keyse)
        {
            
            $key->numerosalle = $keyse->numerosalle;
        }

        // $key->heurefincours = $timef;

    }
    // var_dump($programmes);
    // die;
// $programme = $DB->get_records('programme', null, 'id');

$campus=$DB->get_records('campus');

$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/programme.php'),
            ]; 
$templatecontext = (object)[
    'programme' => array_values($programmes),
    'programmeedit' => new moodle_url('/local/powerschool/programmeedit.php'),
    'programmesupp'=> new moodle_url('/local/powerschool/programme.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'periode' => new moodle_url('/local/powerschool/periode.php'),
    'idca' =>ChangerSchoolUser($USER->id),
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
    'statistique' =>  $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' =>  $CFG->wwwroot.'/local/powerschool/reglages.php',
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' =>  $CFG->wwwroot.'/local/powerschool/seance.php',
    'programme' =>  $CFG->wwwroot.'/local/powerschool/programme.php',

    'inscription' =>  $CFG->wwwroot.'/local/powerschool/inscription.php',
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' =>  $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'configurermini' =>  $CFG->wwwroot.'/local/powerschool/configurationmini.php',
    'listeetudiant' =>  $CFG->wwwroot.'/local/powerschool/listeetudiant.php',
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),

];


echo $OUTPUT->header();

// $mois = $_GET['mois'] ;
// $annee = $_GET['annee'];
// $month = new Month($mois??null,$annee??null);
// $start = $month->getStartingDay();
// $getWeeks = $month->getWeeks();
// $getMonth = $month->toString();

// $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

// $end = (clone $start)->modify('+'.(6 + 7 * ($getWeeks - 1)).'days');
// var_dump($month->toString());

// $events = $month->getEvents($start,$end);
// $eventsByDay = $month->getEventsByDay($start,$end);


// var_dump($start);
// var_dump($getWeeks);
// var_dump($end);


// die;



if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
// echo $OUTPUT->render_from_template('local_powerschool/tableau', $getWeeks);

// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
if(has_capability("local/powerschool:programme",context_system::instance(),$USER->id))
{
    echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

    // echo "<div class='mx-5'></div>";
    $mform->display();
    echo $OUTPUT->render_from_template('local_powerschool/programme', $templatecontext);
    echo ' <a type="button" class="btn btn-danger" href="'.$CFG->wwwroot.'/local/powerschool/indexprogramme.php">Voir le Calendrier </a>';
    echo ' <a type="button" class="btn btn-info" href="'.$CFG->wwwroot.'/local/powerschool/examen.php">Voir examen </a>';
}
else{
    \core\notification::add("Vous avez pas autorisation", \core\output\notification::NOTIFY_ERROR);

}



// echo '<div class="d-flex flex-row align-items-center justify-content-between mx-sm-5">
//             <h1>'.$getMonth. '</h1>
//         <div>  
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->previousmonth()->month.'&annee='.$month->previousmonth()->year.'" class="btn btn-primary"> &lt;</a>
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->nextmonth()->month.'&annee='.$month->nextmonth()->year.'" class="btn btn-primary">&gt;</a>
//         </div>
//      </div>';

// echo ' <div class="table card mt-2 mb-2">
// <table class="calendar__table">';

// for($i = 0 ; $i < $getWeeks; $i++){

//     echo '<tr>';

//     foreach($month->days as $k => $day)
//     {
//         $date = (clone $start)->modify("+".($k + $i * 7)."days");
//         $eventForDay = $eventsByDay[$date->format('Y-m-d')] ?? [];

//         echo '<td>';
//         if($i === 0)
//         {
//         echo '<div> <strong>'.$day.' </strong></div>';
//         }
//       echo '<div> <strong>'.$date->format('d').' </strong></div>';

//       foreach($eventForDay as  $event){


//         $eventday = $event->fullname;
//         $heuredebut = $event->heuredebutcours;
//         $heurefin = $event->heurefincours;
//         echo '<div>'
//         .$heuredebut.'h -'.$heurefin.'h :   '.'<a href="#?id='.$event->id.'">'.$eventday.'</a>
//         </div>';
//       }
//        '</td>';
//     }
//     echo '</tr>';
// }
// echo ' </table>
//         </div>';



echo $OUTPUT->footer();