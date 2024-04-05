<?php

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/idetablisse.php');
require_once(__DIR__.'/fichepaie.php');
global $DB;
global $USER;
$sql="SELECT us.id as userid,firstname,lastname FROM {user} as us,{role_assignments} WHERE us.id=userid AND roleid=3 AND us.idcampuser='".ChangerSchoolUser($USER->id)."'";
$sql1="SELECT fullname,nombreheure FROM {coursspecialite} as csp,{courssemestre} css,{affecterprof} af,{course} co 
       WHERE csp.id = css.idcoursspecialite AND css.id=af.idcourssemestre AND co.id=csp.idcourses AND af.idprof='".$_GET["idprof"]."'";
// var_dump($USER->id);die;
$professeur=$DB->get_records_sql($sql);
$coursheur=$DB->get_records_sql($sql1);
$sqluser=$DB->get_record("user",array("id"=>$_GET["idprof"]));


$sommeheur=0;
foreach ($coursheur as $key => $value) {
    
    $sommeheur=$sommeheur+$value->nombreheure;
    
}

$idprof = (empty($_GET["idprof"])) ? 1 : $_GET["idprof"];
$anneede = (empty($_GET["anneede"])) ? "2023-02-12" : $_GET["anneede"];
$anneefin = (empty($_GET["anneefin"])) ? "2023-02-12" : $_GET["anneefin"];

var_dump(date("Y-m-d H:i:s",1708757676));

$ecc= '
<div class="container">

                <div class="header">
                        <div class="headerlogo">
                            <div class="logo">logo</div>
                            <select class="form-control" onchange="if (this.value) location.href=this.value;">
                               <option>'.$sqluser->firstname."-".$sqluser->lastname.'</option>
                            ';
                            
                            foreach ($professeur as $key => $value) {
                                # code...
                                $ecc.='<option value="'.$CFG->wwwroot.'/local/powerschool/viewfichepaie.php?idprof='.$value->userid.'">'.$value->firstname."--".$value->lastname.'</option>';
                            }
                           $ecc.= '</select>
                        </div>
                        <div class="headerpaie">
                                <div class="headerpaiebul">
                                        <span>BULLETIN  DE PAIE</span>
                                        <div class="headerpaiebulmois">
                                            <h6>Mois de</h6>
                                            <div>
                                             <form method="get" action="'.$CFG->wwwroot.'/local/powerschool/viewfichepaie.php"> 
                                                <input type="date" name="anneede" value="'.$_GET["anneede"].'">
                                                <input type="date" name="anneefin" value="'.$_GET["anneefin"].'">
                                                <input type="hidden" name="idprof" value='.$_GET["idprof"].'>
                                                <input type="submit" value="valider">
                                              
                                            </div>
                                        </div>
                                 </div>
                                 <div class="headerorder">
                                        <div class="order" data-id="1">
                                            <span>N ORDRE</span>
                                            <h6>A 130007</h6>
                                        </div>
                                        <div class="order" data-id="2">
                                            <span>TEMPS DE TRAVAIL</span>';

                                            if($sommeheur>120){

                                                $ecc.='<h6>+ DE 120H</h6>';
                                            }else if($sommeheur<120)
                                            {
                                                $ecc.='<h6>- DE 120H</h6>';
                                                
                                            }else{
                                                $ecc.='<h6>DE 120H</h6>';
                                                
                                            }
                                            

                                        $ecc.='</div>
                                </div>
                        
                        </div>
                </div>

                <div class="header2">
                    <div class="headeraffec">
                       <div class="titreheader2 "><h5 class="affec">AFFECTATION</h5></div>
                       <div class="headeraffecposte">
                          <div class="">
                              <lu class="liste">';

                              foreach ($coursheur as $key => $value) {
                                # code...
                              $ecc.= '<li>'.$value->fullname.'/'.$value->nombreheure.'H</li>';
                              }

                              $ecc.='</lu>
                              </div>
                              </div>
                              </div>
                              
                              </div>
                              
                              <div class="header3">
                              <div class="">
                              <div class="identit"><h4>IDENTIFICATION</h4></div>
                              <div class="header3iden">
                              <div>
                              <div class="ele"><span>MIN<span> </div>
                              <div class=""><span>Numero</span></div>
                              <div class=""><span>CLE</span></div>
                                <div class=""><span>NDOS</span></div>
                            </div>
                        
                            <div class="idenres">
                            <div class=""><span>4<span></div>
                                <div class=""><span>2222</span></div>
                                <div class=""><span>0</span></div>
                                <div class=""><span>232</span></div>
                            </div>
                       </div>
                    </div>
                   
                       

                            
                                    <div class="grade">
                                        <h4>GRADE</h4>
                                    
                                       <h6>PROF.CERTIFIE CN</h6>
                                    </div>
                            
                            
                          
                             <div class="nbr"><span>ECH</span><span>0</span> </div>
                             <div class="nbr"><span>INDICE DU NB DHEURE</span> <span>3</span></div>
                             <div class="nbr"><span>TAUX HORAIRE OU NBI</span> <span>5</span></div>
                             <div class="nbr"><span>TEMPS PARTIEL </span> <span>15</span></div>
                          

                             
            
                </div>


                <table>
                        <tr>
                          <th>ELEMENTS</th>
                          <th>PAYER</th>
                       
                        </tr>

                        <tr>
                          <td>
                          
                                <div>Total Vacation HT</div>
                                <div>Total Vacation TTC</div>
                                <div>Montant Total</div>
                                <div>l accompte</div>
                                <div>Total IRPP</div>
                                <div>Total à payer</div>
                            
                          </td>
                          <td>
                          
                          
                                <div>0</div>
                                <div>0</div>
                                <div>0</div>
                                <div>0</div>
                                <div>0</div>
                                <div>'.mtntTotal($idprof,$anneede,$anneefin).'</div>
                            
                          </td>
                          
                        </tr>
                </table>
          </div>
     
     ';

     print $ecc;

   
