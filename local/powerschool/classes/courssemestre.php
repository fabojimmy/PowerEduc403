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

class courssemestre extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $campus = new campus();
        $cours = $specialite = $cycle =  array();
        $sql1 = "SELECT * FROM {course} ";
        $sql2 = "SELECT * FROM {semestre} ";

        $cours = $campus->select($sql1);
        $semestre = $campus->select($sql2);
        

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','courssemestre', 'Affecter un cours à un semestre');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($cours as $key => $val)
        {
            $selectcours[$key] = $val->fullname;
        }
        foreach ($semestre as $key => $val)
        {
            $selectsemestre[$key] = $val->libellesemestre;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        // $mform->addElement('select', 'idcourses', 'Cours', $selectcours ); // Add elements to your form
        // $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcourses', '');        //Default value
        // $mform->addRule('idcourses', 'Choix du Cours', 'required', null, 'client');
        // $mform->addHelpButton('idcourses', 'cours');
        
        $mform->addElement('hidden', 'idcoursspecialite', 'Cours'); // Add elements to your form
        $mform->setType('idcoursspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcoursspecialite', $_GET["idcosp"]);        //Default value
        $mform->addRule('idcoursspecialite', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idcoursspecialite', 'cours');

        $mform->addElement('hidden','idcycle');
        $mform->setDefault('idcycle', $_GET["idcy"]);
   
        $mform->addElement('hidden','idcampus');
        $mform->setDefault('idcampus', $_GET["idca"]);
        
        $mform->addElement('hidden','idspecialite');
        $mform->setDefault('idspecialite', $_GET["idsp"]);

        $mform->addElement('select', 'idsemestre', 'Semestre', $selectsemestre ); // Add elements to your form
        $mform->setType('idsemestre', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idsemestre', '');        //Default value
        $mform->addRule('idsemestre', 'Choix du Semestre', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'specialite');

        $mform->addElement('text', 'nombreheure', 'Nombre Heure' ); // Add elements to your form
        $mform->setType('nombreheure', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('nombreheure', '');        //Default value
        $mform->addRule('nombreheure', ' Nombre Heure', 'required', null, 'client');
        $mform->addHelpButton('nombreheure', 'heure');

        $mform->addElement('hidden', 'idspc'); // Add elements to your form
        $mform->setType('idspc', PARAM_INT);                   //Set type of element
        $mform->setDefault('idspc', $_GET["idcosp"]);        //Default value

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
    public function update_courssemestre(int $id, string $idcourse, string $idsemestre, string $nbrheure ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idcoursspecialite = $idcourse ;
        $object->idsemestre = $idsemestre ;
        $object->nombreheure = $nbrheure;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('courssemestre', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_courssemestre(int $courssemestreid)
    {
        global $DB;
        return $DB->get_record('courssemestre', ['id' => $courssemestreid]);
    }

    // public function veri_semes($idcourss,$idsem)
    // {
    //     global $DB;
    //     $true=$DB->get_records_sql("SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$idcourss."' AND idsemestre='".$idsem."'");
    //     foreach($true as $key => $value)
    //     {

    //     }
    //     $vercou=$DB->get_records_sql("SELECT * FROM {coursspecialite} WHERE id='".$value->idcoursspecialite."'");
    //     foreach($vercou as $key => $value1)
    //     {
            
    //     }
    //     $vercoucysp=$DB->get_records_sql("SELECT * FROM {coursspecialite} WHERE id='".$value->idcoursspecialite."' AND idcycle='".$value1->idcycle."' AND idspecialite='".$value1->idspecialite."'");
    //     var_dump($idcourss);die;
    //     if($vercoucysp)
    //     {
    //        return true; 
    //     }
    // }


    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_courssemestre(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('courssemestre', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}