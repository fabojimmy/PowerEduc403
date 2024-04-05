<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\affecterprof;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/affecterprof.php');
require_once(__DIR__ .'/../../group/lib.php');
require_once(__DIR__ .'/idetablisse.php');
global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/ressource.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('affecterprof', 'local_powerschool'));
// $PAGE->set_heading(get_string('affecterprof', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('affecterprof', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new affecterprof();
$titre=$_POST["titre"];
$description=$_POST["description"];
$datedebuti=$_POST["datedebuti"];
if(!empty($titre)&&!empty($description))
{

    // die;
    // !empty($titre)&&!empty($description)&&!empty($datedebuti)&&!empty($_POST["datefinuti"])
    // var_dump(ChangerSchoolUser($USER->id));
    // die;
    $ressource=new StdClass();
    $ressource->ressource=$_POST["resotest"];
    $ressource->description=$_POST["description"];
    $ressource->titre=$_POST["titre"];
    $ressource->heurdebut=$_POST["heurdebut"];
    $ressource->heurfin=$_POST["heurfin"];
    $ressource->idanneescolaire=$_POST["idanneescolaire"];
    $ressource->idtransport=0;
    $ressource->idcantine=0;
    $ressource->idbatiment=0;
    $ressource->idsalle=0;
    $ressource->idmateriels=0;
    if($_POST["Salle"])
        {
            $ressource->idsalle=$_POST["Salle"];
    
            // var_dump($ressource->idsalle);
            // die;
        }
        else if($_POST["Transport"])
        {
            // die;
            $ressource->idtransport=$_POST["Transport"];
        }
        else if($_POST["Cantine"])
        {
            $ressource->idcantine=$_POST["Cantine"];
        
        }
        else if($_POST["Batiment"])
        {
            $ressource->idbatiment=$_POST["Batiment"];
            // var_dump($_POST["Batiment"],$_POST["Salle"]);die;

        }
        else if($_POST["Materiels"])
        {
            $ressource->idmateriels=$_POST["Materiels"];
        }
        $ressource->idcampus=$_POST["idcampus"];
        // var_dump($ressource->idcampus);die;
    
    // $datesea=array();
    $datesea=$_POST["datedebuti"];
    $dateArr = explode('-', $datesea);
    $ressource->datedebuti= strtotime($dateArr[2]."-".$dateArr[1]."-".$dateArr[0]);
    // $date = date('d-M-Y', $ressource->datedebuti);
    // var_dump($ressource,$datesea["day"],$ressource->datedebuti);die;
    // $ressource->datedebuti= 1700438400;
    $dateseafin=$_POST["datefinuti"];
    $dateArrfin = explode('-', $dateseafin);
    $ressource->datefinuti= strtotime($dateArrfin[2]."-".$dateArrfin[1]."-".$dateArrfin[0]);
    
    // var_dump(ChangerSchoolUser($USER->id),$ressource->idcampus);
    // die;
    $ressource->timecreated=time();
    $ressource->timemodified=time();
    $ressource->id=0;
    for($i=0;$i<=$_POST["nbresemaine"];$i++)
    {
        $date =  $ressource->datedebuti + ($i * 604800);

        // var_dump($date);
        $datetestfin = date('d-M-Y',$ressource->datefinuti);
        // var_dump(date("Y/m/d",$recordtoinsert->datecours));
        // var_dump($recordtoinsert->datefincours,$date);
        // var_dump($datetest,$datetestfin);
        if(empty($_POST["datefinuti"])&&empty($_POST["datedebututi"] && !empty($_POST["idsemestre"])))
        {
            $veridat=$DB->get_records_sql("SELECT * FROM {semestre} WHERE id='".$_POST["idsemestre"]."'");
    
            foreach($veridat as $key)
            {}
            $date =  $key->datedebutsemestre + ($i * 604800);
            $datetestfin =  date('d-M-Y',$key->datefinsemestre);
            $ressource->datefinuti=$key->datedebutsemestre;
            // $recordtoinsert->datecours=$date;
        }
    
        $datetest = date('d-M-Y',$date);
    
        // var_dump($datetest,$datetestfin);
        // die;
        if($datetest<=$datetestfin)
        {
            if(!empty($_POST["idsemestre"])){
                
                // $semm = $mform->definir_semestre($date,$_POST["idsemestre"]);
                // $recordtoinsert->idsemestre = $semm;
                // var_dump($semm,$i,$_POST["datefincours"],$_POST["datecours"]);
            }
            // $verappartint=$DB->get_records_sql("SELECT * FROM {programme} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND DATE_FORMAT(FROM_UNIXTIME(datecours), '%e-%c-%Y')='".$date."' AND heuredebutcours='".$_POST["heuredebutcours"]."' AND heurefincours='".$_POST["heurefincours"]."'");
            
            // if(empty($verappartint))
            // {
            //     $recordtoinsert->datecours=$date;
    
            // }
            // else
            // {
            //     array_push($tardateocc,$date."-".$_POST["heuredebutcours"]);
            // }
            
        }
        $DB->execute("INSERT INTO {ressource} VALUES (0,'".$_POST["resotest"]."','".$_POST["titre"]."','".$_POST["description"]."', '$ressource->idsalle','$ressource->idcantine','$ressource->idbatiment','$ressource->idtransport','$ressource->idmateriels','".ChangerSchoolUser($USER->id)."','$date','$ressource->datefinuti','$ressource->heurdebut','$ressource->heurfin','$USER->id','$ressource->idanneescolaire','".time()."','".time()."')");
    }


    // die;
    // $titre=$_POST["titre"];

    redirect($CFG->wwwroot . '/local/powerschool/ressource.php', 'Information Bien ajoute');
    
}

