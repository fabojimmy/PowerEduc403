<?php

//     /**
//  * Database connection. Used for all access to the database.
//  * @global int $etablisse
//  * @name $etablisse
//  */
//  global $iddetablisse;
//  /**
//   * Database connection. Used for all access to the database.
//   * @global int $annee
//   * @name $annee
//   */
//   global $gloannee;
//     require_once(__DIR__.'/../../config.php');
//     //l'appel de l'etablissement selectionné
//     global $DB;
//     // die;
//     $verrrif=false;
// //  if($iddetablisse!=0)
// //  {

//      $etablissement=$DB->get_records("campus",array("activerca"=>1));
//      foreach($etablissement as $key => $valet)
//      {
 
//      }
//      $iddetablisse=$valet->id;
//  }
    // die;
    // var_dump($scolaire);die;
    // $gloannee=$valean->id;
function  local_powerschool_extend_navigation (global_navigation $navigation  ){
      
    global $USER,$SESSION,$CFG,$DB;

    $nodefoo=$navigation->add("PowerEduc",null,
    null, null, 'home', null, '');
    // $nodefo=$nodefoo->add('Campus');
    // foreach($tarcampus as $key=> $pro){
       
    //           $nodebar=$nodefo->add($key, new moodle_url($pro),null,null,'Professeur',new pix_icon('i/course', ''));
    //        $nodebar->forceopen=true;
        
      
    // }
    $role=$DB->get_records("role_assignments",array("userid"=>$USER->id,"roleid"=>3));
    if($role&& isloggedin())
    {

         $nodefoo->add("Notes", new \moodle_url('/local/powerschool/note.php'),null,null,'Professeur',null);
         $nodefoo->add("Gérer les absences", new \moodle_url('/local/powerschool/absenceetu.php'),null,null,'Professeur',null);
         $nodefoo->add("Liste des apprenants absences", new \moodle_url('/local/powerschool/listeetuabsenprof.php'),null,null,'Professeur',null);
         $nodefoo->add("Emploi de temps", new \moodle_url('/local/powerschool/programmeprof.php'),null,null,'Professeur',null);
       }
       if(has_capability("local/powerschool:reglageetablissement",context_system::instance(),$USER->id)&&!is_siteadmin()){
        $nodefoo->add("Réglages d'etablissement", new \moodle_url('/local/powerschool/statistique.php'),null, null, 'notes',null);

    }
   if(is_siteadmin())
   {

       $nodefoo->add("Liste des absences", new \moodle_url('/local/powerschool/listeetuabsenadmin.php'),null,null,'Professeur',null);
   }
 $role=$DB->get_records("role_assignments",array("userid"=>$USER->id,"roleid"=>5));
           if($role)
           {

               $nodefoo->add("Profit Apprenant", new \moodle_url('/local/powerschool/gerer.php'),null,null,'Professeur',null);
           }
 $rolepare=$DB->get_records("role_assignments",array("userid"=>$USER->id,"roleid"=>11));
           if($rolepare)
           {

               $nodefoo->add("Profit Apprenant", new \moodle_url('/local/powerschool/bulletinnotepersoparent.php'),null,null,'Professeur',null);
           }

}

// creation de etablissement
    function createetablissement($campus=new StdClass()) {
        global $DB;
        $idca=$DB->insert_record('campus', $campus);

        $data=new StdClass();

        $data->parent = 0;
        $data->name = $campus->libellecampus;
        core_course_category::create($data, null);

        
        return $idca;
    }
    function createetablissementtrue($campus) {
        global $DB;
        // $idca=$DB->insert_record('campus', $campus);

        $idtrueca=$DB->get_records_sql("SELECT id,libellecampus FROM {campus} WHERE id =(SELECT Max(id) FROM {campus})");


        // var_dump($idtrueca);
        // die;

        foreach ($idtrueca as $key => $value) {
            # code...
        }
        $data=new StdClass();

        $data->parent = 0;
        $data->name = $value->libellecampus;
        core_course_category::create($data, null);

        
        return $value->id;
    }

    // Fonction pour afficher la barre de navigation de l'administration
    function local_powerschool_admin_navigation_bar() {
        global $CFG, $OUTPUT, $PAGE;
    
        // Initialiser la page pour le plugin local_powerschool
        $context = context_system::instance();
        $PAGE->set_context($context);
        $PAGE->set_url('/local/powerschool/index.php');
        $PAGE->set_pagelayout('admin');
    
        // Créer la barre de navigation
        $settingsnode = $PAGE->settingsnav->add('powerschoolsettings', new lang_string('admin'));
        $adminroot = get_admin();
        foreach ($adminroot as $branch) {
            $branchurl = new moodle_url('/local/powerschool/admin_settings.php', array('section' => $branch['key']));
            $branchnode = navigation_node::create(
                $branch['name'],
                $branchurl,
                navigation_node::TYPE_CATEGORY
            );
            $settingsnode->add_node($branchnode);
        }
    
        // Afficher la barre de navigation verticale de l'administration
        echo $OUTPUT->header();
        echo $OUTPUT->navbar();
        echo $OUTPUT->footer();
    }


    function local_powerschool_extend_navigation_frontpage(
        navigation_node $frontpagenode,
        stdClass $course = null,
        context_course $context = null
    ) {
         
        // var_dump($frontpagenode->type,navigation_node::TYPE_UNKNOWN);
        // die;
            // Création d'un nœud de navigation pour le lien du plugin
            $powerschoolnode = navigation_node::create(
                'Powerschool information', // Le libellé du lien
                new moodle_url('/local/powerschool/index.php'), // L'URL vers la page du plugin
                navigation_node::NODETYPE_LEAF
            );
            // Ajout du nœud de navigation à la page d'accueil
            $frontpagenode->add_node($powerschoolnode);
        
    }

    // var_dump("sdfghjklmù*");die;
?>