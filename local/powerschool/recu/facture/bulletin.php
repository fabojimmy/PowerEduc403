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
$sql1="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{user} as u,{filiere} as fi,
                   {specialite} as sp,{cycle} as cy,{courssemestre} cse,{bulletin} bu, {campus} ca,{typecampus} tcp 
                   WHERE tcp.id=ca.idtypecampus AND bu.idspecialite=sp.id AND bu.idcycle=cy.id AND bu.idcampus=ca.id AND li.idbulletin=bu.id AND af.id=li.idaffecterprof AND cse.id=af.idcourssemestre 
                   AND co.idcourses=scou.id AND u.id=li.idetudiant AND cy.id=co.idcycle AND sp.id=co.idspecialite AND fi.id=sp.idfiliere
                   AND cse.idcoursspecialite=co.id AND li.idetudiant='".$_GET["idetu"]."'";

$sql="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id
                   AND co.idcourses=scou.id
                   AND li.idetudiant='".$_GET["idetu"]."' AND cse.idsemestre='".$_GET["idse"]."'";
$sqlcredit="SELECT SUM(credit) as credi FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id
                   AND co.idcourses=scou.id
                   AND li.idetudiant='".$_GET["idetu"]."' AND cse.idsemestre='".$_GET["idse"]."'";

  $dte_naisql="SELECT date_naissance,datedebut,datefin FROM {inscription} i,{anneescolaire} a WHERE i.idanneescolaire=a.id AND i.idetudiant='".$_GET["idetu"]."'";
  $datees=$DB->get_records_sql($dte_naisql);
  $notes=$DB->get_records_sql($sql);
  $infor=$DB->get_records_sql($sql1);
  $credit=$DB->get_records_sql($sqlcredit);
  $somme=0;
  $somcredit=0;
  $somp=0;
  foreach ($infor as $key => $value1) {
      # code...
    }
  $sqlpornote="SELECT * FROM {configurationnote} WHERE idcampus='".$value1->idcampus."'";
  $pournote=$DB->get_records_sql($sqlpornote);

  foreach ($pournote as $key => $valuepour) {
    # code...
  }
    // var_dump($value1->logocampus);die;

foreach ($credit as $key => $value2) {
    # code...
}

foreach ($datees as $key => $date) {
    # code...
}

// var_dump($value1->logocampus,$infor,$_GET["idetu"]);die;

