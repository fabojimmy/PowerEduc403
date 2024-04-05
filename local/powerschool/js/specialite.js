$(".toutly").change(function() {
    // Cocher/décocher toutes les cases à cocher du tableau en fonction de l'état de la case à cocher principale
    $(".checkboxItem").prop("checked", $(this).prop("checked"));
});
$(".toutpr").change(function() {
    // Cocher/décocher toutes les cases à cocher du tableau en fonction de l'état de la case à cocher principale
    $(".checkboxItem").prop("checked", $(this).prop("checked"));
});
$(".ajou").click(function (e) {
    e.preventDefault(); // Empêcher la soumission du formulaire normalement
    var specia = $("input[name='specia[]']:checked")
        .map(function () {
            return this.value;
        })
        .get()
        .join(",");

        // alert(specia)
    // var redirectionUrl =
    //     $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
    // window.location.href = redirectionUrl;
    // // $("input[type='submit']").trigger("click");
    var route=$(".roote").val();
    var filiere=$(".filiere").val();
    var campus=$(".campus").val();

    // alert(campus+"-"+filiere)
    // alert("ghjk")
    $.ajax({
        url: route+"/local/powerschool/classes/specialiteexe.php",
        type: 'POST',
        data: {specia:specia,
               idfiliere:filiere,
                idcampus:campus},
        success: function (response) {
            // Le bulletin de chaque étudiant a été imprimé avec succès
               alert(response)
            },
            error: function () {
            alert("Error")
            // Gérer les erreurs si nécessaire
        }
    });
});