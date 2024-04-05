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

// $PAGE->set_url($CFG->wwwroot.'/local/powerschool/periode.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un periode');
$PAGE->set_heading('Listes des differents apprenants et leur Moyennes');

// $PAGE->navbar->add('Administration du Site',  $CFG->wwwroot.'/local/powerschool/index.php'));
// $PAGE->navbar->add(get_string('periode', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new periode();
$sql1="SELECT firstname,lastname,libellespecialite,libellecycle,idetudiant FROM {inscription} i,{user} u,{specialite} sp,{cycle} cy WHERE i.idetudiant=u.id
       AND i.idspecialite='".$_GET["idsp"]."' AND i.idcycle='".$_GET["idcy"]."' AND sp.id=idspecialite
       AND cy.id=idcycle";
$sql2c="SELECT count(idetudiant) coutet FROM {inscription} i,{user} u,{specialite} sp,{cycle} cy WHERE i.idetudiant=u.id
       AND i.idspecialite='".$_GET["idsp"]."' AND i.idcycle='".$_GET["idcy"]."' AND sp.id=idspecialite
       AND cy.id=idcycle";
$counttt=$DB->get_records_sql($sql2c);
$inscription=$DB->get_records_sql($sql1);
// var_dump($inscription);
// die;

$moyennespe=0;

$rolecam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} ty WHERE c.idtypecampus=ty.id AND c.id='".$_GET["idca"]."'");
foreach($inscription as $key => $vvallno)
{
    $sommenote=0;
$sommecredi=0;
    foreach($rolecam as $key => $rolev)
    {}
    if($rolev->libelletype=="universite")
    {
    // $user=$DB->get_records("user");
    // foreach($user as $key)
    // {
        $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li
                WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite='".$_GET["idsp"]."'
                AND sp.idcycle='".$_GET["idcy"]."' AND cs.idsemestre='".$_GET["idsem"]."' AND li.idetudiant='".$vvallno->idetudiant."'";

        $gromoy=$DB->get_records_sql($sqlli);
        foreach($gromoy as $key =>$keynote)
        {   
        
        
        if($keynote->idetudiant==$vvallno->idetudiant)  
        {
            
                $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["idca"]));
        
                foreach($pourcent as $key =>$pou)
                {}
                $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                $sommecredi=$sommecredi+$keynote->credit;
                // $nobret++;
            
            $moyenne=$sommenote/$sommecredi;
            $vvallno->moyenne_semestre=round($moyenne,2);
            
            
        }
        
    }
    $moyennespe=$moyennespe+$vvallno->moyenne_semestre;

        // var_dump($moyenne,$sommecredi,$sommenote,$keynote->idetudiant===$vvallno->idetudiant);
        // die;
    }
    else if($rolev->libelletype=="college" || $rolev->libelletype=="lycee")
    {
        $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li
                WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite='".$_GET["idsp"]."'
                AND sp.idcycle='".$_GET["idcy"]."' AND cs.idsemestre='".$_GET["idsem"]."' AND li.idetudiant='".$vvallno->idetudiant."'";

        $gromoy=$DB->get_records_sql($sqlli);
        foreach($gromoy as $key =>$keynote)
        {   
        
        
        if($keynote->idetudiant==$vvallno->idetudiant)  
        {
            
                $sommenote=$sommenote+(($keynote->note3)*$keynote->credit);
                $sommecredi=$sommecredi+$keynote->credit;
                // $nobret++;
            
            $moyenne=$sommenote/$sommecredi;
            $vvallno->moyenne_semestre=round($moyenne,2);
            
            
        }
        
    }
    $moyennespe=$moyennespe+$vvallno->moyenne_semestre;
    }
    else{
        $nobret=0;
        $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li
        WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite='".$_GET["idsp"]."'
        AND sp.idcycle='".$_GET["idcy"]."' AND cs.idsemestre='".$_GET["idsem"]."' AND li.idetudiant='".$vvallno->idetudiant."'";

        $gromoy=$DB->get_records_sql($sqlli);
        foreach($gromoy as $key =>$keynote)
        {   


        if($keynote->idetudiant==$vvallno->idetudiant)  
        {
            
                $sommenote=$sommenote+(($keynote->note3));
                $sommecredi=$sommecredi+$keynote->credit;
                $nobret++;
            
            $moyenne=$sommenote/$nobret;
            $vvallno->moyenne_semestre=round($moyenne,2);
            
            
        }

        }
        $moyennespe=$moyennespe+$vvallno->moyenne_semestre;
    }
    // $moyen=$DB->get_records_sql($sql);
    // var_dump($moyen);
    // foreach($moyen as $key =>$vvvv)
    // {

    //     if($rolev->libelletype=="universite")
    //     {
    //         $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["idca"]));
    
    //         foreach($pourcent as $key =>$pou)
    //         {}
    //         $moyyenne=$moyyenne+(($vvvv->note3*$vvvv->credit) * $pou->cc/100+($vvvv->note2*$vvvv->credit) * $pou->normal/100);
    //     }
    //     $vvallno->moyenne_semestre=$vvvv->credit;
    // }
   
   
   
}
foreach($counttt as $mm){}
$moyennespe=round($moyennespe/$mm->coutet,2);
// var_dump($mm->coutet,$moyennebb,$moyennespe);
// die;
$templatecontext = (object)[
    'etudiant' => array_values($inscription),
    'moyennegene' => $moyennespe,
    'reglagesedit' => $CFG->wwwroot.'/local/powerschool/reglagesedit.php',
    'reglagessupp'=> $CFG->wwwroot.'/local/powerschool/reglages.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
];
echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/listeetudmoyem', $templatecontext);


echo $OUTPUT->footer();