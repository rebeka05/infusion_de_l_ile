@include('template.header')  
<form action="{{ route('filtreEtatLivraison') }}" method="get">
@csrf

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-10">
        
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-2 mb-3">
                <label class="form-control-label">Date de livraison</label>
                <input type="date" class="form-control" name="datesortie">
            </div>
            <div class="col-lg-1 mb-3">
              <input type="submit" value="filtrer" class="btn btn-outline-primary btn-sm w-140 mt-4 mb-0">
            </div>
          </div>

</form>

          <div class="card mb-4">
            <div class="card-body col-12 mt-3 px-0 pt-0 pb-2">
            <span class="text-secondary text-uppercase text-s font-weight-bolder ps-2">Date du {{$datesortie}}</span>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="col-lg-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produit</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Nombre</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vendu</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">échange</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">dégustation</th>
                      <th class="col-lg-2 text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">Reste</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($ventes) == 0)
                    <tr>
                      <td>
                      </td>
                      <td class="text-end">
                      </td>
                      <td class="text-end">
                        <span">Aucun enregistrement pour cette date</span>
                      </td>
                      <td class="text-end">
                      </td>
                      <td class="text-end">
                      </td>
                      <td class="text-end">
                      </td>
                    </tr>
                    @endif
                    @foreach ($ventes as $vente)
                    <tr>
                      <td>
                        <span class="text-secondary">{{$vente->nom}} {{$vente->qte}} {{$vente->unite}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$vente->nombre}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$vente->vendu}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$vente->echange}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{$vente->degustation}}</span>
                      </td>
                      <td class="text-end">
                        <span class="text-secondary">{{ $vente->reste }}</span>
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