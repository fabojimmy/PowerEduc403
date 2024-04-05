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

class specialite extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB,$iddetablisse;

        $vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t
                                WHERE t.id=c.idtypecampus AND c.id='".ChangerSchoolUser($USER->id)."'"); 

        
        $sqlspec="SELECT * FROM {specialite} WHERE id='".$_GET["id"]."'";
        $speccat=$DB->get_records_sql($sqlspec);
        foreach($speccat as $key =>$vaspelca)
        {

        }
        $sqlfilc="SELECT * FROM {filiere} WHERE id='".$vaspelca->idfiliere."'";
        $filcat=$DB->get_records_sql($sqlfilc);
        foreach($filcat as $key =>$vaaalca)
        {

        }
        $sqlcampcat = "SELECT * FROM {campus} WHERE id='".$vaaalca->idcampus."'";
        $campcat=$DB->get_records_sql($sqlcampcat);
        foreach($campcat as $key =>$vlca)
        {

        }
        $categcampus=$DB->get_records("course_categories",array("name"=>$vlca->libellecampus,"depth"=>1));
        $categfiliere=$DB->get_records("course_categories",array("name"=>$vaaalca->libellefiliere,"depth"=>2));
        $categspecialite=$DB->get_records("course_categories",array("name"=>$vaspelca->libellespecialite,"depth"=>3));
        foreach($categcampus as $key =>$camps)
        {}
        foreach($categfiliere as $key =>$filie)
        {
            $fff=explode("/",$filie->path);
            $idca=array_search($camps->id,$fff);

            if($idca!==false)
            {
                $idficat=$filie->id;

                // var_dump($idficat);die;
            }
        }
        foreach($categspecialite as $key =>$specia)
        {
            $fff=explode("/",$specia->path);
            $idca=array_search($camps->id,$fff);
            $idfil=array_search($idficat,$fff);

            if($idca!==false && $idfil!==false)
            {
                $idspcat=$specia->id;

            }
        }
        // var_dump($idspcat);die;


        $reqq = new campus();
        $annee = array();
        $sql = "SELECT * FROM {filiere} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $filiere = $reqq->select($sql);
        
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','specialite ', 'specialite');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
        $mform->addElement('hidden', 'action');
        $mform->setDefault('action', $_GET["action"]);

        $mform->addElement('hidden', 'idcampus');
        $mform->setType('idcampus', PARAM_INT);
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value

        $mform->addElement('text', 'libellespecialite', 'Libellé specialite'); // Add elements to your form
        $mform->setType('libellespecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libellespecialite', '');        //Default value
        $mform->addRule('libellespecialite', 'Libelle specialite', 'required', null, 'client');
        $mform->addHelpButton('libellespecialite', 'specialite');

        $mform->addElement('text', 'abreviationspecialite', 'Abreviation specialite'); // Add elements to your form
        $mform->setType('abreviationspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('abreviationspecialite', '');        //Default value
        $mform->addRule('abreviationspecialite', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('abreviationspecialite', 'abreviation');
              

        // $uu="fff"||"lycee";
        foreach($vericam as $key => $ver)
            {
                // var_dump($ver->libelletype);die;
                if ($ver->libelletype=="lycee"||$ver->libelletype=="college") {
                    $mform->addElement('text', 'nombreoption', 'Nombre d\'options'); // Add elements to your form
                    $mform->setType('nombreoption', PARAM_TEXT);                   //Set type of element
                    $mform->setDefault('nombreoption', '');        //Default value
                    
                }
            }

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value
       
        $mform->addElement('hidden', 'idcatspe'); // Add elements to your form
        $mform->setType('idcatspe', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcatspe', $idspcat);        //Default value

        foreach ($filiere as $key => $val)
        {
            $selectspecialite[$key] = $val->libellefiliere." ( ".$val->abreviationfiliere." )";

        }
        $mform->addElement('select', 'idfiliere', 'Filiere', $selectspecialite); // Add elements to your form
        $mform->setType('idfiliere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idfiliere', '');        //Default value
        $mform->addRule('idfiliere', ' Filiere', 'required', null, 'client');
        $mform->addHelpButton('idfiliere', 'Filiere');


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
    public function update_specialite(int $id, string $libellespecialite,string $abreviationspecialite,int $idfiliere,$idspecia,$nom): bool
    {
        // var_dump($nom);die;
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libellespecialite = $libellespecialite ;
        $object->abreviationspecialite = $abreviationspecialite ;
        $object->idfiliere = $idfiliere;
        $object->nombreoption = $nom;
        $object->usermodified = $USER->id;
        $object->timemodified = time();

        $objectcat=new stdClass();
        $objectcat->id=$idspecia;
        $objectcat->name=$libellespecialite;
        $objectcat->timemodified = time();
        $DB->update_record('course_categories', $objectcat);
        return $DB->update_record('specialite', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_specialite(int $specialiteid)
    {
        global $DB;
        return $DB->get_record('specialite', ['id' => $specialiteid]);
    }

 

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_specialite(int $id)
    {
        global $DB;

        $sqlspec="SELECT * FROM {specialite} WHERE id='".$id."'";
        $speccat=$DB->get_records_sql($sqlspec);
        foreach($speccat as $key =>$vaspelca)
        {

        }
        $sqlfilc="SELECT * FROM {filiere} WHERE id='".$vaspelca->idfiliere."'";
        $filcat=$DB->get_records_sql($sqlfilc);
        foreach($filcat as $key =>$vaaalca)
        {

        }
        $sqlcampcat = "SELECT * FROM {campus} WHERE id='".$vaaalca->id."'";
        $campcat=$DB->get_records_sql($sqlcampcat);
        foreach($campcat as $key =>$vlca)
        {

        }
        $categcampus=$DB->get_records("course_categories",array("name"=>$vlca->libellecampus,"depth"=>1));
        $categfiliere=$DB->get_records("course_categories",array("name"=>$vaaalca->libellesfiliere,"depth"=>2));
        $categspecialite=$DB->get_records("course_categories",array("name"=>$vaspelca->libellespecialite,"depth"=>3));
        foreach($categcampus as $key =>$camps)
        {}
        foreach($categfiliere as $key =>$filie)
        {
            $fff=explode("/",$filie->path);
            $idca=array_search($camps->id,$fff);

            if($idca!==false)
            {
                $idficat=$filie->id;

                // var_dump($idficat);die;
            }
        }
        foreach($categspecialite as $key =>$specia)
        {
            $fff=explode("/",$specia->path);
            $idca=array_search($camps->id,$fff);
            $idfil=array_search($idficat,$fff);

            if($idca!==false && $idfil!==false)
            {
                $idspcat=$specia->id;

            }
        }
        $transaction = $DB->start_delegated_transaction();
        $DB->delete_records('course_categories', ['id'=> $idspcat]);
        $suppspecialite = $DB->delete_records('specialite', ['id'=> $id]);
        if ($suppspecialite){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    public function verispecialite ($libellespecialite,$idfiliere,$idcampus)
    {
        global $DB;

        $sql="SELECT * FROM {specialite},{filiere} f WHERE libellespecialite='".$libellespecialite."' AND idfiliere=f.id AND idfiliere='".$idfiliere."' AND idcampus='".$idcampus."'";
        return $DB->get_records_sql($sql);
        

    }
}