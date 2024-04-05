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

class seanceedit extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$DB;
        
        global $USER;
        $campus = new campus();
        $cours = $specialite = $cycle =  array();
        $sql1 = "SELECT * FROM {course} ";
        $sql2 = "SELECT s.id,numerosalle,libellecampus,capacitesalle FROM {salle} s,{campus} c WHERE s.idcampus=c.id AND idcampus='".$_GET["idca"]."'";
        $sql3 = "SELECT s.id,libellespecialite FROM {specialite} s,{filiere} f WHERE s.idfiliere=f.id AND f.idcampus='".$_GET["idca"]."'";
        $sql4 = "SELECT * FROM {cycle} ";
        $sql5 = "SELECT * FROM {semestre} ";

        $cours = $campus->select($sql1);
        $salle = $DB->get_records_sql($sql2);
        $semestre = $DB->get_records_sql($sql5);
        $specialite = $campus->select($sql3);
        $cycle = $campus->select($sql4);
        


        // var_dump($salle);die;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','seance', 'Programmation des cours');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $_GET["id"]);
    
        $mform->addElement('hidden', 'idca');
        $mform->setType('idca', PARAM_INT);
        $mform->setDefault('idca', $_GET["id"]);
    
        foreach ($cours as $key => $val)
        {
            $selectcours[$key] = $val->fullname;
        }
        foreach ($salle as $key => $val1)
        {
            $selectsalle[$key] = "Salle ".$val1->numerosalle." - ".$val1->libellecampus." (".$val1->capacitesalle." personnes)";
        }
        foreach ($specialite as $key => $val)
        {
            $selectspecialite[$key] = $val->libellespecialite;
        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        foreach ($semestre as $key => $val)
        {
            $selectsemestre[$key] = $val->libellesemestre;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idcourses', 'Cours', $selectcours ); // Add elements to your form
        // $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcourses', '');        //Default value
        $mform->addRule('idcourses', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idcourses', 'cours');

        $mform->addElement('select', 'idsalle', 'salle', $selectsalle ); // Add elements to your form
        // $mform->setType('idsalle', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idsalle', '');        //Default value
        $mform->addRule('idsalle', 'Choix du salle', 'required', null, 'client');
        $mform->addHelpButton('idsalle', 'specialite');

        $mform->addElement('select', 'idspecialite', 'Specialite', $selectspecialite ); // Add elements to your form
        // $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');
        
        $mform->addElement('select', 'idsemestre', 'Semestre', $selectsemestre ); // Add elements to your form
        // $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idsemestre', 'Choix de la Semestre', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'Semestre');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        // $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'specialite');

        $mform->addElement('date_selector', 'dateseance', 'Date de la seance' ); // Add elements to your form
        // $mform->setType('dateseance', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('dateseance', '');        //Default value
        $mform->addRule('dateseance', ' date de cours ', 'required', null, 'client');
        $mform->addHelpButton('dateseance', 'datecours');

        $mform->addElement('text', 'heuredebutseance', 'Heure debut seance' ); // Add elements to your form
        // $mform->setType('heuredebutseance', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('heuredebutseance', '');        //Default value
        $mform->addRule('heuredebutseance', ' Heure debut du cours', 'required', null, 'client');
        $mform->addHelpButton('heuredebutseance', 'heure');

        $mform->addElement('text', 'heurefinseance', 'Heure Fin seance' ); // Add elements to your form
        // $mform->setType('heurefinseance', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('heurefinseance', '');        //Default value
        $mform->addRule('heurefinseance', ' Heure fin du cours', 'required', null, 'client');
        $mform->addHelpButton('heurefinseance', 'heure');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

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
    public function update_seance($id, $idcourses,  $idsalle, $idspecialite, $idcycle, $dateseance, $heuredebutseance, $heurefinseance,$idsemestre ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idcourses = $idcourses ;
        $object->idsalle = $idsalle ;
        $object->idspecialite = $idspecialite ;
        $object->idcycle = $idcycle ;
        $object->idsemestre = $idsemestre ;
        $object->dateseance = $dateseance ;
        $object->heuredebutseance = $heuredebutseance ;
        $object->heurefinseance = $heurefinseance;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('seance', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_seance(int $seanceid)
    {
        global $DB;
        return $DB->get_record('seance', ['id' => $seanceid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_seance(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('seance', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}