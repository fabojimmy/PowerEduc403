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

class configurerpaiement extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB,$iddetablisse;
        $mform = $this->_form; // Don't forget the underscore!
        $campus = new campus();
        $tarspecialcat=array();
        $camp=$DB->get_records("campus",array("id"=>ChangerSchoolUser($USER->id)));
        foreach ($camp as $key => $value) {
            # code...
        }

        // var_dump(ChangerSchoolUser($USER->id));die;
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
        
                    // var_dump($vallssp->name);
                    array_push($tarspecialcat,$vallssp->name);
                }
            }
            
          }
        }
        $stringspecialitecat=implode("','",$tarspecialcat);
        // die;
        
        // var_dump(ChangerSchoolUser($USER->id));
        // die;
        $sql8 = "SELECT s.id,libellespecialite,libellefiliere,abreviationspecialite FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".ChangerSchoolUser($USER->id)."' AND libellespecialite IN ('$stringspecialitecat')";
        $cours = $specialite = $cycle =  array();
        $sql1 = "SELECT id,libellefiliere FROM {filiere} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql3 = "SELECT * FROM {tranche} WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql6 = "SELECT sp.id as spid,libellespecialite FROM {specialite} sp,{filiere} fi WHERE sp.idfiliere=fi.id AND idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql4 = "SELECT cy.id as cyid,libellecycle FROM {cycle} cy
                 WHERE idcampus='".ChangerSchoolUser($USER->id)."'";
        $sql5 = "SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".ChangerSchoolUser($USER->id)."'";

        $campuss = $DB->get_recordset_sql($sql5);
        $filiere = $DB->get_recordset_sql($sql1);
        $tranche = $DB->get_recordset_sql($sql3);
        $cycle = $DB->get_recordset_sql($sql4);
        // var_dump($cycle);die;
        $specialite = $DB->get_recordset_sql($sql8);

        $annee=$DB->get_records("anneescolaire");

        foreach ($annee as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }

        $mform->addElement('header','configuration', get_string('configurerpaie', 'local_powerschool'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($filiere as $key1 => $val1)
        {
            $selectfiliere[$key1] = $val1->libellefiliere;
        }
        foreach ($tranche as $key2 => $val2)
        {
            $selecttranche[$key2] = $val2->libelletranche;
        }
        foreach ($cycle as $key3 => $val3)
        {
            $selectcycle[$key3] = $val3->libellecycle;
        }
        foreach ($campuss as $key => $valca)
        {
        }
        foreach ($specialite as $key4 => $vals)
        {
            $selectspecia[$key4]=$vals->libellespecialite;
        }
        // var_dump($val2->id,$key2); 
        // die;
        $mform->addElement('select', 'idfiliere', 'Filiere', $selectfiliere ); // Add elements to your form
        // $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcourses', '');        //Default value
        $mform->addRule('idfiliere', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idfiliere', 'cours');


        $mform->addElement('select', 'idtranc', 'Tranche', $selecttranche ); // Add elements to your form
        // $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idtranc', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idtranc', 'specialite');
      if($valca->libelletype==="universite"){

          $mform->addElement('select', 'idcycle', 'Cycle', $selectcycle ); // Add elements to your form
          // $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
          // $mform->setDefault('idcycle', '');        //Default value
          $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
          $mform->addHelpButton('idcycle', 'specialite');
        }else{
          $mform->addElement('select', 'idspecialite', 'specialite', $selectspecia ); // Add elements to your form
          // $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
          // $mform->setDefault('idcycle', '');        //Default value
          $mform->addRule('idspecialite', 'Choix du cycle', 'required', null, 'client');
          $mform->addHelpButton('idspecialite', 'specialite');

      }
      
        $mform->addElement('hidden', 'idcampus'); // Add elements to your form
        // $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value
        $mform->addRule('idcampus', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcampus', 'specialite');
      
        $mform->addElement('text', 'somme', 'Somme'); // Add elements to your form
        // $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('somme', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('somme', 'specialite');

        $mform->addElement('date_selector', 'datelimite', 'Date limite' ); // Add elements to your form
        // $mform->setType('dateseance', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('dateseance', '');        //Default value
        $mform->addRule('datelimite', ' date de cours ', 'required', null, 'client');
        $mform->addHelpButton('datelimite', 'datecours');
       
        $mform->addElement('select', 'idannee', 'Année Academique',$selectannee); // Add elements to your form
        // $mform->setType('dateseance', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('dateseance', '');        //Default value
        $mform->addRule('idannee', 'Choisir l\'année academique', 'required', null, 'client');
        $mform->addHelpButton('idannee', 'Choisir l\'année academique');


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
    public function update_configpaie($id,$idcourses,$idspecialite,$idcycle,$dateseance,$somme): bool
    {

        global $DB;
        $object = new stdClass();
        $object->id = $id;
        $object->idfiliere = $idcourses ;
        $object->idtranc = $idspecialite ;
        $object->idcycle = $idcycle ;
        $object->somme = $somme;
        $object->datelimite = $dateseance ;

        // var_dump($object);die;
        return $DB->update_record('filierecycletranc', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_configpaie(int $seanceid)
    {
        global $DB;
        return $DB->get_record('filierecycletranc', ['id' => $seanceid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_configpaie(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('filierecycletranc', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}