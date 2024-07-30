<?php
$moisArray = $mois->toArray();
$ventesArray = $ventes->toArray();
$produitsArray = $etat_produits->toArray();
$entitesArray = $etat_entites->toArray();

$joursArray = json_decode(json_encode($jours), true);
$labels3 = [];
$datas3 =[];
$entitesAssoc = [];
foreach ($entitesArray as $entite) {
    $entitesAssoc[$entite['datevente']] = $entite['total'];
}
foreach ($joursArray as $jour) {
  $labels3[] = $jour['date'];
  $datas3[] = isset($entitesAssoc[$jour['date']]) ? $entitesAssoc[$jour['date']] : 0;
}

$ventesAssoc = [];
foreach ($ventesArray as $vente) {
    $ventesAssoc[$vente['idmois']] = $vente['total'];
}
$produitsAssoc = [];
foreach ($produitsArray as $produit) {
    $produitsAssoc[$produit['idmois']] = $produit['total'];
}

$labels = [];
$datas = [];
foreach ($moisArray as $moisItem) {
    $labels[] = $moisItem['mois'];
    // Si le mois n'a pas de vente, mettez 0 ou une valeur par défaut
    $datas[] = isset($ventesAssoc[$moisItem['idmois']]) ? $ventesAssoc[$moisItem['idmois']] : 0;
    $datas2[] = isset($produitsAssoc[$moisItem['idmois']]) ? $produitsAssoc[$moisItem['idmois']] : 0;
}

// chart 4
$etatArray = $etats->toArray();
$clientsData = [];
foreach ($etatArray as $etat) {
    // Assurez-vous que l'ID du client est présent dans le tableau
    if (!isset($clientsData[$etat['idclient']])) {
        $clientsData[$etat['idclient']] = ['label' => $etat['nom'], 'data' => []];
    }
    // Ajoutez la valeur total pour le mois correspondant
    $clientsData[$etat['idclient']]['data'][$etat['mois']] = $etat['total'];
}
$colors = [
  'rgba(255, 99, 132, 0.2)', //rouge
  'rgba(54, 162, 235, 0.2)', //bleu
  'rgba(255, 206, 86, 0.2)', //jaune
  'rgba(255, 0, 255, 0.2)',   // Magenta
  'rgba(75, 192, 192, 0.2)', //turquoise
  'rgba(153, 102, 255, 0.2)' //violet
];
$colorIndex = 0; // Index pour parcourir les couleurs disponibles
foreach ($clientsData as $clientData) {
  $datas4[] = [
      'label' => $clientData['label'],
      'data' => $clientData['data'],
      'backgroundColor' => $colors[$colorIndex % count($colors)], // Utilisez une couleur unique par client
      'borderColor' => str_replace('0.2', '1', $colors[$colorIndex % count($colors)]), // Version opaque de la couleur
      'borderWidth' => 1,
  ];
  $colorIndex++; // Incrémentez l'index pour le prochain client
}

$maxValue = 1000000;

?>

@include('template.header')  

