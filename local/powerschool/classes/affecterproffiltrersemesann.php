<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT a.datedebut,a.datefin,a.id FROM {coursspecialite} cp,{cycle} as cy,{course} as c,{anneescolaire} a WHERE 
    idspecialite='".$_POST['specialite']."' AND idcycle='".$_POST['cycle']."' AND idcourses=c.id AND a.id=cp.idanneescolaire";
    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    $bb='<option value=""><option>';
    foreach ($cours as $key => $value1) {
        $time = $value1->datedebut;
        $timef = $value1->datefin;

        $dated = date('Y',$time);
        $datef = date('Y',$timef);
        $bb.='<option value='.$value1->id.'>'.$dated."-".$datef.'</option>';
        echo $bb;
    }
   }
  ?> 