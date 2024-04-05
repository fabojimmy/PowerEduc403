<?php
   require_once(__DIR__ . '/../../../config.php');
   require_once(__DIR__ . '/../idetablisse.php');
   global $DB,$USER;
   if ($_POST["cycle"] && $_POST["specialite"]&&$_POST["salle"]) {
    $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
    FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
    WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idsalle='".$_POST["salle"]."'";

    $veriEtaUverver=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND libelletype="universite" AND c.id='.ChangerSchoolUser($USER->id).'');

    if($veriEtaUverver)
    {
      $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
      s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
      FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{groupapprenant} g
      WHERE i.idanneescolaire=a.id AND g.id=i.idgroupapprenant AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
      AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idgroupapprenant='".$_POST["salle"]."'";
    }
    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
      echo'<tr>
              <td><input type="checkbox" class="checkboxItem" name="abseuser[]" value='.$value1->userid.'></td>
              <td>'.$value1->firstname.'</td>
              <td>'.$value1->lastname.'</td>
            </tr>';
 }
   }


?>