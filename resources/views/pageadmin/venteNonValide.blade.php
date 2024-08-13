@include('template.header')  
<form action="{{ route('filtreventeNonValide') }}" method="get">
@csrf

<div class="container-fluid py-4 mt-5">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Client</label>
              <select class="form-control" name="idclient" id="idclient">
                <option value=""> Tous </option>
              @foreach ($clients as $client)
                <option value="{{$client->idclient}}"> {{$client->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Lieu</label>
              <select class="form-control" name="idlieu">
                <option value=""> Tous </option>
              @foreach ($lieux as $lieu)
                <option value="{{$lieu->idlieu}}"> {{$lieu->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Responsable</label>
              <select class="form-control" name="responsable">
                <option value=""> Tous </option>
              @foreach ($responsables as $responsable)
                <option value="{{$responsable->nom}}"> {{$responsable->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1 mb-3">
              <label class="form-control-label">Mois</label>
              <select class="form-control" name="idmois">
                <option value=""> Tous </option>
              @foreach ($mois as $m)
                <option value="{{$m->idmois}}"> {{$m->mois}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-1 mb-3">
              <label class="form-control-label">Annee</label>
              <select class="form-control" name="annee">
                <option value=""> Tous </option>
              @foreach ($annees as $annee)
                <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Date de livraison</label>
              <input type="date" class="form-control" name="datevente">
            </div>
            <div class="col-md-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

            </form>
            <form action="{{ route('traitementvalidationVente') }}" method="post">
                @csrf

          <div class="card mb-4">

            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th></th>
                      <th class="col-md-1 text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Date</th>
                      <th class="col-md-2 text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-1">Client</th>
                      <th class="col-md-2 text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ref</th>
                      <th class="col-md-5 text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Responsable</th>
                      <th class="col-md-2 text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7 pe-2">Total : {{ number_format($total, 2, '.', ' ') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($ventes as $vente)
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" name="idvente[]" value="{{$vente->idvente}}" id="" class="check-box">
                      </td>
                      <td>
                        <span class="text-secondary text-xs"> {{$vente->datevente}}</span>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">{{$vente->entite}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$vente->lieu}}</p>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">{{$vente->ref}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$vente->nbdc}}</p>
                      </td>
                      <td>
                        <h6 class="mb-0 text-sm">{{$vente->responsable}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$vente->contact}}</p>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($vente->total, 2, '.', ' ') }}</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                <div class="col-md-4 text-center">
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