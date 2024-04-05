<?php   
    require_once 'vendor/autoload.php';
    require_once __DIR__.'/../../../../../../config.php';

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
require_once('vendor/autoload.php');

global $DB;



foreach ($insc as $key => $value) {
    # code...
}
$inscription=$DB->get_records_sql("SELECT *FROM {user},{poweredu_inscription_cours} as ins,{poweredu_filiere} as 
fi,{poweredu_niveau},{poweredu_specialite},{poweredu_payement},{poweredu_modepayement},{course} as 
us WHERE  idspecialite=specialite_id AND idniveau=niveau_id AND idfiliere=idfiliere AND 
idinscription_course=inscription_course_id AND idmodepayement=modepayement_id AND us.id=course_id 
AND idinscription_course='".$_GET["insccour"]."' AND idpayement='".$_GET["fac"]."'");
// var_dump($inscription);die;

// var_dump($inscription);die;

foreach ($inscription as $key => $value1) {
    # code...
}
$etablissement =$value1->nomcampus;
$adresse = $value1->lieucampus;
$telephone = $value1->adressecamp;
$email = $value1->email;
$siteWeb =$value1->boitecampus;
$nom = $value1->firstname." ".$value1->lastname;
$montant = $value1->montantpayement;
$date = date("Y.m.d");
$referencePaiement = $value1->refpay;
$numeroFacture = $value1->idpayement;
$specialite = $value1->libellespecialite;
$filiere = $value1->libellefiliere;
$niveau = $value1->libelleniveau;
$modePaiement = $value1->typepayement;
$cours = $value1->fullname;

// Création de l'instance HTML2PDF
$html2pdf = new Html2Pdf('P', 'A4', 'fr');

// Construction du contenu HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu scolaire</title>
    <style>
        /* Styles CSS pour le reçu */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h5 {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h5 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .header p,h6,.contact {
            font-size: 16px;
            margin: 5px 0;
        }
        .details {
            margin-bottom: 100px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .details p,h6,.contact {
            margin: 5px 0;
        }
        .footer {
            position: fixed;
            top:63rem
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
            background-color: #f2f2f2;
            font-size: 12px;
        }
        table,td,th{
            border-collapse: collapse;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    
     <table>
        <tr>
           <th colspan="5">
              <div style="margin-left:3rem">RECU/FRAIS DE PENSION 2022-2023</div>
              <div>ETABLISSEMENT:' . $telephone .'</div>
              <div>contact: 674823496/695868300. '. $adresse . ' cameroun</div>
           </th>
        </tr>
        <tr>
           <th>
             <div>Douala lundi 28 Novembre 2023</div>
           </th>
        </tr>
     </table>
    <div class="logo">
        <!--<img src="chemin/vers/logo.png" alt="Logo Établissement">-->
    </div>
    <div class="header">
        <!--<h5>RECU/FRAIS DE PENSION</h5>-->
        <!--<h6>ETABLISSEMENT : ' . $etablissement . '</h6>-->
        <!--<p>Adresse : ' . $adresse . '</p>-->
        <!--<p>Téléphone : ' . $telephone . '</p>-->
        <!--<p>Email : ' . $email . '</p>-->
        <!--<p>Site Web : ' . $siteWeb . '</p>-->
       <!-- <div class="contact">contact: 674823496/695868300. Douala cameroun</div>-->
    </div>
    <div class="details">
        <p><strong>Nom :</strong> ' . $nom . '</p>
        <p><strong>Montant :</strong> ' . $montant . ' EUR</p>
        <p><strong>Date :</strong> ' . $date . '</p>
        <p><strong>Référence de paiement :</strong> ' . $referencePaiement . '</p>
        <p><strong>Numéro de facture :</strong> ' . $numeroFacture . '</p>
        <p><strong>Spécialité :</strong> ' . $specialite . '</p>
        <p><strong>Filière :</strong> ' . $filiere . '</p>
        <p><strong>Niveau :</strong> ' . $niveau . '</p>
        <p><strong>Cours :</strong> ' . $cours . '</p>
        <p><strong>Mode de paiement :</strong> ' . $modePaiement . '</p>
    </div>
    <div class="footer">
        <p>© ' . date("Y") . ' ' . $etablissement . '. Tous droits réservés.</p>
    </div>

 
</body>
</html>
';

// Génération du PDF
$html2pdf->writeHTML($html);
$html2pdf->output('recu_scolaire.pdf');
    