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

class message extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;

        


        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','inscription', ' Personnaliser votre message');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
       
        $mform->addElement('hidden', 'idcampus');
        $mform->setDefault('idcampus', $_GET["idca"]);
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('text', 'email', 'Email'); // Add elements to your form
        $mform->setType('email', PARAM_TEXT);                   //Set type of element
        $mform->addRule('email', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('email', 'specialite');
     
        $mform->addElement('text', 'password', 'Password'); // Add elements to your form
        $mform->setType('password', PARAM_TEXT);                   //Set type of element
        $mform->addRule('password', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('password', 'specialite');

        $mform->addElement('textarea', 'subject', 'Subjectif','wrap="virtual" rows="2" cols="2"' ); // Add elements to your form
        $mform->setType('subject', PARAM_TEXT);                   //Set type of element
        $mform->addRule('subject', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('subject', 'specialite');

        $mform->addElement('textarea', 'body', 'Body','wrap="virtual" rows="20" cols="50"'  ); // Add elements to your form
        $mform->setType('body', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('body', '');        //Default value
        $mform->addRule('body', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('body', 'specialite');

        


       

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
    public function update_inscription($id, $idetudiant, $idanneescolaire,$idcampus,$idspecialite,$idcycle,$nomsparent,$telparent,
    $emailparent,$professionparent ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idetudiant = $idetudiant ;
        $object->idanneescolaire = $idanneescolaire ;
        $object->idcampus = $idcampus ;
        $object->idspecialite = $idspecialite ;
        $object->idcycle = $idcycle ;
        $object->nomsparent = $nomsparent ;
        $object->telparent = $telparent ;
        $object->emailparent = $emailparent;
        $object->professionparent = $professionparent;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('inscription', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_inscription(int $inscriptionid)
    {
        global $DB;
        return $DB->get_record('inscription', ['id' => $inscriptionid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_inscription(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('inscription', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    public function veri_insc($iduser){
        global $DB;
        $true=$DB->get_record("inscription", array("idetudiant"=>$iduser));
        // $true1=$DB->get_record("inscription", array("idspecialite"=>$specialite));
        if ($true) {
           return true;
        }
        // if ($true1) {
        //    return true;
        // }

    }
}