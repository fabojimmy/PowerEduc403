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
require_once(__DIR__ .'/../../group/lib.php');
require_once(__DIR__ .'/idetablisse.php');
global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/ressource.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('affecterprof', 'local_powerschool'));
// $PAGE->set_heading(get_string('affecterprof', 'local_powerschool'));

// $PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
// $PAGE->navbar->add(get_string('affecterprof', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new affecterprof();


$sql="SELECT * FROM {ressource} WHERE idcampus='".ChangerSchoolUser($USER->id)."' AND id IN (SELECT idressource FROM {archiver})";
$datefor=$DB->get_records_sql($sql);

$libellesql="";
foreach($datefor as $key=>$value)
{
    if($value->ressource=="salle")
      {
        $sqlsalle="SELECT * FROM {salle} WHERE id='".$value->idsalle."'";
        $salle=$DB->get_records_sql($sqlsalle);

        foreach($salle as $key=>$valuesa)
        {}

        $libellesql=$valuesa->numerosalle;
      }
    if($value->ressource=="bus")
      {
        $sqltrans="SELECT * FROM {transport} WHERE id='".$value->idtransport."'";
        $transport=$DB->get_records_sql($sqltrans);

        foreach($transport as $key=>$valuetra)
        {}

        $libellesql=$valuetra->marque."-".$valuetra->matricule;
      }
    if($value->ressource=="cantine")
      {
        $sqlcant="SELECT * FROM {cantine} WHERE id='".$value->idcantine."'";
        $cantine=$DB->get_records_sql($sqlcant);

        foreach($cantine as $key=>$valuecant)
        {}

        $libellesql=$valuecant->libellecantine;
      }
    if($value->ressource=="batiment")
      {
        $sqlbati="SELECT * FROM {batiment} WHERE id='".$value->idbatiment."'";
        $batiment=$DB->get_records_sql($sqlbati);

        foreach($batiment as $key=>$valuebati)
        {}

        $libellesql=$valuebati->numerobatiment;
        // $value->libellesql=$libellesql;
      }
    if($value->ressource=="materiels")
      {
        $sqlbati="SELECT * FROM {materiels} WHERE id='".$value->idmateriels."'";
        $batiment=$DB->get_records_sql($sqlbati);

        foreach($batiment as $key=>$valuebati)
        {}

        $libellesql=$valuebati->libellemate;
      }
    $value->libellesql=$libellesql;

    $timed = $value->datedebuti;
    $dated = date('d-M-Y',$timed);
    $value->datedebuti=$dated;
    
    //
    // $timef = $value->datefinuti;
    // $datef = date('d-M-Y',$timef);
    // $value->datefinuti=$datef;

    // $time = $ab->datedebut;
    // $timef = $ab->datefin;

    // $dated = date('Y',$time);
    // $datef = date('Y',$timef);

    // $ab->datedebut = $dated;
    // $ab->datefin = $datef;
}

$annee=$DB->get_records("anneescolaire");
// die;
foreach($annee as $key =>$ab)
{
    $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
}
$semestre=$DB->get_records('semestre');

$templatecontext = (object)[
   
    'datefor' => array_values($datefor),
    'affecterprofedit' => new moodle_url('/local/powerschool/affecterprofedit.php'),
    'ressourcesuppr' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcecombo'=> new moodle_url('/local/powerschool/ressource.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'ressourcelien' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcearchive' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcelist' => new moodle_url('/local/powerschool/ressourcelist.php'),
    'root'=>$CFG->wwwroot,
    'resotest'=>$_GET["res"],
    'idca'=>ChangerSchoolUser($USER->id),
    'affec'=>"Reserver une ressource"
];
// var_dump($_GET["res"]);die;
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

    ];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/affecterprof.php'),
    ];
// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
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
//     'notes' => new moodle_url('/local/powerschool/note.php'),
// ];


echo $OUTPUT->header();

if($CFG->theme=="boost")
{
    echo'<div class="" style="margin-top:110px;"></div>';
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo'<div class="" style="margin-top:-50px;"></div>';
    
}

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/ressourcelist', $templatecontext);


echo $OUTPUT->footer();