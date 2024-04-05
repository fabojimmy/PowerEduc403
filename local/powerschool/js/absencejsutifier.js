
//filter salleeteretirer

$(".filiere").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var filiere=$(this).val();
    // alert(specialite);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/bulletinfilitre.php",
        data: {filiere:filiere},
        success: function (response) {
            $(".specialite").html(response);
        
            // throw new Error('ssh');
            return;
        }
    });
});
$(".specialite").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite=$(this).val();
    // alert(specialite);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/bulletinfilitre.php",
        data: {specialite:specialite},
        success: function (response) {
            $(".cycle").html(response);
        
            // throw new Error('ssh');
            return;
        }
    });
});
// $(".cycle").change(function (e) { 
//     e.preventDefault();
//     var route=$(".roote").val();
//     var specialite=$(".specialite").val();
//     var cycle=$(this).val();
//     // alert(cycle);
//     $.ajax({
//         type: "post",
//         url: route+"/local/powerschool/classes/bulletinfiltreretu.php",
//         data: {cycle:cycle,specialite:specialite},
//         success: function (respone) {
//             // alert(respone)
//             $(".bull").html(respone);
//         }
//     });
// });
$(".cycle").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite=$(".specialite").val();
    var cycle=$(this).val();
    // alert(cycle);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/sallelefiltrereturetir.php",
        data: {cycle:cycle,specialite:specialite},
        success: function (respone) {
            // alert(respone)
            sal=JSON.parse(respone);
            $(".salle1").html(sal.sallejs);
        }
    });
});
$(".salle1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite=$(".specialite").val();
    var cycle=$(".cycle").val();
    var salle=$(this).val();
    // alert(cycle);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/absenceetu.php",
        data: {cycle:cycle,specialite:specialite,salle:salle},
        success: function (respone) {
            // alert(respone)
            $(".sall").html(respone);
        }
    });
});
$(".cours").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var campus=$(".campus").val();
    var cours=$(this).val();
    console.log(cours,campus);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/heure.php",
        data: {cours:cours,campus:campus},
        success: function (respone) {
            // alert(respone)
            $(".heure").html(respone);
        }
    });
});

$("#checkboxMaster").change(function() {
    // Cocher/décocher toutes les cases à cocher du tableau en fonction de l'état de la case à cocher principale
    $(".checkboxItem").prop("checked", $(this).prop("checked"));
});
$(".validertrans").click(function (e) {
    e.preventDefault(); // Empêcher la soumission du formulaire normalement
    var idetudiants = $("input[name='useridche[]']:checked")
        .map(function () {
            return this.value;
        })
        .get()
        .join(",");

        // alert(salle)
        // var redirectionUrl =
        //     $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
        // window.location.href = redirectionUrl;
        // // $("input[type='submit']").trigger("click");
        var route=$(".roote").val();
        var salle=$(".salle").val();
        $.ajax({
        url: route+"/local/powerschool/classes/salleete.php",
        type: 'POST',
        data: {etudiantsid:idetudiants,salle:salle},
        success: function (response) {
            // Le bulletin de chaque étudiant a été imprimé avec succès
               alert("Bien affecté")
            },
            error: function () {
            alert("Error")
            // Gérer les erreurs si nécessaire
        }
    });
});
$(".validertransreti").click(function (e) {
    e.preventDefault(); // Empêcher la soumission du formulaire normalement
    var idetudiants = $("input[name='useridche[]']:checked")
        .map(function () {
            return this.value;
        })
        .get()
        .join(",");

        // alert(idetudiants)
    // var redirectionUrl =
    //     $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
    // window.location.href = redirectionUrl;
    // // $("input[type='submit']").trigger("click");
    var route=$(".roote").val();
    var salle=$(".salle1").val();
    $.ajax({
        url: route+"/local/powerschool/classes/salleeteretirer.php",
        type: 'POST',
        data: {etudiantsid:idetudiants,salle:salle},
        success: function (response) {
            // Le bulletin de chaque étudiant a été imprimé avec succès
               alert("Bien enleve")
            },
            error: function () {
            alert("Error")
            // Gérer les erreurs si nécessaire
        }
    });
});