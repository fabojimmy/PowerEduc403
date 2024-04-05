
// Données pour le diagramme circulaire

const speciale=JSON.parse($(".spe1").val());
var specialites = speciale.map(function(item) {
    return item.specialite;
});

var entrees = speciale.map(function(item) {
    return item.entrees;
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
  
  // Créer le diagramme circulaire

  var ctx2 = document.getElementById('diagrammeCirculaire').getContext('2d');
  var myPieChart = new Chart(ctx2, {
    type: 'pie',
    data: data,
    options: options
  });


  const cycl=JSON.parse($(".cy").val());
  var cycle = cycl.map(function(item) {
      return item.cycle;
  });
  
  var entreescy = cycl.map(function(item) {
      return item.entrees;
  });
  
var data = {
    labels:cycle,
    datasets: [{
        data: entreescy,
        backgroundColor: getRandomColor(cycle.length),
        borderColor:getRandomColor(cycle.length),
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
  
  // Créer le diagramme circulaire
  var ctx1 = document.getElementById('diagrammeCirculairecy').getContext('2d');
  var myPieChart = new Chart(ctx1, {
    type: 'pie',
    data: data,
    options: options
  });


  const filcycl=JSON.parse($(".libellecycy").val());
  // var filcycl = filcycle.map(function(item) {
    //     return item.specialite;
    // });
    
    const entreescy1=JSON.parse($(".sommecycy").val());
  // var entreescy = filcycle.map(function(item) {
  //     return item.entrees;
  // });
  
var data = {
    labels:filcycl,
    datasets: [{
        data: entreescy1,
        backgroundColor:getRandomColor(filcycl.length),
        borderColor:getRandomColor(filcycl.length),
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
  
  // Créer le diagramme circulaire
  var ctx3 = document.getElementById('diagrammeCirculairecydetcy').getContext('2d');
  var myPieChart = new Chart(ctx3, {
    type: 'pie',
    data: data,
    options: options
  });

// alert("vvvvvvv")
 const cyclefi=JSON.parse($(".sppsometufilsp").val());
 // var cyclefi = filspecia.map(function(item) {
  //     return item.cycle;
  // });
  
  const entreesfil=JSON.parse($(".sppsometulibefilsp").val());
  // var entreesfil = filspecia.map(function(item) {
  //     return item.entrees;
  // });

  // alert(cyclefi,entreesfil)

  var data = {
    labels:cyclefi,
    datasets: [{
        data: entreesfil,
        backgroundColor: getRandomColor(cyclefi.length),
        borderColor:getRandomColor(cyclefi.length),
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
  
  // alert("rien")
  // Créer le diagramme circulaire
  var ctx4 = document.getElementById('diagrammeCirculairedetsp').getContext('2d');
  var myPieChart = new Chart(ctx4, {
    type: 'pie',
    data: data,
    options: options
  });
 
 //Statistique des etudiants
  const countetuspelibe=JSON.parse($(".libelspe").val());
  const entrees1=JSON.parse($(".entrees").val());
  // var libellespecialite = countetuspe.map(function(item) {
  //     return item.specialite;
  // });
  
  // var entreescountspe = countetuspe.map(function(item) {
  //     return item.entrees;
  // });

  // alert(entrees1)
  var data = {
    labels:countetuspelibe,
    datasets: [{
        data: entrees1,
        backgroundColor: getRandomColor(countetuspelibe.length),
        borderColor: getRandomColor(countetuspelibe.length),
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
  
  // Créer le diagramme circulaire
  var ctx5 = document.getElementById('diagrammeCirculaireetuspfil').getContext('2d');
  var myPieChart = new Chart(ctx5, {
    type: 'pie',
    data: data,
    options: options
  });
  
  const countetucy=JSON.parse($(".countetucy").val());
  var libellecycle = countetucy.map(function(item) {
      return item.cycle;
  });
  
  var entreescountcy = countetucy.map(function(item) {
      return item.entrees;
  });

  var data = {
    labels:libellecycle,
    datasets: [{
        data: entreescountcy,
        backgroundColor:  getRandomColor(libellecycle.length),
        borderColor: getRandomColor(libellecycle.length),
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
  
  // Créer le diagramme circulaire
  var ctx6 = document.getElementById('diagrammeCirculaireetucyfil').getContext('2d');
  var myPieChart = new Chart(ctx6, {
    type: 'pie',
    data: data,
    options: options
  });
  



  const libellecycledet=JSON.parse($(".libellesppdetetu").val());
  // var libellecycledet = datacyetudet.map(function(item) {
    //     return item.cycle;
    // });
    const entreescountcydet=JSON.parse($(".sommesppetudet").val());
    
  // var entreescountcydet = datacyetudet.map(function(item) {
  //     return item.entrees;
  // });

  var data = {
    labels:libellecycledet,
    datasets: [{
        data: entreescountcydet,
        backgroundColor: getRandomColor(libellecycledet.length),
        borderColor: getRandomColor(libellecycledet.length),
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
  
  // Créer le diagramme circulaire
  var ctx7 = document.getElementById('diagrammeCirculairecydetcyetudet').getContext('2d');
  var myPieChart = new Chart(ctx7, {
    type: 'pie',
    data: data,
    options: options
  });
  
  // const dataetudet=JSON.parse($(".dataetudet").val());
  const libellespecialitedet=JSON.parse($(".libellecydetetu").val());
  // var libellespecialitedet = dataetudet.map(function(item) {
    //     return item.cycle;
    // });sommecyetudet
    const entreescountspdet=JSON.parse($(".sommecyetudet").val());
  
    // alert(entreescountspdet)
  // var entreescountspdet = dataetudet.map(function(item) {
  //     return item.entrees;
  // });

  // alert(libellespecialitedet.length)
  var data = {
    labels:libellespecialitedet,
    datasets: [{
        data: entreescountspdet,
        backgroundColor: getRandomColor(libellespecialitedet.length),
        borderColor: getRandomColor(libellespecialitedet.length),
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
  
  // Créer le diagramme circulaire
  var ctx8 = document.getElementById('diagrammeCirculairedetspetudet').getContext('2d');
  var myPieChart = new Chart(ctx8, {
    type: 'pie',
    data: data,
    options: options
  });

//   aler("dfgh")
// Statistique de l'age
const countetuspelibeage=JSON.parse($(".libelspeage").val());
  const entrees1age=JSON.parse($(".entreesage").val());
  // var libellespecialite = countetuspe.map(function(item) {
  //     return item.specialite;
  // });
  
  // var entreescountspe = countetuspe.map(function(item) {
  //     return item.entrees;
  // });

  // alert(entrees1)
  var data = {
    labels:countetuspelibeage,
    datasets: [{
        data: entrees1,
        backgroundColor: getRandomColor(countetuspelibeage.length),
        borderColor: getRandomColor(countetuspelibeage.length),
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
  
  // Créer le diagramme circulaire
  var ctx9 = document.getElementById('diagrammeCirculaireetuspfilage').getContext('2d');
  var myPieChart = new Chart(ctx9, {
    type: 'pie',
    data: data,
    options: options
  });
  
  const countetucyage=JSON.parse($(".countetucyage").val());
  var libellecycleage = countetucy.map(function(item) {
      return item.cycle;
  });
  
  var entreescountcyage = countetucyage.map(function(item) {
      return item.entrees;
  });

  var data = {
    labels:libellecycleage,
    datasets: [{
        data: entreescountcyage,
        backgroundColor:  getRandomColor(libellecycleage.length),
        borderColor: getRandomColor(libellecycleage.length),
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
  
  // Créer le diagramme circulaire
  var ctx10 = document.getElementById('diagrammeCirculaireetucyfilage').getContext('2d');
  var myPieChart = new Chart(ctx10, {
    type: 'pie',
    data: data,
    options: options
  });
  





const libellecycledetag=JSON.parse($(".libellesppdetetuage").val());
// var libellecycledet = datacyetudet.map(function(item) {
  //     return item.cycle;
  // });
  const entreescountcydetag=JSON.parse($(".sommesppetudetage").val());
  
// var entreescountcydet = datacyetudet.map(function(item) {
//     return item.entrees;
// });

var data = {
  labels:libellecycledetag,
  datasets: [{
      data: entreescountcydet,
      backgroundColor: getRandomColor(libellecycledetag.length),
      borderColor: getRandomColor(libellecycledetag.length),
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

// Créer le diagramme circulaire
var ctx11 = document.getElementById('diagrammeCirculairecydetcyetudetag').getContext('2d');
var myPieChart = new Chart(ctx11, {
  type: 'pie',
  data: data,
  options: options
});

// const dataetudet=JSON.parse($(".dataetudet").val());
const libellespecialitedetag=JSON.parse($(".libellecydetetuag").val());
// var libellespecialitedet = dataetudet.map(function(item) {
  //     return item.cycle;
  // });sommecyetudet
  const entreescountspdetag=JSON.parse($(".sommecyetudetag").val());

  // alert(entreescountspdet)
// var entreescountspdet = dataetudet.map(function(item) {
//     return item.entrees;
// });

// alert(libellespecialitedetag.length)
var data = {
  labels:libellespecialitedetag,
  datasets: [{
      data: entreescountspdet,
      backgroundColor: getRandomColor(libellespecialitedetag.length),
      borderColor: getRandomColor(libellespecialitedetag.length),
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

// Créer le diagramme circulaire
var ctx12 = document.getElementById('diagrammeCirculairedetspetudetag').getContext('2d');
var myPieChart = new Chart(ctx12, {
  type: 'pie',
  data: data,
  options: options
});

function getRandomColor(length) {
  var colors=[];
  var letters = '0123456789ABCDEF';
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