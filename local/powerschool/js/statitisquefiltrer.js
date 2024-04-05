// alert("rrr")
$(".campus1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var campus=$(this).val();
    // alert(campus);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/statistiquefiltre1.php",
        data: {campus:campus},
        success: function (response) {
            $(".filiere1").html(response);
        
            // throw new Error('ssh');
            return;
        }
    });
});
$(".filiere1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var filiere=$(this).val();
    // alert(filiere);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/bulletinfilitre.php",
        data: {filiere:filiere},
        success: function (response) {
            $(".specialite1").html(response);
        
            // throw new Error('ssh');
            return;
        }
    });
});
$(".specialite1").change(function (e) { 
    e.preventDefault();
    var route=$(".roote").val();
    var specialite1=$(this).val();
    // alert(specialite);
    $.ajax({
        type: "post",
        url: route+"/local/powerschool/classes/bulletinfilitre.php",
        data: {specialite:specialite1},
        success: function (response) {
            $(".cycle1").html(response);
        
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
// $(".cycle").change(function (e) { 
//     e.preventDefault();
//     var route=$(".roote").val();
//     var specialite=$(".specialite1").val();
//     var cycle=$(this).val();
//     // alert(cycle);
//     $.ajax({
//         type: "post",
//         url: route+"/local/powerschool/classes/sallelefiltrereturetir.php",
//         data: {cycle:cycle,specialite:specialite},
//         success: function (respone) {
//             // alert(respone)
//             $(".salle1").html(respone);
//         }
//     });
// });