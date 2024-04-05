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

class periode extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','periode','periode');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'libelleperiode', 'Libellé periode'); // Add elements to your form
        $mform->setType('libelleperiode', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libelleperiode', '');        //Default value
        $mform->addRule('libelleperiode', 'Libelle periode', 'required', null, 'client');
        $mform->addHelpButton('libelleperiode', 'periode');
       
        $mform->addElement('text', 'duree', 'Durée de la periode'); // Add elements to your form
        $mform->setType('duree', PARAM_INT);                   //Set type of element
        $mform->setDefault('duree','');        //Default value
        $mform->addRule('duree', 'Annee periode', 'required', null, 'client');
        $mform->addHelpButton('duree', 'periode');


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
    public function update_periode(int $id, string $libelleperiode, string $duree): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libelleperiode = $libelleperiode ;
        $object->duree = $duree;

        return $DB->update_record('periode', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_periode(int $periodeid)
    {
        global $DB;
        return $DB->get_record('periode', ['id' => $periodeid]);
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
        $suppperiode = $DB->delete_records('periode', ['id'=> $id]);
        if ($suppperiode){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}