<?php
require_once(__DIR__ . '/token.php');
require_once(__DIR__ . '/../../config.php');
 require_once __DIR__.'/../../vendor/autoload.php';
 use Firebase\JWT\JWT;
 use Firebase\JWT\Key;


 
 $payload=array(
    "isd"=>'localhost',
    "aud"=>'localhost',
    "ii"=>'paspa',
    "usernames"=>'fabo',
    "password"=>'jimmy'
 );

 function tokenencode($payload)
 {
   $sec_key="6HSKOMSQL";
   $encode=JWT::encode($payload,$sec_key,'HS256');
   return $encode;
 }
//  $decode=JWT::decode($encode,new Key($sec_key,'HS256'));

function tokendecode($token)
{
  $sec_key="6HSKOMSQL";
  $header=apache_request_headers();
 //  var_dump($header['Authorization']);
 $header['Authorization']=$token;
 if($header['Authorization'])
 {
     $header=$header['Authorization'];
     $decode=JWT::decode($header,new Key($sec_key,'HS256'));
     
     return $decode;
 }

}
function datetokenexpi($token)
{
   $dateexp=tokendecode($token);

  //  var_dump(date("Y-m-d",$dateexp->timefin));die;
   return date("Y-m-d",$dateexp->timefin);
}
//  print_r($encode);


    function datecomparation($token)
    {
        
        $datenow=date("Y-m-d",time());
        $dateexpi=datetokenexpi($token);

        if($datenow==$dateexpi)
        {
          // var_dump($dateexpi,$datenow,$token);die;
            return false;
        }else{

          return true;
        }
    
    }

    function tokenvalidat()
    {
      global $DB,$USER;

      $seleToken=$DB->get_records_sql("SELECT * FROM {tokenpaie} WHERE idcampus='".ChangerSchoolUser($USER->id)."'");
  
  
      foreach ($seleToken as $key => $valuepaie) {
          # code...
          // var_dump(datecomparation($valuepaie->token));die;
          if(datecomparation($valuepaie->token))
          {
           return true;
          }
        }

        return false;
          
    }

?>