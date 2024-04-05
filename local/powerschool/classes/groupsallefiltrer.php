<?php
   require_once(__DIR__ . '/../../../config.php');
   require_once(__DIR__ . '/../idetablisse.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]&&$_POST["salle"]) {
    $veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.ChangerSchoolUser($USER->id).'');

    $table="";
    // $sallejs='<option value="">'. $veriEta.'<option>';
        foreach($veriEta  as $valueEt){}

        if($valueEt->libelletype=="universite")
        {
            $sql="SELECT c.fullname FROM {course} c,{groups} g WHERE c.id=g.courseid
                  AND name IN (SELECT numerogroup FROM {groupapprenant} WHERE id='".$_POST["salle"]."')";
        }
        else
        {
            $sql="SELECT c.fullname FROM {course} c,{groups} g WHERE c.id=g.courseid
                  AND name IN (SELECT numerosalle FROM {salle} WHERE id='".$_POST["salle"]."')";
          }

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
      echo'<tr>
              <td>'.$value1->fullname.'</td>
            </tr>';
 }
   }


?>