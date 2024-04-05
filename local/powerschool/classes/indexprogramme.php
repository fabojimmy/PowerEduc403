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
 * 
 */

namespace local_powerschool;

use Exception;
use moodleform;
use stdClass;
use local_powerschool\campus;


require_once($CFG->libdir.'/formslib.php');

class indexprogramme extends moodleform {

    public $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    private  $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','November','Decembre'];
    public $month;
    public $year;

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$iddetablisse;
        $campus = new campus();
        $cours = $specialite = $cycle =  array();
        
        
        $sql1 = "SELECT * FROM {course} ";
        $sql6 = "SELECT * FROM {salle} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql2 = "SELECT * FROM {semestre} ";
        $sql3 = "SELECT s.id,libellespecialite FROM {specialite} s,{filiere} f WHERE s.idfiliere=f.id AND idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql4 = "SELECT * FROM {cycle} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql5 = "SELECT * FROM {anneescolaire} ";

        $cours = $campus->select($sql1);
        $salle = $campus->select($sql6);
        $semestre = $campus->select($sql2);
        $specialite = $campus->select($sql3);
        $cycle = $campus->select($sql4);
        $anneescoalire = $campus->select($sql5);
        
        
        
        $mform = $this->_form; // Don't forget the underscore!
        
        $mform->addElement('header','programme', 'Programmation des cours');

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
        
        foreach ($specialite as $key => $val)
        {
            $selectspecialite[$key] = $val->libellespecialite;
        }

        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        foreach ($salle as $key => $val)
        {
            $selectsalle[$key] = $val->numerosalle;
        }

        foreach ($anneescoalire as $key => $val)
        {
            $selectanneescolaire[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);
        }
        
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        // die;
        // $mform->addElement('select', 'idanneescolaire', 'Date du cours' ); // Add elements to your form
        // $mform->setDefault('idanneescolaire', '');        //Default value
        // $mform->addRule('idanneescolaire', 'Choix de la date du cours', 'required', null, 'client');
        // $mform->addHelpButton('idanneescolaire', 'Anneescolaire');



        $mform->addElement('hidden', 'idcampus' ); // Add elements to your form
        $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value

        // $mform->addElement('select', 'idcourses', 'Cours', $selectcours ); // Add elements to your form
        // $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcourses', '');        //Default value
        // $mform->addRule('idcourses', 'Choix du Cours', 'required', null, 'client');
        // $mform->addHelpButton('idcourses', 'cours');

        $mform->addElement('select', 'idsemestre', 'Semestre', $selectsemestre ); // Add elements to your form
        $mform->setDefault('idsemestre', '');        //Default value
        $mform->addRule('idsemestre', 'Choix du Semestre', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'semestre');

        $mform->addElement('select', 'idspecialite', 'Specialite', $selectspecialite ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du Semestre', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'cycle');
     
        $mform->addElement('select', 'idsalle', 'Salle', $selectsalle ); // Add elements to your form
        $mform->setType('idsalle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idsalle', '');        //Default value
        $mform->addRule('idsalle', 'Choix de la salle', 'required', null, 'client');
        $mform->addHelpButton('idsalle', 'cycle');

        $mform->addElement('date_time_selector', 'datecours', 'Date du Cours' ); // Add elements to your form
        $mform->setType('datecours', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('datecours', '');        //Default value
        $mform->addRule('datecours', ' date de cours ', 'required', null, 'client');
        $mform->addHelpButton('datecours', 'datecours');
        

       

        $this->add_action_buttons(true, 'Rechercher');


    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }



     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_programme(int $programmeid)
    {
        global $DB;

        // $sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p WHERE p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id
        // AND p.idcycle = cy.id   ";

        return $DB->get_record('programme', ['id' => $programmeid]);
        // return $DB->get_record_sql($sql);
    }

    // public function get_filiere(int $filiereid)
    // {
    //     global $DB;
    //     return $DB->get_record('filiere', ['id' => $filiereid]);
    // }


    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_programme(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('programme', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }


    public function get_element($sql){
        global $DB;
        $req = $DB->get_records_sql($sql);
        return $req;
    }
}