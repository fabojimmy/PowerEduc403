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
use local_powerschool\lib;


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/campus.php');
require_once($CFG->dirroot.'/local/powerschool/idetablisse.php');

class batiment extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse;
        // global ChangerSchoolUser($USER->id);
        global $USER;
        $campus = new campus();
        $camp = array();
        $sql = "SELECT * FROM {campus} ";
        $camp = $campus->select($sql);
        
        // var_dump(ChangerSchoolUser($USER->id));die;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','Salle', get_string("batimenttitle","local_powerschool"));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'numerobatiment', get_string("batimentlibelle","local_powerschool")); // Add elements to your form
        $mform->setType('numerobatiment', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('numerobatiment', '');        //Default value
        $mform->addRule('numerobatiment', 'Numeros de la Salle', 'required', null, 'client');
        $mform->addHelpButton('numerobatiment', 'salle');

        // $mform->addElement('text', 'capacitesalle', 'Capacite de la Salle'); // Add elements to your form
        // $mform->setType('capacitesalle', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('capacitesalle', '');        //Default value
        // $mform->addRule('capacitesalle', 'Capacite de la Salle', 'required', null, 'client');
        // $mform->addHelpButton('capacitesalle', 'salle');
       
       
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value
     
        $mform->addElement('hidden', 'action',"b"); // Add elements to your form
        $mform->setType('action', PARAM_INT);                   //Set type of element
        $mform->setDefault('action', $_GET["action"]);        //Default value


        foreach ($camp as $key => $val)
        {
            $selectcamp[$key] = $val->libellecampus;
        }
        // var_dump(ChangerSchoolUser($USER->id)); 
        // die;
        $mform->addElement('hidden', 'idcampus' ); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value
        // $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        // $mform->addHelpButton('idcampus', 'campus');
        
        // $mform->addElement('select', 'idcampus', 'Campus', $selectcamp ); // Add elements to your form
        // $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcampus', '');        //Default value
        // $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        // $mform->addHelpButton('idcampus', 'campus');
        
       

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
    public function update_batiment(int $id, string $numerosalle, int $idcampus ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->numerobatiment = $numerosalle ;
        $object->idcampus = $idcampus;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('batiment', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_batiment(int $salleid)
    {
        global $DB;
        return $DB->get_record('batiment', ['id' => $salleid]);
    }
    
    
    
    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_batiment(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('batiment', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }
        
        return true;
    }
    // public function get_salle(int $salleid)
    // {
    //     global $DB;
    //     return $DB->get_record('salle', ['id' => $salleid]);
    // }

    
    public function veriBatiment( $salle, $idcampus)
    {
        global $DB;
        // var_dump($salle,$idcampus);
        // die;
        $true=$DB->get_record("batiment",["numerobatiment"=>$salle,
        "idcampus"=>$idcampus]);
        if ($true) {
            return true;
        }

    }
}