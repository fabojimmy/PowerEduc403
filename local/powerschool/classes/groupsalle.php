<?php
   require_once(__DIR__ . '/../../../config.php');
   require_once(__DIR__ . '/../idetablisse.php');
   global $DB;
   if ($_POST["cours"] && $_POST["salle"]) {
    $libelle="";
    $veriEta=$DB->get_records_sql('SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='.ChangerSchoolUser($USER->id).'');

    // $sallejs='<option value="">'. $veriEta.'<option>';
        foreach($veriEta  as $valueEt){}

        if($valueEt->libelletype=="universite")
        {
            $sall=$DB->get_records("groupapprenant",array("id"=>$_POST["salle"]));
            foreach($sall as $val);
        $libelle=$val->numerogroup;
    }else
    {
        $sall=$DB->get_records("salle",array("id"=>$_POST["salle"]));
        foreach($sall as $val)
        $libelle=$val->numerosalle;
    {}
        }
    $tarsp=[
        "cours"=>$_POST["cours"],
        "salle"=>$libelle,
        "route"=>$_POST["route"],
        "campus"=>$_POST["campus"],
        "idsalle"=>$_POST["salle"],
    ];

    echo json_encode($tarsp);

   }


?>