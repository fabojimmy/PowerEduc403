<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once(__DIR__."/../../../config.php");
require_once ($CFG->dirroot.'/local/powerschool/PHPMailer/vendor/autoload.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $message=$DB->get_records_sql("SELECT * FROM {messagesstocke} me,{campus} c,{typecampus} t WHERE t.id=c.idtypecampus AND me.idcampus=c.id AND idcampus='".$_GET["idca"]."'");
    foreach($message as $key=>$mess)
    {
        
    }
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $mess->email;                     //SMTP username
    // $mail->Password   = 'lanpmamyuuhnpsvv';                               //SMTP password
    $mail->Password   = $mess->password;                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    // $mail->setFrom('lovjim04@gmail.com', 'Mailer');
    $mail->setFrom($mess->email, $mess->abrecampus);
    global $DB;

    
   
    $tarmesss=explode("#",$mess->fullmessage);
    $nnn=$tarmesss[0]." 20000".$tarmesss[1]." 40000";
    // var_dump($nnn);die;
    // var_dump($tarmesss);die;
    $emails=$DB->get_records("inscription",array("idcampus"=>$_GET["idca"]));

    // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
 foreach($emails as $key => $email)
 {
    //  var_dump($email->emailparent);
    //  $mail->addAddress('fabojimmy04@gmail.com');  
                 //Name is optional
  if(!empty($email->emailparent))
  {

      $mail->addAddress($email->emailparent);               //Name is optional
 
      $mail->isHTML(true);                                  //Set email format to HTML
      $sqmema="SELECT SUM(montant) as sum  FROM {paiement} WHERE  idinscription='".$email->id."'";
      $somme=$DB->get_records_sql($sqmema);
      $mail->Subject = $mess->subject;
    if($mess->libelletype=="universite"){

        $sqlmon="SELECT sum(somme) mun FROM {filierecycletranc} filcy,{specialite} sp WHERE sp.idfiliere=filcy.idfiliere AND sp.id='".$email->idspecialite."' AND idcycle='".$email->idcycle."'";
    }else{
        $sqlmon="SELECT sum(somme) mun FROM {filierecycletranc} filcy,{specialite} sp WHERE sp.idfiliere=filcy.idfiliere AND sp.id='".$email->idspecialite."' AND idspecialite='".$email->idspecialite."'";

    }

      $munn=$DB->get_records_sql($sqlmon);
      //   var_dump($munn);
      foreach($munn as $key => $mu){
 
     }
     foreach($somme as $key => $som)
     {
    }
    if($mu->mun || $som->sum )
    {
        if($mu->mun==null)
        $mu->mun=0;
        $mail->Body = $tarmesss[0]." ".$som->sum ." ".$tarmesss[1]." ".$mu->mun." ".$tarmesss[2];
        // var_dump($email->emailparent ,$mu->mun,$som->sum );
    }
    $mail->send();
    $mail->ClearAllRecipients();
    $mail->Body = '';
}


}
// die;
//  die;
//  die;
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
  
    

    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}