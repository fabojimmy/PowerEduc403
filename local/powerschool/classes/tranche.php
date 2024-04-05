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
// require_once(__DIR__ . '/idetablisse.php');

class tranche extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse;
        
        global $USER;

        // var_dump($iddetablisse);
        // die;
        $reqq = new campus();
        $annee = array();
        $sql = "SELECT * FROM {anneescolaire} ";
        $annee = $reqq->select($sql);
        $sql3 = "SELECT * FROM {campus} ";
        $ecole = $reqq->select($sql3);

        $mform = $this->_form; // Don't forget the underscore!

        foreach ($ecole as $key => $val)
        {
            $selectcampus[$key] = $val->libellecampus;
        }

        $mform->addElement('header', 'header','Enregistrer une '.get_string('tranche', 'local_powerschool'));
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'action');
        $mform->setDefault('action', $_GET["action"]);
        
        $mform->addElement('text', 'libelletranche', 'Libellé Tranche'); // Add elements to your form
        $mform->setType('libelletranche', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libelletranche', '');        //Default value
        $mform->addRule('libelletranche', 'Libelle specialite', 'required', null, 'client');
        $mform->addHelpButton('libelletranche', 'specialite');
        
        // var_dump(ChangerSchoolUser($USER->id),__DIR__);die;
        
        $mform->addElement('hidden', 'idcampus' ); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value
        // die;
      
        // $mform->addElement('select', 'idcampus', 'Campus', $selectcampus ); // Add elements to your form
        // $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcampus', '');        //Default value
        // $mform->addRule('idcampus', 'Choix du campus', 'required', null, 'client');
        // $mform->addHelpButton('idcampus', 'specialite');

        foreach ($annee as $key => $value) {
            # code...
        }
        $mform->addElement('hidden', 'idanneescolaire'); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_INT);                   //Set type of element
        $mform->setDefault('idanneescolaire', $value->id);        //Default value

        // die;
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
    public function update_tranche(int $id, string $libellespecialite): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libelletranche = $libellespecialite ;

        return $DB->update_record('tranche', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_tranche($specialiteid)
    {
        global $DB;
        return $DB->get_record('tranche', ['id' => $specialiteid]);
    }

    public function selectspecialite (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_tranche(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppspecialite = $DB->delete_records('tranche', ['id'=> $id]);
        if ($suppspecialite){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}