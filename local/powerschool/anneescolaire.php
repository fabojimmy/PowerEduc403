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
use local_powerschool\anneescolaire;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/anneescolaire.php');

require_once($CFG->libdir.'/adminlib.php');



// include('/local/powerschool/templates/navbar.mustache');


$path = optional_param('path','',PARAM_PATH);
$pageparams = array();

global $DB;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/anneescolaire.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une Année Scolaire');
// $PAGE->headingmenu (new moodle_url('/local/powerschool/templates/navbar.mustache'));
$PAGE->set_heading('Enregistrer une Année Scolaire');
$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('annee', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
$PAGE->requires->js_call_amd('local_powerschool/confirmsupp');



$mform=new anneescolaire;



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ( $_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data() ) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;
        if ($mform->verifannee($recordtoinsert->datedebut,$recordtoinsert->datefin)) {
            // redirect(new \moodle_url('/local/powerschool/anneescolaire.php'), '-Soit l\'année est la meme..<br/>
            //                                                                 -Soit l\'année soclaire execite déjà..<br/>
            //                                                                 -Soit l\'année scolaire de fin est inferieur a l\'année de debut',\core\output\notification::NOTIFY_ERROR);

        \core\notification::add('-Soit l\'année est la meme..<br/>
        -Soit l\'année soclaire execite déjà..<br/>
        -Soit l\'année scolaire de fin est inferieur a l\'année de debut', \core\output\notification::NOTIFY_ERROR);

        }else{
            // var_dump($recordtoinsert);die;
            $DB->insert_record('anneescolaire', $recordtoinsert);
            redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Enregistrement effectué');
            exit;
    
        }
    }

if($_GET['id']) {


    $mform->supp_annee($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Information Bien supprimée');
        
}

//type de campus
$vertype=$DB->get_records("typecampus");
$typpe=["universite","college","lycee","primaire"];
if(!$vertype){
    $recod=new stdClass();
  for($i=0;$i<count($typpe);$i++){

      $recod->libelletype=$typpe[$i];
    //   var_dump($typpe[$i]);
     $DB->insert_record("typecampus",$recod);
  }
}


//type d'enseignant secteur
$vertype=$DB->get_records("frananglobin");
$typpe=["Francophone","Anglophone","Bilingue"];
// die;
if(!$vertype){
    $recod=new stdClass();
    for($i=0;$i<count($typpe);$i++){
        
        $recod->libelle=$typpe[$i];
        //   var_dump($typpe[$i]);
        // die;
        $DB->insert_record("frananglobin",$recod);
    }
}

//type d'enseignement
$vertype=$DB->get_records("enseignementtype");
$typpe=["general","technique"];
if(!$vertype){
    $recod=new stdClass();
  for($i=0;$i<count($typpe);$i++){

      $recod->libelle=$typpe[$i];
    //   var_dump($typpe[$i]);
     $DB->insert_record("enseignementtype",$recod);
  }
}

// die;
$annee = $DB->get_records('anneescolaire', null, 'id');

foreach($annee as $key){
  
    $anneesdebut = $key->datedebut;
    $anneefin = $key->datefin;

    $datedebutannee = DateTime::createFromFormat('U',$anneesdebut);
    $datefinannee = DateTime::createFromFormat('U',$anneefin);

    $formatdebut = $datedebutannee->format('d-M-Y');
    $formatfin = $datefinannee->format('d-M-Y');


    $key->datedebut= $formatdebut;
    $key->datefin= $formatfin;

    
}

// var_dump($annee);
// die;

    $templatecontext = (object)[
        'annee' => array_values($annee),
        // 'datedebut'=> $annees['datedebut'],
        // 'datefins'=> $datefin,
        'libelleanne'=>get_string('anneemustacheaca','local_powerschool'),
        'anneeedit' => new moodle_url('/local/powerschool/anneescolaireedit.php'),
        'anneesupp'=> new moodle_url('/local/powerschool/anneescolaire.php'),
        'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    ];


    // $menu = (object)[
    //  'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    // 'campus' => new moodle_url('/local/powerschool/campus.php'),
    // 'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    // 'salle' => new moodle_url('/local/powerschool/salle.php'),
    // 'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    // 'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    // 'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    // 'seance' => new moodle_url('/local/powerschool/seance.php'),
    // 'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    // 'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    // 'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    // 'programme' => new moodle_url('/local/powerschool/programme.php'),
    // // 'notes' => new moodle_url('/local/powerschool/note.php'),
    // 'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
    // 'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),
    // 'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
    // 'statistique' => new moodle_url('/local/powerschool/statistique.php'),

    // ];

    $menu = (object)[
        'statistique' => new moodle_url('/local/powerschool/statistique.php'),
        'reglage' => new moodle_url('/local/powerschool/reglages.php'),
        // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
        'seance' => new moodle_url('/local/powerschool/seance.php'),
        'programme' => new moodle_url('/local/powerschool/programme.php'),
    
        'inscription' => new moodle_url('/local/powerschool/inscription.php'),
        // 'notes' => new moodle_url('/local/powerschool/note.php'),
        'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
        'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
        // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),
    
    ];


    // echo $OUTPUT->notifications();
echo $OUTPUT->header();
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
echo '<div style="margin-top:70px;"></div>';

echo $OUTPUT->skip_link_target();
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/anneescolaire', $templatecontext);



echo $OUTPUT->footer();
