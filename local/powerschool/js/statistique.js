// import { getAquisitionsByYear } from './api'  
// alert("ghjklm");
const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  //specialite

//   var specialites = {{ specialites|json_encode }};
//         var entrees = {{ entrees }};

// alert("dfghj")
// alert($(".spe").val());

// const special=JSON.parse($(".filiereanee").val());

//  var len=special.length;
//  alert("dfghgfdfg525200")
  var specialites = JSON.parse($(".filiereanee").val());
  var entrees = JSON.parse($(".annnnnee").val());
        // var entrees = [5000, 7000, 4000,5200,9000,100000];

        // Créer le graphique
        var ctx1 = document.getElementById('graphiqueSpecialite').getContext('2d');
        var myChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: specialites,
                datasets: [{
                    label: 'Entrées financières par filiere par année',
                    data: entrees,
                    backgroundColor:getRandomColor(specialites.length),
                    borderColor: getRandomColor(specialites.length),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

//Statistique age

  var age1 = JSON.parse($(".tarfilieresomeage").val());
  var agecount1 = JSON.parse($(".tarfilierecountage").val());
        // var entrees = [5000, 7000, 4000,5200,9000,100000];

        // Créer le graphique
        var ctx1a = document.getElementById('graphiqueFiliereage').getContext('2d');
        var myChart = new Chart(ctx1a, {
            type: 'bar',
            data: {
                labels: age1,
                datasets: [{
                    label: 'Age des Apprenants dans une filiere par année',
                    data: agecount1,
                    backgroundColor:getRandomColor(age1.length),
                    borderColor: getRandomColor(age1.length),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  
        // alert("ddd")
  var age2a = JSON.parse($(".tarfilieresomeagesp").val());
  var agecount2 = JSON.parse($(".tarfilierecountagesp").val());
        // var entrees = [5000, 7000, 4000,5200,9000,100000];

        // Créer le graphique
        var ctx2a = document.getElementById('graphiqueSpecialiteage').getContext('2d');
        var myChart = new Chart(ctx2a, {
            type: 'bar',
            data: {
                labels: age2a,
                datasets: [{
                    label: 'Age des Apprenants dans une filiere et specialite par année',
                    data: agecount2,
                    backgroundColor:getRandomColor(age2a.length),
                    borderColor: getRandomColor(age2a.length),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  
        var age3a = JSON.parse($(".tarfilieresomeagecy").val());
  var agecount3 = JSON.parse($(".tarfilierecountagecy").val());
        // var entrees = [5000, 7000, 4000,5200,9000,100000];

        // Créer le graphique
        var ctx3a = document.getElementById('graphiqueCycleage').getContext('2d');
        var myChart = new Chart(ctx3a, {
            type: 'bar',
            data: {
                labels: age3a,
                datasets: [{
                    label: 'Age des Apprenants dans une filiere et cycle par année',
                    data: agecount3,
                    backgroundColor:getRandomColor(age3a.length),
                    borderColor: getRandomColor(age3a.length),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  
  var age4a = JSON.parse($(".tarfilieresomeagecysp").val());
  var agecount4 = JSON.parse($(".tarfilierecountagecysp").val());
        // var entrees = [5000, 7000, 4000,5200,9000,100000];

        // Créer le graphique
        var ctx4a = document.getElementById('graphiqueCyclespecialiteage').getContext('2d');
        var myChart = new Chart(ctx4a, {
            type: 'bar',
            data: {
                labels: age4a,
                datasets: [{
                    label: 'Age des Apprenants dans une filiere et specialite et cycle par année',
                    data: agecount4,
                    backgroundColor:getRandomColor(age4a.length),
                    borderColor: getRandomColor(age4a.length),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //personnalise


        // import Chart from 'chart.js/auto'
(async function() {
  const data = [
    { year: "Genie", count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];
  
  new Chart(
    document.getElementById('acquisitions1'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets: [
          {
            label: 'Acquisitions by year',
            data: data.map(row => row.count)
          }
        ]
      }
    }
  );
})();
(async function() {
  const data1 = await getAquisitionsByYear();

new Chart(
  document.getElementById('acquisitions2'),
  {
    type: 'bar',
    options: {
      animation: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          enabled: false
        }
      }
    },
    data1: {
      labels: data1.map(row => row.year),
      datasets: [
        {
          label: 'Acquisitions by year',
          data: data1.map(row => row.count)
        }
      ]
    }
  }
);
})();


const anneeeee=JSON.parse($(".annee").val());
const annee=JSON.parse($(".dateannne").val());
  var mois = annee.map(function(item) {
      return item.mois;
  });
  var somme = annee.map(function(item) {
      return item.total;
  });
  

var data = {
  labels:anneeeee,
  datasets: [{
      label: 'Entrées financières',
      data: somme,
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
      borderWidth: 1
  }]
};

// Options du graphique en courbes
var options = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
      y: {
          beginAtZero: true
      }
  }
};

// Créer le graphique en courbes
var ctx3 = document.getElementById('graphiqueCourbes').getContext('2d');
var myLineChart = new Chart(ctx3, {
  type: 'line',
  data: data,
  options: options
});


// Données pour la carte choroplèthe (GeoJSON)
var geojsonFeature = {
  "type": "FeatureCollection",
  "features": [
      {
          "type": "Feature",
          "properties": {
              "region": "Region A",
              "valeur": 200
          },
          "geometry": {
              "type": "Polygon",
              "coordinates": [[
                [-5, 42], [10, 42], [10, 51], [-5, 51], [-5, 42]
                 
              ]]
          }
      },
      {
          "type": "Feature",
          "properties": {
              "region": "Region B",
              "valeur": 350
          },
          "geometry": {
              "type": "Polygon",
              "coordinates": [[
                [-5, 42], [10, 42], [10, 51], [-5, 51], [-5, 42]
              ]]
          }
      },
      // Ajoutez d'autres régions avec leurs valeurs ici
  ]
};

// Créer la carte choroplèthe
var map = L.map('map').setView([48.8566, 2.3522], 5);

// Ajouter une couche de carte de fond (par exemple OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Ajouter les polygones de la carte choroplèthe
        L.geoJSON(data, {
            style: function (feature) {
                return {
                    fillColor: getColor(feature.properties.population),
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }
        }).addTo(map);
// Fonction pour définir la couleur en fonction de la valeur
function getColor(population) {
  return population > 100000000 ? '#800026' :
      population > 50000000 ? '#BD0026' :
      population > 20000000 ? '#E31A1C' :
      population > 10000000 ? '#FC4E2A' :
      population > 5000000 ? '#FD8D3C' :
      population > 2000000 ? '#FEB24C' :
      population > 1000000 ? '#FED976' :
                              '#FFEDA0';
}


//Statistique de l'age


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