<?php
require_once('vendor/autoload.php');
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
require_once __DIR__.'/../../../../config.php';
 // Incluez le fichier d'autoloader de html2pdf
// vendor/autoload.php

// Créez une instance d'Html2Pdf
$html2pdf = new Html2Pdf();
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
$dte_naisql="SELECT date_naissance,datedebut,datefin FROM {inscription} i,{anneescolaire} a WHERE i.idanneescolaire=a.id AND i.id='".$_GET["idins"]."'";
  $datees=$DB->get_records_sql($dte_naisql);
foreach ($notes as $key => $value1) {
    # code...
}

foreach ($datees as $key => $date) {
    # code...
}
// var_dump($value1->lastname);die;
// Définissez le contenu HTML à convertir en PDF

if($value1->logocampus)
{
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
        .logo{
            // border:1px solid black;
             width: 90px;
             height: 90px;
             background:#7AA95C
            }
            .log{
                width:100%;
                height:100%;
            }
            h4{
                text-transform:uppercase
            }
            .header{
                background:#7AA95C
    
            }
            .header .text{
                margin-left:120px;
                margin-top:-100px;
            }
            .text h4,.text p,.text h6{
                text-align:center;
            }
            th{
                background:#7AA95C
            }
            .text h5,.text p,.text h6{
                text-align:center;
            }
            .lieu{
                margin-top:-25px
            }
            .textnote{
                text-align:center;
            }
            .headerglo{
                border:1px solid black;
            }
            .etudiant{
                font-size: 9px;
            }
            .etudiant p{
                font-weigth:700px;
            }
            .etudiant em{
                color:#828282
            }
            .etudiant .info1{
                margin-left:50px
            }
            .etudiant .info2{
                margin-left:300px;
                margin-top:-48px
            }
            .info2 .fil{
                margin-top:20px
            }
            .etudiant .info3{
                margin-left:560px;
                margin-top:-90px
            }
            .note{
                margin-top:30px;
                margin-left:40px
            }
            table{
                border-collapse:collapse;
                border:1px solid black
            }
            td,th{
                border:1px solid black;
                padding:10px
            }
            .som{
                width:5px
            }
            .datlim{
                width:100px
            }
            .foo{
                color:white;
                background:#7AA95C;
            }
        </style>
    </head>
    <body>
        <div class="headerglo">
            <div class="header">
                <div class="logo">
                    <img src='.$value1->logocampus.' class="log">
                </div>
                    <div class="text">
                            <div><h4>'.$value1->libellecampus.'</h4></div>
                            <div class="lieu"><p>'.$value1->adressecampus.'</p></div>
                            <div class="textnote"><h3>Recu De Payement</h3></div>
                    </div>
            </div>
        </div>
        <div class="etudiant">
          <div class="info1">
              <p>Nom(s)  <em>Last and First Name</em>:      '.$value1->lastname.' '.$value1->firstname.'</p>
              <p>Né(e) le/  <em>Born on</em>:        '.date("d/m/Y",$date->date_naissance).'</p>
          </div>
          <div class="info2">
              <p>Matricule / <em>Registration Number</em>:     205554  </p>
              <p>Cycle:     '.$value1->libellecycle.'</p>
              <p class="fil">Filiere/ <em>Field</em>:      '.$value1->libellefiliere.'</p>
          </div>
          <div class="info3">
              <p>Année Academique / <em>Aca year</em>:     '.date("Y",$date->datedebut).'-'.date("Y",$date->datefin).' </p>
              <p></p>
              <p></p>
              <p>Specialité:     '.$value1->libellespecialite.'  </p>
          </div>
        </div> 
    
        <div class="note">
           <table>
              <tr>
                 <!--<th>fiche recu</th>-->
                 <th>Mode de paiement</th>
                 <th>Tranche</th>
                 <th>Montant</th>
                 <th>Date de paiement</th>
                 <th>Tranche total</th>
                 <th>Date Limite</th>
                 <th>Stauts</th>
              </tr>';
              $sql_paie="SELECT paie.id as idpaie,tr.id as idtran,libelletranche FROM {paiement} paie,{tranche} tr WHERE paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."' GROUP BY idtranche";
              $paietr=$DB->get_records_sql($sql_paie);
              foreach ($paietr as $key => $value) {
                  # code...
                  
                  $html.='<tr>';
    
                  $sql_paie="SELECT libellemodepaiement FROM {paiement} paie,{tranche} tr,{modepaiement} m WHERE m.id=paie.idmodepaie AND paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."' AND idtranche='".$value->idtran."'";
                  $fic=$DB->get_records_sql($sql_paie);
    
                  $html.='<td>';
                  foreach($fic as $key => $di)
                  {
                    $html.='<div class="som">'.$di->libellemodepaiement.'</div>';
                  }
                  $html.='</td>';
                  $html.='<td>'.$value->libelletranche.'</td>
                  <td>';
                  $sql_paie="SELECT paie.id as idpaie,tr.id as idtran,libelletranche,montant FROM {paiement} paie,{tranche} tr WHERE paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."' AND idtranche='".$value->idtran."'";
                  $paietr=$DB->get_records_sql($sql_paie);
                  //    var_dump($paietr);
                  foreach ($paietr as $key => $value1) {
                      # code...
                      $html.= '<div class="som">'.$value1->montant.'</div>';
                    }
                    $html.='</td><td>';
                    
                    $sql_date="SELECT * FROM {paiement} paie,{tranche} tr WHERE paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."' AND idtranche='".$value->idtran."'";
                    $dates=$DB->get_recordset_sql($sql_date);
                    // var_dump($dates);die;
                    foreach ($dates as $key => $value2) {
                        # code...
                        $html.= '<div class="som">'.date("Y/m/d",$value2->timecreated).'</div>';
                    }
                    $html.='</td>';
                    
                    $sql_date="SELECT SUM(montant) as mtnt FROM {paiement} paie,{tranche} tr WHERE paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."' AND idtranche='".$value->idtran."'";
                    $montant=$DB->get_records_sql($sql_date);
                    foreach ($montant as $key => $value3) {
                        # code...
                    }
                    $html.= '
                    <td>'.$value3->mtnt.'</td>';
                    
                    $sql_filc="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_GET["idfi"]."' AND idtranc='".$value->idtran."'";
                    $datelimite=$DB->get_records_sql($sql_filc);
                     $html.='<td>';
                     foreach($datelimite as $key =>$date)
                     {
                    }
                    $html.='<div class="datlim">'.date("Y/m/d",$date->datelimite).'</div>';
                     $html.='</td>';
                    $sql_filcy="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_GET["idfi"]."' AND idtranc='".$value->idtran."'";
                    $filcy=$DB->get_records_sql($sql_filcy);
                    foreach ($filcy as $key => $value4) {
                        # code...
                    }
                    if($value4->somme==$value3->mtnt){
                        
                        $html.='<td>fini</td>';
                    }else{
                        $html.='<td>en cours</td>';
                        
                    }
                    
                    $html.='</tr>';
                }
                // die;
                $html.='<tr>';
                $sql_date="SELECT SUM(montant) as mtnt FROM {paiement} paie,{tranche} tr WHERE paie.idtranche=tr.id AND paie.idinscription='".$_GET["idins"]."'";
                $montant=$DB->get_records_sql($sql_date);
           
                foreach ($montant as $key => $value) {
                    # code...
                }
                $html.='<td colspan=6 class="foo">Total:  '.$value->mtnt.'</td>
                </tr>
              </table>';
       $html.='</div>
    </body>
    </html>
    ';
    // Chargez le contenu HTML dans Html2Pdf
    $html2pdf->writeHTML($html);
    
    // Générez le PDF
    $html2pdf->output('output.pdf');
}
else
{
    \core\notification::add('Enregistrer un logo pour les documents', \core\output\notification::NOTIFY_ERROR);
    redirect($CFG->wwwroot.'/local/powerschool/inscription.php');
}

?>