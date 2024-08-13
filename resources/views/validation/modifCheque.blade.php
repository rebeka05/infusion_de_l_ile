@include('template.header')  
<form action="{{ route('traitementCheque') }}" method="post">
@csrf

    <div class="container-fluid py-4 mt-5">

    <div class="row mt-6 d-flex justify-content-center align-items-center">

        <div class="col-md-4 mb-lg-0 mb-3">
          <div class="card">

            <div class="card-body p-4">              

              <div class="row d-flex justify-content-center align-items-center">

                <div class="text-center">
                  <h6 class="text-m text-uppercase mb-0">{{$cheque->entite}}</h6>
                  <p class="text-xs text-secondary">{{$cheque->lieu}}</p>
                </div>

                <div class="col-md-11 mb-3">
                  <label class="form-control-label">Date de paiement</label>
                  <input type="date" class="form-control" value="{{ $cheque->datepaiement }}" disabled>
                  <input type="hidden" name="idpaiement" value="{{ $cheque->idpaiement }}">
                </div>
                <div class="col-md-11 mb-3">
                    <label class="form-control-label">Banque</label>
                    <input type="text" class="form-control" value="{{ $cheque->banque }}" disabled>
                </div>
                <div class="col-md-11 mb-3">
                    <label class="form-control-label">Nom et Numéro du chèque</label>
                    <input type="text" class="form-control" value="{{ $cheque->nom }}, {{ $cheque->numero }}" disabled>
                </div>
                <div class="col-md-11 mb-3">
                    <label class="form-control-label">Date du chèque</label>
                    <input type="date" class="form-control" value="{{ $cheque->datecreation }}" disabled>
                </div>

                <div class="col-md-11 mb-3">
                  <label class="form-control-label">Montant</label>
                  <input type="number" class="form-control" value="{{ $cheque->montant }}" disabled>
                </div>

                @if ($cheque->dateversement == null) 
                <div class="col-md-11">
                    <label class="form-control-label">Date du versement</label>
                    <input type="date" class="form-control" name="dateversement">
                </div>
                @endif
                @if ($cheque->dateversement != null)
                <div class="col-md-11 mb-3">
                    <label class="form-control-label">Date du versement</label>
                    <input type="date" class="form-control" value="{{ $cheque->dateversement }}" disabled>
                </div>
                <div class="col-md-11">
                    <label class="form-control-label">Date de disponibilité</label>
                    <input type="date" class="form-control" name="datedispo">
                </div>
                @endif

              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center pt-4 ps-4 pb-4 pe-4">
              <div class="col-md-6 text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 mb-0">modifier </button>
              </div>
            </div>
            
          </div>
        </div>

      </div>
    
</form>
@include('template.footer')