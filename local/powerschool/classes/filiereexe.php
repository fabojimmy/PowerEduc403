<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["specia"]);
$idanneescolaires=$DB->get_records("anneescolaire");

foreach($idanneescolaires as $key=> $idannee){}
$salleete= new stdClass();

if(!empty($_POST["specia"]))
{
    for($i=0;$i<count($etudiantsidd);$i++)
    {
     $sql="SELECT * FROM {filiere} WHERE libellefiliere='".$etudiantsidd[$i]."' AND idcampus='".$_POST["idca"]."'";
     $versalle=$DB->get_records_sql($sql);
    //  var_dump($versall)
   if(!$versalle){
        $salleete->libellefiliere=$etudiantsidd[$i];
        $salleete->idcampus=$_POST["idca"];
        $salleete->usermodified=$USER->id;
        $salleete->timecreated=time();
        $salleete->timemodified=time();

        $DB->insert_record("filiere",$salleete);
        echo "Bien enregistré";
    }else
       {

       }
    }

}
?>