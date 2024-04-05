<?php   
    require_once 'vendor/autoload.php';
    require_once __DIR__.'/../../../../../../config.php';

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
require_once('vendor/autoload.php');

global $DB;



$inscription=$DB->get_records_sql("SELECT *FROM {user},{poweredu_inscription} as ins,{poweredu_filiere} as fi,{poweredu_specialite},{poweredu_niveau},
                                    {poweredu_anneescolaire},{poweredu_campus},{poweredu_payement},{poweredu_modepayement} WHERE 
                                    modepayement_id=idmodepayement AND idinscription=inscription_id AND id=user_id 
                                    AND idcampus=fi.campus_id AND idcampus=ins.campus_id AND idanneescolaire=annesc_id 
                                    AND idspecialite=specialite_id AND idniveau=niveau_id  AND filiere_id=idfiliere AND 
                                    visibiliteins=0 AND transfert=0 AND idinscription='".$_GET["insc"]."' AND idpayement='".$_GET["fac"]."'");

// function hhh($ids){
//     global $DB;
//      $somme=$DB->get_records_sql("SELECT * FROM {poweredu_payement} WHERE inscription_id='".$ids."'");
//     //  var_dump($somme);die;
//     $tt=[];
//         foreach($somme as $som){
//             // hhh($ids);
//             return $som->montantpayement;
//         }
    
// }

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
        h1 {
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
        .header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 16px;
            margin: 5px 0;
        }
        .details {
            margin-bottom: 100px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .details p {
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
    </style>
</head>
<body>
    <div class="logo">
        <!--<img src="chemin/vers/logo.png" alt="Logo Établissement">-->
    </div>
    <div class="header">
        <h2>Reçu Scolaire</h2>
        <p>Établissement : ' . $etablissement . '</p>
        <p>Adresse : ' . $adresse . '</p>
        <p>Téléphone : ' . $telephone . '</p>
        <!--<p>Email : ' . $email . '</p>-->
        <p>Site Web : ' . $siteWeb . '</p>
    </div>
    <div class="details">
        <p><strong>Nom :</strong> ' . $nom . '</p>
        <p><strong>Date :</strong> ' . $date . '</p>
        <p><strong>Spécialité :</strong> ' . $specialite . '</p>
        <p><strong>Filière :</strong> ' . $filiere . '</p>
        <p><strong>Niveau :</strong> ' . $niveau . '</p>
        <p><strong>Référence de paiement :</strong> ' .$value1->refpay . '</p>
        <p><strong>Numéro de facture :</strong> ' . $value1->idpayement . '</p>
        <p><strong>Montant :</strong> ' .$montant. ' EUR</p>
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
// foreach ($somme as $key => $value3) {
//     # code...
//   echo  $p='<p><strong>Référence de paiement :</strong> ' .$value3->refpay . '</p>';
//   echo  $p.='<p><strong>Numéro de facture :</strong> ' . $value3->idpayement . '</p>';
//   echo  $p.='<p><strong>Montant :</strong> ' . $value3->montantpayement. ' EUR</p>';
// }