//Archive

if(!empty($_GET["action"])&&!empty($_GET["ida"]))
{
    $GY=$DB->get_records('ressource',array("id" => $_GET["ida"]));
    
    foreach($GY as $key=>$value)
    {}
    $AR=$DB->get_records('archiver',array("idressource" => $_GET["ida"],
                                        "dateressource"=>$value->datedebuti,
                                        "idanneescolaire"=>$value->idanneescolaire));
 if(empty($AR))
    {
        
        $DB->insert_record('archiver',array(
                                           "idressource"=>$_GET["ida"],
                                           "dateressource"=>$value->datedebuti,
                                           "usermodified"=>$USER->id,
                                           "idanneescolaire"=>$value->idanneescolaire,
                                           "timecreated"=>time(),
                                           "timemodified"=>time(),
                                        ));
    }else
    {
        \core\notification::add('Désole avais déjà archivé ça', \core\output\notification::NOTIFY_ERROR);

        redirect($CFG->wwwroot . '/local/powerschool/ressource.php');
    }

redirect($CFG->wwwroot . '/local/powerschool/ressource.php', 'Information Bien Archivée');
}


//affichage de données
if($_GET["id"])
{
    // var_dump($_GET["id"]);die;
    $DB->delete_records("ressource",array("id"=>$_GET["id"]));
    redirect($CFG->wwwroot . '/local/powerschool/ressource.php', 'Information Bien supprimée');
}

if($_GET["res"]=="salle")
{
    $sql = "SELECT s.id,s.idcampus,numerosalle,libellecampus,capacitesalle,villecampus FROM {campus} c, {salle} s WHERE s.idcampus=c.id AND s.idcampus ='".ChangerSchoolUser($USER->id)."'";
    $libelle=get_string('salle', 'local_powerschool');

}
else if($_GET["res"]=="bus")
{
    $sql = "SELECT t.id,matricule,marque,place,t.description,firstname,lastname FROM {user} u,{transport} t WHERE u.id = t.idconducteur and t.idcampus='".ChangerSchoolUser($USER->id)."'";
    $libelle=get_string('transport', 'local_powerschool');
}
else if($_GET["res"]=="cantine")
{
    $sql = "SELECT * FROM {cantine} s WHERE s.idcampus = '".ChangerSchoolUser($USER->id)."'";
    $libelle=get_string('cantine', 'local_powerschool');

}
else if($_GET["res"]=="batiment")
{
    $sql = "SELECT c.id,c.idcampus,c.numerobatiment,libellecampus,villecampus FROM {batiment} c, {campus} s WHERE c.idcampus=s.id AND c.idcampus ='".ChangerSchoolUser($USER->id)."'";
    $libelle=get_string('batimenttitle', 'local_powerschool');
}
else if($_GET["res"]=="materiels")
{
    $sql = "SELECT * FROM {materiels} c, {campus} s WHERE c.idcampus=s.id AND c.idcampus ='".ChangerSchoolUser($USER->id)."'";
    $libelle=get_string('materiel', 'local_powerschool');
}

$tarressources=array();
if($_GET["res"]!=null)
{
    $tarressources = $DB->get_records_sql($sql);
    // var_dump($tarressources);die;
}

// var_dump($libelle);die;
$ressourceContenu=array();

if($_GET["res"]=="salle")
{
    foreach($tarressources as $tarressource)
    {
        $id=$tarressource->id;
        $libelleres=$tarressource->numerosalle;
        
        $tarressource->id=$id;
        $tarressource->libelleres=$libelleres;

        // var_dump($ressourceContenu);die;
    }
    
}

