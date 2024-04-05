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

class absencejustifier extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$DB,$USER,$iddetablisse;

        


        $mform = $this->_form; // Don't forget the underscore!
        $anneescolaire=$DB->get_records("anneescolaire");
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }
        $mform->addElement('header','absencejustifier', ' Enregistrer vos depenses');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
       
        $mform->addElement('hidden', 'idcampus');
        $mform->setDefault('idcampus', $_GET["idcampus"]);
        $mform->addElement('hidden', 'usermodified');
        $mform->setDefault('usermodified', $USER->id);
        $mform->addElement('hidden', 'timecreated');
        $mform->setDefault('timecreated', time());
        $mform->addElement('hidden', 'timemodified');
        $mform->setDefault('timemodified', time());
        $mform->addElement('hidden', 'idabsenceetu');
        $mform->setDefault('idabsenceetu', $_GET['idabse']);
        // var_dump( $campus->selectcampus($sql)); 
        // die;

        // $mform->addElement('text', 'libellemate', 'Libellé du mateirel'); // Add elements to your form
        // $mform->setType('libellemate', PARAM_TEXT);                   //Set type of element
        // $mform->addRule('libellemate', 'Enregistrer le libellé du materiel', 'required', null, 'client');
        // $mform->addHelpButton('libellemate', 'specialite');
     
        // $mform->addElement('text', 'quantite', 'Quantité'); // Add elements to your form
        // $mform->setType('quantite', PARAM_TEXT);                   //Set type of element
        // $mform->addRule('quantite', 'Enregistrer la quantité', 'required', null, 'client');
        // $mform->addHelpButton('quantite', 'specialite');
        
        // $mform->addElement('text', 'prixuni', 'Prix Unitaire'); // Add elements to your form
        // $mform->setType('prixuni', PARAM_TEXT);                   //Set type of element
        // $mform->addRule('prixuni', 'Enregistrer le prix unitaire', 'required', null, 'client');
        // $mform->addHelpButton('prixuni', 'specialite');
        
        // $mform->addElement('text', 'prixuni', 'Quantité'); // Add elements to your form
        // $mform->setType('prixuni', PARAM_TEXT);                   //Set type of element
        // $mform->addRule('prixuni', 'Enregistrer le prix unitaire', 'required', null, 'client');
        // $mform->addHelpButton('prixuni', 'specialite');

        $mform->addElement('textarea', 'description', 'Justification de l\'absence','wrap="virtual" rows="2" cols="2"' ); // Add elements to your form
        $mform->setType('description', PARAM_TEXT);                   //Set type of element
        $mform->addRule('description', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('description', 'specialite');

        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');


        


       

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
    public function update_absencejustifier($id, $idabsenceetu, $idanneescolaire,$description): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idabsenceetu = $idabsenceetu ;
        $object->description = $description ;
        $object->idanneescolaire = $idanneescolaire ;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('absencejustifier', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_absencejustifier(int $absencejustifierid)
    {
        global $DB;
        return $DB->get_record('absencejustifier', ['id' => $absencejustifierid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_absencejustifier(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('absencejustifier', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    public function veri_insc($iduser){
        global $DB;
        $true=$DB->get_record("absencejustifier", array("idetudiant"=>$iduser));
        // $true1=$DB->get_record("absencejustifier", array("idspecialite"=>$specialite));
        if ($true) {
           return true;
        }
        // if ($true1) {
        //    return true;
        // }

    }
}