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
use local_powerschool\paiement;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/paiement.php');
require_once(__DIR__ . '/idetablisse.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/paiement.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Liste de vos paiement');
$PAGE->set_heading('Liste de vos paiement');

// $PAGE->navbar->add('Administration du Site',  $CFG->wwwroot.'/local/powerschool/index.php'));
// $PAGE->navbar->add(get_string('paiement', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new paiement();



// if ($mform->is_cancelled()) {

//     redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

// } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


// $recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;

// $sql1="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_POST["idfi"]."' AND idcycle='".$_POST["idcy"]."' AND idtranc='".$fromform->idtranc."'";
// $filiercycltr = $DB->get_records_sql($sql1);

// // var_dump($filiercycltr);
// // die;
// // foreach ($filiercycltr as $key => $value) {

// //     $sql3="SELECT idtranche, sum(montant) as mont FROM {paiement} WHERE idinscription='".$_POST["idinscription"]."' AND idtranche='".$fromform->idtranc."'";
// //     $paieverie = $DB->get_records_sql($sql3);
// //     foreach ($paieverie as $key => $value1) {
// //                     // var_dump($value1->mont==$value->somme,$value->somme);
// //                     // var_dump($value->somme,$value1->mont,$fromform->idtranc);die;
// //                     if ($value->somme==$value1->mont) {
                       
// //                         redirect($CFG->wwwroot . '/local/powerschool/paiement.php?idins='.$_POST['idinscription'].'&idfi='.$_POST['idfi'].'&idcy='.$_POST['idcy'].'', 'Cet etudiant a déjà fini cette etape de la passion');
// //                     }else{
// //                         $recordtoinsert->idmodepaie=$fromform->idmodepaie;
// //                         $recordtoinsert->idinscription=$fromform->idinscription;
// //                         // var_dump($recordtoinsert->idtranc);die;
// //                         $recordtoinsert->usermodified=$fromform->usermodified;
// //                         $recordtoinsert->timecreated=$fromform->timecreated;
// //                         $recordtoinsert->timemodified=$fromform->timemodified;
// //                         $recordtoinsert->montant=$fromform->montant;
// //                         $recordtoinsert->idtranche=$fromform->idtranc;
// //                         // $DB->insert_record('paiement', $recordtoinsert);
// //                         $DB->execute("INSERT INTO mdl_paiement VALUES(0,'".$recordtoinsert->idmodepaie."','".$recordtoinsert->idinscription."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','". $recordtoinsert->timemodified."','".$recordtoinsert->montant."','".$recordtoinsert->idtranche."')");
// //                         redirect($CFG->wwwroot . '/local/powerschool/paiement.php', 'Enregistrement effectué');
// //                         exit;
// //                     }
// //                 }
// //             }
 
// }
// die;
// if($_GET['id']) {

//     $mform->supp_paiement($_GET['id']);
//     redirect($CFG->wwwroot . '/local/powerschool/paiement.php', 'Information Bien supprimée');
        
// }


// $sql="SELECT * FROM {paiement} as pa RIGHT JOIN {tranche} as t ON pa.idtranche=t.id WHERE pa.idinscription=:idins";

// $paiement = $DB->get_records_sql($sql,array("idins"=>$_GET["idins"]));
$sqlfi="SELECT idfiliere,i.idcampus,i.idspecialite,i.idcycle FROM {inscription} i,{specialite} s,{cycle} c WHERE i.idspecialite=s.id AND c.id=i.idcycle AND idetudiant='".$_GET["idenf"]."'";
$fil=$DB->get_records_sql($sqlfi);

// var_dump($fil);die;
foreach($fil as $key => $idfil)
{

}

$campuss=$DB->get_records("campus",array("id"=>$idfil->idcampus));

// var_dump($campuss);die;
foreach($campuss as $key => $vaca){}
if($vaca->idtypecampus==1)
{
    $sqlsommmm="SELECT sum(somme) as som FROM {filierecycletranc} as filcy ,{filiere} as fil,{tranche} as tran
       WHERE filcy.idfiliere=fil.id AND tran.id=filcy.idtranc AND idfiliere='".$idfil->idfiliere."' AND idcycle='".$idfil->idcycle."'";
    $sql1="SELECT * FROM {filierecycletranc} as filcy ,{filiere} as fil,{tranche} as tran
        WHERE filcy.idfiliere=fil.id AND tran.id=filcy.idtranc AND idfiliere='".$idfil->idfiliere."' AND idcycle='".$idfil->idcycle."'";
}else{
    $sql1="SELECT * FROM {filierecycletranc} as filcy ,{filiere} as fil,{tranche} as tran
        WHERE filcy.idfiliere=fil.id AND tran.id=filcy.idtranc AND idfiliere='".$idfil->idfiliere."' AND filcy.idspecialite='".$idfil->idspecialite."'";
    $sqlsommmm="SELECT sum(somme) as som FROM {filierecycletranc} as filcy ,{filiere} as fil,{tranche} as tran
       WHERE filcy.idfiliere=fil.id AND tran.id=filcy.idtranc AND filcy.idfiliere='".$idfil->idfiliere."' AND filcy.idspecialite='".$idfil->idspecialite."'";
    // var_dump("ok");die;

}

