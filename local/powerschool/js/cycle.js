
$(".toutly").change(function() {
    // Cocher/décocher toutes les cases à cocher du tableau en fonction de l'état de la case à cocher principale
    $(".checkboxItem").prop("checked", $(this).prop("checked"));
});

$(".ajou").click(function (e) {
    e.preventDefault(); // Empêcher la soumission du formulaire normalement
    var cycle = $("input[name='cycle[]']:checked")
        .map(function () {
            return this.value;
        })
        .get()
        .join(",");

        // alert("fff")
    // var redirectionUrl =
    //     $("#autoRedirectForm").attr("action") + "?idetu=" + idetudiants;
    // window.location.href = redirectionUrl;
    // // $("input[type='submit']").trigger("click");
    var route=$(".roote").val();
    var idcampus=$(".campus").val();
    $.ajax({
        url: route+"/local/powerschool/classes/cycleexe.php",
        type: 'POST',
        data: {cycle:cycle,
               idcampus:idcampus},
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