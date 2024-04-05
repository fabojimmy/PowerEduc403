<?php

require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ .'/../../../group/lib.php');

global $DB;
$etudiantsidd=explode(",",$_POST["etudiantsid"]);
$idanneescolaires=$DB->get_records("anneescolaire");

$sqlverisalle="SELECT count(idetudiant) as countetu FROM {salleele} WHERE idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'";
$sqlcapacitesalle="SELECT capacitesalle,numerosalle FROM {salle} WHERE id='".$_POST["salle"]."'";
$verisalle=$DB->get_records_sql($sqlverisalle);
$capacitesalle=$DB->get_records_sql($sqlcapacitesalle);
foreach($verisalle as $key => $valversal)
{}
foreach($capacitesalle as $key => $valcapa)
{}
if($valversal->countetu==$valcapa->capacitesalle)
{
    echo "Cette salle est pleine";
}else
{

    $vrisaaal=$DB->get_records_sql("SELECT i.idspecialite FROM {inscription} i,{salleele} sa WHERE i.idspecialite='".$_POST["specialite"]."' AND i.idcycle='".$_POST["cycle"]."'
     AND i.idetudiant=sa.idetudiant AND sa.idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND sa.idanneescolaire='".$_POST["annee"]."'");

     foreach($vrisaaal as $key1)
     {}
    //  echo $key1->idspecialite;
    //  die;
    foreach($idanneescolaires as $key=> $idannee){}
    $salleete= new stdClass();
    $versalgro=$DB->get_records("groups",array("name"=>$valcapa->numerosalle));
    if($vrisaaal)
    {
        if($versalgro)
        {
            foreach($versalgro as $mo){}
            if($_POST["salle"]&&$_POST["etudiantsid"])
            {
                
                for($i=0;$i<count($etudiantsidd);$i++)
                {
                $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'";
                $versalle=$DB->get_records_sql($sql);
                if(!$versalle){
                    // if(!$grid)
                    //  var_dump("dfghjkl",$mo->name,$etudiantsidd[$i]);
                
                    // echo "fghjk"; die;
                groups_add_member($mo->id,$etudiantsidd[$i]);
                // die;
                $sql="SELECT * FROM {coursspecialite} WHERE idspecialite='".$_POST["specialite"]."' AND idcycle='".$_POST["cycle"]."' AND idanneescolaire='".$_POST["annee"]."'";
                $listenote=$DB->get_records_sql($sql);
    
                // je réaffecte les cours de cette salle aux etudiants
                foreach ($listenote as $key => $value) {
                    $sql1="SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$value->id."'";
                    $listenote1=$DB->get_records_sql($sql1);
                    
                    foreach ($listenote1 as $key => $value1) {
                        # code...
                        $sql2="SELECT * FROM {affecterprof} c WHERE c.idcourssemestre='".$value1->id."' AND idsalle='".$_POST["salle"]."' AND quit=0";
                        $listenote2=$DB->get_records_sql($sql2);
                        // var_dump($listenote2);
                        // var_dump($listenote1);die;
                        foreach ($listenote2 as $key => $value2) {
                            // var_dump($value2->id);
                            // var_dump($value2->id); 
                        $verliste=$DB->get_records("listenote",array("idaffecterprof"=>$value2->id,"idetudiant"=>$idetudiant,"retirersalle"=>0));
                        if(!$verliste){
    
                            $notet=new stdClass();
                            $notet->idaffecterprof=$value2->id;
                            $notet->idetudiant=$etudiantsidd[$i];
                            $notet->note1=0;
                            $notet->note2=0;
                            $notet->note3=0;
                            $notet->retirersalle=0;
                            //  var_dump($notet);
                            $DB->insert_record('listenote',$notet);
                        }
                        }
                    }
                }
    
                    $salleete->idetudiant=$etudiantsidd[$i];
                    $salleete->idsalle=$_POST["salle"];
                    $salleete->idanneescolaire=$idannee->id;
                    $salleete->usermodified=$USER->id;
                    $salleete->etudiantpresen=1;
                    $salleete->timecreated=time();
                    $salleete->timemodified=time();
        
                    $DB->insert_record("salleele",$salleete);
                    echo "Bien enregistré";
                }else
                {
        
                }
                }
        
            }
    
            // echo "il n'excite pas";
        }
        else
        {
    
            if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
            {
                for($i=0;$i<count($etudiantsidd);$i++)
                {
                $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'";
                $versalle=$DB->get_records_sql($sql);
                //  var_dump($versall)
            if(!$versalle){
                    $salleete->idetudiant=$etudiantsidd[$i];
                    $salleete->idsalle=$_POST["salle"];
                    $salleete->idanneescolaire=$idannee->id;
                    $salleete->usermodified=$USER->id;
                    $salleete->etudiantpresen=1;
                    $salleete->timecreated=time();
                    $salleete->timemodified=time();
        
                    $DB->insert_record("salleele",$salleete);
                    echo "Bien enregistré";
                }else
                {
        
                }
                }
        
            }
        }
        
    }
    else
    {
        $veriii=$DB->get_records_sql("SELECT * FROM {salleele} WHERE idsalle=".$_POST["salle"]." AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'");
        if($veriii)
        {
            $vrispecy=$DB->get_records_sql("SELECT sp.libellespecialite,cy.libellecycle FROM {inscription} i,{salleele} sa,{specialite} sp,{cycle} cy WHERE i.idspecialite=sp.id AND i.idcycle=cy.id
     AND i.idetudiant=sa.idetudiant AND sa.idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND i.idanneescolaire='".$_POST["annee"]."'");

            foreach($vrispecy as $valsp)
            {}
            
            echo"Cette salle est occupée par la spécialité ou Classe ".$valsp->libellespecialite." du niveau ".$valsp->libellecycle."";
        }
        else
        {

            if($versalgro)
            {
                foreach($versalgro as $mo){}
                if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
                {
                    
                    for($i=0;$i<count($etudiantsidd);$i++)
                    {
                    $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'";
                    $versalle=$DB->get_records_sql($sql);
                    //  var_dump($versall)
                if(!$versalle){
                    // if(!$grid)
                    
                    groups_add_member($mo->id,$etudiantsidd[$i]);
                    // die;
                    $sql="SELECT * FROM {coursspecialite} WHERE idspecialite='".$_POST["specialite"]."' AND idcycle='".$_POST["cycle"]."' AND idanneescolaire='".$_POST["annee"]."'";
                    $listenote=$DB->get_records_sql($sql);
        
                    // je réaffecte les cours de cette salle aux etudiants
                    foreach ($listenote as $key => $value) {
                        $sql1="SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$value->id."'";
                        $listenote1=$DB->get_records_sql($sql1);
                        
                        foreach ($listenote1 as $key => $value1) {
                            # code...
                            $sql2="SELECT * FROM {affecterprof} c WHERE c.idcourssemestre='".$value1->id."' AND idsalle='".$_POST["salle"]."' AND quit=0";
                            $listenote2=$DB->get_records_sql($sql2);
                            // var_dump($listenote2);
                            // var_dump($listenote1);die;
                            foreach ($listenote2 as $key => $value2) {
                                // var_dump($value2->id);
                                // var_dump($value2->id); 
                            $verliste=$DB->get_records("listenote",array("idaffecterprof"=>$value2->id,"idetudiant"=>$idetudiant));
                            if(!$verliste){
        
                                $notet=new stdClass();
                                $notet->idaffecterprof=$value2->id;
                                $notet->idetudiant=$etudiantsidd[$i];
                                $notet->note1=0;
                                $notet->note2=0;
                                $notet->note3=0;
                                $notet->retirersalle=0;
                                //  var_dump($notet);
                                $DB->insert_record('listenote',$notet);
                            }
                            }
                        }
                    }
        
                        $salleete->idetudiant=$etudiantsidd[$i];
                        $salleete->idsalle=$_POST["salle"];
                        $salleete->idanneescolaire=$idannee->id;
                        $salleete->usermodified=$USER->id;
                        $salleete->etudiantpresen=1;
                        $salleete->timecreated=time();
                        $salleete->timemodified=time();
            
                        $DB->insert_record("salleele",$salleete);
                        echo "Bien enregistré";
                    }else
                    {
            
                    }
                    }
            
                }
        
                // echo "il n'excite pas";
            }
            else
            {
        
                if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
                {
                    for($i=0;$i<count($etudiantsidd);$i++)
                    {
                    $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."' AND etudiantpresen=1 AND idanneescolaire='".$_POST["annee"]."'";
                    $versalle=$DB->get_records_sql($sql);
                    //  var_dump($versall)
                if(!$versalle){
                        $salleete->idetudiant=$etudiantsidd[$i];
                        $salleete->idsalle=$_POST["salle"];
                        $salleete->idanneescolaire=$idannee->id;
                        $salleete->usermodified=$USER->id;
                        $salleete->etudiantpresen=1;
                        $salleete->timecreated=time();
                        $salleete->timemodified=time();
            
                        $DB->insert_record("salleele",$salleete);
                        echo "Bien enregistré";
                    }else
                    {
            
                    }
                    }
            
                }
            }

        }


    }
   

}
?>