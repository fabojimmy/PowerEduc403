<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\statistique;
// use local_powerschool\token;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/idetablisse.php');
require_once(__DIR__ . '/token.php');
require_once($CFG->dirroot.'/local/powerschool/classes/statistique.php');
// require_once($CFG->dirroot.'/local/powerschool/token.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

// var_dump($etablisse,$annee);die;
$PAGE->set_url(new moodle_url('/local/powerschool/statistique.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une statistique');
$PAGE->set_heading('Enregistrer une statistique');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('statistique', 'local_powerschool'));
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new statistique();

// var_dump($CFG->wwwroot);die;
//fonction pour extraire les mois dans une année
function extractMonths($startTimestamp, $endTimestamp) {
    $startDateObj = new DateTime();
    $startDateObj->setTimestamp($startTimestamp);
    
    $endDateObj = new DateTime();
    $endDateObj->setTimestamp($endTimestamp);

    // Créer un tableau pour stocker les noms des mois
    $months = array();

    // Boucle pour parcourir les mois entre les deux timestamps
    while ($startDateObj <= $endDateObj) {
        // Obtenir le nom du mois et l'année sous la forme "NomMois Année" (par exemple, "Mai 2023")
        $monthName = $startDateObj->format('F');

        // Ajouter le nom du mois au tableau
        $months[] = $monthName;

        // Passer au mois suivant en augmentant le mois d'un
        $startDateObj->modify('+1 month');
    }

    // Retourner le tableau des mois
    return $months;
}
function corresage(){

}
$annesql="SELECT * FROM {anneescolaire}";
$annee=$DB->get_records_sql($annesql);

foreach($annee as $key =>$vala)
{

}
// var_dump(extractMonths($vala->datedebut,$vala->datefin));die;

// $mform->get_number_ofEtudiant($table);
//cette statistique calcule les sommes des filieres en fonction de annéé
$sqlfilann="SELECT * FROM {filiere} WHERE idcampus='".$_GET["campus"]."'";
$filann=$DB->get_records_sql($sqlfilann);

foreach($filann as $key => $fila)
{
$sqlanninsc="SELECT SUM(montant) entrees FROM {inscription} i,{specialite} sp ,{paiement} pa
             WHERE i.id=pa.idinscription AND i.idspecialite=sp.id AND sp.idfiliere='".$fila->id."'
             AND idanneescolaire='".$_GET["annee"]."' AND i.idcampus='".$_GET["campus"]."'";

  $annnesome=$DB->get_records_sql($sqlanninsc);
  foreach($annnesome as $key=>$somne)
  {
    $annnnnee[]=$somne->entrees;
  }
  $filiereanee[]=$fila->libellefiliere;
//   var_dump($annnnnee);
}
// $specialites = array("Informatique", "Génie Civil", "Economie","mmmmmmmm",
//                     "Informatique", "Génie Civil", "Economie","mmmmmmmm",
//                     "Informatique", "Génie Civil", "Economie","mmmmmmmm");
// $entrees = array(5000, 7000, 4000);

// Convertir les données en format JSON
$specialites_json = json_encode($specialites);
$entrees_json = json_encode($entrees);

// die;
$fils=$DB->get_records_sql("SELECT id FROM {filiere}");

$taret=array();

    $countetusql="SELECT count(idetudiant) somid  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi 
             WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND idanneescolaire='".$_GET["annee"]."'";

$etufilsom=$DB->get_records_sql($countetusql);
foreach($etufilsom as $key => $som)
{

}

foreach($fils as $key => $fil){

    $sqletufil="SELECT count(idetudiant) idd,libellefiliere  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi 
             WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$fil->id."' AND idanneescolaire='".$_GET["annee"]."'";

$etufil=$DB->get_recordset_sql($sqletufil);
// var_dump($etufil);
foreach($etufil as $key => $etu)
{
    
    $sqletuspe="SELECT libellespecialite  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi 
             WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$fil->id."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $etufilsp=$DB->get_recordset_sql($sqletuspe);

        foreach($etufilsp as $key => $etuu){
            $etu->specialite=$etuu->libellespecialite."....";
        }
    $sqletuspe="SELECT libellespecialite  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi 
                WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$fil->id."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $etufilsp=$DB->get_recordset_sql($sqletuspe);

        foreach($etufilsp as $key => $etuu){
            $etu->specialite=$etuu->libellespecialite."....";
        }
        $taret[]=(array)$etu;
    }

}
// die;
// foreach($etufil as $key=> $et)
// {
    //     $et->idd;
    // }
    
    //Statistique somme
    $sqlpso="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."'";

    $speciaaa=$DB->get_records_sql($sqlpso);
    $data = array();
 foreach($speciaaa as $key => $val){
    $sqlsomme="SELECT SUM(montant) as entrees,libellespecialite  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
               WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$_GET["filiere"]."'
               AND idspecialite ='".$val->id."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $sppsom=$DB->get_records_sql($sqlsomme);
    
    // var_dump($sppsom);

    // Parcourez les résultats et ajoutez-les au tableau de données
    foreach ($sppsom as $result) {
    if($result->libellespecialite)
    {
        $data[] = array(
            'specialite' => $result->libellespecialite,
            'entrees' => $result->entrees
        );
    }
    }
      
}
//    die;
$sqlcyc="SELECT DISTINCT cy.id as idcy FROM {cycle} cy";

    $cycleee=$DB->get_records_sql($sqlcyc);
    $datacy = array();
foreach($cycleee as $key => $val){
    $sqlsommecy="SELECT SUM(montant) as entrees,libellecycle  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
             WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$_GET["filiere"]."' AND 
             idcycle ='".$val->idcy."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $cyypsom=$DB->get_records_sql($sqlsommecy);
    
    // var_dump($sppsom);

    // Parcourez les résultats et ajoutez-les au tableau de données
    foreach ($cyypsom as $result) {
     if($result->libellecycle)
     {

         $datacy[] = array(
             'cycle' => $result->libellecycle,
             'entrees' => $result->entrees
         );
     }
    }
      
}

//Statistique details sur la somme 
// cette statistique permet de savoir la somme des differents cycle concernant une specialite et une filiere
// $sqlfilspe="SELECT id FROM {specialite} WHERE idfiliere=1 AND id=1";

//     $filspeee=$DB->get_records_sql($sqlfilspe);
    $datafilsp = array();
    // die;
//  foreach($filspeee as $key => $val1){
    $sqlpsoetufilsp="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."' AND id='".$_GET["specialite"]."'";

    $speciaaaetufilsp=$DB->get_records_sql($sqlpsoetufilsp);
    $dataetu = array();

 foreach($speciaaaetufilsp as $key => $val){}
 $sqlcycl11="SELECT id FROM {cycle} ";
 $cyclllle1=$DB->get_records_sql($sqlcycl11);

 $tarsppsometulibefilsp=array();
 $tarsppsometufilsp=array();
foreach($cyclllle1 as $key =>$cysp)
        {
    $sqlsommeetufilsp="SELECT sum(montant) as entrees  FROM {inscription} i,{paiement} pa
                       WHERE i.id=pa.idinscription AND idspecialite ='".$val->id."' AND idcycle='".$cysp->id."' AND idanneescolaire='".$_GET["annee"]."'";
    $sqlsommeetulibfilsp="SELECT libellecycle FROM {inscription} i,{cycle} cy
                          WHERE cy.id=i.idcycle AND idspecialite ='".$val->id."' AND idcycle='".$cysp->id."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $sppsometulibefilsp=$DB->get_records_sql($sqlsommeetulibfilsp);
    $sppsometufilsp=$DB->get_records_sql($sqlsommeetufilsp);
    
    
                foreach($sppsometufilsp as $key => $pp)
                {
                //   var_dump($pp->entrees);
                $tarsppsometulibefilsp[]=$pp->entrees;
              }
            foreach($sppsometulibefilsp as $key => $pp1)
              {
                if($pp1->libellecycle)
                {

                    $tarsppsometufilsp[]=$pp1->libellecycle;
                }
              }

            //   var_dump($tarsppsometulibefilsp,$tarsppsometufilsp);

}  



