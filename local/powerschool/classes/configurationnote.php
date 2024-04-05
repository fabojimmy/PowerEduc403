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

class configurationnote extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;

        $sql2 = "SELECT * FROM {anneescolaire} ";
        $sql3 = "SELECT * FROM {campus} ";
     

        $campus = $DB->get_records_sql($sql3);
        $anneescolaire = $DB->get_records_sql($sql2);
       
        foreach ($campus as $key => $val)
        {
            $selectcampus[$key] = $val->libellecampus;
        }
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','periode',get_string('pourcentage', 'local_powerschool'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'normal', 'Pourcentage de la Normal'); // Add elements to your form
        $mform->setType('normal', PARAM_INT);                   //Set type of element
        $mform->setDefault('normal', '');        //Default value
        $mform->addRule('normal', 'pourcentage de la normal', 'required', null, 'client');
        $mform->addHelpButton('normal', 'periode');
       
        $mform->addElement('text', 'cc', 'Pourcentage du controle continue'); // Add elements to your form
        $mform->setType('cc', PARAM_INT);                   //Set type of element
        $mform->setDefault('cc','');        //Default value
        $mform->addRule('cc', 'pourcentage du controle continue', 'required', null, 'client');
        $mform->addHelpButton('cc', 'periode');

        $mform->addElement('select', 'idcampus', 'Campus', $selectcampus ); // Add elements to your form
        $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', '');        //Default value
        $mform->addRule('idcampus', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('idcampus', 'specialite');

        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

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
    public function update_periode($id, $normal, $cc,$campus,$annee): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->normal = $normal ;
        $object->cc = $cc;
        $object->idcampus = $campus;
        $object->idannee = $annee;
        $object->timemodified = time();

        // var_dump($object);die;
        return $DB->update_record('configurationnote', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_periode(int $periodeid)
    {
        global $DB;
        return $DB->get_record('configurationnote', ['id' => $periodeid]);
    }

    public function selectperiode (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_periode(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppperiode = $DB->delete_records('configuration', ['id'=> $id]);
        if ($suppperiode){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}