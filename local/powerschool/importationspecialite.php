<?php
    require_once __DIR__.'/../../config.php';
    require_once($CFG->libdir.'/gdlib.php');
    require_once($CFG->libdir.'/adminlib.php');
    require_once($CFG->dirroot.'/user/editadvanced_form.php');
    require_once($CFG->dirroot.'/user/editlib.php');
    require_once($CFG->dirroot.'/user/profile/lib.php');
    require_once($CFG->dirroot.'/user/lib.php');
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
        $filiecat=$DB->get_records("filiere",array("id"=>$row[2]));
          foreach ($filiecat as $key => $value) {
              # code...
            }
           $campus=$DB->get_records("campus",array("id"=>$value->idcampus));

             foreach($campus as $key => $valcam)
             {}
            $categoriecampus=$DB->get_records("course_categories",array("name"=>$valcam->libellecampus,"depth"=>1));

            foreach($categoriecampus as $key=> $valcatcam)
            {}
            $categ=$DB->get_records("course_categories",array("name"=>$value->libellefiliere,"depth"=>2));
            foreach ($categ as $key => $value1) {
                $fff=explode("/",$value1->path);
                $idca=array_search($valcatcam->id,$fff);
                if($idca!==false){
                    $idfill=$value1->id;
                }
            }

            $DB->insert_record('specialite', array(
                "libellespecialite"=>$row[0],
                "abreviationspecialite"=>$row[1],
                "idfiliere"=>$row[2],
                "usermodified"=>$USER->id,
                "timecreated"=>time(),
                "timemodified"=>time(),
            ));

            $newca=new StdClass();
            $newca->parent = $idfill;
            $newca->name = $row[0];
            core_course_category::create($newca, null);

    }
    // die;
    redirect($CFG->wwwroot . '/local/powerschool/importationre.php', 'Importation éffectués avec succès',\core\output\notification::NOTIFY_ERROR);

}
   
?>