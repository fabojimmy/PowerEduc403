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

class affectercantine extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse;
        // global $iddetablisse;
        global $USER,$DB;
        $campus = new campus();
        $camp = array();
        $sql = "SELECT * FROM {campus} ";
        $camp = $campus->select($sql);
        $cantine=$DB->get_records("souscantine");
        $userr=$DB->get_records_sql("SELECT u.id,firstname,lastname FROM {user} u ,{role_assignments} r WHERE u.id = r.userid AND r.roleid=10");
        // var_dump($iddetablisse);die;
        $mform = $this->_form; // Don't forget the underscore!

        foreach ($cantine as $key => $vallll)
        {
            $tarcsousantine[$key]=$vallll->libellesouscantine;
        }
        foreach ($userr as $key => $vallll)
        {
            $taruser[$key]=$vallll->firstname."-".$vallll->lastname;
        }
        $mform->addElement('header','affectercantine', 'Sous Cantine');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $anneescolaire=$DB->get_records("anneescolaire");
        // var_dump($iddetablisse);die;
        $mform = $this->_form; // Don't forget the underscore!

        
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }
        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');

        // $mform->addElement('text', 'libelleaffectercantine', 'Libelle de la affectercantine'); // Add elements to your form
        // $mform->setType('libelleaffectercantine', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('libelleaffectercantine', '');        //Default value
        // $mform->addRule('libelleaffectercantine', 'libelles de la affectercantine', 'required', null, 'client');
        // $mform->addHelpButton('libelleaffectercantine', 'affectercantine');

        // $mform->addElement('text', 'capaciteaffectercantine', 'Capacite de la affectercantine'); // Add elements to your form
        // $mform->setType('capaciteaffectercantine', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('capaciteaffectercantine', '');        //Default value
        // $mform->addRule('capaciteaffectercantine', 'Capacite de la affectercantine', 'required', null, 'client');
        // $mform->addHelpButton('capaciteaffectercantine', 'affectercantine');
       
         $mform->addElement('select', 'idsouscantine', 'Sous Cantine', $tarcsousantine); // Add elements to your form
        $mform->setType('idsouscantine', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idsouscantine', '');        //Default value
        $mform->addRule('idsouscantine', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idsouscantine', 'campus');
        
         $mform->addElement('select', 'idserveur', 'Serveur', $taruser ); // Add elements to your form
        $mform->setType('idserveur', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idserveur', '');        //Default value
        $mform->addRule('idserveur', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idserveur', 'campus');
        
       
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
    public function update_affectercantine($data): bool
    {
        global $DB;
        // global $USER;
        // $object = new stdClass();
        // $object->id = $id;
        // $object->libelleaffectercantine = $libelleaffectercantine ;
        // $object->capaciteaffectercantine = $capaciteaffectercantine ;
        // $object->idcampus = $idcampus;
        // $object->usermodified = $USER->id;
        // $object->timemodified = time();



        return $DB->update_record('affectercantine', $data);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_affectercantine($affectercantineid)
    {
        global $DB;
        return $DB->get_record('affectercantine', ['id' => $affectercantineid]);
    }
    
    
    
    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_affectercantine(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('affectercantine', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }
        
        return true;
    }
    // public function get_affectercantine(int $affectercantineid)
    // {
    //     global $DB;
    //     return $DB->get_record('affectercantine', ['id' => $affectercantineid]);
    // }

    
    public function veriaffectercantine($idserveur,$idanne)
    {
        global $DB;
        $true=$DB->get_record("affectercantine",["idserveur"=>$idserveur,
                                                "idanneescolaire"=>$idanne]);
        if ($true) {
            return true;
        }

    }
}