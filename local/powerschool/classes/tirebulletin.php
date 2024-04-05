<?php
//    require_once(__DIR__ . '/../../../config.php');
//    global $DB;
//    if ($_POST["cycle"] && $_POST["specialite"]) {
//     $sql="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
//     s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid
//     FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
//     WHERE i.idanneescolaire=a.id AND i.idspecialite='".$_POST["specialite"]."' AND i.idetudiant=u.id 
//     AND i.idcampus=c.id AND i.idcycle ='".$_POST["cycle"]."'";

//     $cours=$DB->get_records_sql($sql);
//     // var_dump($cours);die;
//     foreach ($cours as $key => $value1) {
//     }
//    }
$data = array(
    'specialite' => $_POST["specialite"],
    'cycle' => $_POST["cycle"],
);

$json_data = json_encode($data);

// Écrivez la réponse JSON
header('Content-Type: application/json');
echo $json_data;

?>