<?php
// This file is part of powereduc Course Rollover Plugin
//
// powereduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// powereduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with powereduc.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\inscription;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');

require_once($CFG->dirroot.'/local/powerschool/classes/inscription.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/inscription.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Liste des etudiants');
$PAGE->set_heading('Importation des données');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'), $CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->navbar->add(get_string('importationimpo', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');






// $inscription =$tab = array();

// $sql_inscrip = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus,i.idetudiant, 
//                 s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,s.idfiliere,idcycle,i.idcampus,idspecialite
//                 FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
//                 WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idetudiant=u.id 
//                 AND i.idcampus=c.id AND i.idcycle = cy.id AND i.idspecialite='".$_GET["specialite"]."' AND i.idcycle='".$_GET["cycle"]."' AND i.idanneescolaire='".$_GET["annee"]."' AND s.idfiliere='".$_GET["filiere"]."' AND i.idcampus='".$_GET["campus"]."'" ;


$sql_inscrip="SELECT i.id, u.firstname, u.lastname,i.idetudiant,sp.libellespecialite, sp.abreviationspecialite , cy.libellecycle, cy.nombreannee,sp.idfiliere,idcycle,
              i.idcampus,idspecialite FROM {inscription} i,{user} u,{specialite} sp,{cycle} cy WHERE i.idetudiant =u.id AND i.idspecialite=sp.id AND i.idcycle=cy.id";

if (!empty($_GET["annee"])) {
    # code...
    $sql_inscrip.=' AND i.idanneescolaire='.$_GET["annee"];

    // var_dump($sql_inscrip);
    // die;
   
} 
if (!empty($_GET["campus"])) {
    # code...
    $sql_inscrip.=' AND i.idcampus ='.$_GET["campus"];
   
} 
if (!empty($_GET["filiere"])) {
    # code...
    $sql_inscrip.=' AND sp.idfiliere ='.$_GET["filiere"];
   
} 

 if (!empty($_GET["specialite"])) {
    $sql_inscrip.=' AND i.idspecialite='.$_GET["specialite"];
}
 if (!empty($_GET["cycle"])) {
    $sql_inscrip.=' AND i.idcycle='.$_GET["cycle"];
}

// $inscription = $DB->get_records('inscription', null, 'id');


// var_dump($sql_inscrip);
// die;
$inscription = $DB->get_records_sql($sql_inscrip);
// $i=0;

// var_dump($inscription);
// die;
foreach ($inscription as $key ){

    $time = $key->datedebut;
    $timef = $key->datefin;

    $dated = date('Y',$time);
    $datef = date('Y',$timef);

    $key->datedebut = $dated;
    $key->datefin = $datef;

    // die;
    $salle=$DB->get_records_sql("SELECT sa.id,numerosalle FROM {salle} sa,{salleele} saa WHERE sa.id=saa.idsalle AND saa.idetudiant='".$key->idetudiant."'");

    foreach($salle as $sallee)
    {

    }
    $key->numerosalle=$sallee->numerosalle;
    $key->idsa=$sallee->id;
}

// var_dump($i);
// var_dump($inscription);
// die;

// die;

// $specialite=$cycle=$semestre=array();
$specialite=$DB->get_records_sql("SELECT s.id,libellespecialite FROM {specialite} s,{filiere} f WHERE s.idfiliere = f.id AND f.idcampus='".ChangerSchoolUser($USER->id)."'");
$cycle=$DB->get_records_sql("SELECT * FROM {cycle} c WHERE c.idcampus='".ChangerSchoolUser($USER->id)."'");
$semestre=$DB->get_records_sql("SELECT * FROM {semestre}");

// var_dump($specialite,$cycle,$semestre);
// die;
$annee=$DB->get_records("anneescolaire");
$campus=$DB->get_records("campus");
foreach($annee as $key => $ab)
            {
                $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
            }
$templatecontext = (object)[
    'specialitere'=>array_values($specialite),
    'cyclere'=>array_values($cycle),
    'semestrere'=>array_values($semestre),
    // 'nb'=>array_values($tab),
    'inscriptionedit' => new moodle_url('/local/powerschool/inscriptionedit.php'),
    'inscriptionpayer'=> new moodle_url('/local/powerschool/paiement.php'),
    'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    'suppins'=> new moodle_url('/local/powerschool/inscription.php'),
    'importationn'=> new moodle_url('/local/powerschool/importation.php'),
    'importationpaie'=> new moodle_url('/local/powerschool/importationpaie.php'),
    'filiere'=> new moodle_url('/local/powerschool/importationfiliere.php'),
    'specialite'=> new moodle_url('/local/powerschool/importationspecialite.php'),
    'cycle'=> new moodle_url('/local/powerschool/importationcycle.php'),
    'semestre'=> new moodle_url('/local/powerschool/importationsemestre.php'),
    'cours'=> new moodle_url('/local/powerschool/importationcours.php'),
    'prof'=> new moodle_url('/local/powerschool/importationprofesseur.php'),
    'pare'=> new moodle_url('/local/powerschool/importationparentim.php'),
    // 'imprimer' => new moodle_url('/local/powerschool/imp.php'),
    'anneee'=>array_values($annee),
    'root'=>$CFG->wwwroot,
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
// $menu = (object)[
//     'statistique' => new moodle_url('/local/powerschool/statistique.php'),
//     'reglage' => new moodle_url('/local/powerschool/reglages.php'),
//     // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),

//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     // 'notes' => new moodle_url('/local/powerschool/note.php'),
//     'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
//     'listeetudiant' => new moodle_url('/local/powerschool/listeetudiant.php'),
//     // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

//     //navbar
//     'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
//     'reglagenavr'=>get_string('reglages', 'local_powerschool'),
//     'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
//     'seancenavr'=>get_string('seance', 'local_powerschool'),
//     'programmenavr'=>get_string('programme', 'local_powerschool'),
//     'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
//     'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
//     'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),
// ];

echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();
if($CFG->theme=="boost")
{
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo"<p style='margin-top:-120px'><p>";
}

echo $OUTPUT->render_from_template('local_powerschool/importation', $templatecontext);


echo $OUTPUT->footer();