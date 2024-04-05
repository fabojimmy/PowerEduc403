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

class souscantine extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse;
        // global $iddetablisse;
        global $USER,$DB;
        $campus = new campus();
        $camp = array();
        $sql = "SELECT * FROM {campus} ";
        $camp = $campus->select($sql);
        $cantine=$DB->get_records("cantine");
        // var_dump($iddetablisse);die;
        $mform = $this->_form; // Don't forget the underscore!

        foreach ($cantine as $key => $vallll)
        {
            $tarcantine[$key]=$vallll->libellecantine;
        }
        $anneescolaire=$DB->get_records("anneescolaire");
        // var_dump($iddetablisse);die;
        $mform = $this->_form; // Don't forget the underscore!

        
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }
        $mform->addElement('header','souscantine', 'Sous Cantine');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'libellesouscantine', 'Libelle de la souscantine'); // Add elements to your form
        $mform->setType('libellesouscantine', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libellesouscantine', '');        //Default value
        $mform->addRule('libellesouscantine', 'libelles de la souscantine', 'required', null, 'client');
        $mform->addHelpButton('libellesouscantine', 'souscantine');

        // $mform->addElement('text', 'capacitesouscantine', 'Capacite de la souscantine'); // Add elements to your form
        // $mform->setType('capacitesouscantine', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('capacitesouscantine', '');        //Default value
        // $mform->addRule('capacitesouscantine', 'Capacite de la souscantine', 'required', null, 'client');
        // $mform->addHelpButton('capacitesouscantine', 'souscantine');
       
         $mform->addElement('select', 'idcantine', 'Cantine', $tarcantine ); // Add elements to your form
        $mform->setType('idcantine', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcantine', '');        //Default value
        $mform->addRule('idcantine', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idcantine', 'campus');
        
        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value
       
        $mform->addElement('hidden', 'action'); // Add elements to your form
        $mform->setDefault('action', $_GET["action"]);        //Default value



        foreach ($camp as $key => $val)
        {
            $selectcamp[$key] = $val->libellecampus;
        }
        // var_dump($iddetablisse); 
        // die;
        // $mform->addElement('hidden', 'idcampus' ); // Add elements to your form
        // $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        // $mform->setDefault('idcampus', $iddetablisse);        //Default value
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
    public function update_souscantine($data): bool
    {
        global $DB;
        // global $USER;
        // $object = new stdClass();
        // $object->id = $id;
        // $object->libellesouscantine = $libellesouscantine ;
        // $object->capacitesouscantine = $capacitesouscantine ;
        // $object->idcampus = $idcampus;
        // $object->usermodified = $USER->id;
        // $object->timemodified = time();



        return $DB->update_record('souscantine', $data);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_souscantine($souscantineid)
    {
        global $DB;
        return $DB->get_record('souscantine', ['id' => $souscantineid]);
    }
    
    
    
    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_souscantine(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('souscantine', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }
        
        return true;
    }
    // public function get_souscantine(int $souscantineid)
    // {
    //     global $DB;
    //     return $DB->get_record('souscantine', ['id' => $souscantineid]);
    // }

    
    public function verisouscantine(String $souscantine,$idcanti,$idanne)
    {
        global $DB;
        $true=$DB->get_record("souscantine",["libellesouscantine"=>$souscantine,
                                             "idcantine"=>$idcanti,
                                             "idanneescolaire"=>$idanne]);
        if ($true) {
            return true;
        }

    }
}