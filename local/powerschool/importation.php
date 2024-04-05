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
        $new =new stdClass();
        $new->auth="manual";
        $new->confirmed=1;
        $new->policyagreed=0;
        $new->deleted=0;
        $new->suspended=0;
        $new->mnethostid=1;
        $new->username=$row[0];
        $new->password=hash_internal_user_password($row[1]);
        $new->firstname=$row[2];
        $new->lastname=$row[3];
        $new->email=$row[4];
        $new->emailstop=0;
        $new->phone1=$row[5];
        $new->phone2=$row[6];
        $new->department=$row[7];
        $new->address=$row[8];
        $new->country=$row[9];
        $new->idparent=$row[20];
        $new->idcampuser=$row[21];
        // $new->lastname=$row['2'];
        
        // var_dump($ko, "<br>");
        $id=$DB->insert_record("user",$new);

        if($row[10])
        {

            $DB->insert_record("role_assignments",array("roleid"=>$row[10],"userid"=>$id));
        }

    if($row[11]&&$row[12]&&$row[13]&&$row[14]&&$row[15]&&$row[16]&&$row[17]&&$row[18]&&$row[19]){

        $idins=$DB->insert_record("inscription",array(
            "idetudiant"=>$id,
            "idanneescolaire"=>$row[11],
            "idcampus"=>$row[12],
            "idspecialite"=>$row[13],
            "idcycle"=>$row[14],
            "nomsparent"=>$row[15],
            "telparent"=>$row[16],
            "emailparent"=>$row[17],
            "timecreated"=>time(),
            "date_naissance"=>strtotime($row[18]),
            "gender"=>$row[19]
        ));
    }

    }
    // die;
    redirect($CFG->wwwroot . '/local/powerschool/importationre.php', 'Importation éffectués avec succès',\core\output\notification::NOTIFY_ERROR);

}
   

   
//    global $DB;
//    $reader= new SpreadsheetReader($targetDirectory);
//    //    die;
//    if($reader)
//    {
//        foreach($reader as $key => $row)
//        {
//         die;
//          $new= new stdClass();
//          $new->firstname=$row[0];
//          $new->lastname=$row[1];
//         //  $DB->insert_record("user",$new);
//       }
//  }
//  else
//  {
//     var_dump($targetDirectory);die;
//  }
//     var_dump($new->firstname);
//    die;
?>