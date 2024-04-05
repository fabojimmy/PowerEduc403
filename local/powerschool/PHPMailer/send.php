<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../../../config.php';
require_once ($CFG->dirroot.'/local/powerschool/PHPMailer/src/Exception.php');
require_once ($CFG->dirroot.'/local/powerschool/PHPMailer/src/PHPMailer.php');
require_once ($CFG->dirroot.'/local/powerschool/PHPMailer/src/SMTP.php');

if(isset($_POST["send"])){
     $mail=new PHPMailer(true);

     $mail->Host='smtp.gmail.com';
     $mail->SMTPAuth=true;
     $mail->Username='lovjim04@gmail.com';
     $mail->Password='mmopvhotkrpuohes';
     $mail->SMTPSecure='ssl';
     $mail->Port='465';

     $mail->setFrom($_POST["email"],"fghjk");

     $mail->addAddress("lovjim04@gmail.com");

     $mail->isHTML(true);
     $mail->Subject=$_POST["subject"];
     $mail->Body=$_POST["message"];

     $mail->send();

     echo"
      <script>
        alert('Send');
      </script>
     ";


}
?>