// $filspepr="SELECT * FROM {specialite} WHERE idfiliere=1";

// $speciaaa=$DB->get_records_sql($sqlpso);
// $data = array();
// foreach($speciaaa as $key => $val){
    // die;
    $sqlcycetucy="SELECT id FROM {cycle} cy WHERE id='".$_GET["cycle"]."'";

    $cycleeeetudetcy=$DB->get_records_sql($sqlcycetucy);
    $datacyetudet = array();

    // var_dump($cycleeeetudet);
    $sommecycy=array();
    $libellecycy=array();
 foreach($cycleeeetudetcy as $key => $val){}
    $sqlsp1="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."'";
    $spec1=$DB->get_records_sql($sqlsp1);
    foreach($spec1 as $key => $sp){

        $sqlsommecyetudetcy="SELECT SUM(montant) as entrees FROM {inscription} i,{paiement} p
                             WHERE idcycle ='".$val->id."' AND idspecialite='".$sp->id."' AND p.idinscription=i.id AND idanneescolaire='".$_GET["annee"]."'";
        $sqllibelcyetudetcy="SELECT libellespecialite FROM {specialite} sp,{inscription} i
                             WHERE sp.id=i.idspecialite AND idcycle ='".$val->id."' AND idspecialite='".$sp->id."' AND idanneescolaire='".$_GET["annee"]."'";
        // $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
        //          WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere =1 AND 
        //          idcycle ='".$val->idcy."'";
      
        $cyypsometudetcy=$DB->get_records_sql($sqlsommecyetudetcy);
        // var_dump($cyypsometudetcy);die;
        $cyypcyetudetcy=$DB->get_records_sql($sqllibelcyetudetcy);
        
        foreach($cyypsometudetcy as $key => $libcy)
        {
            $sommecycy[]=$libcy->entrees;
        }
        foreach($cyypcyetudetcy as $key => $libcy1)
        {
            if($libcy1->libellespecialite)
            {

                $libellecycy[]=$libcy1->libellespecialite;
            }
        }
        // var_dump($libellecycy, $sommecycy);
    }
  
// }
    // die;

 // Statistique Sur les etudiants
   ///global
 $sqlpsoetu="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."'";

    $speciaaaetu=$DB->get_records_sql($sqlpsoetu);
    $dataetu = array();
 foreach($speciaaaetu as $key => $val){
    $sqlsommeetu="SELECT count(i.id) as entrees  FROM {inscription} i
             WHERE idspecialite ='".$val->id."' AND idanneescolaire='".$_GET["annee"]."'";
    $sqlsommeetulib="SELECT distinct libellespecialite FROM {inscription} i,{specialite} sp
             WHERE sp.id=i.idspecialite AND idspecialite ='".$val->id."' AND idanneescolaire='".$_GET["annee"]."'";
    
    $sppsometulibe=$DB->get_recordset_sql($sqlsommeetulib);
    $sppsometu=$DB->get_recordset_sql($sqlsommeetu);
    
    // var_dump($sppsometu);

    // Parcourez les résultats et ajoutez-les au tableau de données
    foreach ($sppsometu as $result) {
    }
    $entrees1[] = $result->entrees;
    foreach ($sppsometulibe as $result1) {
    }
    $specialite[] = $result1->libellespecialite;
    // $dataetu[] = array(
    //     'specialite' => $result1->libellespecialite,
    //     'entrees' => $result->entrees
    // );
      
}
//    die;
//cycle
$sqlcycetu="SELECT cy.id as idcy FROM {cycle} cy";

    $cycleeeetu=$DB->get_records_sql($sqlcyc);
    $datacyetu = array();
 foreach($cycleeeetu as $key => $val){
    $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi
                    WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$_GET["filiere"]."' AND 
                    idcycle ='".$val->idcy."' AND idanneescolaire='".$_GET["annee"]."'";
    // $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
    //          WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere =1 AND 
    //          idcycle ='".$val->idcy."'";
    
    $cyypsometu=$DB->get_records_sql($sqlsommecyetu);
    
    // var_dump($cyypsometu);

    // Parcourez les résultats et ajoutez-les au tableau de données
    foreach ($cyypsometu as $result) {
     if($result->libellecycle)
        $datacyetu[] = array(
            'cycle' => $result->libellecycle,
            'entrees' => $result->entrees
        );
    }
      
}
// die;
        // foreach($sppsom as $key => $etuu){
        //     $etu->specialite=$etuu->libellespecialite."....";
        // }
    
        //details
// die;
        $sqlpsoetudet="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."' AND id='".$_GET["specialite"]."'";

    $speciaaaetudet=$DB->get_records_sql($sqlpsoetudet);
    // $dataetudet = array();
    $specialiteentreesdet1=array();
    $specialitelibelle=array();
 foreach($speciaaaetudet as $key => $vall){}
    // $sqlsommeetu="SELECT count(i.id) as entrees  FROM {inscription} i
    //          WHERE idspecialite ='".$val->id."'";
     $sqlcycl1="SELECT id FROM {cycle} ";
     $cyclllle=$DB->get_records_sql($sqlcycl1);
 foreach($cyclllle as $key =>$cysp)
            {

                $sqlsommeetulibdet="SELECT count(idetudiant) as entrees FROM {inscription} i
                                    WHERE idcycle='".$cysp->id."' AND idspecialite ='".$vall->id."' AND idanneescolaire='".$_GET["annee"]."'";
                
                $sqllibelletulibdet="SELECT libellecycle FROM {inscription} i,{cycle} cy
                                     WHERE cy.id=i.idcycle AND idcycle='".$cysp->id."' AND idspecialite ='".$vall->id."' AND idanneescolaire='".$_GET["annee"]."'";
                
                $sppsometulibedet=$DB->get_records_sql($sqlsommeetulibdet);
                $spplibeltulibedet=$DB->get_records_sql($sqllibelletulibdet);
                // $sppsometu=$DB->get_recordset_sql($sqlsommeetu);
                
                // var_dump($sppsometu);
            
                // Parcourez les résultats et ajoutez-les au tableau de données
                foreach ($sppsometulibedet as $key=>$result) {
                    $specialiteentreesdet1[] = $result->entrees;
                }
                foreach ($spplibeltulibedet as $key=>$result1) {
                    $specialitelibelle[] = $result1->libellecycle;
                }
                // foreach ($sppsometulibedet as $result) {
                //     $dataetudet[] = array(
                //         'specialite' => $result->libellecycle,
                //         'entrees' => $result->entrees
                //     );
                // }
            }
      
    //   var_dump($specialitelibelle);
