<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cours"]&&$_POST["campus"]) {
    // $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    // s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
    // FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
    // WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    // AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idsalle='".$_POST["salle"]."'";
    $sql="SELECT heuredebutcours FROM {course} c,{coursspecialite} cs,{courssemestre} css,{affecterprof} af,{specialite} s,{filiere} f,{programme} p
       WHERE f.id=s.idfiliere AND s.id=cs.idspecialite AND c.id=cs.idcourses AND c.id=p.idcourses AND css.idcoursspecialite=cs.id AND css.id=af.idcourssemestre AND af.quit=0 AND p.idprof='".$USER->id."' AND c.id='".$_POST["cours"]."' AND f.idcampus='".$_POST["campus"]."'";

    $cours=$DB->get_recordset_sql($sql);
    // var_dump($cours);die;
    $heure='';
    foreach ($cours as $key => $value1)
     {
        $heure.='<option value="'.$value1->heuredebutcours.'">'.$value1->heuredebutcours.'</option>';
     }

     echo $heure;
   }


?>