
//filter salleeteretirer

// alert("df")
// alert("ffffffggg")
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
            tar=JSON.parse(respone)
            // for(var i=0;i< tar.length;i++){
                console.log(tar.sallejs);
                $(".salle1").html(tar.sallejs);
                $(".courss").html(tar.coursjs);
        // }
            // console.log(tar[0].sallejs)
        }
    });
});
// alert("dfgjk")
$(".salle1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite=$(".specialite").val();
    var cycle=$(".cycle").val();
    var salle=$(this).val();
    // alert(cycle);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/sallelefiltrereturetirannee.php",
        data: {cycle:cycle,specialite:specialite,salle:salle},
        success: function (respone) {
            // alert(respone)
            $(".annee1").html(respone);
        }
    });
});
$(".annee1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite=$(".specialite").val();
    var cycle=$(".cycle").val();
    var salle=$(".salle1").val();
    var annee=$(this).val();
    // alert(cycle);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/sallelefiltrereturetir1.php",
        data: {cycle:cycle,specialite:specialite,salle:salle,annee:annee},
        success: function (respone) {
            // alert(respone)
            $(".sall").html(respone);
        }
    });
});

$("#checkboxMaster").change(function() {
    // Cocher/décocher toutes les cases à cocher du tableau en fonction de l'état de la case à cocher principale
    $(".checkboxItem").prop("checked", $(this).prop("checked"));
});

// alert("hjklm")
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
        var specialite=$(".specialite").val();
        var cycle=$(".cycle").val();
        var annee=$(".annee").val();


        console.log(specialite,cycle)
        $.ajax({
        url: route+"/local/powerschool/classes/salleete.php",
        type: 'POST',
        data: {etudiantsid:idetudiants,salle:salle,specialite:specialite,cycle:cycle,annee:annee},
        success: function (response) {
            // Le bulletin de chaque étudiant a été imprimé avec succès
               alert(response)
            // console.log(response)
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
$(".group").click(function (e) {
    e.preventDefault(); // Empêcher la soumission du formulaire normalement
    // var idetudiants = $("input[name='useridche[]']:checked")
    //     .map(function () {
    //         return this.value;
    //     })
    //     .get()
    //     .join(",");

        // alert(idetudiants)
    // var redirectionUrl =
    //     $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
    // window.location.href = redirectionUrl;
    // // $("input[type='submit']").trigger("click");
    var specialite=$(".specialite").val();
    var cycle=$(".cycle").val();
    var route=$(".roote").val();
    var salle=$(".salle1").val();
    var cours=$(".courss").val();
    var campus=$(".campus").val();

    // alert(salle+"-"+cours+"-"+route)
    $.ajax({
        url: route+"/local/powerschool/classes/groupsalle.php",
        type: 'POST',
        data: {salle:salle,route:route,cycle:cycle,specialite:specialite,cours:cours,campus:campus},
        success: function (response) {
            // Le bulletin de chaque étudiant a été imprimé avec succès
            // console.log()
            repo=JSON.parse(response)
               window.location.href =repo.route+"/group/group.php"+ "?courseid=" +repo.cours + "&salle=" +repo.salle +"&idca=" +repo.campus+"&idsalle="+repo.idsalle;
            },
            error: function () {
            alert("Error")
            // Gérer les erreurs si nécessaire
        }
    });
});