//    die;
//Ici le diagramme de specialite est donné en connaissant la filiere et le cyle
$sqlcycetu="SELECT id FROM {cycle} cy WHERE id='".$_GET["cycle"]."'";

    $cycleeeetudet=$DB->get_records_sql($sqlcycetu);
    $datacyetudet = array();

    // var_dump($cycleeeetudet);
 foreach($cycleeeetudet as $key => $val){}
    $sqlsp="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."'";
    $spec=$DB->get_records_sql($sqlsp);
    foreach($spec as $key => $sp){

        $sqlsommecyetudet="SELECT count(idetudiant) as entrees FROM {inscription} i
                        WHERE idcycle ='".$val->id."' AND idspecialite='".$sp->id."' AND idanneescolaire='".$_GET["annee"]."'";
        $sqllibelcyetudet="SELECT libellespecialite FROM {specialite} sp,{inscription} i
                        WHERE sp.id=i.idspecialite AND idcycle ='".$val->id."' AND idspecialite='".$sp->id."' AND idanneescolaire='".$_GET["annee"]."'";
        // $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
        //          WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere =1 AND 
        //          idcycle ='".$val->idcy."'";
        
        $cyypsometudet=$DB->get_records_sql($sqlsommecyetudet);
        $cyypcyetudet=$DB->get_records_sql($sqllibelcyetudet);
        
        foreach($cyypsometudet as $key => $libcy)
        {
            $sommecy[]=$libcy->entrees;
        }
        foreach($cyypcyetudet as $key => $libcy1)
        {
            $libellecy[]=$libcy1->libellespecialite;
        }
        // var_dump($libcy->entrees,$libcy1->libellespecialite);
    }
    // Parcourez les résultats et ajoutez-les au tableau de données
    // foreach ($cyypsometudet as $result1) {
        //     $datacyetudet[] = array(
            //         'cycle' => $result1->libellespecialite,
            //         'entrees' => $result1->entrees
            //     );
            // }
            // var_dump( $libellecy,$sommecy);
            // die;
      

// die;
//    $aninsc=$DB->get_records("inscription");


// foreach($aninsc as $key => $valll)  {}
//     $startDateObj = new DateTime();
//     $startDateObj->setTimestamp($valll->timecreated);
//     $daeche = $startDateObj->format('Y-m-d H:i:s');
//  var_dump($startDateObj);
// die;
    $sqlsommefil="SELECT DATE_FORMAT(FROM_UNIXTIME(p.timecreated), '%M') AS mois, SUM(montant) AS total
                    FROM {inscription} i
                    JOIN {specialite} sp ON i.idspecialite = sp.id
                    JOIN {paiement} p ON p.idinscription = i.id
                    WHERE idanneescolaire = '".$_GET["annee"]."'
                    ";
            $sqlanne=$DB->get_records_sql($sqlsommefil);
            // var_dump($sqlanne);
            // die;
            $dateannne=[];
            foreach($sqlanne as $key =>$anneee)
            {
                $dateannne[] = array(
                            'mois' => $anneee->mois,
                            'entrees' => $anneee->total
                        );
            }

            $filiere=$DB->get_records("filiere");
            $campus=$DB->get_records("campus");
            $specialite=$DB->get_records("specialite");
            $cycle=$DB->get_records("cycle");
            $annee=$DB->get_records_sql("SELECT * FROM {anneescolaire}");
            foreach($annee as $key => $ab)
            {
                $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
            }
            // var_dump($ab->datedebut = $dated,
            // $ab->datefin = $datef);die;


    // Statistique de l'age 

//     $sqlpsoetuage="SELECT * FROM {specialite} WHERE idfiliere='".$_GET["filiere"]."'";

//     $speciaaaetuage=$DB->get_records_sql($sqlpsoetuage);
//     $dataetuage = array();
//  foreach($speciaaaetuage as $key => $val){
//     $sqlsommeetuage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age
//     FROM mdl_inscription i
//     INNER JOIN mdl_specialite s ON i.idspecialite = s.id
//     WHERE s.id ='".$val->id."'";
//     $sqlsommeetulibage="SELECT distinct libellespecialite FROM {inscription} i,{specialite} sp
//              WHERE sp.id=i.idspecialite AND idspecialite ='".$val->id."'";
    
//     $sppsometulibeage=$DB->get_recordset_sql($sqlsommeetulibage);
//     $sppsometuage=$DB->get_recordset_sql($sqlsommeetuage);
    
    
//     // Parcourez les résultats et ajoutez-les au tableau de données
//     foreach ($sppsometuage as $result) {
//     }
//     $entrees1[] = $result->age;
//     var_dump($entrees1);
//     foreach ($sppsometulibe as $result1) {
//     }
//     $specialite[] = $result1->libellespecialite;
//     // $dataetu[] = array(
//     //     'specialite' => $result1->libellespecialite,
//     //     'entrees' => $result->entrees
//     // );
      
// }
//    die;
//cycle
// $sqlcycetu="SELECT cy.id as idcy FROM {cycle} cy";

//     $cycleeeetu=$DB->get_records_sql($sqlcyc);
//     $datacyetu = array();
//  foreach($cycleeeetu as $key => $val){
//     $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi
//                     WHERE fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere ='".$_GET["filiere"]."' AND 
//                     idcycle ='".$val->idcy."'";
//     // $sqlsommecyetu="SELECT count(idetudiant) as entrees,libellecycle  FROM {specialite} sp,{cycle} cy,{inscription} i,{filiere} fi,{paiement} pa 
//     //          WHERE i.id=pa.idinscription AND fi.id=sp.idfiliere AND i.idcycle=cy.id AND sp.id=i.idspecialite AND sp.idfiliere =1 AND 
//     //          idcycle ='".$val->idcy."'";
    
//     $cyypsometu=$DB->get_records_sql($sqlsommecyetu);
    
//     // var_dump($cyypsometu);

//     // Parcourez les résultats et ajoutez-les au tableau de données
//     foreach ($cyypsometu as $result) {
//         $datacyetu[] = array(
//             'cycle' => $result->libellecycle,
//             'entrees' => $result->entrees
//         );
//     }
// }

// Par raport a une filiere
// die;

if(!empty($_GET["gender"]))
{

    $sqlsommefilage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                    FROM  {inscription} i
                    INNER JOIN {specialite} s ON i.idspecialite = s.id
                    INNER JOIN  {filiere} f ON s.idfiliere = f.id
                    WHERE f.id='".$_GET["filiere"]."' AND idanneescolaire='".$_GET["annee"]."'
                    AND gender='".$_GET["gender"]."'";
}
else{

    $sqlsommefilage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                    FROM  {inscription} i
                    INNER JOIN {specialite} s ON i.idspecialite = s.id
                    INNER JOIN  {filiere} f ON s.idfiliere = f.id
                    WHERE f.id='".$_GET["filiere"]."' AND idanneescolaire='".$_GET["annee"]."'
                    ";
}
// 934104420

            $sqlanneagefi=$DB->get_records_sql($sqlsommefilage);
    
            // var_dump($sqlanneage);

            foreach($sqlanneagefi as $key => $vallle)
            {
                            if(!empty($_GET["gender"]))
                    {

                        $sqlcountfilage="SELECT count(i.id) cou
                                FROM  {inscription} i
                                INNER JOIN {specialite} s ON i.idspecialite = s.id
                                INNER JOIN  {filiere} f ON s.idfiliere = f.id
                                WHERE f.id='".$_GET["filiere"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                                AND gender='".$_GET["gender"]."'";
                    }
                    else{

                        $sqlcountfilage="SELECT count(i.id) cou
                                FROM  {inscription} i
                                INNER JOIN {specialite} s ON i.idspecialite = s.id
                                INNER JOIN  {filiere} f ON s.idfiliere = f.id
                                WHERE f.id='".$_GET["filiere"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                                ";
                    }
                        
                        
                        $tarfilieresomeage[]=$vallle->datena;
                        $sqlannecountage=$DB->get_records_sql($sqlcountfilage);
                        // var_dump($sqlannecountage,$vallle->datena);
                        foreach($sqlannecountage as $key => $valllle)
                        {
                   
                            $tarfilierecountage[]=$valllle->cou;
                        }
    }
