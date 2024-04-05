<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;

   if($_POST["filiere"]){
    $sql="SELECT * FROM {specialite} WHERE idfiliere='".$_POST['filiere']."'";
    $filiere=$DB->get_records_sql($sql);
    echo'<option value=""><option>';
      foreach ($filiere as $key => $value) {
          echo '<option value='.$value->id.'>'.$value->libellespecialite.'</option>';
      }
   }
   if ($_POST["specialite"]) {
    $sql="SELECT cy.id as idc,libellecycle FROM {coursspecialite},{cycle} as cy WHERE idspecialite='".$_POST['specialite']."' AND idcycle=cy.id";
    $cycle=$DB->get_records_sql($sql);
    echo'<option value=""><option>';
    foreach ($cycle as $key => $value) {
          echo '<option value='.$value->idc.'>'.$value->libellecycle.'</option>';
    }
   }
//    die;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee
    FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
    WHERE i.idanneescolaire=a.id AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."'";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    echo'<option value=""><option>';
    foreach ($cours as $key => $value1) {
         echo"<tr>
                 <td>'".$value1->firstname."'</td>
                 <td>'".$value1->lastname."'</td>
                 <td><a class='btn-primary'>Voir note</a></td>
               </tr>";
    }
   }


?>