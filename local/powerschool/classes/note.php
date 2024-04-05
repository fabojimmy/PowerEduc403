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

class note extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;
        $tarspecialcat=array();
        $camp=$DB->get_records("campus",array("id"=>$_GET["idca"]));
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
        
                    // var_dump($vallssp->name);
                    array_push($tarspecialcat,$vallssp->name);
                }
            }
            
          }
        }
        $stringspecialitecat=implode("','",$tarspecialcat);
        // die;
        
        $sql8 = "SELECT s.id,libellespecialite,libellefiliere,abreviationspecialite FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".$_GET["idca"]."' AND libellespecialite IN ('$stringspecialitecat')";
        
        $campus = new campus();
        $semestre = $anneescolaire = $ecole = $specialite = $cycle =  array();
        // $sql1 = "SELECT * FROM {courssemestre} cs,{affecterprof} af,{semestre} se WHERE se.id=cs.idsemestre AND af.idcourssemestre=cs.id AND idprof='".$USER->id."'";
        $sql1 = "SELECT * FROM {semestre}";
        $sql2 = "SELECT * FROM {anneescolaire} ";
        $sql3 = "SELECT * FROM {campus} ";
        // $sql4 = "SELECT sp.id as ids,libellespecialite FROM {specialite} sp,{affecterprof} af,{courssemestre} cs,{coursspecialite} csp WHERE csp.idspecialite=sp.id AND cs.idcoursspecialite=csp.id AND cs.id=af.idcourssemestre AND idprof='".$USER->id."'";
        $sql4 = "SELECT * FROM {specialite}";
        // $sql5 = "SELECT * FROM {cycle} cy,{affecterprof} af,{courssemestre} cs,{coursspecialite} csp WHERE cy.id=csp.idcycle AND cs.idcoursspecialite=csp.id AND cs.id=af.idcourssemestre AND idprof='".$USER->id."'";
        $sql5 = "SELECT id,libellecycle FROM {cycle} WHERE idcampus='".$_GET["idca"]."'";
        $sqlgr = "SELECT g.id,s.libellespecialite,c.libellecycle,g.numerogroup,capacitegroup FROM {specialite} s,{cycle} c,{filiere} f,{groupapprenant} g WHERE s.id=g.idspecialite AND c.id=g.idcycle AND f.id=s.idfiliere AND f.idcampus='".$_GET["idca"]."'";

        $semestre = $campus->select($sql1);
        $anneescolaire = $campus->select($sql2);
        $ecole = $campus->select($sql3);
        $specialite = $DB->get_recordset_sql($sql8);
        $cycle = $campus->select($sql5);
        $group = $campus->select($sqlgr);

        // $salle=$DB->get_records_sql("SELECT id,numerosalle FROM {salle} WHERE idcampus='".$_GET["idca"]."' AND numerosalle IN (SELECT DISTINCT name FROM {groups})");        
        $salle=$DB->get_records_sql("SELECT id,numerosalle FROM {salle} WHERE idcampus='".$_GET["idca"]."'");        


        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','inscription', ' Configuration de note');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($semestre as $key => $val)

        {
            $selectetudiant[$key] = $val->libellesemestre;
        }
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);
            
        }
        foreach ($ecole as $key => $val)
        {
            $selectcampus[$key] = $val->libellecampus;
        }
        foreach ($specialite as $key => $val)
        {
            // $key=$val->ids;
            $selectspecialite[$key] = $val->libellespecialite;

            // var_dump($selectspecialite,$key);
        }
        // die;
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        foreach ($salle as $key => $val)
        {
            $selectsalle[$key] = $val->numerosalle;
        }
        foreach ($group as $key => $valgr)
        {
            $selectgroup[$key] = $valgr->numerogroup;
        }

        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idsemestre', 'Partie de Année Scolaire', $selectetudiant ); // Add elements to your form
        $mform->setType('idsemestre', PARAM_TEXT);                   //Set type of element
        $mform->addRule('idsemestre', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'cours');

        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');
        
        if($_GET["idca"]==null)
        {
            $_GET["idca"]=0;
        }
       
        $veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.$_GET["idca"].'');
        foreach($veriEta as $valueEt){}
        if($valueEt->libelletype=="universite")
        {
           $mform->addElement('select', 'idgroupapprenant', 'Groupe Apprenant', $selectgroup ); // Add elements to your form
           $mform->setType('idgroupapprenant', PARAM_TEXT);                   //Set type of element
           $mform->setDefault('idgroupapprenant', '');        //Default value
           $mform->addRule('idgroupapprenant', 'Choix du gender', 'required', null, 'client');
           $mform->addHelpButton('idgroupapprenant', 'specialite');
          
        }
        else
        {
            $mform->addElement('select', 'salle', 'Salle', $selectsalle ); // Add elements to your form
            $mform->setType('salle', PARAM_TEXT);                   //Set type of element
            $mform->setDefault('salle', '');        //Default value
            $mform->addRule('salle', 'Choix du campus', 'required', null, 'client');
            $mform->addHelpButton('salle', 'Salle');
        }
        $mform->addElement('select', 'idspecialite', 'Specialite', $selectspecialite ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'specialite');

        //informations sur le parent
      

        $mform->addElement('hidden', 'idcampus'); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus', $_GET["idca"]);        //Default value

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
    // public function update_inscription(int $id, string $idetudiant, string $idanneescolaire,string $idcampus,
    // string $idspecialite,string $idcycle, string $nomsparent,string $telparent,
    // string $emailparent,string $professionparent ): bool
    // {
    //     global $DB;
    //     global $USER;
    //     $object = new stdClass();
    //     $object->id = $id;
    //     $object->idetudiant = $idetudiant ;
    //     $object->idanneescolaire = $idanneescolaire ;
    //     $object->idcampus = $idcampus ;
    //     $object->idspecialite = $idspecialite ;
    //     $object->idcycle = $idcycle ;
    //     $object->nomsparent = $nomsparent ;
    //     $object->telparent = $telparent ;
    //     $object->emailparent = $emailparent;
    //     $object->professionparent = $professionparent;
    //     $object->usermodified = $USER->id;
    //     $object->timemodified = time();



    //     return $DB->update_record('inscription', $object);
    // }


    //  /** retourne les informations de l'année pour id =anneeid.
    //  * @param int $anneeid l'id de l'année selectionné .
    //  */

    // public function get_inscription(int $inscriptionid)
    // {
    //     global $DB;
    //     return $DB->get_record('inscription', ['id' => $inscriptionid]);
    // }



    // /** pour supprimer une annéee scolaire
    //  * @param $id c'est l'id  de l'année à supprimer
    //  */
    // public function supp_inscription(int $id)
    // {
    //     global $DB;
    //     $transaction = $DB->start_delegated_transaction();
    //     $suppcampus = $DB->delete_records('inscription', ['id'=> $id]);
    //     if ($suppcampus){
    //         $DB->commit_delegated_transaction($transaction);
    //     }

    //     return true;
    // }

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