<div class="container-fluid py-4">
      <div class="col-10">
        
        <div class="card">
          <div class="row">

            <div class="card-body col-6">
              <div class="row">
                <div class="col-lg-3">
                  <label class="form-control-label">Année</label>
                  <select class="form-control" id="annee1" onchange="updateChart1()">
                  @foreach ($annees as $annee)
                    <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                  @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-control-label">Entité</label>
                    <select class="form-control" id="idclient1" onchange="updateChart1()">
                      <option value=""> Tous </option>
                    @foreach ($clients as $client)
                      <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                  <label class="form-control-label">Lieu</label>
                  <select class="form-control" id="idlieu1" onchange="updateChart1()">
                    <option value=""> Tous </option>
                  @foreach ($lieux as $lieu)
                    <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
                  @endforeach
                  </select>
                </div>
              </div>
              <div class="mt-2">
                <div class="chart">
                  <canvas id="chart1" class="chart-canvas"></canvas>
                </div>
              </div>

            </div>

            <div class="card-body col-6">
              <div class="row">
                <div class="col-lg-3">
                  <label class="form-control-label">Année</label>
                  <select class="form-control" id="annee2" onchange="updateChart2()">
                  @foreach ($annees as $annee)
                    <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                  @endforeach
                  </select>
                </div>
                <div class="col-lg-9">
                    <label class="form-control-label">Produit</label>
                    <select class="form-control" id="idproduit2" onchange="updateChart2()">
                    @foreach ($produits as $produit)
                      <option value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}} </option>
                    @endforeach
                    </select>
                </div>
              </div>
              <div class="mt-2">
                <div class="chart">
                  <canvas id="chart2" class="chart-canvas"></canvas>
                </div>
              </div>

            </div>

            <div class="card-body col-6">
              <div class="card-body row">
                <div class="col-lg-2">
                  <label class="form-control-label">Année</label>
                  <select class="form-control" id="annee3" onchange="updateChart3()">
                  @foreach ($annees as $annee)
                    <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                  @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-control-label">Mois</label>
                    <select class="form-control" id="idmois3" onchange="updateChart3()">
                    @foreach ($mois as $m)
                      <option value="{{$m->idmois}}"> {{$m->mois}} </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-control-label">Entité</label>
                    <select class="form-control" id="idclient3" onchange="updateChart3()">
                    @foreach ($clients as $client)
                      <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                  <label class="form-control-label">Lieu</label>
                  <select class="form-control" id="idlieu3" onchange="updateChart3()">
                    <option value=""> Tous </option>
                  @foreach ($lieux as $lieu)
                    <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
                  @endforeach
                  </select>
                </div>
              </div>
              <div class="mt-3 px-0 pt-0 pb-2">
                <div class="chart">
                  <canvas id="chart3" class="chart-canvas"></canvas>
                </div>
              </div>

            </div>

            <div class="card-body col-6">
              <div class="card-body row">
                <div class="col-lg-2">
                  <label class="form-control-label">Année</label>
                  <select class="form-control" id="annee4"  onchange="updateChart4()">
                  @foreach ($annees as $annee)
                    <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                  @endforeach
                  </select>
                </div>
                <div class="col-lg-3">
                    <label class="form-control-label">Tri par</label>
                    <select class="form-control" id="type4"  onchange="updateChart4()">
                      <option value="1"> Entité </option>
                      <option value="2"> Produit </option>
                    </select>
                </div>
              </div>
              <div class="mt-3 px-0 pt-0 pb-2">
                <div class="chart">
                  <canvas id="chart4" class="chart-canvas"></canvas>
                </div>
              </div>

            </div>
            
          </div>
        </div>

          <script>   
            var ctx1 = document.getElementById('chart1').getContext('2d');
            var chart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels);?>,
                    datasets: [{
                        label: 'Etat de vente par année par client',
                        data: <?php echo json_encode($datas);?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //rouge
                            'rgba(54, 162, 235, 0.2)', //bleu
                            'rgba(255, 206, 86, 0.2)', //jaune
                            'rgba(255, 0, 255, 0.2)',   // Magenta
                            'rgba(75, 192, 192, 0.2)', //turquoise
                            'rgba(153, 102, 255, 0.2)',//violet
                            'rgba(220, 20, 60, 0.2)',     // Tomato
                            'rgba(0, 191, 255, 0.2)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 105, 180, 0.2)',  // Rose vif
                            'rgba(0, 128, 128, 0.2)',   // Vert printemps
                            'rgba(218, 112, 214, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)', //rouge
                            'rgba(54, 162, 235, 1)', //bleu
                            'rgba(255, 206, 86, 1)', //jaune
                            'rgba(255, 0, 255, 1)',   // Magenta
                            'rgba(75, 192, 192, 1)', //turquoise
                            'rgba(153, 102, 255, 1)',//violet
                            'rgba(220, 20, 60, 1)',     // Tomato
                            'rgba(0, 191, 255, 1)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 105, 180, 1)',  // Rose vif
                            'rgba(0, 128, 128, 1)',   // Vert printemps
                            'rgba(218, 112, 214, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                          beginAtZero: true,
                          max: <?php echo $maxValue; ?>
                        }
                    }
                }
            });  

            var ctx2 = document.getElementById('chart2').getContext('2d');
            var chart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels);?>,
                    datasets: [{
                        label: 'Etat de vente par produit',
                        data: <?php echo json_encode($datas2);?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //rouge
                            'rgba(54, 162, 235, 0.2)', //bleu
                            'rgba(255, 206, 86, 0.2)', //jaune
                            'rgba(255, 0, 255, 0.2)',   // Magenta
                            'rgba(75, 192, 192, 0.2)', //turquoise
                            'rgba(153, 102, 255, 0.2)',//violet
                            'rgba(220, 20, 60, 0.2)',     // Tomato
                            'rgba(0, 191, 255, 0.2)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 105, 180, 0.2)',  // Rose vif
                            'rgba(0, 128, 128, 0.2)',   // Vert printemps
                            'rgba(218, 112, 214, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)', //rouge
                            'rgba(54, 162, 235, 1)', //bleu
                            'rgba(255, 206, 86, 1)', //jaune
                            'rgba(255, 0, 255, 1)',   // Magenta
                            'rgba(75, 192, 192, 1)', //turquoise
                            'rgba(153, 102, 255, 1)',//violet
                            'rgba(220, 20, 60, 1)',     // Tomato
                            'rgba(0, 191, 255, 1)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 105, 180, 1)',  // Rose vif
                            'rgba(0, 128, 128, 1)',   // Vert printemps
                            'rgba(218, 112, 214, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                          beginAtZero: true,
                          max: <?php echo $maxValue; ?>
                        }
                    }
                }
            });  

            var ctx3 = document.getElementById('chart3').getContext('2d');
            var chart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels3);?>,
                    datasets: [{
                        label: 'Etat de vente par mois par entité',
                        data: <?php echo json_encode($datas3);?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //rouge
                            'rgba(54, 162, 235, 0.2)', //bleu
                            'rgba(255, 206, 86, 0.2)', //jaune
                            'rgba(255, 0, 255, 0.2)',   // Magenta
                            'rgba(75, 192, 192, 0.2)', //turquoise
                            'rgba(153, 102, 255, 0.2)',//violet
                            'rgba(220, 20, 60, 0.2)',     // Tomato
                            'rgba(0, 191, 255, 0.2)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 105, 180, 0.2)',  // Rose vif
                            'rgba(0, 128, 128, 0.2)',   // Vert printemps
                            'rgba(218, 112, 214, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)', //rouge
                            'rgba(54, 162, 235, 1)', //bleu
                            'rgba(255, 206, 86, 1)', //jaune
                            'rgba(255, 0, 255, 1)',   // Magenta
                            'rgba(75, 192, 192, 1)', //turquoise
                            'rgba(153, 102, 255, 1)',//violet
                            'rgba(220, 20, 60, 1)',     // Tomato
                            'rgba(0, 191, 255, 1)',     // Deep Sky Blue
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 105, 180, 1)',  // Rose vif
                            'rgba(0, 128, 128, 1)',   // Vert printemps
                            'rgba(218, 112, 214, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                          beginAtZero: true,
                          max: <?php echo $maxValue; ?>
                        }
                    }
                }
            }); 
            
            var ctx4 = document.getElementById('chart4').getContext('2d');
            var chart4 = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: <?php echo json_encode($datas4); ?>
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            function updateChart1() {
                var selectedYear = document.getElementById('annee1').value;
                var selectedClient = document.getElementById('idclient1').value;
                var selectedLieu = document.getElementById('idlieu1').value;

                // console.log(`Fetching data for year: ${selectedYear}, client: ${selectedClient}, lieu: ${selectedLieu}`);

                // Faites une requête AJAX pour obtenir les nouvelles données en fonction de l'année
                fetch(`/getEtatVente?annee=${selectedYear}&client=${selectedClient}&lieu=${selectedLieu}`)
                    .then(response => response.json())
                    .then(data => {
                        // console.log('Data received:', data);
                        // chart1.data.labels = data.labels;
                        chart1.data.datasets[0].data = data.datas;
                        chart1.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
            
            function updateChart2() {
                var selectedYear = document.getElementById('annee2').value;
                var selectedProduit = document.getElementById('idproduit2').value;
                console.log(`Fetching data for year: ${selectedYear}, produit: ${selectedProduit}`);

                // Faites une requête AJAX pour obtenir les nouvelles données en fonction de l'année
                fetch(`/getEtatVenteProduit?annee=${selectedYear}&produit=${selectedProduit}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received:', data);
                        chart2.data.datasets[0].data = data.datas;
                        chart2.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
            
            function updateChart3() {
                var selectedYear = document.getElementById('annee3').value;
                var selectedMois = document.getElementById('idmois3').value;
                var selectedClient = document.getElementById('idclient3').value;
                var selectedLieu = document.getElementById('idlieu3').value;

                // Faites une requête AJAX pour obtenir les nouvelles données en fonction de l'année
                fetch(`/getEtatVenteEntite?annee=${selectedYear}&mois=${selectedMois}&client=${selectedClient}&lieu=${selectedLieu}`)
                .then(response => response.json())
                .then(data => {
                    // Mettre à jour les données du graphique
                    chart3.data.labels = data.labels;
                    chart3.data.datasets[0].data = data.datas;
                    chart3.update();
                })
                .catch(error => console.error('Error fetching data:', error));
            }
            
            function updateChart4() {
                var selectedYear = document.getElementById('annee4').value;
                var selectedType = document.getElementById('type4').value;
                console.log(`Fetching data for year: ${selectedYear}, type: ${selectedType}`);
                // Faites une requête AJAX pour obtenir les nouvelles données en fonction de l'année
                fetch(`/getEtatProduitEntite?annee=${selectedYear}&type=${selectedType}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data received:', data);
                        // Mettre à jour les données du graphique
                        chart4.data.labels = data.labels;
                        chart4.data.datasets[0].data = data.datas;
                        chart4.update();
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
  
            document.getElementById('idclient1').addEventListener('change', function () {
                const clientId = this.value;
                fetch('/getlieuxbyidclient?clientId=' + clientId)
                    .then(response => response.json())
                    .then(data => {
                        updateLieuxSelect1(data.lieux);
                    })
                    .catch(error => console.error('Erreur:', error));
            });

            function updateLieuxSelect1(lieux) {
                const lieuSelect = document.querySelector('.form-control[id="idlieu1"]');
                lieuSelect.innerHTML = '';
                const aucunOption = new Option("Tous", "");
                lieuSelect.add(aucunOption);
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.nom, lieu.idlieu);
                    lieuSelect.add(option);
                });
            }

            document.getElementById('idclient3').addEventListener('change', function () {
                const clientId = this.value;
                fetch('/getlieuxbyidclient?clientId=' + clientId)
                    .then(response => response.json())
                    .then(data => {
                        updateLieuxSelect3(data.lieux);
                    })
                    .catch(error => console.error('Erreur:', error));
            });

            function updateLieuxSelect3(lieux) {
                const lieuSelect = document.querySelector('.form-control[id="idlieu3"]');
                lieuSelect.innerHTML = '';
                const aucunOption = new Option("Tous", "");
                lieuSelect.add(aucunOption);
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.nom, lieu.idlieu);
                    lieuSelect.add(option);
                });
            }
          </script>

    </div>
</div>

    
@include('template.footer')