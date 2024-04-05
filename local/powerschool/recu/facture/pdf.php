<?php   
    // require_once 'vendor/autoload.php';
    // require_once __DIR__.'/../../../../../../config.php';

require_once('vendor/autoload.php');
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
require_once __DIR__.'/../../../../config.php';


// $insc=$DB->get_records_sql("SELECT MAX(idinscription) as id FROM {poweredu_inscription}");

// foreach ($insc as $key => $value) {
//     # code...
// }
// $inscription=$DB->get_records_sql("SELECT *FROM {user},{poweredu_inscription} as ins,{poweredu_filiere} as fi,{poweredu_specialite},{poweredu_niveau},{poweredu_anneescolaire},{poweredu_campus},{poweredu_payement},{poweredu_modepayement} WHERE modepayement_id=idmodepayement AND idinscription=inscription_id AND id=user_id AND idcampus=fi.campus_id AND idcampus=ins.campus_id AND idanneescolaire=annesc_id AND idspecialite=specialite_id AND idniveau=niveau_id  AND filiere_id=idfiliere AND visibiliteins=0 AND transfert=0 AND idinscription='".$value->id."'");

// var_dump($inscription);die;



// Création de l'instance HTML2PDF
$html2pdf = new Html2Pdf('P', 'A4', 'fr');



// Génération du PDF
// $html2pdf->writeHTML($html);
$html2pdf->output('recu_scolaire.pdf');

?>