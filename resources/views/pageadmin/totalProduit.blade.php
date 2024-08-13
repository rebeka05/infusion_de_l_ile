@include('template.header')  
<form action="{{ route('filtretotalProduit') }}" method="get">
@csrf

<div class="container-fluid py-4 mt-5">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-5 mb-3">
              <label class="form-control-label">Produit</label>
              <select class="form-control" name="idinfoproduit">
              @foreach ($produits as $produit)
                <option value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}} </option>
              @endforeach
              </select>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-control-label">Année</label>
                <select class="form-control" name="annee">
                @foreach ($annees as $annee)
                <option value="{{$annee->annee}}"> {{$annee->annee}} </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-control-label">Mois</label>
                <select class="form-control" name="idmois">
                @foreach ($mois as $m)
                <option value="{{$m->idmois}}"> {{$m->mois}} </option>
                @endforeach
                </select>
            </div>
            <div class="col-md-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

</form>

          <div class="card mb-4">
            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
            <span class="text-secondary text-uppercase text-s font-weight-bolder ps-2">{{$mois[$prod[0]->idmois - 1]->mois}} {{$prod[0]->annee}} : {{$prod[0]->nom}} {{$prod[0]->qte}} {{$prod[0]->unite}}</span>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="col-md-6 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Entité</th>
                      <th class="col-md-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">PU</th>
                      <th class="col-md-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Qte</th>
                      <th class="col-md-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Montant</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $total = 0; $qte = 0; @endphp
                    @foreach ($prod as $p)
                    @php $total = $total + $p->total; $qte = $qte + $p->nombre; @endphp
                    <tr>
                      <td>
                        <span class="text-secondary">{{$p->client}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($p->pu, 2, '.', ' ') }}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$p->nombre}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ number_format($p->total, 2, '.', ' ') }}</span>
                      </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">Total</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">{{$qte}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">{{ number_format($total, 2, '.', ' ') }}</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>

        </div>
    </div>
</div>
    
@include('template.footer')