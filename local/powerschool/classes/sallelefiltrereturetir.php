<?php
   require_once(__DIR__ . '/../../../config.php');
   require_once(__DIR__ . '/../idetablisse.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
       $veriEta=array();
    $veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.ChangerSchoolUser($USER->id).'');

    // $sallejs='<option value="">'. $veriEta.'<option>';
        foreach($veriEta  as $valueEt){}

        if($valueEt->libelletype=="universite")
        {
            $sql="SELECT g.id,g.numerogroup FROM {groupapprenant} g WHERE idspecialite='".$_POST["specialite"]."' AND idcycle ='".$_POST["cycle"]."'";
            $cours=$DB->get_records_sql($sql);
            $sallejs="";
                $sallejs='<option value=""><option>';
            foreach ($cours as $key => $value1) {
                 $sallejs.='<option value='.$value1->id.'>'.$value1->numerogroup.'</option>';
            }
        }
        else
        {
            $sql="SELECT sa.id as idsa,numerosalle
            FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
            WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
            AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."'";
            $cours=$DB->get_records_sql($sql);
            $sallejs="";
                $sallejs='<option value=""><option>';
            foreach ($cours as $key => $value1) {
                 $sallejs.='<option value='.$value1->idsa.'>'.$value1->numerosalle.'</option>';
            }
        }
        

    $sql1="SELECT c.id as idco,c.fullname FROM {coursspecialite},{cycle} as cy,{course} as c WHERE idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses=c.id";
    $cours=$DB->get_records_sql($sql1);
    // var_dump($cours);die;
    $coursjs="";
    $coursjs='<option value=""><option>';
    foreach ($cours as $key => $value1) {
          $coursjs.= '<option value='.$value1->idco.'>'.$value1->fullname.'</option>';
    }
   }

   $tardeux=[
    "sallejs"=>$sallejs,
    "coursjs"=>$coursjs,
   ];
   echo json_encode($tardeux);
//    if ($_POST["cycle"] && $_POST["specialite"]) {
//     $sql="SELECT c.id as idco,c.fullname FROM {coursspecialite},{cycle} as cy,{course} as c WHERE idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses=c.id";
//     $cours=$DB->get_records_sql($sql);
//     // var_dump($cours);die;
//     echo'<option value=""><option>';
//     foreach ($cours as $key => $value1) {
//           echo '<option value='.$value1->idco.'>'.$value1->fullname.'</option>';
//     }
//    }
//    if ($_POST["cycle"] && $_POST["specialite"]&&$_POST["salle"]) {
//     $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
//     s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
//     FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
//     WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle  AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
//     AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idsalle='".$_POST["salle"]."'";

//     $cours=$DB->get_records_sql($sql);
//     // var_dump($cours);die;
//     foreach ($cours as $key => $value1) {
//       echo'<tr>
//               <td><input type="checkbox" class="checkboxItem" name="useridche[]" value='.$value1->userid.'></td>
//               <td>'.$value1->firstname.'</td>
//               <td>'.$value1->lastname.'</td>
//             </tr>';
//  }
//    }


?>