// par rapport à une specialité
// die;
if(!empty($_GET["gender"]))
{

    $sqlsommefilspage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                    FROM  {inscription} i
                    INNER JOIN {specialite} s ON i.idspecialite = s.id
                    INNER JOIN  {filiere} f ON s.idfiliere = f.id
                    WHERE f.id='".$_GET["filiere"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."'
                    AND gender='".$_GET["gender"]."'
                    ";
}
else{

    $sqlsommefilspage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                    FROM  {inscription} i
                    INNER JOIN {specialite} s ON i.idspecialite = s.id
                    INNER JOIN  {filiere} f ON s.idfiliere = f.id
                    WHERE f.id='".$_GET["filiere"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."'
                    ";
}
// 934104420

            $sqlanneagesp=$DB->get_records_sql($sqlsommefilspage);
    
            // var_dump($sqlanneage);

            foreach($sqlanneagesp as $key => $vallle)
            {
                if(!empty($_GET["gender"]))
                {

                    $sqlcountfilagesp="SELECT count(i.id) cou,libellespecialite
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            WHERE f.id='".$_GET["filiere"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            AND gender='".$_GET["gender"]."'";
                }else{

                    $sqlcountfilagesp="SELECT count(i.id) cou,libellespecialite
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            WHERE f.id='".$_GET["filiere"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            ";
                }
                        
                        
                        $tarfilieresomeagesp[]=$vallle->datena;
                        $sqlannecountagesp=$DB->get_records_sql($sqlcountfilagesp);
                        // var_dump($sqlannecountagesp,$vallle->datena);
                        foreach($sqlannecountagesp as $key => $valllle)
                        {
                   
                            $tarfilierecountagesp[]=$valllle->cou;
                        }
    }

    // par rapport à un cycle
    // die;
    if(!empty($_GET["gender"]))
    {

        $sqlsommefilcyage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                        FROM  {inscription} i
                        INNER JOIN {specialite} s ON i.idspecialite = s.id
                        INNER JOIN  {filiere} f ON s.idfiliere = f.id
                        INNER JOIN  {cycle} c ON i.idcycle = c.id
                        WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND idanneescolaire='".$_GET["annee"]."'
                        AND gender='".$_GET["gender"]."'
                        ";
    }
    else{

        $sqlsommefilcyage="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                        FROM  {inscription} i
                        INNER JOIN {specialite} s ON i.idspecialite = s.id
                        INNER JOIN  {filiere} f ON s.idfiliere = f.id
                        INNER JOIN  {cycle} c ON i.idcycle = c.id
                        WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND idanneescolaire='".$_GET["annee"]."'
                        ";
    }
// 934104420

            $sqlanneagecy=$DB->get_records_sql($sqlsommefilcyage);
    
            // var_dump($sqlanneage);

            foreach($sqlanneagecy as $key => $vallle)
            {
        
                if(!empty($_GET["gender"]))
                {
                    $sqlcountfilagecy="SELECT count(i.id) cou,libellecycle
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            INNER JOIN  {cycle} c ON i.idcycle = c.id
                            WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            AND gender='".$_GET["gender"]."'";

                }else{

                    $sqlcountfilagecy="SELECT count(i.id) cou,libellecycle
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            INNER JOIN  {cycle} c ON i.idcycle = c.id
                            WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            ";
                }
                        
                        
                        $tarfilieresomeagecy[]=$vallle->datena;
                        $sqlannecountagecy=$DB->get_records_sql($sqlcountfilagecy);
                        // var_dump($sqlannecountagecy,$vallle->datena);
                        foreach($sqlannecountagecy as $key => $valllle)
                        {
                   
                            $tarfilierecountagecy[]=$valllle->cou;
                        }
    }
    // par rapport à un specialite et cycle specifique
    // die;
    if(!empty($_GET["gender"]))
    {

        $sqlsommefilcyagesp="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                        FROM  {inscription} i
                        INNER JOIN {specialite} s ON i.idspecialite = s.id
                        INNER JOIN  {filiere} f ON s.idfiliere = f.id
                        INNER JOIN  {cycle} c ON i.idcycle = c.id
                        WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."'
                        AND gender='".$_GET["gender"]."'
                        ";
        }
    else{
        $sqlsommefilcyagesp="SELECT YEAR(NOW()) - YEAR(FROM_UNIXTIME(i.date_naissance)) AS age,YEAR(FROM_UNIXTIME(i.date_naissance)) as datena
                        FROM  {inscription} i
                        INNER JOIN {specialite} s ON i.idspecialite = s.id
                        INNER JOIN  {filiere} f ON s.idfiliere = f.id
                        INNER JOIN  {cycle} c ON i.idcycle = c.id
                        WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."'
                        ";

    }
// 934104420

            $sqlanneagecysp=$DB->get_records_sql($sqlsommefilcyagesp);
    
            // var_dump($sqlanneage);

            foreach($sqlanneagecysp as $key => $vallle)
            {
                if(!empty($_GET["gender"]))
                {

                    $sqlcountfilagecysp="SELECT count(i.id) cou
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            INNER JOIN  {cycle} c ON i.idcycle = c.id
                            WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            AND gender='".$_GET["gender"]."'";
                } 
                else{

                    $sqlcountfilagecysp="SELECT count(i.id) cou
                            FROM  {inscription} i
                            INNER JOIN {specialite} s ON i.idspecialite = s.id
                            INNER JOIN {filiere} f ON s.idfiliere = f.id
                            INNER JOIN  {cycle} c ON i.idcycle = c.id
                            WHERE f.id='".$_GET["filiere"]."' AND c.id='".$_GET["cycle"]."' AND s.id='".$_GET["specialite"]."' AND idanneescolaire='".$_GET["annee"]."' AND YEAR(FROM_UNIXTIME(i.date_naissance))='".$vallle->datena."'
                            ";
                }
                        
                        
                        $tarfilieresomeagecysp[]=$vallle->datena;
                        $sqlannecountagecysp=$DB->get_records_sql($sqlcountfilagecysp);
                        // var_dump($sqlannecountagecy,$vallle->datena);
                        foreach($sqlannecountagecysp as $key => $valllle)
                        {
                   
                            $tarfilierecountagecysp[]=$valllle->cou;
                        }
    }
    //  var_dump($tarfilierecountage);


            // die;
            // $dateannne=[];
            // {
            //     $dateannne[] = array(
            //                 'mois' => $anneee->mois,
            //                 'entrees' => $anneee->total
            //             );
            // }

            // $filiere=$DB->get_records("filiere");
            // $campus=$DB->get_records("campus");
            // $specialite=$DB->get_records("specialite");
            // $cycle=$DB->get_records("cycle");
            // $annee=$DB->get_records_sql("SELECT * FROM {anneescolaire}");
            // foreach($annee as $key => $ab)
            // {
            //     $time = $ab->datedebut;
            //     $timef = $ab->datefin;

            //     $dated = date('Y',$time);
            //     $datef = date('Y',$timef);

            //     $ab->datedebut = $dated;
            //     $ab->datefin = $datef;
            // }

  // Statistique pour les notes
      //par filiere
