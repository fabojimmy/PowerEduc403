<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["cycle"]);
$idanneescolaires=$DB->get_records("anneescolaire");

foreach($idanneescolaires as $key=> $idannee){}
$salleete= new stdClass();

if(!empty($_POST["cycle"]))
{
    for($i=0;$i<count($etudiantsidd);$i++)
    {
     $sql="SELECT * FROM {cycle} WHERE libellecycle='".$etudiantsidd[$i]."'AND idcampus='".$_POST["idcampus"]."'";
     $versalle=$DB->get_records_sql($sql);
    //  var_dump($versall)
   if(!$versalle){
        $salleete->libellecycle=$etudiantsidd[$i];
        $salleete->nombreannee=0;
        $salleete->idcampus=$_POST["idcampus"];
        $salleete->usermodified=$USER->id;
        $salleete->timecreated=time();
        $salleete->timemodified=time();

        $DB->insert_record("cycle",$salleete);
        echo "Bien enregistré";
        // var_dump($versalle,$_POST["idcampus"]);
    }else
       {

       }
    }

}
?>