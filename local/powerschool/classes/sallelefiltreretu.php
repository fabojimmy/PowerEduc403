<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
    FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
    WHERE i.idetudiant=u.id AND i.idanneescolaire=a.id AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND u.id NOT IN (SELECT idetudiant FROM {salleele} WHERE etudiantpresen=1)";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
         echo'<tr>
                 <td><input type="checkbox" class="checkboxItem" name="useridche[]" value='.$value1->userid.'></td>
                 <td>'.$value1->firstname.'</td>
                 <td>'.$value1->lastname.'</td>
               </tr>';
    }
   }


?>