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
use local_powerschool\lib;


require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/local/powerschool/classes/campus.php');
require_once($CFG->dirroot.'/local/powerschool/idetablisse.php');

class groupapprenant extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG,$iddetablisse,$DB;
        // global ChangerSchoolUser($USER->id);
        global $USER;
        $campus = new campus();
        $camp = array();
        $sql = "SELECT * FROM {campus} ";
        $sqlcour = "SELECT cs.id,s.libellespecialite,c.libellecycle FROM {specialite} s,{cycle} c,{coursspecialite} cs,{filiere} f WHERE s.id=cs.idspecialite AND c.id=cs.idcycle AND f.id=s.idfiliere AND f.idcampus='".ChangerSchoolUser($USER->id)."'";
        $camp = $campus->select($sql);
        $coursspeci = $campus->select($sqlcour);
        $sql5 = "SELECT * FROM {cycle} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $cycle = $campus->select($sql5);
        $sql2 = "SELECT * FROM {anneescolaire} ";

        $anneescolaire = $campus->select($sql2);

        
        // var_dump(ChangerSchoolUser($USER->id));die;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','Salle', get_string("groupapprenanttitle","local_powerschool"));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'numerogroup', get_string("groupapprenantlibelle","local_powerschool")); // Add elements to your form
        $mform->setType('numerogroup', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('numerogroup', '');        //Default value
        $mform->addRule('numerogroup', 'Numeros du groupe', 'required', null, 'client');
        $mform->addHelpButton('numerogroup', 'salle');

        // foreach ($coursspeci as $key => $value) {
        //     $selectcoursspe[$key] = $value->libellespecialite."-".$value->libellecycle;

        // }
        $tarspecialcat=array();
        $camp=$DB->get_records("campus",array("id"=>ChangerSchoolUser($USER->id)));
        // }
        // else{
        //     $gg=$DB->get_records("user",array("id"=>$USER->id));
    
        //     foreach($gg as $kk)
        //     {}
            
        //     $camp=$DB->get_records("campus",array("id"=>$kk->idcampuser));
        // }

        foreach ($camp as $key => $value) {
            # code...
        }
        $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
        foreach ($categ as $key => $value1categ) {
            # code...
        }
        // $filiere = $DB->get_records('filiere', array("idcampus"=>$_GET["idca"]));
        
        $catfill=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=2");
        $catspecia=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=3");
        foreach($catfill as $key => $valfil)
        {
            $fff=explode("/",$valfil->path);
            $idca=array_search($value1categ->id,$fff);
          if($idca!==false)
          {
            foreach($catspecia as $key => $vallssp)
            {
                $sss=explode("/",$vallssp->path);
                $idfill=array_search($valfil->id,$sss);
                if($idfill!==false)
                {
        
                    // var_dump($vallssp->name);die;
                    array_push($tarspecialcat,$vallssp->name);
                }
            }
            
          }
        }
        $stringspecialitecat=implode("','",$tarspecialcat);
        // die;
        
        $sql8 = "SELECT s.id,libellespecialite,libellefiliere,abreviationspecialite FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".ChangerSchoolUser($USER->id)."' AND libellespecialite IN ('$stringspecialitecat')";
        $specialite = $campus->select($sql8);

        foreach ($specialite as $key => $val)
        {
            $selectspecialite[$key] = $val->libellespecialite;
        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }
        $mform->addElement('text', 'capacitegroup', get_string("capacitegroup","local_powerschool")); // Add elements to your form
        $mform->setType('capacitegroup', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('capacitegroup', '');        //Default value
        $mform->addRule('capacitegroup', 'Capacite du groupe', 'required', null, 'client');
        $mform->addHelpButton('capacitegroup', 'salle');
       
        $mform->addElement('select', 'idspecialite', 'Specialite/Classes', $selectspecialite ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'specialite');
        
        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value
     
        $mform->addElement('hidden', 'action',"b"); // Add elements to your form
        $mform->setType('action', PARAM_INT);                   //Set type of element
        $mform->setDefault('action', $_GET["action"]);        //Default value


        foreach ($camp as $key => $val)
        {
            $selectcamp[$key] = $val->libellecampus;
        }
        // var_dump(ChangerSchoolUser($USER->id)); 
        // die;
        $mform->addElement('hidden', 'idcampus' ); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value
        // $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        // $mform->addHelpButton('idcampus', 'campus');
        
        // $mform->addElement('select', 'idcampus', 'Campus', $selectcamp ); // Add elements to your form
        // $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcampus', '');        //Default value
        // $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        // $mform->addHelpButton('idcampus', 'campus');
        
       

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
    public function update_groupapprenant(int $id, string $numerosalle, int $idcycle,$idspecialite,$idanneescolaire,$capacite): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->numerogroup = $numerosalle ;
        $object->capacitegroup = $capacite ;
        $object->idcycle = $idcycle ;
        $object->idspecialite = $idspecialite;
        $object->idanneescolaire = $idanneescolaire;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('groupapprenant', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_groupapprenant(int $salleid)
    {
        global $DB;
        return $DB->get_record('groupapprenant', ['id' => $salleid]);
    }
    
    
    
    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_groupapprenant(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('groupapprenant', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }
        
        return true;
    }
    // public function get_salle(int $salleid)
    // {
    //     global $DB;
    //     return $DB->get_record('salle', ['id' => $salleid]);
    // }

    
    public function verigroupapprenant( $salle, $idcycle,$idspecialite,$idanneescolaire)
    {
        global $DB;
        $true=$DB->get_record("groupapprenant",["numerogroup"=>$salle,
        "idcycle"=>$idcycle,"idspecialite"=>$idspecialite,"idanneescolaire"=>$idanneescolaire]);
        // die;
        // var_dump($salle,$idcycle,$idspecialite,$idanneescolaire);die;
        // $true=true;
        if ($true) {
            return true;
        }

    }
}