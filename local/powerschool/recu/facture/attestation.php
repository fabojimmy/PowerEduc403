<?php
require_once('vendor/autoload.php');
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
require_once __DIR__.'/../../../../config.php';
 // Incluez le fichier d'autoloader de html2pdf
// vendor/autoload.php

// Créez une instance d'Html2Pdf
$largeur = 210; // Largeur pour le format A4
$hauteur = 297; // Hauteur pour le format A4

// Créer un objet Html2Pdf avec les options de configuration
$html2pdf = new Html2Pdf('P', 'A3', 'fr', true, 'UTF-8', array(15, 5, 15, 5));
$html2pdf->pdf->SetDisplayMode('fullpage');
// $sql="SELECT * FROM {listenote} li LEFT JOIN {affecterprof} af ON af.id=li.idaffecterprof LEFT JOIN {coursspecialite} co ON co.id=af.idcoursspecialite LEFT JOIN
// {course} scou ON co.idcourses=scou.id LEFT JOIN {user} as u ON u.id=li.idetudiant 
//  WHERE li.idetudiant=3";
$sql_inscrip = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus,libellecampus,adressecampus,
                s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,idfiliere,idcycle,libellefiliere,logocampus
                FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{filiere} fi
                WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idetudiant=u.id AND fi.id=idfiliere
                AND i.idcampus=c.id AND i.idcycle = cy.id AND i.id='".$_GET["idins"]."'" ;

// $sql="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou WHERE af.id=li.idaffecterprof AND co.id=af.idcoursspecialite 
//                    AND co.idcourses=scou.id
//                    AND li.idetudiant='".$_GET["idetu"]."'";
  $notes=$DB->get_records_sql($sql_inscrip);
//   var_dump($notes);die;
//   $infor=$DB->get_records_sql($sql1);
// var_dump($notes);die;

foreach ($notes as $key => $value1) {
    # code...
}

// var_dump($value1->lastname);die;
// Définissez le contenu HTML à convertir en PDF
$html = '
<!DOCTYPE html>
<html>
<head>
<style>
       h5{
            color:red;
            z-index:1;
            font-size:25px
        }
        h1{
            font-size:50px
        }
        h2{
            font-size:45px
        }
        .tou{
            margin-top:-250px;
        }
        .h5{
            margin-left:450px;
        }
        .h2{
            margin-left:250px;
        }
        .h6{
            margin-left:190px;
        }
        .h1{
            margin-left:188px;
            margin-top:20px
        }
        .h55{
            margin-left:148px;

            z-index:100
        }
        .img1{
            opacity:0.1;
        }
        .log{
            margin-left:320px;
            margin-top:400px;
            opacity:0.2;
        }
        p{
            font-size:24px;
        }
        .sui{
            margin-left:175px;
        }
        body{
            width:100%;
            height:100%;
            background-color:#3d2b1f;
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            border: none;
        }
  
    </style>
</head>
<body>
<div class="body">
    <div class="log"><!--<img class="img1" src="http://127.0.0.1/moodle1/local/powerschool/logo/delete_delete_deleteusers_delete_male_user_maleclient_2348.png">--></div>
    <div class="tou">
    <div class="h5"><h5>CECI ATTESTE QUE</h5></div>
    <div class="h2"><h2>MARIE JOSEPHINE MASSON</h2></div>
    <div class="h6"><p>a satisfait aux exigences du cursus élémentaires à l\'ecole maternelle de <div class="sui">Condorcet et, en conséquence,reçoit ce</div></p></div>
    <div class="h1"><h1>CERTIFICAT DE SCOLARITE</h1></div>
    <div class="h55"><p>Remis dans la salle Marceau en ce 25e jour de fevrier de l\'année 2023</p></div>
    </div>
</div>
</body>
</html>
';

// Chargez le contenu HTML dans Html2Pdf
$html2pdf->writeHTML($html);

// Générez le PDF
$html2pdf->output('output.pdf');
?>