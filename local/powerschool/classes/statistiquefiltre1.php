<?php
require_once(__DIR__ . '/../../../config.php');
   global $DB;

   if($_POST["campus"]){
    $sql="SELECT * FROM {filiere} WHERE idcampus='".$_POST['campus']."'";
    $filiere=$DB->get_records_sql($sql);
    echo'<option value=""></option>';
      foreach ($filiere as $key => $value) {
          echo '<option value='.$value->id.'>'.$value->libellefiliere.'</option>';
      }
   }?>