//      
$tanoteefiliere=array();
$hhfiliere=$DB->get_records_sql("SELECT fi.id,fi.libellefiliere FROM {inscription} i,{specialite} sp,{filiere} fi
                                 WHERE i.idspecialite=sp.id AND fi.id=sp.idfiliere AND fi.idcampus='".$_GET["campus"]."'");

foreach($hhfiliere as $key => $filll)
{
    $moyennespe=0;
    
//  die;   
    $sql1="SELECT idetudiant FROM {inscription} i,{user} u,{specialite} sp,{cycle} cy,{filiere} fi WHERE i.idetudiant=u.id
        AND i.idcycle=cy.id AND sp.id=idspecialite AND sp.idfiliere=fi.id AND fi.id='".$filll->id."'";
        
        $sql2c="SELECT count(DISTINCT idetudiant) coutet FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se,{filiere} fi
        WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND spe.idfiliere=fi.id AND cs.idsemestre='".$_GET["semestre"]."'
        AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND fi.id='".$filll->id."'";
        $counttt=$DB->get_records_sql($sql2c);
        $inscription=$DB->get_records_sql($sql1);
        // var_dump($inscription);die;
        // var_dump($counttt);
        // die;
        
        
        $rolecam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} ty WHERE c.idtypecampus=ty.id AND c.id='".$_GET["campus"]."'");
        foreach($inscription as $key => $vvallno)
        {   $i=0;
            $sommenote=0;
            $sommecredi=0;
            foreach($rolecam as $key => $rolev)
            {}
            
            // $user=$DB->get_records("user");
            // foreach($user as $key)
            // {
                $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se
                    WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND cs.idsemestre='".$_GET["semestre"]."'
                    AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND li.idetudiant='".$vvallno->idetudiant."'";
        
        $gromoy=$DB->get_records_sql($sqlli);
        // die;
            foreach($gromoy as $key =>$keynote)
            {   
            
            
            if($keynote->idetudiant==$vvallno->idetudiant)  
            {
                
                //     $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
            
                //     foreach($pourcent as $key =>$pou)
                //     {}
                //     $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                //     $sommecredi=$sommecredi+$keynote->credit;
                //     // $nobret++;
                // if($sommecredi!=0)
                // {

                //     $moyenne=$sommenote/$sommecredi;
                //     $vvallno->moyenne_semestre=round($moyenne,2);
                // }

                if($rolev->libelletype=="universite")
                {
                        $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                
                        foreach($pourcent as $key =>$pou)
                        {}
                        $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                        $sommecredi=$sommecredi+$keynote->credit;
                }// $nobret++;
            else if($rolev->libelletype=="college" || $rolev->libelletype=="lycee")
                {
                    $sommenote=$sommenote+($keynote->note3*$keynote->credit);
                    $sommecredi=$sommecredi+$keynote->credit;
                }
            else 
                {
                    $sommenote=$sommenote+$keynote->note3;
                    $i++;
                }
                if($sommecredi!=0)
                {
                    
                    $moyenne=$sommenote/$sommecredi;
                    $vvallno->moyenne_semestre=round($moyenne,2);
                    
                }else
                {
                    if($i!=0)
                    {
                        $moyenne=$sommenote/$i;
                        $vvallno->moyenne_semestre=round($moyenne,2);
                    }

                }
                
                
            }
            
        }
    
    $moyennespe=$moyennespe+$vvallno->moyenne_semestre;
    // var_dump($moyennespe);
}

    // die;
        
        // foreach($hhfiliere as $key=>$mofil )
        // {}
        if($filll->libellefiliere!=null)
        {
            foreach($counttt as $mm){}
            if($mm->coutet!=0)
            {

                $moyennespe=round($moyennespe/$mm->coutet,2);
        
                $tanoteefiliere[]=[
                    "libelle"=>$filll->libellefiliere,
                    "moyenne"=>$moyennespe
                ];
            }
        }
        // var_dump($tanotee);
}
    // die;
  //connaissant la filiere et la specialite



//   $specialitefiliere=$DB->get_records_sql("SELECT * FROM {filiere} WHERE id='".$_GET["filiere"]."' AND idcampus='".$_GET["campus"]."'");
//   foreach($specialitefiliere as $key=>$valn)
//   {}
//   $specialitefilierenote=$DB->get_records_sql("SELECT * FROM {specialite} WHERE idfiliere='".$valn->id."'");
//     // var_dump($specialitefilierenote);die;
// foreach($specialitefilierenote as $key =>$valspfil)
// {


//       $sqlnotespeciafil="SELECT
//       S.libellespecialite AS libellespecial,
//       ROUND(SUM(((LN.note2 * CSp.credit) * '".$bb->cc."' + ((LN.note3 * CSp.credit) * '".$bb->normal."')))/SUM(CSp.credit),2) AS moyenne
//         FROM
//             {listenote} LN
//         JOIN
//             {affecterprof} AP ON LN.idaffecterprof = AP.id
//         JOIN
//             {user} U ON AP.idprof = U.id
//         JOIN
//             {courssemestre} CS ON AP.idcourssemestre = CS.id
//         JOIN
//             {coursspecialite} CSp ON CS.idcoursspecialite = CSp.id
//         JOIN
//             {specialite} S ON CSp.idspecialite = S.id
//         JOIN
//             {filiere} F ON S.idfiliere = F.id
//         WHERE S.id='".$valspfil->id."'
//   ";
//   $notespeciafil=$DB->get_records_sql($sqlnotespeciafil);

//   foreach($notespeciafil as $key =>$bppp)
//   {
//       if($bppp->libellespecial!=null || $bppp->moyenne!=0)
//       {
  
//           $tanoteefilsp=[
//               "libelle"=>$bppp->libellespecial,
//               "moyenne"=>$bppp->moyenne
//           ];
//         //   var_dump($tanoteefilsp);
//       }
//   }
// //   var_dump($notespeciafil);
// }
//   die;


$noteefilieresp=array();
$hhfilieresp=$DB->get_records_sql("SELECT fi.id,cy.libellecycle FROM {inscription} i,{specialite} sp,{filiere} fi,{cycle} cy
                                 WHERE cy.id=i.idcycle AND i.idspecialite=sp.id AND fi.id='".$_GET["filiere"]."' AND fi.idcampus='".$_GET["campus"]."'");
$cyclesql=$DB->get_records("cycle",array("idcampus"=>$_GET["campus"]));

foreach($cyclesql as $keyy){
        foreach($hhfilieresp as $key => $filll)
        {
            $moyennespefil=0;
            

                $sql1="SELECT idetudiant FROM {inscription} i,{user} u,{cycle} cy,{filiere} fi,{specialite} sp WHERE i.idetudiant=u.id
                    AND i.idcycle=cy.id AND sp.idfiliere=fi.id AND sp.id='".$_GET["specialite"]."' AND fi.id='".$filll->id."' AND i.idspecialite='".$_GET["specialite"]."' AND cy.id='".$keyy->id."'";
                    
            
            // die;
                $sql2c="SELECT count(DISTINCT idetudiant) coutet FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se,{filiere} fi
                WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND spe.idfiliere=fi.id
                AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND fi.id='".$filll->id."' AND sp.idspecialite='".$_GET["specialite"]."' AND se.id='".$_GET["semestre"]."' AND cy.id='".$keyy->id."'";
                $counttt=$DB->get_records_sql($sql2c);
                // die;
                $inscriptionsp=$DB->get_records_sql($sql1);
                // var_dump($inscription);die;
                // var_dump($counttt);
                // die;
                
                $rolecam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} ty WHERE c.idtypecampus=ty.id AND c.id='".$_GET["campus"]."'");
                foreach($inscriptionsp as $key => $vvallno)
                {   $i=0;
                    $sommenote=0;
                    $sommecredi=0;
                    foreach($rolecam as $key => $rolev)
                    {}
                  
                    // $user=$DB->get_records("user");
                    // foreach($user as $key)
                    // {
                        $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se
                            WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND cs.idsemestre='".$_GET["semestre"]."'
                            AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND li.idetudiant='".$vvallno->idetudiant."' AND sp.idspecialite='".$_GET["specialite"]."'";
                
                $gromoy=$DB->get_records_sql($sqlli);
                // die;
                    foreach($gromoy as $key =>$keynote)
                    {   
                    
                    
                    if($keynote->idetudiant==$vvallno->idetudiant)  
                    {
                        
                            // $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                    
                            // foreach($pourcent as $key =>$pou)
                            // {}
                            // $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                            // $sommecredi=$sommecredi+$keynote->credit;
                            // // $nobret++;
                            // if($sommecredi!=0)
                            // {

                            //     $moyennenotesp=$sommenote/$sommecredi;
                            //     $vvallno->moyenne_semestre=round($moyennenotesp,2);
                                
                            // }

                            if($rolev->libelletype=="universite")
                            {
                                    $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                            
                                    foreach($pourcent as $key =>$pou)
                                    {}
                                    $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                                    $sommecredi=$sommecredi+$keynote->credit;
                            }// $nobret++;
                        else if($rolev->libelletype=="college" || $rolev->libelletype=="lycee")
                            {
                                $sommenote=$sommenote+($keynote->note3*$keynote->credit);
                                $sommecredi=$sommecredi+$keynote->credit;
                            }
                        else 
                            {
                                $sommenote=$sommenote+$keynote->note3;
                                $i++;
                            }
                            if($sommecredi!=0)
                            {
                                
                                $moyennenotesp=$sommenote/$sommecredi;
                                $vvallno->moyenne_semestre=round($moyennenotesp,2);
                                
                            }else
                            {
                                if($i!=0)
                                {

                                    $moyennenotesp=$sommenote/$i;
                                    $vvallno->moyenne_semestre=round($moyennenotesp,2);
                                }

                            }
                        
                    }
                    
                }
            
            $moyennespefil=$moyennespefil+$vvallno->moyenne_semestre;
            // var_dump($moyennespe);
        }

            // die;
                
                // foreach($hhfiliere as $key=>$mofil )
                // {}
                if($filll->libellecycle!=null)
                {
                    foreach($counttt as $mm){}
                    if($mm->coutet!=0)
                    {

                        $moyennespefil=round($moyennespefil/$mm->coutet,2);
                
                        $tanoteefilierespec[]=[
                            "libelle"=>$keyy->libellecycle,
                            "moyenne"=>$moyennespefil
                        ];
                    }
                }
            }
}
// die();
  //connaissant la filiere et le cycle

  $noteefilierecy=array();
