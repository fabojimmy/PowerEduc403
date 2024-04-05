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
use local_powerschool\configurerpaiement;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/configurerpaiement.php');
require_once(__DIR__ . '/idetablisse.php');
require_once(__DIR__ . '/token.php');
require_once(__DIR__ . '/OrangeMoney.class.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/logo.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Ajouter logo');
$PAGE->set_heading('Ajouter logo');
$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('payementcampus', 'local_powerschool'), $managementurl);

// $PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/configurationmini.php');
// $PAGE->navbar->add(get_string('logo', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');


if ($_POST['payement']) {

    
    $payload=array(
        "libelle"=>$_POST["libellecampus"],
        "email"=>$_POST["emailcampus"],
        "timedebut"=>time(),
        "timefin"=>$timestampDansTroisMois,
     );
    
       
    //   $m=4;

    $tarmois=explode(",",$_POST['mois']);
    $moisajou="+".$tarmois[0]." months";
    $timestampAujourdhui = time(); // Obtention du timestamp Unix actuel
    $timestampDansTroisMois = strtotime($moisajou, $timestampAujourdhui); // Ajout de 3 mois au timestamp actuel
    
    // var_dump($_POST['payement'],$_POST['mois'],tokenencode($payload),date("Y-m-d",$timestampDansTroisMois));die;
  // var_dump(date("Y-m-d",$timestampDansTroisMois));die;
  $orange=new Orange();
  $objetOra=$orange->iniatiVen('https://api-s1.orange.cm/token',"raQRf7zAh7tPd24UlYtxMzsk2mca","m4MglHkMUH6qSmJ8XhQAEGsmXhYa",array(
    'grant_type' => 'client_credentials'
  ));

   $Objeinit=$orange->payementInit('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/init',$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=");

   $ObjPayR=$orange->paymentRequest('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/pay',$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=",8630,'','Payment',659924181,$tarmois[1],$_POST['payement'],$Objeinit);
  // $dateDansMois = date("Y-m-d", $timestampDansTroisMois); // Conversion du timestamp dans 3 mois en format de date YYYY-MM-DD
  $Objtsta=$orange->getStauts("https://api-s1.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/$Objeinit",$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=");
  
  $Objtsta=json_decode($Objtsta);

  // var_dump("LOLO".$objetOra."kkkk",$Objtsta,$ObjPayR,"vraiment",$Objtsta->data->status);die;
  


    redirect(new moodle_url('/local/powerschool/getStatuspay.php?paydd='.$Objeinit.'&&oran='.$objetOra.'&&libelle='.$_POST["libellecampus"].'&&email='.$_POST["emailcampus"].'&&time='.$timestampDansTroisMois.''),"payment lancé regarder status",null,\core\notification::SUCCESS);

    # code...
} else {
    # code...
}


$templatecontext = (object)[
    'payementeta' => new moodle_url('/local/powerschool/payementCampus.php'),
    'anneesupp'=> new moodle_url('/local/powerschool/anneescolaire.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
];
echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/payementCampus', $templatecontext);


echo $OUTPUT->footer();