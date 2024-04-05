<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT c.id as idco,c.fullname FROM {coursspecialite},{cycle} as cy,{course} as c WHERE 
    idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses=c.id
    AND idanneescolaire=1";
    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    echo'<option value=""><option>';
    foreach ($cours as $key => $value1) {
          echo '<option value='.$value1->idco.'>'.$value1->fullname.'</option>';
    }
   }

   if ($_POST["cycle"] && $_POST["specialite"] && $_POST["cours"]) {
    $sql1="SELECT sem.id as idsem ,libellesemestre FROM {coursspecialite} as csp,{courssemestre} as cse,{semestre} sem WHERE sem.id=cse.idsemestre AND cse.idcoursspecialite=csp.id AND idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses='".$_POST["cours"]."'";
    $semestre=$DB->get_records_sql($sql1);
    // var_dump($cours);die;
    echo'<option value=""><option>';
    foreach ($semestre as $key => $value2) {
          echo '<option value='.$value1->idsem.'>'.$value1->libellesemestre.'</option>';
    }
   }


?>