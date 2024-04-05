<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["specia"]);
$idanneescolaires=$DB->get_records("anneescolaire");

foreach($idanneescolaires as $key=> $idannee){}
$salleete= new stdClass();

if(!empty($_POST["idfiliere"])&&!empty($_POST["idcampus"]))
{
    for($i=0;$i<count($etudiantsidd);$i++)
    {
     $sql="SELECT * FROM {specialite},{filiere} f WHERE libellespecialite='".$etudiantsidd[$i]."' AND idfiliere=f.id AND idcampus='".$_POST["idcampus"]."' AND idfiliere='".$_POST["idfiliere"]."'";
     $versalle=$DB->get_records_sql($sql);
//     //  var_dump($versall)
   if(!$versalle){
        $salleete->libellespecialite=$etudiantsidd[$i];
        $salleete->idfiliere=$_POST["idfiliere"];
        $salleete->usermodified=$USER->id;
        $salleete->timecreated=time();
        $salleete->timemodified=time();

        $DB->insert_record("specialite",$salleete);
        echo "Bien enregistré";
    }else
    {
           echo $etudiantsidd[$i]." existe déjà";

       }
    }
// echo $_POST["idfiliere"]."".$_POST["idcampus"];
}
?>