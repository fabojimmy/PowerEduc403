<?php   
    require_once __DIR__.'/vendor/autoload.php';
    // require_once __DIR__.'/';

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
// require_once('vendor/autoload.php');


// $insc=$DB->get_records_sql("SELECT MAX(idinscription_course) as id FROM {poweredu_inscription_cours}");


// foreach ($insc as $key => $value) {
//     # code...
// }
// $inscription=$DB->get_records_sql("SELECT *FROM {user},{poweredu_inscription_cours} as ins,{poweredu_filiere} as fi,{poweredu_niveau},{poweredu_specialite},{poweredu_payement},{poweredu_modepayement},{course} as us WHERE  idspecialite=specialite_id AND idniveau=niveau_id AND idfiliere=idfiliere AND idinscription_course=inscription_course_id AND idmodepayement=modepayement_id AND us.id=course_id AND idinscription_course='".$value->id."'");
// // var_dump($inscription);die;

// // var_dump($inscription);die;



// Création de l'instance HTML2PDF
$html2pdf = new Html2Pdf('P', 'A4', 'fr');



// Génération du PDF
$html2pdf->writeHTML($html);
$html2pdf->output('recu_scolaire.pdf');
    