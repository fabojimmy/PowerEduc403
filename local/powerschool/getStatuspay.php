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
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/OrangeMoney.class.php');
require_once(__DIR__ . '/idetablisse.php');
require_once(__DIR__ . '/token.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url($CFG->wwwroot.'/local/powerschool/paiement.php');
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une paiement');
$PAGE->set_heading('Enregistrer une paiement');

$PAGE->navbar->add(get_string('inscription', 'local_powerschool'),  $CFG->wwwroot.'/local/powerschool/inscription.php?idca='.$_GET["idca"].'');
$PAGE->navbar->add(get_string('paiement', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new paiement();
$orange=new Orange();
global $DB;




echo $OUTPUT->header();

$Objtsta=$orange->getStauts("https://api-s1.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/".$_GET["paydd"]."",$_GET["oran"],"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=");

// echo $Objtsta;
$Objtsta=json_decode($Objtsta);
var_dump($Objtsta->data->status);
    if($Objtsta->data->status=="CANCELLED"){
        redirect(new moodle_url('/local/powerschool/getStatuspay.php?paydd='.$_GET["paydd"].'&&oran='.$_GET["oran"].'&&libelle='.$_GET["libelle"].'&&email='.$_GET["email"].'&&time='.$_GET["time"].''),"payment a échoué",null,\core\output\notification::NOTIFY_ERROR);
    }
    else if($Objtsta->data->status=="PENDING"){
        redirect(new moodle_url('/local/powerschool/getStatuspay.php?paydd='.$_GET["paydd"].'&&oran='.$_GET["oran"].'&&libelle='.$_GET["libelle"].'&&email='.$_GET["email"].'&&time='.$_GET["time"].''),"payment toujours en attende",null,\core\output\notification::NOTIFY_WARNING);
        
    }else if($Objtsta->data->status=="SUCCESSFULL"){
        $payload=array(
            "libelle"=>$_GET["libelle"],
            "email"=>$_GET["email"],
            "timedebut"=>time(),
            "timefin"=>$_GET["time"],
         );
        
           tokenencode($payload);
        
          //  var_dump(tokenencode($payload));
          //  die;
           $DB->insert_record('tokenpaie',array("token"=>tokenencode($payload),
                                                "idcampus"=>ChangerSchoolUser($USER->id),
                                                "usermodified"=>$USER->id,
                                                "timecreated"=>time(),
                                                "timemodified"=>time(),
                                              ));
        redirect(new moodle_url('/local/powerschool/reglages.php'),"payment a été un succès",null,\core\output\notification::NOTIFY_SUCCESS);

    }





    echo $OUTPUT->footer();
