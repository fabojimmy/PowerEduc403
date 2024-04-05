<?php
     
     require_once(__DIR__ . '/../../config.php');

     function mtntTotal($idpro=null,$anneede=null,$anneefin=null){
        // var_dump(date("H:i:s",47973));
        // var_dump(47973/3600);
         global $DB;
         $fileprogram= $DB->get_records_sql("SELECT idcourses,prixheur FROM {affecterprof} af,{courssemestre} css,{coursspecialite} csp 
                       WHERE af.idprof='".$idpro."' AND af.idcourssemestre=css.id AND csp.id=css.idcoursspecialite");

$somme=0;
foreach($fileprogram as $value){
    
    // $file= $DB->get_records_sql("SELECT count(id) as nbrerapo FROM {rapportcours} WHERE idpro='".$idpro."' AND YEAR(FROM_UNIXTIME(timecreated))='".$annee."' AND MONTH(FROM_UNIXTIME(timecreated))='".$mois."' AND idcours='".$value->idcourses."' AND validerap=1 ");
    $file= $DB->get_records_sql("SELECT duree FROM {rapportcours} WHERE idpro='".$idpro."' AND FROM_UNIXTIME(timecreated) BETWEEN '".$anneede."' AND '".$anneefin."' AND idcours='".$value->idcourses."' AND validerap=1 ");
    // die;
            foreach ($file as $key => $value1) {
                # code...
                $somme=$somme+($value->prixheur*($value1->duree/(60*60*1000)));
                $ff4=$value->prixheur*($value1->duree/(60*60*1000));
                // var_dump($ff4);
            }

        }
        // die;
     


        return $somme;

     }
    
?>