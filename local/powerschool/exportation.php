<?php

require_once __DIR__.'/../../config.php';
require_once 'vendor/autoload.php';
// require_once __DIR__.'/../../../local/poweredu/importation_exportation/actionfitrer.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\IOFactory;
    

 if((!empty($_GET["libel"]) && $_GET["libel"]=="expoData")||(!empty($_GET["libel"]) && $_GET["libel"]=="expoDcom"))
 {
    $sql="SELECT i.id, u.firstname, u.lastname,username,emailparent,nomsparent,i.idetudiant,sp.libellespecialite,i.idanneescolaire, 
    sp.abreviationspecialite , cy.libellecycle, cy.nombreannee,sp.idfiliere,idcycle,i.idcampus,idspecialite,i.idcampus FROM 
    {inscription} i,{user} u,{specialite} sp,{cycle} cy WHERE i.idetudiant =u.id
    AND i.idspecialite=sp.id AND i.idcycle=cy.id";

 }
 else if(($_GET["libel"]=="expoDatapaie") || ($_GET["libel"]=="expoDcompaie"))
 {
    $sql="SELECT pa.id, u.firstname, u.lastname,username,emailparent,nomsparent,i.idetudiant,sp.libellespecialite,i.idanneescolaire,montant,idinscription, 
    sp.abreviationspecialite , cy.libellecycle, cy.nombreannee,sp.idfiliere,idcycle,i.idcampus,idspecialite,i.idcampus,libelletranche,idtranche,idmodepaie FROM 
    {inscription} i,{user} u,{specialite} sp,{cycle} cy,{paiement} pa,{modepaiement} mp,{tranche} tr WHERE i.idetudiant =u.id
    AND i.idspecialite=sp.id AND i.idcycle=cy.id AND pa.idinscription=i.id AND mp.id=pa.idmodepaie AND tr.id=pa.idtranche";

 }
        if (!empty($_GET["idca"])) {
            # code...
            $sql.=' AND i.idcampus ='.$_GET["idca"];
        
        } 

        // var_dump($sql);
        // die;
        if (!empty($_GET["idfi"])) {
            # code...
            $sql.=' AND sp.idfiliere ='.$_GET["idfi"];
        
        } 
        
        if (!empty($_GET["idsp"])) {
            $sql.=' AND i.idspecialite='.$_GET["idsp"];
        }
        // die;
        if (!empty($_GET["idcy"])) {
            $sql.=' AND i.idcycle='.$_GET["idcy"];
        }
        // var_dump($sql);die;
        $pa=$DB->get_records_sql($sql);

        // Création d'un nouvel objet Spreadsheet
        $spreadsheet = new Spreadsheet();

        // Sélection de la feuille de calcul active
        $sheet = $spreadsheet->getActiveSheet();

        // Écriture des en-têtes de colonne
        if($_GET["libel"]=="expoDcom" || $_GET["libel"]=="expoDcompaie")
        {
            $sheet->setCellValue('A1', 'Nom');
            $sheet->setCellValue('B1', 'prenom');
            $sheet->setCellValue('C1', 'username');
            $sheet->setCellValue('D1', 'Numero');
            $sheet->setCellValue('E1', 'E-mail');
            $sheet->setCellValue('F1', 'Specialite');
            $sheet->setCellValue('G1', 'Cycle');
            $sheet->setCellValue('H1', 'Nom parent');
            $sheet->setCellValue('I1', 'Email parent');
            if($_GET["libel"]=="expoDcompaie")
            {
                $sheet->setCellValue('J1', 'Tranche');
                $sheet->setCellValue('K1', 'Somme');

            }

        }
        else if($_GET["libel"]=="expoData" || $_GET["libel"]=="expoDatapaie")
        {
            $sheet->setCellValue('A1', 'id');
            $sheet->setCellValue('B1', 'idspecialite');
            $sheet->setCellValue('C1', 'idcycle');
            $sheet->setCellValue('D1', 'idanneescolaire');
            $sheet->setCellValue('E1', 'idcampus');
            $sheet->setCellValue('F1', 'idetudiant');
            if($_GET["libel"]=="expoDatapaie")
            {
                $sheet->setCellValue('G1', 'Tranche');
                $sheet->setCellValue('H1', 'Inscription');
                $sheet->setCellValue('I1', 'Somme');

            }
        
        }
        // Écriture des données des utilisateurs

        $row = 2;
        foreach ($pa as $key=> $user) {
            // var_dump($user->libellespecialite);
        if($_GET["libel"]=="expoDcom" || $_GET["libel"]=="expoDcompaie")
        {

            $sheet->setCellValue('A' . $row, $user->firstname);
            $sheet->setCellValue('B' . $row, $user->lastname);
            $sheet->setCellValue('C' . $row, $user->username);
            $sheet->setCellValue('D' . $row, $user->phone1);
            $sheet->setCellValue('E' . $row, $user->email);
            $sheet->setCellValue('F' . $row, $user->libellespecialite);
            $sheet->setCellValue('G' . $row, $user->libellecycle);
            $sheet->setCellValue('H' . $row, $user->nomsparent);
            $sheet->setCellValue('I' . $row, $user->emailparent);

            if($_GET["libel"]=="expoDcompaie")
            {
                $sheet->setCellValue('J' . $row, $user->libelletranche);
                $sheet->setCellValue('K' . $row, $user->montant);
            }
            $row++;
            }else if($_GET["libel"]=="expoData" || $_GET["libel"]=="expoDatapaie")
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->idspecialite);
            $sheet->setCellValue('C' . $row, $user->idcycle);
            $sheet->setCellValue('D' . $row, $user->idanneescolaire);
            $sheet->setCellValue('E' . $row, $user->idcampus);
            $sheet->setCellValue('F' . $row, $user->idetudiant);
            if($_GET["libel"]=="expoDatapaie")
            {
                $sheet->setCellValue('G' . $row, $user->idtranche);
                $sheet->setCellValue('H' . $row, $user->idinscription);
                $sheet->setCellValue('I' . $row, $user->montant);
            }
            $row++;
        {

        }
        }
        // die;
        // Création d'un objet Writer pour le format XLSX
        $writer = new Xlsx($spreadsheet);

        // Génération d'un nom de fichier unique
        $filename = 'jimm_' . uniqid() . '.xlsx';

        // Enregistrement du fichier Excel
        $writer->save("uploads/".$filename);

        // Réponse JSON avec le nom du fichier
        // $response = [
        //     'success' => true,
        //     'fileUrl' => $filename
        // ];

        // header('Content-Type: application/json');
        // echo json_encode($response);

        redirect($CFG->wwwroot . '/local/powerschool/exportationre.php?campus='.$_GET["idca"].'&specialite='.$_GET["idsp"].'&cycle='.$_GET["idcy"].'&filiere='.$_GET["idfi"].'&annee='.$_GET["idan"].'');


