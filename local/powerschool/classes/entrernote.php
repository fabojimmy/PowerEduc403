<?php
require_once(__DIR__ . '/../../../config.php');

// var_dump($_GET["notetest"]=="test",$_GET["idbu"],$_GET["id"]);die;
// die;
if($_GET["notetest"]=="test"&&$_GET["idbu"]&&$_GET["id"])
{
    // var_dump($_GET["idsa"]);die;

    $verlesson=$DB->get_records("lesson",array("id"=>$_POST["lesson"]));
    foreach($verlesson as $key =>$bonte)
    {}
    $vertest=$DB->get_records("quiz",array("id"=>$_POST["test"]));
    foreach($vertest as $key =>$bontetes)
    {}
        if($_POST["test"] && $_POST["lesson"])
        {
            \core\notification::add('Vous pouvez selectionner un seul soit le test<br> Soit la leçon'.$value->libellespecialite.'', \core\output\notification::NOTIFY_ERROR);
                redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'');
        }
        else
        {

            if($_POST["normalcc"])
            {

                $inscription=$DB->get_records_sql("SELECT * FROM {inscription} i,{salleele} sa WHERE i.idetudiant=sa.idetudiant AND sa.idsalle='".$_GET["idsa"]."'");
                foreach($inscription as $key => $vall)
                {

                    $ligneliste=$DB->get_records("listenote",array("idaffecterprof"=>$_GET['id'],"idetudiant"=>$vall->idetudiant));
                    foreach ($ligneliste as $key => $value) {
                        # code...
                    }
                    // var_dump($vall->idetudiant);
                    $quiznote=$DB->get_records("quiz_grades", array("quiz"=>$_POST["test"],"userid"=>$vall->idetudiant));
                    // var_dump($value->id);die;
                
                    foreach($quiznote as $key =>$valllle)
                    {

                    }
                    if($_POST["test"])
                    {

                        if($value->idetudiant==$valllle->userid && $value->idetudiant!=null)
                        {
                        
                            
                            $noteetu=new stdClass();
                            $noteetu->id=$value->id;
                            $noteetu->idaffecterprof=$_GET['id'];
                            $noteetu->idbulletin=$_GET['idbu'];
                            $noteetu->idetudiant=$valllle->userid;
                            
                            $vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_GET["idca"]."'");
                            
                            foreach($vericam as $key)
                            {}
                            if($_POST["normalcc"]=="cc")
                            {
                                    if($key->libelletype=="universite")
                                    {
                                    
                                    $noteetu->note2=$valllle->grade;
                                    var_dump($noteetu);
                                }else
                                {
                                    \core\notification::add('Vos ne pouvez pas remplir les données dans la case controle continu', \core\output\notification::NOTIFY_ERROR);
            
                                    redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'');                        
                                }
                            }
                            else
                            {
                                $noteetu->note3=$valllle->grade;
                                
                            }
                            // var_dump( $noteetu->note2);die;
                            $DB->update_record("listenote", $noteetu);
                        }
                        // die;
                    }
                    else if($_POST["lesson"])
                    {
                        // $lesson_gradee=$DB->get_records("lesson_attempts",array("lessonid"=>$_POST["lesson"],"userid"=>$vall->idetudiant));
                        // foreach($lesson_gradee as $key =>$lesgra)
                        // {}
                        // $lesson_answers=$DB->get_records_sql("SELECT SUM(score) as moye FROM {lesson_answers} WHERE lessonid='".$lesgra->lessonid."' AND pageid='".$lesgra->pageid."' AND id='".$lesgra->answerid."'");
                        // foreach($lesson_answers as $key =>$lesan)
                        // {}
                        $noteles=$DB->get_records("lesson_grades",array("lessonid"=>$_POST["lesson"],"userid"=>$vall->idetudiant));
                            foreach($noteles as $key =>$lesan)
                            {}
                            if($value->idetudiant==$lesan->userid)
                            {
                            
                                
                                $noteetu=new stdClass();
                                $noteetu->id=$value->id;
                                $noteetu->idaffecterprof=$_GET['id'];
                                $noteetu->idbulletin=$_GET['idbu'];
                                $noteetu->idetudiant=$lesan->userid;
                                if($_POST["normalcc"]=="cc")
                                {
                                    $vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_GET["idca"]."'");

                                    foreach($vericam as $key)
                                    {}
                                    if($key->libelletype=="universite")
                                    {

                                        $noteetu->note2=($lesan->grade*$bonte->grade)/100;
                                    }else
                                    {
                                        \core\notification::add('Vos ne pouvez pas remplir les données dans la case controle continu', \core\output\notification::NOTIFY_ERROR);
                
                                        redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'');                        
                                    }
                                }
                                else
                                {
                                    $noteetu->note3=($lesan->grade*$bonte->grade)/100;
                                    
                                }
                                // var_dump( $noteetu->note2);die;
                                $DB->update_record("listenote", $noteetu);
                            }
                        

                    }
                    
                }
                // die;
            }else
            {
                \core\notification::add('Selectionner le type de note'.$value->libellespecialite.'', \core\output\notification::NOTIFY_ERROR);
                redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'');
            }

        }

 redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'', 'les notes ont été bien enregistrées');

}else
{
    $notes=$_POST['noteaj'];
    $notescc=$_POST['notecc'];
    $itest=0;
    $itest1=0;

    // var_dump($notes,$notescc);
    // die;

    foreach ($notes as $userId => $note) {
                // var_dump($note,$userId);
                // Enregistrer la note dans la base de données ou effectuer toute autre opération nécessaire
                // Utilisez $userId comme identifiant de l'étudiant et $note comme note soumise
                // $data = $userId . ": " . $note . "\n";
                // var_dump($data,"idaff=".$_GET['id']); 
    
                //select la ligne correspondant dans la liste de note
                    if(!empty($note)){
                        $ligneliste=$DB->get_records("listenote",array("idaffecterprof"=>$_GET['id'],"idetudiant"=>$userId));
                        foreach ($ligneliste as $key => $value) {
                            # code...
                        }
                        // var_dump($value->id);die;
                        $noteetu=new stdClass();
                        $noteetu->id=$value->id;
                        $noteetu->idaffecterprof=$_GET['id'];
                        $noteetu->idbulletin=$_GET['idbu'];
                        $noteetu->idetudiant=$userId;
                        $noteetu->note3=$note;
                        $DB->update_record("listenote", $noteetu);
                        
                        $itest++;
                    }
                    
                }
                //cc
$vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_GET["idca"]."'");

                    foreach($vericam as $key)
                    {}
                    if($key->libelletype=="universite")
                    {
                        foreach ($notescc as $userId => $note) {
                            // var_dump($note,$userId);
                            // Enregistrer la note dans la base de données ou effectuer toute autre opération nécessaire
                            // Utilisez $userId comme identifiant de l'étudiant et $note comme note soumise
                            // $data = $userId . ": " . $note . "\n";
                            // var_dump($data,"idaff=".$_GET['id']); 
                
                            //select la ligne correspondant dans la liste de note
                                if(!empty($note)){
                                    $ligneliste=$DB->get_records("listenote",array("idaffecterprof"=>$_GET['id'],"idetudiant"=>$userId));
                                    foreach ($ligneliste as $key => $value) {
                                        # code...
                                    }
                                    // var_dump($value->id);die;
                                    $noteetu=new stdClass();
                                    $noteetu->id=$value->id;
                                    $noteetu->idaffecterprof=$_GET['id'];
                                    $noteetu->idbulletin=$_GET['idbu'];
                                    $noteetu->idetudiant=$userId;
                                    $noteetu->note2=$note;
                                    $DB->update_record("listenote", $noteetu);
                                    
                                    $itest1++;
                                }
                                
                            }
                    }
                    // else
                    // {
                    //     // \core\notification::add('Vos ne pouvez pas remplir les données dans la case controle continu', \core\output\notification::NOTIFY_ERROR);

                    //     redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'');                        
                    // }
   
    
                // if($itest==0)
                // {
                //     \core\notification::add('Remplissez au moins une case pour la normal'.$value->libellespecialite.'', \core\output\notification::NOTIFY_ERROR);
    
                //     redirect($CFG->wwwroot . '/local/powerschool/entrernote.php');
                // }
                // else
                // {
    
                    // var_dump($_GET["idbu"],$_GET["idsa"],$_GET["idcour"],$_GET["idsp"],$_GET["idcy"],$_GET["idsem"],$_GET["idca"],$_GET["idan"]);die;
                    redirect($CFG->wwwroot . '/local/powerschool/entrernote.php?idbu='.$_GET["idbu"].'&idsa='.$_GET["idsa"].'&idcour='.$_GET["idcour"].'&idsp='.$_GET["idsp"].'&idcy='.$_GET["idcy"].'&idsem='.$_GET["idsem"].'&idca='.$_GET["idca"].'&idan='.$_GET["idan"].'&libelcou='.$_GET["libelcou"].'', 'les notes ont été bien enregistrées');
                // }
                // die;
                // die;
                
}
?>