?>

<style>

    body{
        padding: 0;
        margin: 0;
    }
    .container{

        margin :90px;
        background-color: gainsboro;
        font-family: monospace;
    }
    .header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 20px;
        /* background: yellow; */
    }
    .headerpaie{

        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

    }
    .headerpaiebul{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        margin: 0 100px 0 0;
        background-color: gray;
        color: white;
        padding: 10px 90px 0px 40px;
    }
    .headerpaiebulmois{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .headerlogo{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .headerlogo .logo{
        margin-right: 12px;
        padding: 2.5em;
        background-color: red;
    }
    .headerorder{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }
    .headerorder .order{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 0;
    }
    .headerorder .order[data-id="1"] h6{
        width: 160px;
        background-color: white;
        margin-left: 12px;
    }
    .headerorder .order[data-id="2"] h6{
        width: 90px;
        background-color: white;
        margin-left: 12px;
    }

    /* header2 */

    .header2{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        /* background: green; */
        margin: 20px;
        
    }
    .headeraffec{
        
        border: 1px solid black;
        border-top: none;
        /* height: 60px; */
        line-height: 15px;
        width: 100%;
    }
    .rect{
        padding: 0;
        margin: 0;
        /* background-color: blue; */
        margin-top: -30px;

    }
    .header2 .headeraffec .headeraffecposte{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;

    }
    .header2 .titreheader2{
        background: gray;
        padding: 0 260px 0 0;
        /* position: relative;
        top: 50%;
        transform: translateY(-50%); */
       
    }
    .header2 .titreheader2 .affec{
        margin: 0;
        padding: 0;
        margin-top: -10px;
    }
    .header2 .titreheader2 h5{
        text-align: center;
    }
    .liste {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    ul{
        
    }

    .header2 .headeraffec:nth-child(2){
        padding: 0 300px 0 0;
        /* background: darkblue; */
    }
    .header2 .headeraffec:nth-child(2) .titreheader2{
        /* padding: 0 500px 0 150px; */
        width: 100%;
        text-align: center;
    }
   
    /* header3 */

    .header3{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        /* background: greenyellow; */
        margin: 20px;
    }
    .header3iden{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }
    .header3iden div {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

        margin: 5px 5px 5px 5px;
    }
    .header3en{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 5px 5px 5px 5px;
    }
    .ele{
        display: flex;
        flex-direction: column;
        
    }

    .header3 .header3iden .idenres div{
        margin: 4px 15px 4px 4px;
        /* background: white; */
    }
    .nbr{
        display: flex;
        flex-direction: column;
        /* background-color: blue; */
        border: 1px solid black;
        border-top: none;
    }
    .header3 .nbr span:nth-child(1){
        /* margin: 12px 12px 15px 12px; */
        background-color: gray;
        color: white;
    }
    .header3 .nbr span:nth-child(2){
        margin: 12px 12px 15px 12px;
        /* background-color: red; */
        color: red;
    }
    .header3 .identit{
        background-color: gray;
        color: white;
    }
    .header3 .grade h4{
        background-color: gray;
        color: white;
    }
    .header3iden div:nth-child(1) span{
        background-color: gray;
        color: white;
    }

    table{

        padding: 25px;
        /* background: blue; */
        /* border: 1px solid black; */
        width: 100%;
        border-collapse: collapse;
        margin: 2px;
    }
    tr th{
        border: 1px solid black;
        background: gray;
        
    }
    tr td{
        border: 1px solid black;
        border-bottom: none;
        
    }
    tr td div{
        border: 1px solid black;
        border-top: 0;
        border-right: 0;
        border-left: 0;
        padding: 5px;
        
    }
</style>