$sql = "SELECT pa.id as paid,libelletranche,pa.timecreated,pa.montant,libellemodepaiement,idinscription as idins,t.id as traid FROM 
{paiement} as pa JOIN {tranche} as t ON pa.idtranche = t.id JOIN {modepaiement} as mo ON pa.idmodepaie=mo.id 
JOIN {inscription} as i ON i.id=pa.idinscription WHERE idetudiant = :idins";

// Les paramètres à lier à la requête
$params = array("idins" => $_GET["idenf"]);

// cette fonction retourne tout les lignes attendus sans faire un distinct sur les donnees
//get_records_sql cette fonction retourne en annuler les doublons 
$rs = $DB->get_recordset_sql($sql, $params);

$sql_som="SELECT SUM(montant) as mnt FROM {paiement} p,{inscription} i WHERE p.idinscription=i.id AND idetudiant='".$_GET["idenf"]."'";

// var_dump($rs);die;
$sommes=$DB->get_records_sql($sql_som);
// var_dump($sommes);die;

foreach($sommes as $key=> $somme)
{}
$filicycy=$DB->get_records_sql($sql1);
// Convertir l'objet mysqli_native_moodle_recordset en tableau d'enregistrements
$paiement = array();
foreach ($rs as $record) {
// $sommepay=0;
// $record->sommepay=$sommepay;
    $dateli=date("Y/m/d",$record->timecreated);

    $record->timecreated=$dateli;
    // $record->sommepay=$sommepay;
    $paiement[] = (array) $record;
}

foreach($filicycy as $key => $fiifi)
{
    $dateli=date("Y/m/d",$fiifi->datelimite);

    $fiifi->datelimite=$dateli;
}
// foreach ($rs as $key => $value) {
//     # code...
//     var_dump($value->montant);
// }
// // $paiement=$DB->get_records_select("paiement", $select, $params_array, $sort, $fields, $limitfrom, $limitnum);
// die;
$sommmm=$DB->get_records_sql($sqlsommmm);
foreach ($sommmm as $key => $value) { 
    // var_dump($sommmm,$idfil->idspecialite);
}
// die;
$enfant=$DB->get_records("user",array("idparent"=>$USER->id));
$templatecontext = (object)[
    'paiement' => array_values($paiement),
    'enfant' => array_values($enfant),
    'filierecycletran' => array_values($filicycy),
    'somme' => $somme->mnt,
    'montant' => $value->som,
    'enfantabse'=> new moodle_url('/local/powerschool/paiementpersoparent.php'),
    'reste' => $value->som-$somme->mnt,
    'paiementedit' => $CFG->wwwroot.'/local/powerschool/paiementedit.php',
    'paiementsupp'=> $CFG->wwwroot.'/local/powerschool/paiement.php',
    'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php',
    'recu' => $CFG->wwwroot.'/local/powerschool/recu/facture/recu.php',
    // 'idins'=>$_GET["idins"],
    // 'idfi'=>$_GET["idfi"],
];

// $menu = (object)[
//     'annee' => $CFG->wwwroot.'/local/powerschool/anneescolaire.php'),
//     'campus' => $CFG->wwwroot.'/local/powerschool/campus.php'),
//     'semestre' => $CFG->wwwroot.'/local/powerschool/semestre.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
//     'filiere' => $CFG->wwwroot.'/local/powerschool/filiere.php'),
//     'cycle' => $CFG->wwwroot.'/local/powerschool/cycle.php'),
//     'modepayement' => $CFG->wwwroot.'/local/powerschool/modepayement.php'),
//     'matiere' => $CFG->wwwroot.'/local/powerschool/matiere.php'),
//     'seance' => $CFG->wwwroot.'/local/powerschool/seance.php'),
//     'inscription' => $CFG->wwwroot.'/local/powerschool/inscription.php'),
//     'enseigner' => $CFG->wwwroot.'/local/powerschool/enseigner.php'),
//     'paiement' => $CFG->wwwroot.'/local/powerschool/paiement.php'),
// ];


$menu = (object)[
    'programme' => new moodle_url('/local/powerschool/programmepersoparent.php'),
    'paiement' => new moodle_url('/local/powerschool/paiementpersoparent.php'),
    'note' => new moodle_url('/local/powerschool/bulletinnotepersoparent.php'),
    'absence' => new moodle_url('/local/powerschool/listeetuabsenetuparent.php'),
];
echo $OUTPUT->header();
if($CFG->theme=="boost")
    {
    }
    elseif ($CFG->theme == 'adaptable') {
        // Changer la couleur en bleu
        echo"<p style='margin-top:-120px'><p>";
    }

echo $OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// $mform->display();

echo $OUTPUT->render_from_template('local_powerschool/paiementpersoparent', $templatecontext);


echo $OUTPUT->footer();