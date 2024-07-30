@include('template.header')  
<form action="{{ route('filtrevalidationEchange') }}" method="get">
@csrf

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-2 mb-3">
              <label class="form-control-label">Client</label>
              <select class="form-control" name="idclient" id="idclient">
                <option value=""> Tous </option>
              @foreach ($clients as $client)
                <option value="{{$client->idclient}}"> {{$client->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-lg-2 mb-3">
              <label class="form-control-label">Lieu</label>
              <select class="form-control" name="idlieu">
                <option value=""> Tous </option>
              @foreach ($lieux as $lieu)
                <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-lg-2 mb-3">
              <label class="form-control-label">Date d'échange</label>
              <input type="date" class="form-control" name="dateechange">
            </div>
            <div class="col-lg-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

            </form>
            <form action="{{ route('traitementvalidationEchange') }}" method="post">
                @csrf

          <div class="card mb-4">

            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th></th>
                      <th class="col-lg-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                      <th class="col-lg-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Client</th>
                      <th class="col-lg-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produit</th>
                      <th class="col-lg-1 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">pu</th>
                      <th class="col-lg-1 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Nombre</th>
                      <th class="col-lg-1 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Montant</th>
                      <th class="col-lg-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date d'éxpiration</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($echanges as $echange)
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" name="idechange[]" value="{{$echange->idechange}}" id="" class="check-box">
                      </td>
                      <td>
                        <span class="text-secondary text-xs"> {{$echange->dateechange}}</span>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">{{$echange->entite}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$echange->lieu}}</p>
                      </td>
                      <td>
                        <span class="text-secondary text-s"> {{$echange->produit}} {{$echange->qte}} {{$echange->unite}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{number_format($echange->pu, 2, '.', ' ')}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$echange->nombre}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{number_format($echange->nombre * $echange->pu, 2, '.', ' ')}}</span>
                      </td>
                      <td>
                        <span class="text-secondary text-xs"> {{$echange->expiration}}</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                <div class="col-lg-4 text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Valider</button>
                </div>
            </div>

          </div>

          <script>              
  
            document.getElementById('idclient').addEventListener('change', function () {
                const clientId = this.value;
                fetch('/getlieuxbyidclient?clientId=' + clientId)
                    .then(response => response.json())
                    .then(data => {
                        updateLieuxSelect(data.lieux);
                    })
                    .catch(error => console.error('Erreur:', error));
            });

            function updateLieuxSelect(lieux) {
                const lieuSelect = document.querySelector('.form-control[name="idlieu"]');
                lieuSelect.innerHTML = '';
                const aucunOption = new Option("Tous", "");
                lieuSelect.add(aucunOption);
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.nom, lieu.idlieu);
                    lieuSelect.add(option);
                });
            }

            $(document).ready(function() {
                // Sélectionnez tous les checkboxes avec la classe 'check-box'
                var checkboxes = $('.check-box');

                // Fonction pour vérifier si au moins un checkbox est coché
                function isAnyChecked() {
                    return checkboxes.is(':checked');
                }

                // Activez ou désactivez le bouton 'Payer' en fonction de l'état des checkboxes
                checkboxes.on('change', function() {
                    if (isAnyChecked()) {
                        $('button[type=submit]').prop('disabled', false); // Active le bouton
                    } else {
                        $('button[type=submit]').prop('disabled', true); // Désactive le bouton
                    }
                });

                // Initialisation : si aucun checkbox n'est coché au chargement de la page, désactivez le bouton
                if (!isAnyChecked()) {
                    $('button[type=submit]').prop('disabled', true);
                }
            });
          </script>

        </div>
    </div>
</div>
    
</form>
@include('template.footer')