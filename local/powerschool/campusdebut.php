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
use local_powerschool\campus;
use local_powerschool\lib;

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/token.php');
require_once(__DIR__ . '/OrangeMoney.class.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/campus.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/campusdebut.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un Campus');
$PAGE->set_heading('Enregistrer un Campus');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('campus', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');



//insertion etabliessement et token

global $DB;
if(!empty($_POST["libellecampus"])&&!empty($_POST["abrecampus"])&&!empty($_POST["adressecampus"]&&!empty($_POST["telcampus"]))){
  // $tarrspecia=[
  //   "Sil"=>array("francais"=>"fransil",
  //               "mathematics"=>"mathsil",
  //                "Physique"=>"phy"),
  //   "CP"=>array("francais"=>"francp"),
  //   "CM1",
  //   "CM2",
  // ];

  // foreach($tarrspecia as $key=>$value)
  // {
  //   foreach($value as $b=>$val)
  //   {

  //     var_dump($key.''.$b.''.$val);
  //   }
  // }

  // die;
  $reques=new StdClass();
  $reques->id=0;
  $reques->libellecampus=$_POST["libellecampus"];
   $reques->telcampus=$_POST["telcampus"];
   $reques->abrecampus=$_POST["abrecampus"];
   $reques->adressecampus=$_POST["adressecampus"];
   $reques->telcampus=$_POST["telcampus"];
   $reques->payscampus=$_POST["pays"];
   $reques->codepostalcampus=$_POST["codepostalcampus"];
   $reques->emailcampus=$_POST["emailcampus"];
   $reques->villecampus=$_POST["villecampus"];
   $reques->sitecampus=$_POST["sitecampus"];
   $reques->timecreated=time();
   $reques->logocampus="";
   $reques->timemodified=time();
   $reques->usermodified=$USER->id;
   $reques->activerca=0;
  //  $reques->type=$_POST["type"];
  //  $reques->type=$_POST["type"];
   $reques->idfrananglobin='5';
   $reques->idenseignementtype='5';

   
   $idd= $DB->execute("INSERT INTO mdl_campus (libellecampus, telcampus, abrecampus, adressecampus, payscampus, codepostalcampus, emailcampus, villecampus, sitecampus, timecreated, logocampus, timemodified, usermodified, activerca, idfrananglobin, idenseignementtype)
  VALUES ('".$_POST["libellecampus"]."', '".$_POST["telcampus"]."', '".$_POST["abrecampus"]."', '".$_POST["adressecampus"]."','".$_POST["pays"]."','".$_POST["codepostalcampus"]."' ,'".$_POST["emailcampus"]."', '".$_POST["villecampus"]."', '".$_POST["sitecampus"]."',
   '".time()."', '', '".time()."', '".$USER->id."', 0, '".json_encode($_POST["frananglobin"])."', '".json_encode($_POST["enseignementtype"])."')");
   //  $idcam= createetablissement($reques);
   $idcam= createetablissementtrue($idd);
   




//    if($_POST["typecampus"]==4)
//    {

//     //filiere
//     $camp=$DB->get_records("campus",array("id"=>$idcam));
//     foreach ($camp as $key => $value) {
//         # code...
//     }
//     $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
//     foreach ($categ as $key => $value1) {
//         # code...
//     }

//     $recordtoinsertfil=new StdClass();
    
//     $recordtoinsertfil->libellefiliere="standardfil";
//     $recordtoinsertfil->abreviationfiliere="abr";
//     $recordtoinsertfil->usermodified=$USER->id;
//     $recordtoinsertfil->timecreated=time();
//     $recordtoinsertfil->timemodified=time();
//     $recordtoinsertfil->idcampus=$idcam;
    
//     // var_dump($value1->id);die;
//     $idfil=$DB->insert_record('filiere', $recordtoinsertfil);

//     $data=new StdClass();
//     $data->parent = $value1->id;

//     // var_dump($value1->id);die;
//     $data->name = $recordtoinsertfil->libellefiliere;
//     core_course_category::create($data, null);
//     // die;

//     //specialite

//     $tarrspecia=[
//       "Sil"=>array("francais"=>"fransil",
//                   "mathematics"=>"mathsil"),
//       "CP"=>array("francais","fransil"),
//       "CM1",
//       "CM2",
//     ];

// // die;
//     $filiecat=$DB->get_records("filiere",array("id"=>$idfil));
//           foreach ($filiecat as $key => $value) {
//               # code...
//             }
//            $campus=$DB->get_records("campus",array("id"=>$value->idcampus));

//              foreach($campus as $key => $valcam)
//              {}
//             $categoriecampus=$DB->get_records("course_categories",array("name"=>$valcam->libellecampus,"depth"=>1));

//             foreach($categoriecampus as $key=> $valcatcam)
//             {}
//             $categ=$DB->get_records("course_categories",array("name"=>$value->libellefiliere,"depth"=>2));
//             foreach ($categ as $key => $value1sp) {
//                 $fff=explode("/",$value1->path);
//                 $idca=array_search($valcatcam->id,$fff);
//                 if($idca!==false){
//                     $idfill=$value1sp->id;
//                 }
//             }

//             foreach($tarrspecia as $keva)
//             {

//               $recordtoinsertsp=new StdClass();

//               $recordtoinsertsp->libellespecialite=$keva;
//               $recordtoinsertsp->usermodified=$USER->id;
//               $recordtoinsertsp->idfiliere=$idfil;
//               $recordtoinsertsp->timecreated=time();
//               $recordtoinsertsp->timemodified=time();
//               // $recordtoinsertsp->abreviationspecialite=$keva;

//               $idsp=$DB->insert_record('specialite', $recordtoinsertsp);
//               $datasp=new StdClass();

//               $datasp->parent = $value1sp->id;
//               $datasp->name = $keva;
              

//               core_course_category::create($datasp, null);
//             }


//             //Cycle

//             $recordtoinsertcy=new StdClass();
    
//     $recordtoinsertcy->libellecycle="standard";
//     $recordtoinsertcy->nombreannee=0;
//     $recordtoinsertcy->usermodified=$USER->id;
//     $recordtoinsertcy->timecreated=time();
//     $recordtoinsertcy->timemodified=time();
//     $recordtoinsertcy->idcampus=$idcam;
    
//     // var_dump($value1->id);die;
//     $idcy=$DB->insert_record('cycle', $recordtoinsertcy);


    


//             $cycle=$DB->get_records("cycle",array("id"=>$idcy));
//             foreach ($cycle as $key => $valuecycl) {
//                 # code...
//             }
//             $camp=$DB->get_records("campus",array("id"=>$idcam));
//             foreach ($camp as $key => $value) {
//                 # code...
//             }
//             $categcamp=$DB->get_records("course_categories",array("name"=>$value->libellecampus,"depth"=>1));
//             foreach ($categcamp as $key => $valuecam) {
//                 # code...
//             }

//             $specia=$DB->get_records("specialite");
//             foreach ($specia as $key => $value2) {
//                 # code...
//                     $filiere=$DB->get_records("filiere",array("id"=>$value2->idfiliere));
//                     foreach ($filiere as $key => $value3) {
//                         # code...
//                     }
//                     $categfil=$DB->get_records("course_categories",array("name"=>$value3->libellefiliere,"depth"=>2));
//                     // var_dump($filiere);
//                     foreach ($categfil as $key => $valuefil) {
//                         # code...
//                         $fff=explode("/",$valuefil->path);
//                         $iddc=array_search($valuecam->id,$fff);
//                         if($iddc!==false)
//                         {
//                             $idcatfil=$valuefil->id;
//                             // var_dump( $idcatfil);
//                         }
//                     }
//                     $categ=$DB->get_records("course_categories",array("name"=>$value2->libellespecialite,"depth"=>3));
//                     foreach ($categ as $key => $value1) {
//                         # code...
//                         $fff=explode("/",$value1->path);
//                         $iddc=array_search($valuecam->id,$fff);
//                         $iddfil=array_search($idcatfil,$fff);
//                         if($iddc!==false&&$iddfil!==false)
//                         {
//                             $idcat=$value1->id;
//                             // var_dump( $idcat);
//                         }
//                     }
//                     $vercycat=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
//                     foreach ($vercycat as $key => $value1cyy) {
//                         # code...
//                         $fff=explode("/",$value1cyy->path);
//                         $iddc=array_search($valuecam->id,$fff);
//                         $iddfil=array_search($idcatfil,$fff);
//                         $iddspp=array_search($idcat,$fff);
//                         // var_dump($idcat,$idcatfil,$valuecam->id,$value1cyy->path);
//                         if($iddc!==false&&$iddfil!==false&&$iddspp!==false)
//                         {
//                             $idcatcy=$value1cyy->id;
//                             // var_dump("Exicte");
//                             // $catsperec=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
//                             // $DB->insert_record('coursspecialite', $recordtoinsert);
//                             // $DB->execute("INSERT INTO mdl_coursspecialite VALUES(0,'".$recordtoinsert->idcourses."','".$recordtoinsert->idspecialite."','".$recordtoinsert->idcycle."','".$recordtoinsert->credit."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','".$recordtoinsert->timemodified."')");
//                         }else{
//                             // $DB->insert_record('coursspecialite', $recordtoinsert);
//                             // redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$idcat.'&cycle='.$valuecycl->libellecycle.'&idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
//                         }
//                         if($idcatcy==null || $idcatcy==0)
//                         {
//                           $data=new StdClass();
//                           $data->parent = $idcatcy;
//                           $data->name = $valuecycl->libellecycle;
                          
//                           $DB->insert_record('coursspecialite', array("idcycle"=>$idcy,
//                                                                 "idspecialite"=>$value2->id,
//                                                                 "credit"=>2,
//                                                                 "idanneescolaire"=>1,
//                                                                 "idcourses"=>0));
//                           core_course_category::create($data, null);
//                         }

//                 }
//             }


//             //semestre


//             $semestre=$DB->get_records("semestre",array("id"=>$_POST["idsemestre"]));
//             foreach ($semestre as $key => $valuesem) {
//                 # code...
//             }

//             $cycle=$DB->get_records("cycle",array("id"=>$_POST["idcycle"]));
//             foreach ($cycle as $key => $valuecycl) {
//                 # code...
//             }
            
//             $camp=$DB->get_records("campus",array("id"=>$_POST["idcampus"]));
//             foreach ($camp as $key => $value) {
//                 # code...
//             }
//             $categcamp=$DB->get_records("course_categories",array("name"=>$value->libellecampus,"depth"=>1));
//             foreach ($categcamp as $key => $valuecam) {
//                 # code...
//             }

//             $specia=$DB->get_records("specialite",array("id"=>$_POST["idspecialite"]));
//             foreach ($specia as $key => $value2) {
//                 # code...
//                 $filiere=$DB->get_records("filiere",array("id"=>$value2->idfiliere));
//                 foreach ($filiere as $key => $value3) {
//                     # code...
//                 }
//                 $categfil=$DB->get_records("course_categories",array("name"=>$value3->libellefiliere,"depth"=>2));
//                 // var_dump($filiere);
//                 foreach ($categfil as $key => $valuefil) {
//                     # code...
//                     $fff=explode("/",$valuefil->path);
//                     $iddc=array_search($valuecam->id,$fff);
//                     if($iddc!==false)
//                     {
//                         $idcatfil=$valuefil->id;
//                         // var_dump( $idcatfil);
//                     }
//                 }
//                 $categ=$DB->get_records("course_categories",array("name"=>$value2->libellespecialite,"depth"=>3));
//                 foreach ($categ as $key => $value1) {
//                     # code...
//                     $fff=explode("/",$value1->path);
//                     $iddc=array_search($valuecam->id,$fff);
//                     $iddfil=array_search($idcatfil,$fff);
//                     if($iddc!==false && $iddfil!==false)
//                     {
//                         $idcat=$value1->id;
    
//                         // var_dump($idcat);
//                     }
//                 }
//                 $categcy=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
//                 // var_dump( $categcy);
//                 // die;
//                 foreach ($categcy as $key => $value1cy) {
//                     # code...
//                     $fffcy=explode("/",$value1cy->path);
//                     $iddc=array_search($valuecam->id,$fffcy);
//                     $iddfil=array_search($idcatfil,$fffcy);
//                     $iddsp=array_search( $idcat,$fffcy);
//                     if($iddc!==false&&$iddfil!==false&&$iddsp!==false)
//                     {
//                         $idcatcy=$value1cy->id;
//                         // var_dump($idcatcy);
//                     }
//                 }
//                 $categsem=$DB->get_records("course_categories",array("name"=>$valuesem->libellesemestre,"depth"=>5));
//                 // var_dump( $categcy);
//                 // die;
//                 foreach ($categsem as $key => $value1sem) {
//                     # code...
//                     $fffsem=explode("/",$value1sem->path);
//                     $iddc=array_search($valuecam->id,$fffsem);
//                     $iddfil=array_search($idcatfil,$fffsem);
//                     $iddsp=array_search( $idcat,$fffsem);
//                     $iddcy=array_search( $idcatcy,$fffsem);
//                     if($iddc!==false&&$iddfil!==false&&$iddsp!==false&&$iddcy!==false)
//                     {
//                         $idcatsem=$value1sem->id;
//                         var_dump($idcatcy);
//                     }
//             }
//             }
//             if($idcatsem==null || $idcatsem==0)
//             {
            
//                 $DB->insert_record('courssemestre', $recordtoinsert);
//             }
            // var_dump( $idcat);die;
//  die;


  //  }
  //  die;


  //Creation de token et paiement
//   $m=4;
//   $moisajou="+".$m." months";
//   $timestampAujourdhui = time(); // Obtention du timestamp Unix actuel
//   $timestampDansTroisMois = strtotime($moisajou, $timestampAujourdhui); // Ajout de 3 mois au timestamp actuel

//   // var_dump(date("Y-m-d",$timestampDansTroisMois));die;
//   $orange=new Orange();
//   $objetOra=$orange->iniatiVen('https://api-s1.orange.cm/token',"raQRf7zAh7tPd24UlYtxMzsk2mca","m4MglHkMUH6qSmJ8XhQAEGsmXhYa",array(
//     'grant_type' => 'client_credentials'
//   ));

//    $Objeinit=$orange->payementInit('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/init',$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=");

//    $ObjPayR=$orange->paymentRequest('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/pay',$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=",8630,'','Payment',659924181,"2",690200718,$Objeinit);
//   // $dateDansMois = date("Y-m-d", $timestampDansTroisMois); // Conversion du timestamp dans 3 mois en format de date YYYY-MM-DD
//   $Objtsta=$orange->getStauts("https://api-s1.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/$Objeinit",$objetOra,"WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk=");
  
//   $Objtsta=json_decode($Objtsta);

//   var_dump("LOLO".$objetOra."kkkk",$Objtsta,$Objtsta->status);die;
//   $payload=array(
//     "libelle"=>$_POST["libellecampus"],
//     "email"=>$_POST["emailcampus"],
//     "timedebut"=>time(),
//     "timefin"=>$timestampDansTroisMois,
//  );

//    tokenencode($payload);

//    var_dump(tokenencode($payload));
//   //  die;
//    $DB->insert_record('tokenpaie',array("token"=>tokenencode($payload),
//                                         "idcampus"=>$idcam,
//                                         "usermodified"=>$USER->id,
//                                         "timecreated"=>time(),
//                                         "timemodified"=>time(),
//                                       ));

    

   redirect($CFG->wwwroot . '/my/',"Etablissement");

}



echo $OUTPUT->header();

$pays = get_string_manager()->get_list_of_countries(true);

$arrayAz1=array("A","B","C","F","G");
$arrayAz2=array("A","B","C","F","G");

$types=$DB->get_records("typecampus");
$frananglobin=$DB->get_records("frananglobin");
$enseignementtype=$DB->get_records("enseignementtype");




// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

$htmlcapus= "<!-- Button trigger modal -->
<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>
Créer votre Etablissement
</button>

<!-- Modal -->
<div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Création établissement</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
         <form method='post' action=''>
            <div class='modal-body'>
              <div>
                  <label class=''>Nom</label>
                  <input class='form-control' type='text' placeholder='Libelle' name='libellecampus' required='Libelle'>
              </div>
              <div>
                  <label class=''>Abréviations</label>
                  <input class='form-control' type='text' placeholder='Abréviations' name='abrecampus' required>
              </div>
              <div>
                  <label class=''>Adresse</label>
                  <input class='form-control' type='text' placeholder='Adresse' name='adressecampus' required>
              </div>
              <div>
                  <label class=''>Ville</label>
                  <input class='form-control' type='text' placeholder='Ville' name='villecampus' required>
              </div>
              <div>
                  <label class=''>Code Postal</label>
                  <input class='form-control' type='text' placeholder='Code Postal' name='codepostalcampus' required>
              </div>
              <div>
                  <label class=''>Pays</label>
                  <select class='form-control' name='pays'>";
                  foreach($arrayAz1 as $key=>$value1)
                  {
                      
                      foreach($arrayAz2 as $key=>$value2)
                      {
                          if(!empty($pays[$value1.$value2]))
                          {
                  
                            $htmlcapus.=  "<option value=".$value1.$value2.">".$pays[$value1.$value2]."</option>";
                            
                          }
                      }
                  }
                $htmlcapus.=" </select>
              </div>
              <div>
                  <label class=''>Categorie Etablissement</label>
                  <select class='form-control' name='typecampus'>";
                  foreach($types as $key=>$valuet)
                  {
                      
                  
                            $htmlcapus.=  "<option value=".$valuet->id.">".$valuet->libelletype."</option>";
                            
                        
                  }
                $htmlcapus.=" </select>
              </div>
                  <div>
                    <label class=''>Tel</label>
                    <input class='form-control' type='text' placeholder='Telephone ' name='telcampus' required>
                  </div>
                  <div>
                    <label class=''>Email</label>
                    <input class='form-control' type='email' placeholder='email ' name='emailcampus' required>
                </div>
                <div>
                <label class=''>Site</label>
                <input class='form-control' type='text' placeholder='Site' name='sitecampus' required>
              </div>
            </div>
            <div class='form-group'>
               <div class='mx-3'>
                  <label class=''>Choisir le type</label><br/>";
                  foreach($frananglobin as $key=>$valuet)
                  {

                    $htmlcapus.="<input class='' type='checkbox' value='$valuet->id' name='frananglobin[]' ><span class=''>$valuet->libelle</span><br/>";

                  }
              $htmlcapus.="</div>
               <div class='mx-3'>
                  <label class=''>Choisir le type d'enseignement</label><br/>";
                  foreach($enseignementtype as $key=>$valuet)
                  {

                    $htmlcapus.="<input class='' type='checkbox' value='$valuet->id' name='enseignementtype[]'><span class=''>$valuet->libelle</span><br/>";

                  }
                  $htmlcapus.=" </div>
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
              <button type='submit' class='btn btn-primary'>Save</button>
            </div>
          </form>
    </div>
  </div>
</div>";

echo $htmlcapus;
// echo $OUTPUT->render_from_template('local_powerschool/campus', $templatecontext);


echo $OUTPUT->footer();
?>

<Style>
  label{
    font-weight: 700;
  }
  input[type="checkbox"]
  {
    margin-left: 2em;
    font-weight: 600;
  }
 span
  {

    font-weight: 500;
  }
</Style>