else if($_GET["res"]=="bus")
{
    foreach($tarressources as $tarressource)
    {
        $id=$tarressource->id;
        $libelleres=$tarressource->marque;
        $matricule=$tarressource->marque;
        
        $tarressource->id=$id;
        $tarressource->libelleres=$libelleres;
        $tarressource->matricule=$matricule;

    }
}
else if($_GET["res"]=="cantine")
{
    foreach($tarressources as $tarressource)
    {
        $id=$tarressource->id;
        $libelleres=$tarressource->libellecantine;
        
        // var_dump($id);die;
        $tarressource->id=$id;
        $tarressource->libelleres=$libelleres;
    }
}
else if($_GET["res"]=="batiment")
{
    foreach($tarressources as $tarressource)
    {
        $id=$tarressource->id;
        $libelleres=$tarressource->numerobatiment;
        // var_dump($libelleres);die;

        $tarressource->id=$id;
        $tarressource->libelleres=$libelleres;
    }   
}
else if($_GET["res"]=="materiels")
{
    foreach($tarressources as $tarressource)
    {
        $id=$tarressource->id;
        $libelleres=$tarressource->libellemate;

        $tarressource->id=$id;
        $tarressource->libelleres=$libelleres;
    }   
}

$sql="SELECT * FROM {ressource} WHERE idcampus='".ChangerSchoolUser($USER->id)."' AND id NOT IN (SELECT idressource FROM {archiver})";
$datefor=$DB->get_records_sql($sql);

$libellesql="";
foreach($datefor as $key=>$value)
{
    if($value->ressource=="salle")
      {
        $sqlsalle="SELECT * FROM {salle} WHERE id='".$value->idsalle."'";
        $salle=$DB->get_records_sql($sqlsalle);

        foreach($salle as $key=>$valuesa)
        {}

        $libellesql=$valuesa->numerosalle;
      }
    if($value->ressource=="bus")
      {
        $sqltrans="SELECT * FROM {transport} WHERE id='".$value->idtransport."'";
        $transport=$DB->get_records_sql($sqltrans);

        foreach($transport as $key=>$valuetra)
        {}

        $libellesql=$valuetra->marque."-".$valuetra->matricule;
      }
    if($value->ressource=="cantine")
      {
        $sqlcant="SELECT * FROM {cantine} WHERE id='".$value->idcantine."'";
        $cantine=$DB->get_records_sql($sqlcant);

        foreach($cantine as $key=>$valuecant)
        {}

        $libellesql=$valuecant->libellecantine;
      }
    if($value->ressource=="batiment")
      {
        $sqlbati="SELECT * FROM {batiment} WHERE id='".$value->idbatiment."'";
        $batiment=$DB->get_records_sql($sqlbati);

        foreach($batiment as $key=>$valuebati)
        {}

        $libellesql=$valuebati->numerobatiment;
        // $value->libellesql=$libellesql;
      }
    if($value->ressource=="materiels")
      {
        $sqlbati="SELECT * FROM {materiels} WHERE id='".$value->idmateriels."'";
        $batiment=$DB->get_records_sql($sqlbati);

        foreach($batiment as $key=>$valuebati)
        {}

        $libellesql=$valuebati->libellemate;
      }
    $value->libellesql=$libellesql;

    $timed = $value->datedebuti;
    $dated = date('d-M-Y',$timed);
    $value->datedebuti=$dated;
    
    //
    // $timef = $value->datefinuti;
    // $datef = date('d-M-Y',$timef);
    // $value->datefinuti=$datef;

    // $time = $ab->datedebut;
    // $timef = $ab->datefin;

    // $dated = date('Y',$time);
    // $datef = date('Y',$timef);

    // $ab->datedebut = $dated;
    // $ab->datefin = $datef;
}

$annee=$DB->get_records("anneescolaire");
// die;
foreach($annee as $key =>$ab)
{
    $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
}
$semestre=$DB->get_records('semestre');

$templatecontext = (object)[
    
    'tarressources' => array_values($tarressources),
    'libelle' => $libelle,
    'annee' => array_values($annee),
    'semestre' => array_values($semestre),
    'datefor' => array_values($datefor),
    'affecterprofedit' => new moodle_url('/local/powerschool/affecterprofedit.php'),
    'ressourcesuppr' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcecombo'=> new moodle_url('/local/powerschool/ressource.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'ressourcelien' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcearchive' => new moodle_url('/local/powerschool/ressource.php'),
    'ressourcelist' => new moodle_url('/local/powerschool/ressourcelist.php'),
    'root'=>$CFG->wwwroot,
    'resotest'=>$_GET["res"],
    'idca'=>ChangerSchoolUser($USER->id),
    'affec'=>"Reserver une ressource"
];
// var_dump($_GET["res"]);die;
$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),
    'materiell' => new moodle_url('/local/powerschool/materiels.php'),
    'groupe' => new moodle_url('/local/powerschool/groupsalle.php'),
    'ressource' => new moodle_url('/local/powerschool/ressource.php'),

    ];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/affecterprof.php'),
    ];
// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),
// ];


echo $OUTPUT->header();

if($CFG->theme=="boost")
{
    echo'<div class="" style="margin-top:110px;"></div>';
}
elseif ($CFG->theme == 'adaptable') {
    // Changer la couleur en bleu
    echo'<div class="" style="margin-top:50px;"></div>';
    
}

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo '<div style="margin-top:80px";><wxcvbn</div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/ressource', $templatecontext);


echo $OUTPUT->footer();