$hhfilierecy=$DB->get_records_sql("SELECT fi.id,sp.libellespecialite FROM {inscription} i,{specialite} sp,{filiere} fi,{cycle} cy
                                 WHERE cy.id=i.idcycle AND i.idspecialite=sp.id AND fi.id='".$_GET["filiere"]."' AND cy.id='".$_GET["cycle"]."' AND fi.idcampus='".$_GET["campus"]."'");
$specialsql=$DB->get_records_sql("SELECT sp.id,libellespecialite FROM {specialite} sp,{filiere} fi
                            WHERE sp.idfiliere=fi.id AND fi.idcampus='".$_GET["campus"]."' AND fi.id='".$_GET["filiere"]."'");
// die;

foreach($specialsql as $keyy){
        foreach($hhfilierecy as $key => $filll)
        {
            $moyennecycfil=0;
            

                $sql1="SELECT idetudiant FROM {inscription} i,{user} u,{cycle} cy,{filiere} fi,{specialite} sp WHERE i.idetudiant=u.id
                    AND i.idcycle=cy.id AND sp.idfiliere=fi.id AND fi.id='".$filll->id."' AND i.idspecialite='".$keyy->id."' AND cy.id='".$_GET["cycle"]."'";
                    
            
            // die;
                $sql2c="SELECT count(DISTINCT idetudiant) coutet FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se,{filiere} fi
                WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND spe.idfiliere=fi.id
                AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND fi.id='".$filll->id."' AND sp.idcycle='".$_GET["cycle"]."' AND se.id='".$_GET["semestre"]."' AND spe.id='".$keyy->id."'";
                $counttt=$DB->get_records_sql($sql2c);
                // die;
                $inscriptioncy=$DB->get_records_sql($sql1);
                // var_dump($inscription);die;
                // var_dump($counttt);
                
                
                $rolecam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} ty WHERE c.idtypecampus=ty.id AND c.id='".$_GET["campus"]."'");
                foreach($inscriptioncy as $key => $vvallno)
                {   $i=0;
                    $sommenote=0;
                    $sommecredi=0;
                    foreach($rolecam as $key => $rolev)
                    {}
                    
                    // $user=$DB->get_records("user");
                    // foreach($user as $key)
                    // {
                        $sqlli="SELECT note2,credit,note3,idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se
                            WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND cs.idsemestre='".$_GET["semestre"]."'
                            AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND li.idetudiant='".$vvallno->idetudiant."' AND cy.id='".$_GET["cycle"]."'";
                
                $gromoy=$DB->get_records_sql($sqlli);
                    foreach($gromoy as $key =>$keynote)
                    {   
                    
                    
                    if($keynote->idetudiant==$vvallno->idetudiant)  
                    {
                        
                            // $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                    
                            // foreach($pourcent as $key =>$pou)
                            // {}
                            // $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                            // $sommecredi=$sommecredi+$keynote->credit;
                            // // $nobret++;
                            // if($sommecredi!=0)
                            // {
                                
                            //     $moyennenotecy=$sommenote/$sommecredi;
                            //     $vvallno->moyenne_semestre=round($moyennenotecy,2);
                                
                            // }
                            if($rolev->libelletype=="universite")
                                    {
                                            $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                                    
                                            foreach($pourcent as $key =>$pou)
                                            {}
                                            $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                                            $sommecredi=$sommecredi+$keynote->credit;
                                    }// $nobret++;
                                else if($rolev->libelletype=="college" || $rolev->libelletype=="lycee")
                                    {
                                        $sommenote=$sommenote+($keynote->note3*$keynote->credit);
                                        $sommecredi=$sommecredi+$keynote->credit;
                                    }
                                else 
                                    {
                                        $sommenote=$sommenote+$keynote->note3;
                                        $i++;
                                    }
                                    if($sommecredi!=0)
                                    {
                                        
                                        $moyennenotecy=$sommenote/$sommecredi;
                                        $vvallno->moyenne_semestre=round($moyennenotecy,2);
                                        
                                    }else
                                    {
                                        if($i!=0)
                                        {
                                            $moyennenotecy=$sommenote/$i;
                                            $vvallno->moyenne_semestre=round($moyennenotecy,2);
                                        }

                                    }
                        
                        // var_dump($vvallno->idetudiant,$moyennenotecy);
                    }
                    
                }
            
            $moyennecycfil=$moyennecycfil+$vvallno->moyenne_semestre;
            // var_dump($moyennespe);
        }

            // die;
                
                // foreach($hhfiliere as $key=>$mofil )
                // {}
                if($filll->libellespecialite!=null)
                {
                    
                    foreach($counttt as $mm){
                            if($mm->coutet!=0)
                            {

                                $moyennecycfil=round($moyennecycfil/$mm->coutet,2);

                                // var_dump($mm->coutet);
                           }
                        }
                
                        $noteefilierecy[]=[
                            "libelle"=>$keyy->libellespecialite,
                            "moyenne"=>$moyennecycfil
                        ];
                }
            }
}

//connaissant la filiere la specialite le cycle
  $noteefilierecyspsal=array();
$salle=$DB->get_records("salle");

foreach($salle as $idsalllle)
{
$hhfilierecyspsal=$DB->get_records_sql("SELECT i.idetudiant FROM {inscription} i,{specialite} sp,{filiere} fi,{cycle} cy,{salleele} saa
                                 WHERE saa.idsalle='".$idsalllle->id."' AND saa.idetudiant=i.idetudiant AND cy.id=i.idcycle AND i.idspecialite=sp.id AND etudiantpresen=0
                                 AND sp.id='".$_GET["specialite"]."' AND fi.id='".$_GET["filiere"]."' AND cy.id='".$_GET["cycle"]."' AND fi.idcampus='".$_GET["campus"]."'");
$specialsqlcyspsal=$DB->get_records_sql("SELECT sp.id,libellespecialite FROM {specialite} sp,{filiere} fi
                            WHERE sp.idfiliere=fi.id AND fi.idcampus='".$_GET["campus"]."' AND fi.id='".$_GET["filiere"]."'");
// die;


// foreach($hhfilierecyspsal as $key => $filll)
// {
    $moyennecycfilspsal=0;
            
    
                $sql1="SELECT i.idetudiant FROM {inscription} i,{user} u,{cycle} cy,{filiere} fi,{specialite} sp,{salleele} saa WHERE i.idetudiant=u.id AND saa.idetudiant=i.idetudiant AND etudiantpresen=0
                    AND i.idcycle=cy.id AND sp.idfiliere=fi.id AND fi.id='".$_GET["filiere"]."' AND i.idspecialite='".$_GET["specialite"]."' AND cy.id='".$_GET["cycle"]."' AND saa.idsalle='".$idsalllle->id."'";
                    
            
            // die;
                $sql2c="SELECT count(DISTINCT li.idetudiant) coutet FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se,{filiere} fi,{salleele} saa
                WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND spe.idfiliere=fi.id AND saa.idetudiant=li.idetudiant AND saa.idsalle='".$idsalllle->id."' AND etudiantpresen=0
                AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND fi.id='".$_GET["filiere"]."' AND sp.idcycle='".$_GET["cycle"]."' AND se.id='".$_GET["semestre"]."' AND spe.id='".$_GET["specialite"]."'";
                $counttt=$DB->get_records_sql($sql2c);
                // die;
                $inscriptionspcyfil=$DB->get_records_sql($sql1);
                // var_dump($inscriptionspcyfil);
                // var_dump($counttt);
                
                
                $rolecam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} ty WHERE c.idtypecampus=ty.id AND c.id='".$_GET["campus"]."'");
                foreach($inscriptionspcyfil as $key => $vvallno)
                {   $i=0;// permet de connaitre le nombre de matiere
                    $sommenote=0; //permet de calculer la somme de chaque etudiant
                    $sommecredi=0;// permet de calculer la somme de credit de chaque etudiant
                    foreach($rolecam as $key => $rolev)
                    {}
                    
                    // $user=$DB->get_records("user");
                    // foreach($user as $key)
                    // {
                        $sqlli="SELECT note2,credit,note3,li.idetudiant FROM {coursspecialite} sp,{courssemestre} cs,{affecterprof} af,{listenote} li,{cycle} cy,{specialite} spe,{semestre} se,{salleele} saa
                            WHERE sp.id=cs.idcoursspecialite AND af.idcourssemestre=cs.id AND li.idaffecterprof=af.id AND sp.idspecialite=spe.id AND saa.idetudiant=li.idetudiant AND cs.idsemestre='".$_GET["semestre"]."'
                            AND saa.idsalle='".$idsalllle->id."' AND sp.idcycle=cy.id AND cs.idsemestre=se.id AND li.idetudiant='".$vvallno->idetudiant."' AND cy.id='".$_GET["cycle"]."' AND spe.id='".$_GET["specialite"]."'";
                
                $gromoy=$DB->get_records_sql($sqlli);
                    foreach($gromoy as $key =>$keynote)
                    {   
                    
                    
                            if($keynote->idetudiant==$vvallno->idetudiant)  
                            {
                                if($rolev->libelletype=="universite")
                                    {
                                            $pourcent=$DB->get_records("configurationnote",array("idcampus"=>$_GET["campus"]));
                                    
                                            foreach($pourcent as $key =>$pou)
                                            {}
                                            $sommenote=$sommenote+(($keynote->note2*($pou->cc/100))*$keynote->credit+($keynote->note3*($pou->normal/100))*$keynote->credit);
                                            $sommecredi=$sommecredi+$keynote->credit;
                                    }// $nobret++;
                                else if($rolev->libelletype=="college" || $rolev->libelletype=="lycee")
                                    {
                                        $sommenote=$sommenote+($keynote->note3*$keynote->credit);
                                        $sommecredi=$sommecredi+$keynote->credit;
                                    }
                                else 
                                    {
                                        $sommenote=$sommenote+$keynote->note3;
                                        $i++;
                                    }
                                    if($sommecredi!=0)
                                    {
                                        
                                        $moyennenotecyspsal=$sommenote/$sommecredi;
                                        $vvallno->moyenne_semestre=round($moyennenotecyspsal,2);
                                        
                                    }else
                                    {
                                        if($i!=0)
                                        {

                                            $moyennenotecyspsal=$sommenote/$i;
                                            $vvallno->moyenne_semestre=round($moyennenotecyspsal,2);
                                        }
                                      

                                    }
                                
                                // var_dump($vvallno->idetudiant,$vvallno->moyenne_semestre);
                            
                            
                        }
                     }
            $moyennecycfilspsal=$moyennecycfilspsal+$vvallno->moyenne_semestre;
            // var_dump($moyennespe);
        }

            // die;
                
                // foreach($hhfiliere as $key=>$mofil )
                // {}
                if($idsalllle->numerosalle!=null)
                {
                    
                    foreach($counttt as $mm){
                            if($mm->coutet!=0)
                            {

                                $moyennecycfilspsal=round($moyennecycfilspsal/$mm->coutet,2);

                                // var_dump($mm->coutet);
                           }
                        }
                
                        $noteefilierecyspsal[]=[
                            "libelle"=>$idsalllle->numerosalle,
                            "moyenne"=>$moyennecycfilspsal
                        ];
                    }
                    // }
                    
    }
                // var_dump($noteefilierecyspsal);
// die;
//   $cyclefiliere=$DB->get_records_sql("SELECT * FROM {cycle} WHERE idcampus='".$_GET["campus"]."'");

//   foreach($cyclefiliere as $key => $valcy)
//   {
//     $sqlnotecyclefil="SELECT
//     C.libellecycle AS libellecycle,
//     AVG((LN.note2 * 0.5 + LN.note3 * 0.5)) AS moyenne
//       FROM
//           {listenote} LN
//       JOIN
//           {affecterprof} AP ON LN.idaffecterprof = AP.id
//       JOIN
//           {user} U ON AP.idprof = U.id
//       JOIN
//           {courssemestre} CS ON AP.idcourssemestre = CS.id
//       JOIN
//           {coursspecialite} CSp ON CS.idcoursspecialite = CSp.id
//       JOIN
//           {cycle} C ON CSp.idcycle = C.id
//       JOIN
//           {specialite} S ON CSp.idspecialite = S.id
//       JOIN
//           {filiere} F ON S.idfiliere = F.id
//       WHERE C.id='".$valcy->id."' AND F.id='".$_GET["filiere"]."'
// ";
// $notecyclefil=$DB->get_records_sql($sqlnotecyclefil);
// // var_dump($notecyclefil);
//     foreach($notecyclefil as $key =>$bppp)
//     {
//         if($bppp->libellecycle!=null || $bppp->moyenne!=0)
//         {

//             $tanoteefilcy=[
//                 "libelle"=>$bppp->libellecycle,
//                 "moyenne"=>$bppp->moyenne
//             ];
//             // var_dump($tanoteefilcy);
//         }
//     }
//   }
//   die;

  //connaissant la filiere la specilite le cycle
$countuser=$DB->get_records("user");
foreach($countuser as $key => $count)
{

    $sqlnotecyclefilspec="SELECT
      F.libellefiliere AS libellefilie,
      C.libellecycle AS libellecycle,
      S.libellespecialite AS libellespecialite,
      COUNT(*) AS nombre_etudiants,
      ROUND(AVG((LN.note2 * 0.5 + LN.note3 * 0.5)),0) AS moyenne_arrondie
        FROM
            {listenote} LN
        JOIN
            {affecterprof} AP ON LN.idaffecterprof = AP.id
        JOIN
            {user} U ON AP.idprof = U.id
        JOIN
            {courssemestre} CS ON AP.idcourssemestre = CS.id
        JOIN
            {coursspecialite} CSp ON CS.idcoursspecialite = CSp.id
        JOIN
            {cycle} C ON CSp.idcycle = C.id
        JOIN
            {specialite} S ON CSp.idspecialite = S.id
        JOIN
            {filiere} F ON S.idfiliere = F.id
        WHERE C.id='".$_GET["cycle"]."' AND F.id='".$_GET["filiere"]."' AND S.id='".$_GET["specialite"]."' AND LN.idetudiant='".$count->id."'
        
  ";
//   $notecycspelefil=$DB->get_records_sql($sqlnotecyclefilspec);
//   var_dump($notecycspelefil);
    // foreach($notecycspelefil as $key =>$bppp)
    // {
    //     if($bppp->libellecycle!=null || $bppp->moyenne!=0)
    //     {

    //         $tanoteefilcy=[
    //             "libelle"=>$bppp->libellecycle,
    //             "moyenne"=>$bppp->moyenne
    //         ];
    //         // var_dump($tanoteefilcy);
    //     }
    // }

}
// die;
//verifiertypecampus
$vericcc=$DB->get_records("campus",array("idtypecampus"=>4,"id"=>$_GET["campus"]));

if($vericcc)
{
   
}else
{
 $htmlcyetdet="<div><canvas id='diagrammeCirculairecydetcyetudet'></canvas></div>";
}
// var_dump(json_encode($tanoteefiliere));die;
$semestre=$DB->get_records("semestre");

// var_dump(ChangerSchoolUser($USER->id));
// die;





//Selectionner le token corespondant à l'etablissement

   if(tokenvalidat())
   {
       $seance=$CFG->wwwroot.'/local/powerschool/seance.php';
       $programme=$CFG->wwwroot.'/local/powerschool/programme.php';
       $inscriptionlien=$CFG->wwwroot.'/local/powerschool/inscription.php';
       $groupappr=new moodle_url('/local/powerschool/groupapprenant.php');
       $bulletin=$CFG->wwwroot.'/local/powerschool/bulletin.php';
       $configurationmi=$CFG->wwwroot.'/local/powerschool/configurationmini.php';
    }
    $reglage=$CFG->wwwroot.'/local/powerschool/reglages.php';
     





$templatecontext = (object)[
    'htmlcyetdet'=>$htmlcyetdet,
    'anneee'=>array_values($annee),
    'roote'=>$CFG->wwwroot,
    'specialite1' => array_values($specialite),
    'cycle1' => array_values($cycle),
    'filiere1' => array_values($filiere),
    'campus1' => array_values($campus),
    // 'specialite' => array_values($specialites),
    'specialite' => $specialites_json,
    'etufil' => array_values($taret),
    'specialiteedit' => new moodle_url('/local/powerschool/specialiteedit.php'),
    'specialitesupp'=> new moodle_url('/local/powerschool/specialite.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'star' => new moodle_url('/local/powerschool/statistique.php'),
    'someetu'=>$som->somid,
    'specialsomme'=> json_encode($data),
    'countetuspe'=> json_encode($dataetu),
    'countetucy'=> json_encode($datacyetu),
    'cyclesomme'=> json_encode($datacy),
    'filspecia'=> json_encode($datafilsp),
    "sppsometufilsp"=>json_encode($tarsppsometufilsp),

    "sppsometulibefilsp"=>json_encode($tarsppsometulibefilsp),
    "sppsometulibefilsp"=>json_encode($tarsppsometulibefilsp),
    
    "sommecycy"=>json_encode($sommecycy),
    "libellecycy"=>json_encode($libellecycy),

    'filcycle'=> json_encode($datafilcy),
    'annee'=> json_encode(extractMonths($vala->datedebut,$vala->datefin)),

    'entrees'=>json_encode($entrees1),
    'libelspe'=>json_encode($specialite),
    
    //details etudiant
    'datacyetudet'=>json_encode($datacyetudet),
    'sommecyetudet'=>json_encode($sommecy),
    'libellecydetetu'=>json_encode($libellecy),
   
    'sommesppetudet'=>json_encode($specialiteentreesdet1),
    'libellesppdetetu'=>json_encode($specialitelibelle),

    'dateannne'=>json_encode($dateannne),
    
    //par année
    'filiereanee'=>json_encode($filiereanee),
    'annnnnee'=>json_encode($annnnnee),
    
    //age
    'tarfilieresomeage'=>json_encode($tarfilieresomeage),
    'tarfilierecountage'=>json_encode($tarfilierecountage),

    'tarfilieresomeagesp'=>json_encode($tarfilieresomeagesp),
    'tarfilierecountagesp'=>json_encode($tarfilierecountagesp),

    'tarfilieresomeagecy'=>json_encode($tarfilieresomeagecy),
    'tarfilierecountagecy'=>json_encode($tarfilierecountagecy),

    'tarfilieresomeagecysp'=>json_encode($tarfilieresomeagecysp),
    'tarfilierecountagecysp'=>json_encode($tarfilierecountagecysp),

    //Note
    "tanoteefiliere"=>json_encode($tanoteefiliere),
    "tanoteefilierespec"=>json_encode($tanoteefilierespec),
    "noteefilierecy"=>json_encode($noteefilierecy),
    "noteefilierecyspsal"=>json_encode($noteefilierecyspsal),

    //$_GET
    "idca"=>$_GET["campus"],
    "idsp"=>$_GET["specialite"],
    "idcy"=>$_GET["cycle"],
    "idan"=>$_GET["annee"],
    "idge"=>$_GET["gender"],
    "idfi"=>$_GET["filiere"],
    "idsem"=>$_GET["semestre"],

    //lien
    "listevers"=>new moodle_url('/local/powerschool/listeversements.php'),
    "listenombre"=>new moodle_url('/local/powerschool/listenombreapp.php'),
    "listenote"=>new moodle_url('/local/powerschool/listeetudmoyem.php'),

    //semestre
    'semestre'=>array_values($semestre)
];


// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     // 'notes' => new moodle_url('/local/powerschool/note.php'),
//     'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
//     'gerer' => new moodle_url('/local/powerschool/gerer.php'),
//     'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
//     'statistique' => new moodle_url('/local/powerschool/statistique.php'),

// ];

$menu = (object)[
    'statistique' =>  $CFG->wwwroot.'/local/powerschool/statistique.php',
    'reglage' =>  $reglage,
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' =>  $seance,
    'programme' =>  $programme,

    'inscription' =>  $inscriptionlien,
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' =>  $bulletin,
    'configurermini' => $configurationmi ,
    'listeetudiant' =>  $CFG->wwwroot.'/local/powerschool/listeetudiant.php',
    'activer' => $CFG->wwwroot.'/local/powerschool/activat.php',
    'activat' => get_string('activat', 'local_powerschool'),
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),
    'groupapprenant' => $groupappr,

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),
];

echo $OUTPUT->header();

// var_dump($CFG->wwwroot.'/local/powerschool/activat.php',new moodle_url($CFG->wwwwroot.'/local/powerschool/activat.php'));die;
if($CFG->theme=="boost")
{
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo"<p style='margin-top:-120px'><p>";
}
echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);

// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/statistique1', $templatecontext);


echo $OUTPUT->footer();