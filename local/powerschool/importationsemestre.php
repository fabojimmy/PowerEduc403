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
       
        $dateArrdeb = explode('-', $row[2]);
        $dateArrfin = explode('-', $row[3]);
        $datedebut= strtotime($dateArrdeb[2]."-".$dateArrdeb[1]."-".$dateArrdeb[0]);
        $datefin= strtotime($dateArrfin[2]."-".$dateArrfin[1]."-".$dateArrfin[0]);
        
  if(!empty($row[0])&&!empty($row[1]))
  {

      $DB->insert_record('semestre', array(
          "libellesemestre"=>$row[0],
          "numerosemestre"=>0,
          "datedebutsemestre"=>$datedebut,
          "datefinsemestre"=>$datefin,
          "idanneescolaire"=>[1],
      ));
  }
    }
    // die;
}
   
?>