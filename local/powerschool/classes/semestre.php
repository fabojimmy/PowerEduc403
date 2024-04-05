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

class semestre extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $campus = new campus();
        $annee = array();
        $sql = "SELECT * FROM {anneescolaire} ";
        $annee = $campus->select($sql);

        $entier = array(0,1,2,3,4,5,6,7,8,9);
        

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','semestre', 'Differentes Parties');
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'numerosemestre', 'Semestre N° '); // Add elements to your form
        $mform->setType('numerosemestre', PARAM_INT);                   //Set type of element
        // $mform->setDefault('numerosemestre', '');        //Default value
        $mform->addRule('numerosemestre', 'numeros de semestre', 'required', null, 'client');
        $mform->addHelpButton('numerosemestre', 'semestre');

        $mform->addElement('text', 'libellesemestre', 'Libelle semestre'); // Add elements to your form
        $mform->setType('libellesemestre', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('libellesemestre', '');        //Default value
        $mform->addRule('libellesemestre', 'Libelle semestre', 'required', null, 'client');
        $mform->addHelpButton('libellesemestre', 'semestre');

        $mform->addElement('date_selector', 'datedebutsemestre', 'date de debut'); // Add elements to your form
        $mform->setType('datedebutsemestre', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('datedebutsemestre', '');        //Default value
        $mform->addRule('datedebutsemestre', 'date de debut', 'required', null, 'client');
        $mform->addHelpButton('datedebutsemestre', 'datedebut');

        $mform->addElement('date_selector', 'datefinsemestre', 'date de fin'); // Add elements to your form
        $mform->setType('datefinsemestre', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('datefinsemestre', '');        //Default value
        $mform->addHelpButton('datefinsemestre', 'datefin');
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value


        foreach ($annee as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }

        

        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idanneescolaire', 'Année scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l Annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'anneescolaire');

       

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
    public function update_semestre(int $id, string $numerosemestre,string $libellesemestre,string $datedebutsemestre,string $datefinsemestre,string $idanneescolaire ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->numerosemestre = $numerosemestre ;
        $object->libellesemestre = $libellesemestre ;
        $object->datedebutsemestre = $datedebutsemestre;
        $object->datefinsemestre = $datefinsemestre;
        $object->idanneescolaire = $idanneescolaire;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('semestre', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_semestre(int $semestreid)
    {
        global $DB;
        return $DB->get_record('semestre', ['id' => $semestreid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_semestre(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('semestre', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    
    public function verifisemestre(String $semetre){


        global $DB;
        $true=$DB->get_record("semestre", ['libellesemestre'=> $semetre]);
        if($true){
            return true;
        }
    }
    public function verifientreannee(int $dateD,int $dateF){
        global $DB;

        $true=$DB->get_record("semestre", ['datedebutsemestre'=> $dateD,'datefinsemestre'=>$dateF]);
        $annee=$DB->get_records("anneescolaire");

        foreach($annee as $key=>$value){
        }
        

        $yeardA=date("Y",$value->datedebut);
        $yearfA=date("Y",$value->datefin);
        
        $yeardS=date("Y",$dateD);
        $yearfS=date("Y",$dateF);


        if (($value->datedebut>$dateD && $dateD<$value->datefin || $value->datedebut>$dateF && $dateF<$value->datefin) 
        || $dateD===$dateF || $true ||
        (($value->datedebut>$dateD && $dateD<$value->datefin) && ($value->datedebut>$dateF && $dateF<$value->datefin))
        ||(($yeardS<$yeardA && $yearfS>$yearfA)||($yeardS<$yeardA || $yearfS>$yearfA))) {

            return true;
        } 
        
    }
}