@include('template.header')  
<form action="{{ route('filtreetatVentePaye') }}" method="get">
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
            <div class="col-lg-1 mb-3">
              <label class="form-control-label">Mois</label>
              <select class="form-control" name="idmois">
                <option value=""> Tous </option>
              @foreach ($mois as $m)
                <option value="{{$m->idmois}}"> {{$m->mois}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-lg-1 mb-3">
              <label class="form-control-label">Annee</label>
              <select class="form-control" name="annee">
                <option value=""> Tous </option>
              @foreach ($annees as $annee)
                <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-lg-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

</form>

          <div class="card mb-4">

            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="col-lg-2 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-1">Client</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7 pe-2">Total : {{ number_format($total->total, 2, '.', ' ') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($paiements as $paiement)
                    <tr>
                      <td>
                        <h6 class="mb-0 text-sm">{{$paiement->entite}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$paiement->lieu}}</p>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($paiement->total, 2, '.', ' ') }}</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>

        </div>
    </div>
</div>
    
@include('template.footer')