<?php
require_once('vendor/autoload.php');
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class plusieurs{

    function generatePDF($idetudiant){
        require_once('vendor/autoload.php');
        require_once __DIR__.'/../../../../config.php';
     // Incluez le fichier d'autoloader de html2pdf
    // vendor/autoload.php
    global $DB;
    // Créez une instance d'Html2Pdf
    $html2pdf = new Html2Pdf();
    
    // var_dump($CFG->dirroot);die;
    // $sql="SELECT * FROM {listenote} li LEFT JOIN {affecterprof} af ON af.id=li.idaffecterprof LEFT JOIN {coursspecialite} co ON co.id=af.idcoursspecialite LEFT JOIN
    // {course} scou ON co.idcourses=scou.id LEFT JOIN {user} as u ON u.id=li.idetudiant 
    //  WHERE li.idetudiant=3";
    
    // var_dump($idetudiant);
    
    
    
    
    $sql1="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{user} as u,{filiere} as fi,
                            {specialite} as sp,{cycle} as cy,{courssemestre} cse,{bulletin} bu, {campus} ca,{typecampus} tcp 
                            WHERE tcp.id=ca.idtypecampus AND bu.idspecialite=sp.id AND bu.idcycle=cy.id AND bu.idcampus=ca.id AND li.idbulletin=bu.id AND af.id=li.idaffecterprof AND cse.id=af.idcourssemestre 
                            AND co.idcourses=scou.id AND u.id=li.idetudiant AND cy.id=co.idcycle AND sp.id=co.idspecialite AND fi.id=sp.idfiliere
                            AND cse.idcoursspecialite=co.id AND li.idetudiant='".$idetudiant."'";
    
    $sql="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id
                            AND co.idcourses=scou.id
                            AND li.idetudiant='".$idetudiant."'";
            $sqlcredit="SELECT SUM(credit) as credi FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id
                            AND co.idcourses=scou.id
                            AND li.idetudiant='".$idetudiant."'";
            $notes=$DB->get_records_sql("SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id
            AND co.idcourses=scou.id
            AND li.idetudiant='".$idetudiant."'");
            // var_dump($notes);die;
            $infor=$DB->get_records_sql($sql1);
            $credit=$DB->get_records_sql($sqlcredit);
            // var_dump($notes);die;
    
          
                        // $somme=0;
                        // $somcredit=0;
                        foreach ($infor as $key => $value1) {
                            # code...
                        }
    
                        foreach ($credit as $key => $value2) {
                            # code...
                        }
    
                        // Définissez le contenu HTML à convertir en PDF
                        $html = '
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <style>
                                .logo{
                                    border:1px solid black;
                                    width: 120px;
                                    height: 60px;
                                    margin-top:25px
                                }
                                .header .text{
                                    margin-left:120px;
                                    margin-top:-80px;
                                }
                                .text h5,.text p,.text h6{
                                    text-align:center;
                                }
                                .lieu{
                                    margin-top:-25px
                                }
                                .textnote{
                                    text-align:center;
                                }
                                .headerglo{
                                    border:1px solid black;
                                }
                                .etudiant{
                                    font-size: 9px;
                                }
                                .etudiant p{
                                    font-weigth:700px;
                                }
                                .etudiant em{
                                    color:#828282
                                }
                                .etudiant .info1{
                                    margin-left:50px
                                }
                                .etudiant .info2{
                                    margin-left:300px;
                                    margin-top:-100px
                                }
                                .info2 .fil{
                                    margin-top:20px
                                }
                                .etudiant .info3{
                                    margin-left:560px;
                                    margin-top:-90px
                                }
                                .note{
                                    margin-top:30px;
                                    margin-left:40px
                                }
                                table{
                                    border-collapse:collapse;
                                    border:1px solid black
                                }
                                td,th{
                                    border:1px solid black;
                                    padding:10px
                                }
                                .dec,.som,.men,.lieu1
                                {
                                    width:130px;
                                    background:red
                                }
                                .som{
                                    margin-left:150px;
                                    margin-top:-40px;
                                }
                                .cre{
                                    margin-left:290px;
                                    margin-top:-40px;
                                    background:red;
                                    width:150px;
                                }
                                .men{
                                    margin-left:460px;
                                    margin-top:-40px;
                                }
                                .men label{
                                    margin-left:45px;
    
                                }
                                .lieu1{
                                    margin-left:450px;
                                    margin-top:10px;
                                }
                                .dec1,.som1,.cre1,.men1
                                {
                                    margin-top:10px;
                                    margin-left:50px
                                }
                                .nb{
                                    font-weight:0;
                                    font-size:8px;
                                    margin-top:50px
                                }
                                .nba{
                                    font-weight:0;
                                    font-size:8px;
                                    margin-top:-5px
                                }
                                .dia{
                                    font-weight:0;
                                    font-size:12px;
                                    margin-top:-6px
                                }
                                .idi{
                                    margin-left:520px;
                                    margin-top:-50px
                                }
                            </style>
                        </head>
                        <body>
                            <div class="headerglo">
                                <div class="header">
                                        <div class="logo">logo</div>
                                        <div class="text">
                                                <div><h5>'.$value1->libellecampus.'</h5></div>
                                                <div class="lieu"><p>'.$value1->adressecampus.'</p></div>
                                                <div class="textnote"><h3>RELEVE DE NOTES ANNUEL/ ANNUAL TRANSCRIPT</h3></div>
                                        </div>
                                </div>
                            </div>
                            <div class="etudiant">
                            <div class="info1">
                                <p>Nom(s)  <em>Last and First Name</em>:      '.$value1->lastname.' '.$value1->firstname.'</p>
                                <p>Né(e) le/  <em>Born on</em>:       12/08/2002</p>
                                <p>Domaine(s)  <em>Domain</em>:       TECHNOLOGIE DE L\'INFORMATION ET DE LA COMMUNIcATION</p>
                                <p>Specialité:    '.$value1->libellespecialite.'  </p>
                            </div>
                            <div class="info2">
                                <p>Matricule / <em>Registration Number</em>:     205554  </p>
                                <p>Cycle:     '.$value1->libellecycle.'</p>
                                <p class="fil">Filiere/ <em>Field</em>:      '.$value1->libellefiliere.'</p>
                            </div>
                            <div class="info3">
                                <p>Année Academique / <em>Aca year</em>:     205554  </p>
                                <p></p>
                                <p></p>
                                <p>Specialité:     Genie Logiciel  </p>
                            </div>
                            </div> 
    
                            <div class="note">
                            <table>
                                <tr>';
                                    if("universite"===$value1->libelletype){
    
                                        $html.='<th>Code Matiere</th>';
                                    }
    
                                    $html.='<th>l\'unité d\'Enseignement(UE) ou de la matiere</th>
                                    <th>Coef ou credit</th>
                                    <th>Note</th>';
    
                                    if ("college"===$value1->libelletype) {
                                        # code...
                                        $html.='<th>Note*coef</th>';
                                    }
                                    
                                    if ("universite"===$value1->libelletype) {
                                        # code...
                                        $html.='<th>Décision</th>';
                                    }
                                    // $html.='<th>Grade</th>';
    
                                $html.='</tr>
                            ';
                            
                            foreach ($notes as $key => $item) {
                                $html .= '<tr>';
                                if ("universite"===$value1->libelletype) {
                                    # code...
                                    $html.='<td>' . $item->codematiere . '</td>';
                                }
    
                                            $html.='<td>'.$item->fullname.'</td>
                                            <td>'.$item->credit.'</td>
                                            <td>'.$item->note3.'</td>';
                                            if ("college"===$value1->libelletype) {
                                                # code...
                                                $html.= '<td>'.$item->note3*$item->credit.'</td>';
                                            }
    
                                            if ("universite"===$value1->libelletype) {
                                                # code...
                                                if ($item->note3>=9.75) {
                                                    
                                                    $html.= '<td>VA</td>';
                                                    $somcredit=$somcredit+$item->credit;
                                                }
                                                else{
                                                    
                                                    $html.= '<td>NVA</td>';
                                                }
                                            }
    
                                            //   $html.='<td>'.$item->grade.'</td>';
                                    $html.='</tr>';
                                        if("college"===$value1->libelletype)
                                        {
                                            $somme=$somme+(($item->note3*$item->credit)/$item->credit);
                                    
                                        }
                                        if("universite"===$value1->libelletype)
                                        {
                                            $somme=$somme+($item->note3/$item->credit);
                                            
                                            
                                            }
                                    }
                                        $html.='
                                        <tr>
                                            <td colspan=7>';
                                            if($somme>=10){
    
                                                $html.='<div class="dec"><label>Décision du jury</label><div class="dec1">Admis(e)</div></div>';
                                                $html.='<div class="som"><label>Moyenne annuelle</label><div class="som1">'.$somme.'</div></div>';
                                                $html.='<div class="cre"><label>Total crédits capitalisés</label><div class="cre1">'.$somcredit.'</div></div>';
                                                if ($somme>=10 && $somme<12) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Passable</div></div>';
                                                }
                                                if ($somme>=12 && $somme<14) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Assez Bien</div></div>';
                                                }
                                                if ($somme>=14 && $somme<16) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Bien</div></div>';
                                                }
                                                if ($somme>=16) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Très Bien</div></div>';
                                                }
                                            }else{
                                                $html.='<div class="dec"><label>Décision du jury</label><div class="dec1">Refusé(e)</div></div>';
                                                $html.='<div class="som"><label>Moyenne annuelle</label><div class="som1">'.$somme.'</div></div>';
                                                $html.='<div class="cre"><label>Total crédits capitalisés</label><div class="cre1">'.$somcredit.'</div></div>';
                                                if ($somme<10 ) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">null</div></div>';
                                                }
                                                if ($somme>=10 && $somme<12) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Passable</div></div>';
                                                }
                                                if ($somme>=12 && $somme<14) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Assez Bien</div></div>';
                                                }
                                                if ($somme>=14 && $somme<16) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Bien</div></div>';
                                                }
                                                if ($somme>=16) {
                                                    # code...
                                                    $html.='<div class="men"><label>Mention</label><div class="men1">Très Bien</div></div>';
                                                }
    
    
                                            }
                                            $html.='<div class="lieu1"><label>Fait à   </label><div>  '.$value1->villecampus.'   le '.   date("Y/m/d").'</div></div>
                                            </td>
                                        </tr>
                                        ';
                            $html .= '</table>
                        </div>
                        <div>
                            <p class="nb">NB:Il n\'est délivré qu\'un seul exemplaire de ce document, le titulaire peut en faire autant de copies conformes nécessaires</p>
                            <p class="nba">NB:Il n\'est délivré qu\'un seul exemplaire de ce document, le titulaire peut en faire autant de copies conformes nécessaires</p>
    
                            <div class="idi">
                                    <p class="di">Le Directeur Academique</p>
                                    <em class="dia">Le Directeur Academique</em>
                            </div>
                        </div>
                        </body>
                        </html>
                        ';
    
                        // Chargez le contenu HTML dans Html2Pdf
                        $html2pdf->writeHTML($html);
    
                        // Générez le PDF
                        $pdf_content=$html2pdf->output('output'.$idetudiant.'.pdf',"S");
                        // $pdf_content = $html2pdf->output('nom_du_fichier.pdf', 'S');
    
                        // Envoi du PDF au navigateur
                        // header('Content-Type: application/pdf');
                        // header('Content-Disposition: inline; filename="output.pdf"');
                        // header('Cache-Control: private, max-age=0, must-revalidate');
                        // header('Pragma: public');
                        // header('Content-Length: ' . strlen($pdf_content));
    
                        // echo $pdf_content;
    
                    //     $chemin_dossier = $CFG->dirroot.'/local/powerschool/bulletin/';
    
                    //     // Vérifiez si le dossier existe, sinon, créez-le
                    //     if (!file_exists($chemin_dossier)) {
                    //         mkdir($chemin_dossier, 0755, true);
                    //     }
    
                    //     // Enregistrez le fichier PDF dans le dossier spécifié
                    //     $chemin_fichier = $chemin_dossier . 'output'.$idetudiant.'.pdf';
                    //     // var_dump($chemin_fichier);
                        
                    //   file_put_contents($chemin_fichier, $pdf_content);

                    $sooo=552;
    }
}
