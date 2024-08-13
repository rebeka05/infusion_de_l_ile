@include('template.header')  
<form action="{{ route('filtreetatCheque') }}" method="get">
@csrf

<div class="container-fluid py-4 mt-5">
      <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-1 mb-3">
              <label class="form-control-label">Etat</label>
              <select class="form-control" name="etat">
                <option value=""> Tous </option>
                <option value="3"> Disponible </option>
                <option value="2"> Non disponible </option>
                <option value="1"> Non versé </option>
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Entité</label>
              <select class="form-control" name="idclient" id="idclient">
                <option value=""> Tous </option>
              @foreach ($clients as $client)
                <option value="{{$client->idclient}}"> {{$client->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-control-label">Client</label>
              <select class="form-control" name="idlieu">
                <option value=""> Tous </option>
              @foreach ($lieux as $lieu)
                <option value="{{$lieu->idinfoclient}}"> {{$lieu->entite}} </option>
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
              <label class="form-control-label">Date de paiement</label>
              <input type="date" class="form-control" name="datepaiement">
            </div>
            <div class="col-md-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

          </form>
          
          @csrf
            <div class="card mb-4">
                <div class="card-body col-12 px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                        <!-- <th> <input type="checkbox" id="check-all"> </th> -->
                        <th class="col-md-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date du paiement</th>
                        <th class="col-md-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ref</th>
                        <th class="col-md-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Client</th>
                        <th class="col-md-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nom</th>
                        <th class="col-md-1 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">état</th>
                        <th class="col-md-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cheques as $cheque)
                        <tr>
                        <td>
                            <span class="text-secondary text-xs"> {{$cheque->datepaiement}}</span>
                        </td>
                        <td>
                            <span class="text-secondary"> {{$cheque->ref}}</span>
                        </td>
                        <td>
                            <h6 class="mb-0 text-sm">{{$cheque->entite}}</h6>
                            <p class="text-xs text-secondary mb-0">{{$cheque->lieu}}</p>
                        </td>
                        <td>
                            <h6 class="mb-0 text-sm">{{$cheque->nom}} {{$cheque->numero}}</h6>
                            <p class="text-xs text-secondary mb-0">{{$cheque->banque}}</p>
                        </td>
                        <td>
                            @if ($cheque->etat == 1)
                                <span class="badge badge-sm bg-gradient-danger">Non versé</span>
                            @endif
                            @if ($cheque->etat == 2)
                                <span class="badge badge-sm bg-gradient-warning">non disponible</span>
                            @endif
                            @if ($cheque->etat == 3)
                                <span class="badge badge-sm bg-gradient-success">disponible</span>
                            <p class="text-xs text-secondary mb-0">{{$cheque->datedispo}}</p>
                            @endif                            
                        </td>
                        <td class="text-end">
                            <span class="text-secondary">{{number_format($cheque->montant, 2, '.', ' ')}}</span>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

          <script>   
  
            document.getElementById('idclient').addEventListener('change', function () {
                const clientId = this.value;
                if (clientId !== ''){                  
                  fetch('/getlieuxbyidclient?clientId=' + clientId)
                      .then(response => response.json())
                      .then(data => {
                          updateLieuxSelect(data.lieux);
                      })
                    .catch(error => console.error('Erreur:', error));
                } else{
                  fetch('/getLieux')
                      .then(response => response.json())
                      .then(data => {
                          updateLieuxSelect(data.lieux);
                      })
                    .catch(error => console.error('Erreur:', error));
                }
            });

            function updateLieuxSelect(lieux) {
                const lieuSelect = document.querySelector('.form-control[name="idlieu"]');
                lieuSelect.innerHTML = '';
                const aucunOption = new Option("Tous", "");
                lieuSelect.add(aucunOption);
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.entite, lieu.idinfoclient);
                    lieuSelect.add(option);
                });
            }
          </script>

        </div>
      </div>
</div>
    
@include('template.footer')