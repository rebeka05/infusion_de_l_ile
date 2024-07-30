@include('template.header')  
<form action="{{ route('filtreventeProduitClient') }}" method="get">
@csrf

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-2 mb-3">
              <label class="form-control-label">Client</label>
              <select class="form-control" name="idclient">
              @foreach ($clients as $client)
                <option value="{{$client->idclient}}"> {{$client->nom}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-lg-2 mb-3">
                <label class="form-control-label">Année</label>
                <select class="form-control" name="annee">
                @foreach ($annees as $annee)
                <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-3">
                <label class="form-control-label">Mois</label>
                <select class="form-control" name="idmois">
                @foreach ($mois as $m)
                <option value="{{$m->idmois}}"> {{$m->mois}} </option>
                @endforeach
                </select>
            </div>
            <div class="col-lg-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

</form>

        @foreach ($lieux as $lieu)
        @php
            $an= isset($year) ? $year : $annees[0]->annee;
            $idclient= isset($idclient) ? $idclient : $lieu->idclient;
            $idmois= isset($idmois) ? $idmois : $mois[0]->idmois;

            $ventes = \App\Models\Generic::select('v_vente_client_mensuel', ['*'], [["annee", "=", $an], ["idclient", "=", $idclient], ["idlieu", "=", $lieu->idlieu], ["idmois", "=", $idmois]])->get();
            $total = 0;
        @endphp
          <div class="card mb-4">
            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
            <span class="text-secondary text-uppercase text-s font-weight-bolder ps-2">{{$mois[$idmois-1]->mois}} {{$an}} : {{$ventes[0]->entite}}</span>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="col-lg-6 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produit</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">PU</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Qte</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Montant</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($ventes as $vente)
                    @php $total = $total + $vente->total; @endphp
                    <tr>
                      <td>
                        <span class="text-secondary">{{$vente->nom}} {{$vente->qte}} {{$vente->unite}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($vente->pu, 2, '.', ' ') }}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$vente->nombre}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($vente->total, 2, '.', ' ') }}</span>
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td>
                      </td>
                      <td class="text-end">
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">Total</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">{{$total}}</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        @endforeach

        </div>
    </div>
</div>
    
@include('template.footer')