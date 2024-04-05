<?php
   /**
 * Database connection. Used for all access to the database.
 * @global int $etablisse
 * @name $etablisse
 */
global $iddetablisse;
/**
 * Database connection. Used for all access to the database.
 * @global int $annee
 * @name $annee
 */
 global $gloannee;
   require_once(__DIR__.'/../../config.php');
   //l'appel de l'etablissement selectionné
   global $DB;
   // die;
   $verrrif=false;
//  if($iddetablisse!=0)
//  {



   function ChangerSchoolUser($user)
  {
    global $DB;

    $modulecontext=context_system::instance();
    if(has_capability("local/powerschool:activation",$modulecontext,$user))
    {
  
      // $etablissement=$DB->get_records("campus",array("activerca"=>1));
      // foreach($etablissement as $key => $valet)
      // {
    
      // }
          $Changer=$DB->get_records("changerschooluser", array("usermodified" => $user));
          foreach ($Changer as $key => $value)
          {
            
          }
          $ValueChanger=$value->idcampus;
    }
    else
    {
          $NotChange=$DB->get_records("user",array("id"=>$user));

          foreach ($NotChange as $key => $value)
          {
            
          }
          $ValueChanger=$value->idcampuser;
    }
    if($ValueChanger==null)
    {
      $ValueChanger=0;
    }
    return $ValueChanger;
  }
  
  // $iddetablisse=2;

?>