
console.log($(".tanoteefiliere").val())
const noteffill=JSON.parse($(".tanoteefiliere").val());
var specialites = noteffill.map(function(item) {
  return item.libelle;
});
// alert(specialites)

var entrees = noteffill.map(function(item) {
    return item.moyenne;
});

var data = {
    labels:specialites,
    datasets: [{
        data:entrees,
        backgroundColor:getRandomColor(specialites.length),
        borderColor:getRandomColor(specialites.length),
        borderWidth: 1
    }]
  };
  
  // Options du diagramme circulaire
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        position: 'right'
    }
  };

  // graphiqueFilierenote
  // Créer le diagramme circulaire

  var ctx1 = document.getElementById('diagrammeCirculaireetuspfilnote').getContext('2d');
  var myPieChart = new Chart(ctx1, {
    type: 'pie',
    data: data,
    options: options
  });

const notefilcy=JSON.parse($(".tanoteefilierespec").val());
var specialites = notefilcy.map(function(item) {
  return item.libelle;
});
// alert(specialites)

var entrees = notefilcy.map(function(item) {
    return item.moyenne;
});

var data = {
    labels:specialites,
    datasets: [{
        data:entrees,
        backgroundColor:getRandomColor(specialites.length),
        borderColor:getRandomColor(specialites.length),
        borderWidth: 1
    }]
  };
  
  // Options du diagramme circulaire
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        position: 'right'
    }
  };

  // graphiqueFilierenote
  // Créer le diagramme circulaire

  var ctx2 = document.getElementById('diagrammeCirculaireetucyfilnote').getContext('2d');
  var myPieChart = new Chart(ctx2, {
    type: 'pie',
    data: data,
    options: options
  });

const notefilsp=JSON.parse($(".noteefilierecy").val());
var specialites = notefilsp.map(function(item) {
  return item.libelle;
});
// alert(specialites)

var entrees = notefilsp.map(function(item) {
    return item.moyenne;
});

var data = {
    labels:specialites,
    datasets: [{
        data:entrees,
        backgroundColor:getRandomColor(specialites.length),
        borderColor:getRandomColor(specialites.length),
        borderWidth: 1
    }]
  };
  
  // Options du diagramme circulaire
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        position: 'right'
    }
  };

  // graphiqueFilierenote
  // Créer le diagramme circulaire

  var ctx3 = document.getElementById('diagrammeCirculairedetspetudetnote').getContext('2d');
  var myPieChart = new Chart(ctx3, {
    type: 'pie',
    data: data,
    options: options
  });

// alert("dfgj")
const notefilspcysal=JSON.parse($(".noteefilierecyspsal").val());
var specialites = notefilspcysal.map(function(item) {
  return item.libelle;
});
// alert(specialites)

var entrees = notefilspcysal.map(function(item) {
    return item.moyenne;
});

var data = {
    labels:specialites,
    datasets: [{
        data:entrees,
        backgroundColor:getRandomColor(specialites.length),
        borderColor:getRandomColor(specialites.length),
        borderWidth: 1
    }]
  };
  
  // Options du diagramme circulaire
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        position: 'right'
    }
  };

  // graphiqueFilierenote
  // Créer le diagramme circulaire

  var ctx4 = document.getElementById('diagrammeCirculairecydetcyetudetnote').getContext('2d');
  var myPieChart = new Chart(ctx4, {
    type: 'pie',
    data: data,
    options: options
  });




  function getRandomColor(length) {
    var colors=[];
    // var letters = '0123456789ABCDEF';
    for (var i = 0; i < length; i++) {
      var color = 'rgba(';
      for (var j = 0; j < 3; j++) {
        var channelValue = Math.floor(Math.random() * 256); // Valeur pour chaque canal RVB (0-255)
        color += channelValue + ',';
      }
      color += 0.8 + ')'; // Ajouter l'opacité à la couleur (valeur entre 0 et 1)
      colors.push(color);
    }
    return colors;
  }