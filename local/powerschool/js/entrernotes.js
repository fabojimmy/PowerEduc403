
$(document).ready(function () {
    // $(".btnmodnote").click(function (e) { 
        //     e.preventDefault();
        
        //      $(".inputnoteuser").val($(".inputmodi").val());
        // });
        // var btnmo=document.querySelectorAll(".btnmodnote")
        // btnmo.forEach((e) => {
        //     e.addEventListener("click",(e)=>{
        //          e.preventDefault();
        //      var inputmodi=document.querySelectorAll(".inputmodi")
             
        //      inputmodi.forEach((e1)=>{
        //               alert(e1.value)
        //           })
        //         //  alert("f")
        //  })
        // });

       
function copierNoteToModi(input, event) {
    // Empêcher le comportement par défaut du bouton (rafraîchissement de la page)
    event.preventDefault();

    // Récupérer la valeur de la note
    var note = input.value;

    // Trouver l'élément input de modification à côté du bouton
    var inputModi = input.parentElement.querySelector(".inputmodi");

    // Mettre la valeur de la note dans le champ de modification
    inputModi.value = note;
    alert("fghjk",inputModi)
  }

});
