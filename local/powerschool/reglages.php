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
use local_powerschool\reglages;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/token.php');
require_once(__DIR__ . '/idetablisse.php');
require_once($CFG->dirroot.'/local/powerschool/classes/reglage.php');

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
$PAGE->navbar->add(get_string('reglages', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new reglages();


// var_dump($CFG->wwwroot.'/local/powerschool/reglages.php'));
// die;

$templatecontext = (object)[
    // 'reglages' => array_values($reglages),
    'reglagesedit' => $CFG->wwwroot.'/local/powerschool/reglagesedit.php',
    'reglagessupp'=> $CFG->wwwroot.'/local/powerschool/reglages.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
];

$menu = (object)[
    'statistique' =>  $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' =>  $CFG->wwwroot.'/local/powerschool/reglages.php',
    // 'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
    'seance' =>  $CFG->wwwroot.'/local/powerschool/seance.php',
    'programme' =>  $CFG->wwwroot.'/local/powerschool/programme.php',

    'inscription' =>  $CFG->wwwroot.'/local/powerschool/inscription.php',
    // 'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),
    'bulletin' =>  $CFG->wwwroot.'/local/powerschool/bulletin.php',
    'configurermini' =>  $CFG->wwwroot.'/local/powerschool/configurationmini.php',
    'listeetudiant' =>  $CFG->wwwroot.'/local/powerschool/listeetudiant.php',
    // 'gerer' => $CFG->wwwroot.'/local/powerschool/gerer.php'),

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
if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }

echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


// echo $OUTPUT->render_from_template('local_powerschool/reglages', $templatecontext);
$modulecontext=context_system::instance();
if(has_capability("local/powerschool:reglageetablissement",$modulecontext,$USER->id))
{
    
    
    echo html_writer::start_div("card",array('style' => "width: 100%;")) ;
    echo"  <div class='card-header text-center'>
    <p class=''> Gérer les réglages de vos Etablissements</p>
    </div>";
    echo" <ul class='list-group list-group-flush'>";

    echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/anneescolaire.php',get_string('annee', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</il>";echo "<br/>";


    // var_dump(tokenvalidat(),ChangerSchoolUser($USER->id));die;
    if(tokenvalidat())
    {
        
        if(has_capability("local/powerschool:anneecreated",$modulecontext,$USER->id))
        {
        }
        if(has_capability("local/powerschool:ajoutercampus",$modulecontext,$USER->id))
        {
            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/campus.php',get_string('campus', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/batiment.php',get_string('batimenttitle', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        if(has_capability("local/powerschool:ajoutersemestre",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/semestre.php',get_string('semestre', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
       
        if(has_capability("local/powerschool:createfiliere",$modulecontext,$USER->id))
        {
    
            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/filiere.php',get_string('filiere', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:ajouterspecialite",$modulecontext,$USER->id))
        {
            
            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/specialite.php',get_string('specialite', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:createcycle",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/cycle.php',get_string('cycle', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:sallecreated",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/salle.php',get_string('salle', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:ajoutermodepaiement",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/modepaiement.php',get_string('modepaiement', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:importation",$modulecontext,$USER->id))
        {
            
            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/importationre.php',get_string('importationimpo', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:exportation",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/exportationre.php',get_string('exportation', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:cantine",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/cantine.php',get_string('cantine', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
        if(has_capability("local/powerschool:transportcreated",$modulecontext,$USER->id))
        {

            echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/transport.php',get_string('transport', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        }
    }
    // if(has_capability("local/powerschool:transportcreated",$modulecontext,$USER->id))
    // {

        echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/payementCampus.php',get_string('Payment', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
        // echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/.php',get_string('transport', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    // }
       
        
        // echo "<li class='list-group-item '>".html_writer::link($CFG->wwwroot.'/local/powerschool/logo.php'),"Logo",array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
     echo"</ul>";
    echo html_writer::end_div();
    
}
else
{
    \core\notification::add('Vous avez pas autorisations néccessaire', \core\output\notification::NOTIFY_ERROR);

}

echo $OUTPUT->footer();