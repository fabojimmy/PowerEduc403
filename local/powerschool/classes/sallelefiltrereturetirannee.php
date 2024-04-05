<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]&&$_POST["salle"]) {
    $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid,a.id as idan
    FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
    WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idsalle='".$_POST["salle"]."'";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    $bb="<option></option>";
    foreach ($cours as $key => $value1) {
                $time = $value1->datedebut;
                $timef = $value1->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);
        $bb.='<option value='.$value1->idan.'>'.$dated."-".$datef.'</option>';
      echo $bb;
 }
   }


?>