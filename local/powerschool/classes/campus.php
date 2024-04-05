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

use core_string_manager;
use moodleform;
use stdClass;


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot .'/lib/classes/string_manager.php');

class campus extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;
        $mform = $this->_form; // Don't forget the underscore!

        $types=$DB->get_records("typecampus");

        foreach ($types as $key => $value) {
             $type[$key]=$value->libelletype;  
        }

        $pays = get_string_manager()->get_list_of_countries(true);


        $mform->addElement('header','Campus','Informations sur la Campus');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'libellecampus', 'Nom du Campus'); // Add elements to your form
        $mform->setType('libellecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libellecampus', '');        //Default value
        $mform->addRule('libellecampus', 'Nom du Campus', 'required', null, 'client');
        $mform->addHelpButton('libellecampus', 'Campus');

        $mform->addElement('text', 'abrecampus', 'Abréviations du Campus'); // Add elements to your form
        $mform->setType('abrecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('abrecampus', '');        //Default value
        $mform->addRule('abrecampus', 'Nom du Campus', 'required', null, 'client');
        $mform->addHelpButton('abrecampus', 'Campus');

        $mform->addElement('text', 'adressecampus', 'Adresse du Campus'); // Add elements to your form
        $mform->setType('adressecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('adressecampus', '');        //Default value
        $mform->addHelpButton('adressecampus', 'Campus');

        $mform->addElement('text', 'codepostalcampus', 'Code Postal du Campus'); // Add elements to your form
        $mform->setType('codepostalcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('codepostalcampus', '');        //Default value
        $mform->addHelpButton('codepostalcampus', 'Campus');
        
        $mform->addElement('text', 'villecampus', 'Ville'); // Add elements to your form
        $mform->setType('villecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('villecampus', '');        //Default value
        $mform->addHelpButton('villecampus', 'Campus');

        $mform->addElement('select', 'payscampus', 'Pays',$pays); // Add elements to your form
        $mform->setType('payscampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('payscampus', '');        //Default value
        $mform->addHelpButton('payscampus', 'Campus');

        
        $mform->addElement('select', 'idtypecampus', 'Type Campus',$type); // Add elements to your form
        $mform->setType('idtypecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idtypecampus', '');        //Default value
        $mform->addHelpButton('idtypecampus', 'Campus');
        
        $mform->addElement('text', 'telcampus', 'Numeros du Campus'); // Add elements to your form
        $mform->setType('telcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('telcampus', '');        //Default value
        $mform->addHelpButton('telcampus', 'Campus');
        
        $mform->addElement('text', 'emailcampus', 'Email du campus'); // Add elements to your form
        $mform->setType('emailcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('emailcampus', '');        //Default value
        $mform->addRule('emailcampus', 'Adresse du Campus', 'required', null, 'client');
        $mform->addHelpButton('emailcampus', 'Campus');
        
        $mform->addElement('text', 'sitecampus', 'Site Internet'); // Add elements to your form
        $mform->setType('sitecampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('sitecampus', '');        //Default value
        $mform->addHelpButton('sitecampus', 'Campus');

        // $mform->addElement('text', 'logocampus', 'Votre logo'); // Add elements to your form
        // $mform->setType('logocampus', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('logocampus', '');        //Default value
        // $mform->addHelpButton('logocampus', 'Campus');

        // $mform->addElement('filemanager', 'logocampus', "Votre logo", null, array('accepted_types' => '*'));
        // // $mform->get_file_manager("");
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
    public function update_campus(int $id, string $libellecampus, string $adressecampus,string $codepostalcampus,string $villecampus,string $payscampus,int $telcampus, string $emailcampus,string $sitecampus ,$logocampus,$abrecampus,$idtypecampus ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libellecampus = $libellecampus ;
        $object->abrecampus = $abrecampus ;
        $object->idtypecampus = $idtypecampus ;
        $object->adressecampus = $adressecampus ;
        $object->codepostalcampus = $codepostalcampus ;
        $object->villecampus = $villecampus;
        $object->payscampus = $payscampus ;
        $object->telcampus = $telcampus;
        $object->emailcampus = $emailcampus ;
        $object->sitecampus = $sitecampus ;
        $object->logocampus = $logocampus ;
        $object->usermodified = $USER->id;
        $object->timemodified = time();


        $sqlcampcat = "SELECT * FROM {campus} WHERE id='".$id."'";
        $campcat=$DB->get_records_sql($sqlcampcat);
        foreach($campcat as $key =>$vlca)
        {

        }
        $categcampus=$DB->get_records("course_categories",array("name"=>$vlca->libellecampus,"depth"=>1));
        foreach($categcampus as $key =>$camps)
        {}

        $objectcat=new stdClass();
        $objectcat->id=$camps->id;
        $objectcat->name=$libellecampus;
        $objectcat->timemodified = time();
        $DB->update_record('course_categories', $objectcat);
        return $DB->update_record('campus', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_campus(int $campusid)
    {
        global $DB;
        return $DB->get_record('campus', ['id' => $campusid]);
    }

    /** retourne le resultat de la requête mis en parametre
     * @param string $sql c'est la requête que vous voulez
     */
    public function select (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_campus(int $id)
    {
        global $DB;

        $sqlcampcat = "SELECT * FROM {campus} WHERE id='".$id."'";
        $campcat=$DB->get_records_sql($sqlcampcat);
        foreach($campcat as $key =>$vlca)
        {

        }
        $categcampus=$DB->get_records("course_categories",array("name"=>$vlca->libellecampus,"depth"=>1));
        foreach($categcampus as $key =>$camps)
        {}

        $transaction = $DB->start_delegated_transaction();
        $DB->delete_records('course_categories', ['id'=> $camps->id]);
        $suppcampus = $DB->delete_records('campus', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    /**
     * retourne la liste des etudiants d'un campus
     */
    public function Etudiant_Campus (int $userid)
    {
        
    }
    public function veri_Campus ($libelle)
    {   
        global $DB;
        $ver=$DB->get_records("campus",array("libellecampus"=>$libelle));

        return $ver;
    }
}