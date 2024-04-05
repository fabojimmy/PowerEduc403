$(document).ready(function(){
    //Charge les éléments p depuis la page "une/url" et les insère dans #res
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
    $(".cycle").change(function (e) { 
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(".specialite").val();
        var cycle=$(this).val();
        // alert(cycle);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/bulletinfiltreretu.php",
            data: {cycle:cycle,specialite:specialite},
            success: function (respone) {
                // alert(respone)
                $(".bull").html(respone);
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
            url: route+"/local/powerschool/classes/sallelefiltreretu.php",
            data: {cycle:cycle,specialite:specialite},
            success: function (respone) {
                // alert(respone)
                $(".sall").html(respone);
            }
        });
    });

    $(".tirerbull").click(function(e){
        e.preventDefault();
        var route=$(".roote").val();
        var specialite=$(".specialite").val();
        var cycle=$(".cycle").val();
        // alert(specialite);
        $.ajax({
            type: "post",
            url: route+"/local/powerschool/classes/tirebulletin.php",
            data: {cycle:cycle,specialite:specialite},
            success: function (respone) {
                // alert(respone)
                // $(".bull").html(respone);
                location.href=route+"/local/powerschool/Toutbulletin.php?idsp="+respone.specialite+"&idcy="+respone.cycle+"";
            }
        });
        // alert("jkjhg")

    })

    // Rediriger automatiquement lorsqu'on appuie sur le bouton
    // $("#autoRedirectForm").submit(function (event) {
    //     event.preventDefault(); // Empêcher la soumission du formulaire normalement
    //     var idetudiants = $("input[name='idetu[]']")
    //         .map(function () {
    //             return this.value;
    //         })
    //         .get()
    //         .join(",");
    //     var redirectionUrl =
    //         $(this).attr("action") + "?idetu=" + idetudiants;
    //     window.location.href = redirectionUrl;
    // });
    $(".tirerr").click(function (e) {
        e.preventDefault(); // Empêcher la soumission du formulaire normalement
        var idetudiants = $("input[name='idetu[]']")
            .map(function () {
                return this.value;
            })
            .get()
            .join(",");

            // alert( idetudiants)
        var redirectionUrl =
            $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
        window.location.href = redirectionUrl;
        // $("input[type='submit']").trigger("click");
        $.ajax({
            url: redirectionUrl,
            type: 'GET',
            success: function () {
                // Le bulletin de chaque étudiant a été imprimé avec succès
                $("#successMessage").show();
            },
            error: function () {
                // Gérer les erreurs si nécessaire
            }
        });
    });

    // Cliquer automatiquement sur le bouton de soumission

    // alert("bn,;")
});