$(document).ready(function(){
    // alert("sdf")
    //Charge les éléments p depuis la page "une/url" et les insère dans #res
    $(".specialite").change(function (e) { 
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(this).val();
        // alert(specialite);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/affecterproffiltrer.php",
            data: {specialite:specialite},
            success: function (response) {
                $(".cycle").html(response);
            
                // throw new Error('ssh');
                return;
            }
        });
    });
    $(".cycle").change(function (e) { 
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(".specialite").val();
        var cycle=$(this).val();
        // alert(cycle);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/affecterproffiltrersemesann.php",
            data: {cycle:cycle,specialite:specialite},
            success: function (respone) {
                // alert(respone)
                $(".annee").html(respone);
            }
        });
    });
    $(".annee").change(function (e) { 
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(".specialite").val();
        var cycle=$(".cycle").val();
        var annee=$(this).val();
        // alert(cycle);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/affecterproffiltrercour.php",
            data: {cycle:cycle,specialite:specialite,annee:annee},
            success: function (respone) {
                // alert(respone)
                $(".cours").html(respone);
            }
        });
    });
    $(".cours").change(function (e) { 
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(".specialite").val();
        var cycle=$(".cycle").val();
        var cours=$(this).val();
        // alert(cours);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/affecterproffiltrersemes.php",
            data: {cycle:cycle,specialite:specialite,cours:cours},
            success: function (respone) {
                // alert(respone)
                $(".semestre").html(respone);
            }
        });
    });
});