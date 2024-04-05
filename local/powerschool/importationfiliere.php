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
        // $new->lastname=$row['2'];
        
        // var_dump($ko, "<br>");
        $camp=$DB->get_records("campus",array("id"=>ChangerSchoolUser($USER->id)));
        foreach ($camp as $key => $value) {
            # code...
        }
        $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
        foreach ($categ as $key => $value1) {
            # code...
        }
        // get_string("local_powerschool:createfiliere");
        // $fffff=context::instance_by_id(CONTEXT_MODULE,70);
        // var_dump($fffff);die;
        // role_assign()
        // if(has_capability('local_powerschool:createfiliere',$fffff)) {
    
            $DB->insert_record('filiere', array(
                "libellefiliere"=>$row[0],
                "abreviationfiliere"=>$row[1],
                "idcampus"=>ChangerSchoolUser($USER->id),
                "usermodified"=>$USER->id,
                "timecreated"=>time(),
                "timemodified"=>time(),
            ));

            $newca=new StdClass();
            $newca->parent = $value1->id;
            $newca->name = $row[0];
            core_course_category::create($newca, null);

    }

    redirect($CFG->wwwroot . '/local/powerschool/importationre.php', 'Importation éffectués avec succès',\core\output\notification::NOTIFY_ERROR);

    // die;
}
   
?>