// Définissez le contenu HTML à convertir en PDF
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
            border:1px solid black;
            margin-left:-35px
        }
        td,th{
            border:1px solid black;
            padding:10px
        }
        th{
            background:#7AA95C
        }
        .dec,.som,.men,.lieu1
        {
            width:130px;
        }
        .som{
            margin-left:170px;
            margin-top:-40px;
            border:1px solid #7AA95C;
        }
        .cre{
            margin-left:330px;
            margin-top:-40px;
            width:150px;
            border:1px solid #7AA95C;
        }
        .men{
            margin-left:510px;
            margin-top:-57px;
            border:1px solid #7AA95C;
        }
        .men label{
            margin-left:45px;

        }
        .lieu1{
            margin-left:450px;
            margin-top:10px;
        }
        .dec1,.som1,.cre1,.men1
        {
            margin-top:10px;
           
        }
        .dec1{
            margin-left:10px;
            border:1px solid #7AA95C;

        }
        .som1{
            margin-left:10px;
            border:1px solid #7AA95C;

        }
        .cre1{
            margin-left:10px;
            border:1px solid #7AA95C;

        }
        .men1{
            margin-left:17px;
            border:1px solid black;
            //text-align:center;
            height:27px

        }
        .men1 p{
            text-align:center

        }
        .nb{
            font-weight:0;
            font-size:8px;
            margin-top:50px
        }
        .nba{
            font-weight:0;
            font-size:8px;
            margin-top:-5px;
            color:#cacaca
        }
        .dia{
            font-weight:0;
            font-size:12px;
            margin-top:-6px;
            color:#cacaca
        }
        .idi{
            margin-left:520px;
            margin-top:-50px
        }
        .log{
            width:100%;
            height:100%;
        }
        .foo{
            color:white;
            background:#7AA95C;
        }
        .foo td{
            font-weight:700;
        }
        .foo td label{
            font-weight:700;
        }
        .coco{
            margin-left:40px
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
                        <div class="textnote"><h3>RELEVE DE NOTES ANNUEL/ ANNUAL TRANSCRIPT</h3></div>
                </div>
        </div>
    </div>
    <div class="etudiant">
      <div class="info1">
          <p>Nom(s)  <em>Last and First Name</em>:      '.$value1->lastname.' '.$value1->firstname.'</p>
          <p>Né(e) le/  <em>Born on</em>:       '.date("d/m/Y",$date->date_naissance).'</p>
          <!--<p>Domaine(s)  <em>Domain</em>:       TECHNOLOGIE DE L\'INFORMATION ET DE LA COMMUNIcATION</p>-->
          <!--<p>Specialité:    '.$value1->libellespecialite.'  </p>-->
      </div>
      <div class="info2">
          <p>Matricule / <em>Registration Number</em>:     205554  </p>
          <p>Cycle:     '.$value1->libellecycle.'</p>
          <p class="fil">Filiere/ <em>Field</em>:      '.$value1->libellefiliere.'</p>
      </div>
      <div class="info3">
          <p>Année Academique / <em>Aca year</em>:     '.date("Y",$date->datedebut).'-'.date("Y",$date->datefin).'  </p>
          <p></p>
          <p></p>
          <p>Specialité:     '.$value1->libellespecialite.'  </p>
      </div>
    </div> 

    <div class="note">
       <table>
          <tr>';
            if("universite"===$value1->libelletype){

                $html.='<th>Code Matiere</th>';
            }
            
            $html.='<th>l\'unité d\'Enseignement(UE) ou de la matiere</th>
             <th>Coef ou credit</th>';
            if("universite"===$value1->libelletype){

                $html.='<th>Cc</th>';
            }
             $html.='<th>NoteN</th>';

             if ("college"===$value1->libelletype) {
                # code...
                $html.='<th>Note*coef</th>';
            }
             if ("universite"===$value1->libelletype) {
                # code...
                $html.='<th>NoteP</th>';
            }
             
            if ("universite"===$value1->libelletype) {
                # code...
                $html.='<th>Décision</th>';
            }
            // $html.='<th>Grade</th>';

          $html.='</tr>
       ';
     $ii=0;
    foreach ($notes as $key => $item) {
        $html .= '<tr>';
        if ("universite"===$value1->libelletype) {
            # code...
            $html.='<td>' . $item->codematiere . '</td>';
        }
        
                $html.='<td>'.$item->fullname.'</td>
                <td>'.$item->credit.'</td>';
                if ("universite"===$value1->libelletype) {
                    # code...
                    $html.='<td>' . $item->note2 . '</td>';
                }
                      $html.='<td>'.$item->note3.'</td>';
                    if ("college"===$value1->libelletype) {
                        # code...
                        $html.= '<td>'.$item->note3*$item->credit.'</td>';
                    }
                    if ("universite"===$value1->libelletype) {
                        # code...
                        $html.= '<td>'.((($item->note3*$valuepour->normal/100))+(($item->note2*($valuepour->cc)/100))).'</td>';
                        $somp=((($item->note3*$valuepour->normal/100))+(($item->note2*($valuepour->cc)/100)));
                    }

                    if ("universite"===$value1->libelletype) {
                        # code...
                        if ($somp>=9.75) {
                            
                            $html.= '<td>VA</td>';
                            $somcredit=$somcredit+$item->credit;
                        }
                        else{
                            
                            $html.= '<td>NVA</td>';
                        }
                    }

                    //   $html.='<td>'.$item->grade.'</td>';
                    $ii++;
             $html.='</tr>';
                if("primaire"===$value1->libelletype)
                {
                    $somme=$somme+(($item->note3)/$ii);
            
                }
                if("college"===$value1->libelletype || "lycee"===$value1->libelletype)
                {
                    $somme=$somme+(($item->note3*$item->credit)/$item->credit);
            
                }
                if("universite"===$value1->libelletype)
                {
                    $somme=$somme+($somp/$item->credit);
                    
                    
                    }
            }
                $html.='
                   <tr class="foo">
                      <th colspan=7>';
                    if($somme>=10){

                        $html.='<div class="dec"><label>Décision du jury</label><div class="dec1">Admis(e)</div></div>';
                        $html.='<div class="som"><label>Moyenne annuelle</label><div class="som1">'.$somme.'</div></div>';
                        $html.='<div class="cre"><label>Total crédits capitalisés</label><div class="cre1">'.$somcredit.'</div></div>';
                        if ($somme>=10 && $somme<12) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1"><p>Passable</p></div></div>';
                        }
                        if ($somme>=12 && $somme<14) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Assez Bien</div></div>';
                        }
                        if ($somme>=14 && $somme<16) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Bien</div></div>';
                        }
                        if ($somme>=16) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Très Bien</div></div>';
                        }
                    }else{
                        $html.='<div class="dec"><label>Décision du jury</label><div class="dec1">Refusé(e)</div></div>';
                        $html.='<div class="som"><label>Moyenne annuelle</label><div class="som1">'.$somme.'</div></div>';
                        $html.='<div class="cre"><label>Total crédits capitalisés</label><div class="cre1">'.$somcredit.'</div></div>';
                        if ($somme<10 ) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1"><p>null</p></div></div>';
                        }
                        if ($somme>=10 && $somme<12) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Passable</div></div>';
                        }
                        if ($somme>=12 && $somme<14) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Assez Bien</div></div>';
                        }
                        if ($somme>=14 && $somme<16) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Bien</div></div>';
                        }
                        if ($somme>=16) {
                            # code...
                            $html.='<div class="men"><label>Mention</label><div class="men1">Très Bien</div></div>';
                        }


                    }
                      $html.='<div class="lieu1"><label>Fait à   </label><div>  '.$value1->villecampus.'   le '.   date("Y/m/d").'</div></div>
                      </th>
                   </tr>
                ';
    $html .= '</table>
   </div>
   <div class="coco">
      <p class="nb">NB:Il n\'est délivré qu\'un seul exemplaire de ce document, le titulaire peut en faire autant de copies conformes nécessaires</p>
      <p class="nba">NB:Only one copy of this document is issued, the holder can make as many certified copies as necessary</p>

      <div class="idi">
            <p class="di">Le Directeur Academique</p>
            <em class="dia">The Academic Director</em>
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