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

namespace local_powerschool;
use stdClass;
use moodleform;
use local_powerschool\campus;


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/campus.php');

class paiement extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$DB;
        
        
        // var_dump($filiercycltr,$_GET["idfi"]);die;
        
        //ici on affiche les tranche que l'etudiant n'as pas payé et n'as encore fini
        
        
        $mform = $this->_form; // Don't forget the underscore!
        global $USER;
        $campus = new campus();
        $modepaie = array();
        $sql = "SELECT * FROM {modepaiement} ";
        // $sql1="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_GET["idfi"]."' AND idcycle='".$_GET["idcy"]."'";
       
        $sql2 = "SELECT * FROM {tranche} ";
        $modepaie = $campus->select($sql);
        // $selecttranche=array();
        // $filiercycltr = $DB->get_records_sql($sql1);

        $mform->addElement('header','paiement', 'paiement');

        $mform->addElement('hidden', 'idinscription');
        $mform->setType('idinscription', PARAM_INT);
        $mform->setDefault('idinscription', $_GET['idins']);

        $mform->addElement('hidden', 'idfi');
        $mform->setType('idfi', PARAM_INT);
        $mform->setDefault('idfi', $_GET['idfi']);

        $mform->addElement('hidden', 'idcy');
        $mform->setType('idcy', PARAM_INT);
        $mform->setDefault('idcy', $_GET['idcy']);
       
        $mform->addElement('hidden', 'idsp');
        $mform->setType('idsp', PARAM_INT);
        $mform->setDefault('idsp', $_GET['idsp']);
        
        $mform->addElement('hidden', 'idca');
        $mform->setType('idca', PARAM_INT);
        $mform->setDefault('idca', $_GET['idca']);

        // var_dump($_GET['idins']);die;
        // $mform->addElement('text', 'notepaiement', 'Capacite de la paiement'); // Add elements to your form
        // $mform->setType('notepaiement', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('notepaiement', '');        //Default value
        // $mform->addRule('notepaiement', 'Capacite de la paiement', 'required', null, 'client');
        // $mform->addHelpButton('notepaiement', 'paiement');
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

        foreach ($modepaie as $key => $val)
        {
            $selectmodepaie[$key] = $val->abreviationmodepaie;
        }
// $selecttranche=array();
//         foreach ($filiercycltr as $key => $value) {

//             // var_dump($value->idtranc);die;
//                 $sql3="SELECT idtranc, sum(montant) as mont FROM {paiement} WHERE idinscription='".$_GET["idins"]."' AND idtranc='".$value->idtranc."'";
//                 $paieverie = $DB->get_records_sql($sql3);
//                 // var_dump($paieverie);die;
//                 foreach ($paieverie as $key => $value1) {
//                     // var_dump($value1->countlig);die;
//                     if ($value->somme==$value1->mont) {
//                         $sql4="SELECT id,libelletranche FROM {tranche} WHERE id <> '".$value1->idtranc."'";
//                         $tranche = $DB->get_records_sql($sql4);
//                         foreach ($tranche as $key1 => $value2) {
//                             // var_dump($tranche);
                            
//                             $selecttranche[$key1]=$value2->libelletranche;
//                         }
//                         // die;
//                     }else if(((int)$value1->countlig)===0){
//                         // $sql4="SELECT * FROM {tranche}";
//                         // $tranche = $DB->get_records_sql($sql4);
//                         //     foreach ($tranche as $key => $value5) {
//                             //       $selecttranche[$key]=$value5->libelletranche;
//                             //     }
//                         }         
//                     }
//                 }
                $sql4="SELECT * FROM {tranche} WHERE idcampus='".$_GET["idca"]."'";
                $tranche = $DB->get_records_sql($sql4);
                    foreach ($tranche as $key => $value5) {
                          $selecttranche1[$key]=$value5->libelletranche;
                        }
                
                // var_dump($selecttranche);
                //     die;
                // var_dump($selecttranche); 
        // die;

        
        $mform->addElement('text', 'montant', 'Montant' ); // Add elements to your form
        $mform->setType('montant', PARAM_INT);                   //Set type of element
        $mform->setDefault('montant', '');        //Default value
        $mform->addRule('montant', 'Choix de la fiche Insciption', 'required', null, 'client');
        $mform->addHelpButton('montant', 'inscirption');
        
        $mform->addElement('select', 'idmodepaie', 'Mode du paiement', $selectmodepaie ); // Add elements to your form
        $mform->setType('idmodepaie', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idmodepaie', '');        //Default value
        $mform->addRule('idmodepaie', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idmodepaie', 'campus');
        
        $mform->addElement('select', 'idtranc', 'Differente Tranche', $selecttranche1 ); // Add elements to your form
        $mform->setType('idtranc', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idtranc', '');        //Default value
        $mform->addRule('idtranc', 'Differente Tranche','required', null, 'tranche');
        $mform->addHelpButton('idtranc', 'tranche');
       

        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

    

     /** Mise à jour de l'année academique 
     * @param int $id l'identifiant de l'année a à modifier
     * @param string $datedebut la date de debut de l'annee
     * @param string $datefin date de fin de l'annee 
     */
    public function update_paiement(int $id, string $idmodepaie, string $idinscription ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idmodepaie = $idmodepaie ;
        $object->idinscription = $idinscription ;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('paiement', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_paiement(int $paiementid)
    {
        global $DB;
        return $DB->get_record('paiement', ['id' => $paiementid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_paiement(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('paiement', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}