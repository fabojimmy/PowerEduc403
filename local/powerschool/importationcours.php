<?php
    require_once __DIR__.'/../../config.php';
    require_once($CFG->libdir.'/gdlib.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->dirroot.'/user/editadvanced_form.php');
    require_once($CFG->dirroot.'/user/editlib.php');
    require_once($CFG->dirroot.'/user/profile/lib.php');
    require_once($CFG->dirroot.'/user/lib.php');
    require_once($CFG->dirroot.'/course/lib.php');
    require_once($CFG->dirroot.'/webservice/lib.php');
    require_once(__DIR__ . '/idetablisse.php');


   $file=$_FILES["excel"]["name"];
   $fileExtension=explode('.',$file);
   $fileExtension=strtolower(end($fileExtension));

   $newFileName=date("Y.m.d") ."-". date("h.i.sa") . "." . $fileExtension;

   $targetDirectory="uploads/" . $newFileName;

   move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);
   
//    error_reporting(0);
//    ini_set('display_errors',0);

    //    var_dump(require_once "excelReader-main/SpreadsheetReader.php");

//    require_once "excelReader-main/excel_reader2.php";
   require_once "vendor/autoload.php";

   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//    $file=$_FILES["excel"]["name"];
   $Extension=explode('.',$targetDirectory);
   $Extension=strtolower(end($Extension));
// $extension=pathinfo($_FILES['excel']['name'],PATHINFO_EXTENSION);
if($Extension=='xlxs' || $Extension='xls' || $Extension=='csv')
{
    $obj=PhpOffice\PhpSpreadsheet\IOFactory::load($targetDirectory);
    $data=$obj->getActiveSheet()->toArray();
    foreach($data as $key =>$row)
    {
       if(!empty($row[0]) && $row[1]&& $row[3]) 
       {

                $semestre=$DB->get_records("semestre",array("id"=>$_POST["idsemestre"]));
                foreach ($semestre as $key => $valuesem) {
                    # code...
                }
        
                $cycle=$DB->get_records("cycle",array("id"=>$_POST["idcycle"]));
                foreach ($cycle as $key => $valuecycl) {
                    # code...
                }
                
                $camp=$DB->get_records("campus",array("id"=>$_POST["idcampus"]));
                foreach ($camp as $key => $value) {
                    # code...
                }
                $categcamp=$DB->get_records("course_categories",array("name"=>$value->libellecampus,"depth"=>1));
                foreach ($categcamp as $key => $valuecam) {
                    # code...
                }
        
                $specia=$DB->get_records("specialite",array("id"=>$_POST["idspecialite"]));
                foreach ($specia as $key => $value2) {
                    # code...
                }
                $filiere=$DB->get_records("filiere",array("id"=>$value2->idfiliere));
                foreach ($filiere as $key => $value3) {
                    # code...
                }
                $categfil=$DB->get_records("course_categories",array("name"=>$value3->libellefiliere,"depth"=>2));
                // var_dump($filiere);
                foreach ($categfil as $key => $valuefil) {
                    # code...
                    $fff=explode("/",$valuefil->path);
                    $iddc=array_search($valuecam->id,$fff);
                    if($iddc!==false)
                    {
                        $idcatfil=$valuefil->id;
                    }
                }
                
                $categ=$DB->get_records("course_categories",array("name"=>$value2->libellespecialite,"depth"=>3));
                foreach ($categ as $key => $value1) {
                    # code...
                    $fff=explode("/",$value1->path);
                    $iddc=array_search($valuecam->id,$fff);
                    $iddfil=array_search($idcatfil,$fff);
                    if($iddc!==false && $iddfil!==false)
                    {
                        $idcat=$value1->id;
                        
                        // var_dump($idcat);
                    }
                }
                $categcy=$DB->get_records("course_categories",array("name"=>$valuecycl->libellecycle,"depth"=>4));
                // var_dump( $categcy);
                // die;
                foreach ($categcy as $key => $value1cy) {
                    # code...
                    $fffcy=explode("/",$value1cy->path);
                    $iddc=array_search($valuecam->id,$fffcy);
                    $iddfil=array_search($idcatfil,$fffcy);
                    $iddsp=array_search( $idcat,$fffcy);
                    if($iddc!==false&&$iddfil!==false&&$iddsp!==false)
                    {
                        $idcatcy=$value1cy->id;
                        // var_dump($idcatcy);
                    }
                }
                $categsem=$DB->get_records("course_categories",array("name"=>$valuesem->libellesemestre,"depth"=>5));
                // var_dump( $categcy);
                // die;
                foreach ($categsem as $key => $value1sem) {
                    # code...
                    $fffsem=explode("/",$value1sem->path);
                    $iddc=array_search($valuecam->id,$fffsem);
                    $iddfil=array_search($idcatfil,$fffsem);
                    $iddsp=array_search( $idcat,$fffsem);
                    $iddcy=array_search( $idcatcy,$fffsem);
                    if($iddc!==false&&$iddfil!==false&&$iddsp!==false&&$iddcy!==false)
                    {
                        $idcatsem=$value1sem->id;
                        // var_dump($idcatcy);
                    }
                }
                
                $idcouss= $DB->insert_record('coursspecialite', array(
                    "idcourses"=>0,
                    "idspecialite"=>$_POST["idspecialite"],
                    "idcycle"=>$_POST["idcycle"],
                    "credit"=>$row[2],
                    "idanneescolaire"=>$row[3],
                    "usermodified"=>$USER->id,
                    "timecreated"=>time(),
                    "timemodified"=>time(),
                ));
                
                $newcour=new StdClass();
                $newcour->fullname = $row[0];
                $newcour->shortname = $row[1];
                $newcour->category = $idcatsem;
                $idcou= create_course($newcour);
                
                // var_dump($idcou);die;
                $record = new stdClass();
                $record->id = $idcouss;
                $record->idcourses = $idcou->id;
                $record->idspecialite = $_POST["idspecialite"];
                $record->idcycle = $_POST["idcycle"];
                $record->credit = $row[2];
                $record->idanneescolaire = $row[3];
                $record->usermodified = $USER->id;
                $record->timecreated = time();
                $record->timemodified = time();
                
                $DB->update_record('coursspecialite', $record);
            }
            else
            {
             
                redirect($CFG->wwwroot . '/local/powerschool/importationre.php', 'Remplissez les données essentiels',\core\output\notification::NOTIFY_ERROR);
            }
       }

    redirect($CFG->wwwroot . '/local/powerschool/importationre.php', 'Importation éffectués avec succès',\core\output\notification::NOTIFY_SUCCESS);

    // die;
}
   
?>