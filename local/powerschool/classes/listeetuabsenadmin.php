<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]) {
    $sql="SELECT sbet.id,firstname,lastname,a.datedebut,a.datefin,sbet.idprof,fullname,sbet.heuredebutcours,sbet.nombreheure,sbet.timecreated,sbet.idcampus
    FROM {absenceetu} sbet,{user} u,{anneescolaire} a,{course} c,{coursspecialite} cs,{courssemestre} css
    WHERE u.id=sbet.idetudiant AND c.id=sbet.idcourses AND a.id=sbet.idanneescolaire AND sbet.idspecialite='".$_POST["specialite"]."' AND sbet.id NOT IN (SELECT idabsenceetu FROM {absencejustifier}) 
    AND sbet.idcycle='".$_POST["cycle"]."' AND cs.idcourses=c.id AND cs.id=css.idcoursspecialite AND css.idsemestre='".$_POST["semestre"]."' AND c.id='".$_POST["cours"]."'";
    // $sql="SELECT *
    // FROM {user} u,{specialite} s,{campus} c,{cycle} cy,{absenceetu} sbet,{salle} sa,{course} cous,{coursspecialite} cs,{courssemestre} css,{semestre} see
    // WHERE cs.id=css.idcoursspecialite AND cs.idspecialite=s.id AND cs.idcycle=cy.id AND cs.idspecialite='".$_POST["specialite"]."' AND css.idsemestre=see.id AND cous.id=sbet.idcourses 
    // AND sbet.idsalle=sa.id AND sbet.idprof=u.id AND sbet.idcampus=c.id AND cs.idcycle ='".$_POST["cycle"]."'";
    // $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
    // s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
    // FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
    // WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
    // AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."' AND idsalle='".$_POST["salle"]."'";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
        $user=$DB->get_records("user",array("id"=>$value1->idprof));
        foreach($user as $key => $vauser)
        {}
      echo'<tr>
              <td>'.$value1->id.'</td>
              <td>'.$value1->firstname.'</td>
              <td>'.$value1->lastname.'</td>
              <td>'.date("d-m-Y",$value1->timecreated).'</td>
              <td>'.$vauser->firstname.'</td>
              <td>'.$value1->fullname.'</td>
              <td>'.date("Y",$value1->datedebut).'-'.date("Y",$value1->datefin).'</td>
              <td>'.$value1->heuredebutcours.' h</td>
              <td>'.$value1->nombreheure.' h</td>
              <td><a class="btn btn-warning" href='.new moodle_url("/local/powerschool/absencejustifier.php?idabse=$value1->id&idcampus=$value1->idcampus").'>Justifier Heure</a></td>
            </tr>';
 }
   }


?>