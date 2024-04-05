<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
    FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
    WHERE i.idanneescolaire=a.id AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."'";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
         echo"<tr>
                 <td>".$value1->firstname."</td>
                 <td>".$value1->lastname."</td>
                 <td><a href='".new moodle_url('/local/powerschool/bulletinnote.php?idet='.$value1->userid.'&idsp='.$_POST["specialite"].'&idcy='.$_POST["cycle"].'')."' class='btn-primary form-control col-3'>Voir note</a></td>
               </tr>";
    }
   }


?>