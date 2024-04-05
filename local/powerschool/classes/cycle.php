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
use moodleform;
use stdClass;


require_once($CFG->libdir.'/formslib.php');

class cycle extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$DB,$iddetablisse;
        
        global $USER;
        $mform = $this->_form; // Don't forget the underscore!
        $rolecasql="SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".ChangerSchoolUser($USER->id)."'";
        $campus=$DB->get_records_sql($rolecasql);

        
    foreach($campus as $key => $cam)
    {}
    if($cam->libelletype=="universite"){
        $mform->addElement('header','cycle','cycle');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
       
        $mform->addElement('hidden', 'idcampus');
        $mform->setType('idcampus', PARAM_INT);
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));

        $mform->addElement('text', 'libellecycle', 'Libellé cycle'); // Add elements to your form
        $mform->setType('libellecycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libellecycle', '');        //Default value
        $mform->addRule('libellecycle', 'Libelle Cycle', 'required', null, 'client');
        $mform->addHelpButton('libellecycle', 'Cycle');
       
        $mform->addElement('text', 'nombreannee', 'Nombres d\'année du Cycle'); // Add elements to your form
        $mform->setType('nombreannee', PARAM_INT);                   //Set type of element
        $mform->setDefault('nombreannee','');        //Default value
        $mform->addRule('nombreannee', 'Annee Cycle', 'required', null, 'client');
        $mform->addHelpButton('nombreannee', 'Cycle');


        $this->add_action_buttons();
    }
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
    public function update_cycle(int $id, string $libellecycle, string $nombreannee): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libellecycle = $libellecycle ;
        $object->nombreannee = $nombreannee;

        return $DB->update_record('cycle', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_cycle(int $cycleid)
    {
        global $DB;
        return $DB->get_record('cycle', ['id' => $cycleid]);
    }

    public function selectcycle (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_cycle(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcycle = $DB->delete_records('cycle', ['id'=> $id]);
        if ($suppcycle){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    
    public function verificycle( $libelle,$idcampus)
    {
        global $DB;
        $true=$DB->get_record("cycle",array("libellecycle" => $libelle,"idcampus"=>$idcampus));
        if ($true) {
            return true;
        }
    }
}