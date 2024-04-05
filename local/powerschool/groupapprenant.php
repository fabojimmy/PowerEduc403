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
use local_powerschool\groupapprenant;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/groupapprenant.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/groupapprenant.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un batiment');
$PAGE->set_heading('Enregistrer un batiment');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/reglages.php');
$PAGE->navbar->add(get_string('groupapprenanttitle', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new groupapprenant();


// $specialiteprimary=[
//    $libelle=> "Sil",
//    $libelle=>"CP",
//    $libelle=> "CE1",
//    $libelle=> "CE2",
//    $libelle=> "CM1",
//    $libelle=>"CM2",
// ];


// var_dump(ChangerSchoolUser($USER->id));
// die;

if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;
    if($recordtoinsert->idcampus)
    {

        // var_dump($_POST["action"]);die;
      if($_POST["action"]=='edit')
         {

            $mform->update_groupapprenant($recordtoinsert->id,$recordtoinsert->numerogroup,$recordtoinsert->idcycle,$recordtoinsert->idspecialite,$recordtoinsert->idanneescolaire,$recordtoinsert->capacitegroup);
            redirect($CFG->wwwroot . '/local/powerschool/groupapprenant.php', get_string('notificationedit','local_powerschool'));

         }
    else
         {

             if (!$mform->verigroupapprenant($recordtoinsert->numerogroup,$recordtoinsert->idcycle,$recordtoinsert->idspecialite,$recordtoinsert->idanneescolaire)) {
                 $DB->insert_record('groupapprenant', $recordtoinsert);
                 redirect($CFG->wwwroot . '/local/powerschool/groupapprenant.php', get_string('notificationinsert','local_powerschool'));
                 exit;
                }else{
                //  var_dump($recordtoinsert);die;
                 // redirect($CFG->wwwroot . '/local/powerschool/salle.php', 'Cette salle execite dans ce campus');
                 \core\notification::add(get_string('verifierexistebatimen','local_powerschool'), \core\output\notification::NOTIFY_ERROR);
                 
             }
         }
    }else
    {
        \core\notification::add(get_string('verifierexistebatimenet','local_powerschool'), \core\output\notification::NOTIFY_ERROR);

    }
     
    }

if($_GET['id']&&$_GET['action']=="delete") {

    $mform->supp_groupapprenant($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/batiment.php', get_string('notificationdelete','local_powerschool'));
        
}

if ($_GET['id']&&$_GET['action']=="edit")
{
        // Add extra data to the form.
        global $DB;
        $id = $_GET['id'];
        $newbatiment = new groupapprenant();
        $batiment = $newbatiment->get_groupapprenant($id);
        if (!$batiment) {
            throw new invalid_parameter_exception('Message not found');
        }
        $mform->set_data($batiment);
}


$sql = "SELECT g.id,s.libellespecialite,c.libellecycle,g.numerogroup,capacitegroup FROM {specialite} s,{cycle} c,{filiere} f,{groupapprenant} g WHERE s.id=g.idspecialite AND c.id=g.idcycle AND f.id=s.idfiliere AND f.idcampus='".ChangerSchoolUser($USER->id)."'";

// $salle = $DB->get_records('salle', null, 'id');

$salles = $DB->get_records_sql($sql);
// die;


// var_dump($salles);
// die;


$templatecontext = (object)[
    'salle' => array_values($salles),
    // 'specialiteprimary' => array_values($specialiteprimary),
    'salleedit' => $CFG->wwwroot.'/local/powerschool/groupapprenant.php',
    'sallesupp'=> $CFG->wwwroot.'/local/powerschool/groupapprenant.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
    'libelle' => get_string('groupapprenantlibelle','local_powerschool'),
    'capacitegroupe'=>get_string('capacitegroup','local_powerschool'),
    'specialie'=>get_string('specialite','local_powerschool')."-".get_string('cycle','local_powerschool')
];

// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'salle' => $CFG->wwwroot.'/local/powerschool/salle.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
//     'programme' => $CFG->wwwroot.'/local/powerschool/programme.php'),
//     // 'notes' => $CFG->wwwroot.'/local/powerschool/note.php'),
//     'bulletin' => $CFG->wwwroot.'/local/powerschool/bulletin.php'),
//     'configurermini' => $CFG->wwwroot.'/local/powerschool/configurationmini.php'),
//     'gerer' => $CFG->wwwroot.'/local/powerschool/gerer.php'),
//     'modepaie' => $CFG->wwwroot.'/local/powerschool/modepaiement.php'),
//     'statistique' => $CFG->wwwroot.'/local/powerschool/statistique.php'),


// ];

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
    'groupapprenant' => new moodle_url('/local/powerschool/groupapprenant.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),

];

echo $OUTPUT->header();

if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

$vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".ChangerSchoolUser($USER->id)."'");

foreach($vericam as $key)
{}
if($key->libelletype=="universite" )
{

    $mform->display();
}else
{
    \core\notification::add('Votre n\'est autorisé pour cette partie', \core\output\notification::NOTIFY_ERROR);

            redirect($CFG->wwwroot . '/local/powerschool/statistique.php');
       
}
echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();
echo $OUTPUT->render_from_template('local_powerschool/groupapprenant', $templatecontext);


echo $OUTPUT->footer();