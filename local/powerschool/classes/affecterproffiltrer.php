<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["specialite"]) {
    $sql="SELECT cy.id as idc,libellecycle FROM {coursspecialite},{cycle} as cy WHERE idspecialite='".$_POST['specialite']."' AND idcycle=cy.id";
    $cycle=$DB->get_records_sql($sql);
          echo'<option value=""></option>';
    foreach ($cycle as $key => $value) {
          echo '<option value='.$value->idc.'>'.$value->libellecycle.'</option>';
    }
   }
//    die;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT c.id as idco,c.fullname FROM {coursspecialite},{cycle} as cy,{course} as c WHERE idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses=c.id";
    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
          echo '<option value='.$value1->idco.'>'.$value1->fullname.'</option>';
    }
   }


?>