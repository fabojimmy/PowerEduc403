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

class rapportcours extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB,$iddetablisse;


        // var_dump(ChangerSchoolUser($USER->id));die;
        // var_dump($idspcat);die;

        
        $mform = $this->_form; // Don't forget the underscore!

        $pp=$DB->get_records_sql("SELECT * FROM {rapportcours} WHERE id='".$_GET["idra"]."' AND idcours='".$_GET["idcour"]."' AND usermodified='".$USER->id."'");
        $heure_actuelle=time();

        $heure=date('H',$heure_actuelle);
        $min=date('i',$heure_actuelle);
        $sec=date('s',$heure_actuelle);

        $seconde_ecoule=$heure*3600*1000+$min*60*1000+$sec*1000;
        

        foreach ($pp as $key => $valuera) {
            # code...
        }
         $duree= $seconde_ecoule-$valuera->heuredebut;

        //  var_dump($heure,$min);die;
        $mform->addElement('header','specialite ', get_string('rapport','local_powerschool'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $_GET['idra']);
        
        $mform->addElement('hidden', 'action');
        $mform->setDefault('action', $_GET["action"]);

        $mform->addElement('hidden', 'idcampus');
        $mform->setType('idcampus', PARAM_INT);
        $mform->setDefault('idcampus', ChangerSchoolUser($USER->id));        //Default value

        $mform->addElement('textarea', 'frequeappre', get_string('freqappr','local_powerschool')); // Add elements to your form
        $mform->setType('frequeappre', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('frequeappre', $valuera->frequeappre);        //Default value
        $mform->addRule('frequeappre', 'Libelle specialite', 'required', null, 'client');
        $mform->addHelpButton('frequeappre', "Cela pourrait inclure le nombre total d'étudiants présents, absents ou en retard. 
        Il pourrait également indiquer des détails tels que les noms des étudiants absents.");

        $mform->addElement('textarea', 'contenucouvert', get_string('contenu','local_powerschool')); // Add elements to your form
        $mform->setType('contenucouvert', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('contenucouvert', $valuera->contenucouvert);        //Default value
        $mform->addRule('contenucouvert', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('contenucouvert', " Cela pourrait fournir un résumé du matériel didactique, des sujets abordés, 
        des chapitres traités ou des leçons enseignées ce jour-là.");
              
        $mform->addElement('textarea', 'activiteclasse', get_string('activiclass','local_powerschool')); // Add elements to your form
        $mform->setType('activiteclasse', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('activiteclasse', $valuera->activiteclasse);        //Default value
        $mform->addRule('activiteclasse', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('activiteclasse', "Cela peut inclure des détails sur les activités réalisées en classe, 
        telles que des exercices pratiques, des discussions de groupe, des présentations d'étudiants, ou des démonstrations.");
              
        $mform->addElement('textarea', 'progresapprenant', get_string('progreapp','local_powerschool')); // Add elements to your form
        $mform->setType('progresapprenant', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('progresapprenant', $valuera->progresapprenant);        //Default value
        $mform->addRule('progresapprenant', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('progresapprenant', "En fonction des évaluations réalisées ce jour-là, 
        le rapport pourrait inclure des informations sur les progrès des étudiants dans la compréhension des sujets abordés.");
        
        $mform->addElement('textarea', 'comportappre', get_string('comportapp','local_powerschool')); // Add elements to your form
        $mform->setType('comportappre', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('comportappre', $valuera->comportappre);        //Default value
        $mform->addRule('comportappre', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('comportappre', "Cela pourrait indiquer les comportements remarquables des élèves, tels que la participation active en classe, 
        la collaboration avec d'autres étudiants, ou tout comportement perturbateur");
        
        $mform->addElement('textarea', 'questappren', get_string('questapp','local_powerschool')); // Add elements to your form
        $mform->setType('questappren', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('questappren', $valuera->questappren);        //Default value
        $mform->addRule('questappren', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('questappren', "Ce rapport pourrait inclure toute question notée ou toute préoccupation soulevée par les étudiants pendant le cours.");
              
        $mform->addElement('textarea', 'duree', get_string('durre','local_powerschool')); // Add elements to your form
        $mform->setType('duree', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('duree', $duree);        //Default value
        $mform->addRule('duree', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('duree', "Il pourrait inclure des détails sur la durée réelle du cours, y compris les périodes de pause programmées ou non programmées.");
              
        $mform->addElement('textarea', 'probletechlogis', get_string('problete','local_powerschool')); // Add elements to your form
        $mform->setType('probletechlogis', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('probletechlogis', $valuera->probletechlogis);        //Default value
        $mform->addRule('probletechlogis', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('probletechlogis', "Tout problème technique ou logistique rencontré pendant le cours, tel qu'un équipement défectueux, 
        des problèmes de connectivité, etc., pourrait être enregistré.");
              
        $mform->addElement('textarea', 'feedback', get_string('feelba','local_powerschool')); // Add elements to your form
        $mform->setType('feedback', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('feedback', $valuera->feedback);        //Default value
        $mform->addRule('feedback', 'abreviation specialite', 'required', null, 'client');
        $mform->addHelpButton('feedback', "Le rapport pourrait inclure des réflexions ou des notes personnelles du professeur sur le déroulement du cours, les points forts et les points à améliorer.");
              
        $mform->addElement('hidden', 'idcours'); // Add elements to your form
        $mform->setType('idcours', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcours', $_GET["idcour"]);        //Default value

        $mform->addElement('hidden', 'idpro'); // Add elements to your form
        $mform->setType('idpro', PARAM_INT);                   //Set type of element
        $mform->setDefault('idpro', $USER->id);        //Default value
       
        $mform->addElement('hidden', 'validerap'); // Add elements to your form
        $mform->setType('validerap', PARAM_INT);                   //Set type of element
        $mform->setDefault('validerap', 0);        //Default value
    //    var_dump($_GET["id"]);die;
        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);  
              //Default value
        $mform->addElement('hidden', 'heurefin'); // Add elements to your form
        $mform->setType('heurefin', PARAM_INT);                   //Set type of element
        $mform->setDefault('heurefin', $seconde_ecoule);        //Default value

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
    // public function update_specialite(int $id, string $frequeappre,string $contenucouvert,int $idfiliere,$idspecia): bool
    // {
    //     // var_dump($idspecia);die;
    //     global $DB;
    //     global $USER;
    //     $object = new stdClass();
    //     $object->id = $id;
    //     $object->frequeappre = $frequeappre ;
    //     $object->contenucouvert = $contenucouvert ;
    //     $object->idfiliere = $idfiliere;
    //     $object->usermodified = $USER->id;
    //     $object->timemodified = time();

    //     $objectcat=new stdClass();
    //     $objectcat->id=$idspecia;
    //     $objectcat->name=$frequeappre;
    //     $objectcat->timemodified = time();
    //     $DB->update_record('course_categories', $objectcat);
    //     return $DB->update_record('specialite', $object);
    // }


    //  /** retourne les informations de l'année pour id =anneeid.
    //  * @param int $anneeid l'id de l'année selectionné .
    //  */

    // public function get_specialite(int $specialiteid)
    // {
    //     global $DB;
    //     return $DB->get_record('specialite', ['id' => $specialiteid]);
    // }

 

    // /** pour supprimer une annéee scolaire
    //  * @param $id c'est l'id  de l'année à supprimer
    //  */
    // public function supp_specialite(int $id)
    // {
    //     global $DB;

    //     $sqlspec="SELECT * FROM {specialite} WHERE id='".$id."'";
    //     $speccat=$DB->get_records_sql($sqlspec);
    //     foreach($speccat as $key =>$vaspelca)
    //     {

    //     }
    //     $sqlfilc="SELECT * FROM {filiere} WHERE id='".$vaspelca->idfiliere."'";
    //     $filcat=$DB->get_records_sql($sqlfilc);
    //     foreach($filcat as $key =>$vaaalca)
    //     {

    //     }
    //     $sqlcampcat = "SELECT * FROM {campus} WHERE id='".$vaaalca->id."'";
    //     $campcat=$DB->get_records_sql($sqlcampcat);
    //     foreach($campcat as $key =>$vlca)
    //     {

    //     }
    //     $categcampus=$DB->get_records("course_categories",array("name"=>$vlca->libellecampus,"depth"=>1));
    //     $categfiliere=$DB->get_records("course_categories",array("name"=>$vaaalca->libellesfiliere,"depth"=>2));
    //     $categspecialite=$DB->get_records("course_categories",array("name"=>$vaspelca->frequeappre,"depth"=>3));
    //     foreach($categcampus as $key =>$camps)
    //     {}
    //     foreach($categfiliere as $key =>$filie)
    //     {
    //         $fff=explode("/",$filie->path);
    //         $idca=array_search($camps->id,$fff);

    //         if($idca!==false)
    //         {
    //             $idficat=$filie->id;

    //             // var_dump($idficat);die;
    //         }
    //     }
    //     foreach($categspecialite as $key =>$specia)
    //     {
    //         $fff=explode("/",$specia->path);
    //         $idca=array_search($camps->id,$fff);
    //         $idfil=array_search($idficat,$fff);

    //         if($idca!==false && $idfil!==false)
    //         {
    //             $idspcat=$specia->id;

    //         }
    //     }
    //     $transaction = $DB->start_delegated_transaction();
    //     $DB->delete_records('course_categories', ['id'=> $idspcat]);
    //     $suppspecialite = $DB->delete_records('specialite', ['id'=> $id]);
    //     if ($suppspecialite){
    //         $DB->commit_delegated_transaction($transaction);
    //     }

    //     return true;
    // }

    // public function verispecialite ($frequeappre,$idfiliere,$idcampus)
    // {
    //     global $DB;

    //     $sql="SELECT * FROM {specialite},{filiere} f WHERE frequeappre='".$frequeappre."' AND idfiliere=f.id AND idfiliere='".$idfiliere."' AND idcampus='".$idcampus."'";
    //     return $DB->get_records_sql($sql);
        

    // }
}