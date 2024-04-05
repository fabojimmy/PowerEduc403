<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["etudiantsid"]);
$idanneescolaires=$DB->get_records("anneescolaire");

foreach($idanneescolaires as $key=> $idannee){}
$salleete= new stdClass();

$affecterppp=$DB->get_records_sql("SELECT af.id FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af
                                   WHERE sp.id=cs.idcoursspecialite AND cs.id=af.idcourssemestre AND idanneescolaire='".$idannee->id."'
                                   AND af.idsalle='".$_POST["salle"]."'");


if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
{
    for($i=0;$i<count($etudiantsidd);$i++)
    {
     $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."'";
     $versalle=$DB->get_records_sql($sql);
    //  var_dump($versalle);die;
    foreach($versalle as $key => $idsalle){
        
    }
    $salleete->id=$idsalle->id;
    $salleete->idetudiant=$etudiantsidd[$i];
    $salleete->idsalle=$_POST["salle"];
    $salleete->idanneescolaire=$idannee->id;
    $salleete->usermodified=$USER->id;
    $salleete->etudiantpresen=0;
    $salleete->timecreated=time();
    $salleete->timemodified=time();
    
    $ff=$DB->update_record("salleele",$salleete);
    //  var_dump($ff);die;

    $salet=$DB->get_records("salle",array("id"=>$_POST["salle"]));
    foreach($salet as $key =>$ppp)
    {}
    $groupsal=$DB->get_records("groups",array("name"=>$ppp->numerosalle));
    foreach($groupsal as $key)
    {}
    $DB->delete_records("groups_members",array("groupid"=>$key->id,"userid"=>$etudiantsidd[$i]));

    foreach($affecterppp as $key )
    {
        $listenote=$DB->get_records("listenote",array("idaffecterprof"=>$key->id,"idetudiant"=>$etudiantsidd[$i],"retirersalle"=>0));
         foreach($listenote as $keyli)
         {
             $listenoteet=new stdClass();

             $listenoteet->id=$keyli->id;
             $listenoteet->retirersalle=1;
             $DB->update_record("listenote",$listenoteet);
         }
    }
}
    // }

}
?>