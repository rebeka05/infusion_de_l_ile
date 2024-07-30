@include('template.header')  
<form action="{{ route('filtreetatechange') }}" method="get">
@csrf

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
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

          <div class="card mb-4">
            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="col-lg-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">entité</th>
                      <th class="col-lg-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produit</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">PU</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Montant</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($echanges as $p)
                    <tr>
                      <td>
                        <h6 class="mb-0 text-sm">{{$p->entite}}</h6>
                        <p class="text-xs text-secondary mb-0">{{$p->lieu}}</p>
                      </td>
                      <td>
                        <span class="text-secondary">{{$p->produit}} {{$p->qte}} {{$p->unite}}</span>
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
                      <td></td>
                      <td></td>
                      <td class="text-end">
                      </td>
                      <td class="text-end">
                        <span class="text-secondary font-weight-bolder">Total</span>
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