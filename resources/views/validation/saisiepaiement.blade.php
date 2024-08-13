@include('template.header')  
<form action="{{ route('traitementPaiement') }}" method="post">
@csrf

    <div class="container-fluid py-4 mt-5">

      <div class="row mt-6 d-flex justify-content-center align-items-center">

        <div class="col-md-4 mb-lg-0 mb-3">
          <div class="card">

            <div class="card-body p-4">              

              <div class="row d-flex justify-content-center align-items-center">

                <div class="text-center">
                  <h6 class="text-m text-uppercase mb-0">{{$impaye->entite}}</h6>
                  <p class="text-xs text-secondary">{{$impaye->lieu}}</p>
                </div>

                <div class="col-md-11 mb-3">
                  <label class="form-control-label">Date de paiement</label>
                  <input type="date" class="form-control" name="date">
                  <input type="hidden" name="idvente" value="{{ $impaye->idvente }}">
                </div>

                <div class="col-md-11 mb-3">
                  <label class="form-control-label">Mode de paiement</label>
                  <select class="form-control" name="idmodepaiement" id="idmodepaiement">
                  @foreach ($modes as $mode)
                    <option value="{{$mode->idmodepaiement}}"> {{$mode->nom}} </option>
                  @endforeach
                  </select>
                </div>
                <div class="col-md-11 mb-3" id="banqueDiv">
                  <label class="form-control-label">Banque</label>
                  <select class="form-control" name="idbanque" id="banqueSelect">
                      @foreach ($banques as $banque)
                          <option value="{{$banque->idbanque}}"> {{$banque->nom}} </option>
                      @endforeach
                  </select>
                </div>
                <div class="col-md-11 mb-3" id="nomChequeDiv">
                    <label class="form-control-label">Nom du chèque</label>
                    <input type="text" class="form-control" name="nom">
                </div>
                <div class="col-md-11 mb-3" id="numeroChequeDiv">
                    <label class="form-control-label">Numéro du chèque</label>
                    <input type="text" class="form-control" name="numero">
                </div>
                <div class="col-md-11 mb-3" id="dateChequeDiv">
                    <label class="form-control-label">Date du chèque</label>
                    <input type="date" class="form-control" name="datecreation">
                </div>

                <div class="col-md-11">
                  <label class="form-control-label">Montant</label>
                  <input type="number" class="form-control" name="montant" value="{{ $impaye->reste }}">
                </div>

              </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center pt-4 ps-4 pb-4 pe-4">
              <div class="col-md-6 text-center">
                <button type="submit" class="btn bg-gradient-primary w-100 mb-0">Payer </button>
              </div>
            </div>

            <script>
              
              document.addEventListener('DOMContentLoaded', function() {
                const idModePaiement = document.getElementById('idmodepaiement');
                const banqueDiv = document.getElementById('banqueDiv');
                const nomChequeDiv = document.getElementById('nomChequeDiv');
                const numeroChequeDiv = document.getElementById('numeroChequeDiv');
                const dateChequeDiv = document.getElementById('dateChequeDiv');
                var selectElement = document.getElementById('banqueSelect');

                function toggleChequeFields() {
                    if (idModePaiement.value == '2') {
                        banqueDiv.style.display = 'block';
                        nomChequeDiv.style.display = 'block';
                        numeroChequeDiv.style.display = 'block';
                        dateChequeDiv.style.display = 'block';
                    }
                    else if (idModePaiement.value == '4') {
                        banqueDiv.style.display = 'block';
                        nomChequeDiv.style.display = 'none';
                        numeroChequeDiv.style.display = 'none';
                        dateChequeDiv.style.display = 'none';
                    } else {
                        selectElement.value = "";

                        banqueDiv.style.display = 'none';
                        nomChequeDiv.style.display = 'none';
                        numeroChequeDiv.style.display = 'none';
                        dateChequeDiv.style.display = 'none';
                    }
                }

                idModePaiement.addEventListener('change', toggleChequeFields);

                toggleChequeFields();

                var montantInput = document.querySelector('.form-control[name="montant"]');
                var payerButton = document.querySelector('.bg-gradient-primary');
                function updatePayerButtonState() {
                    var montant = parseFloat(montantInput.value);

                    // Vérifie si la valeur est inférieure ou égale à zéro ou supérieure au reste dû
                    if (montant <= 0 || montant > {{ $impaye->reste }}) {
                        payerButton.disabled = true; // Désactive le bouton
                    } else {
                        payerButton.disabled = false; // Active le bouton
                    }
                }
                // Ajoutez un écouteur d'événements pour détecter les changements de valeur de l'input
                montantInput.addEventListener('input', updatePayerButtonState);
                // Appellez la fonction pour initialiser l'état du bouton au chargement de la page
                updatePayerButtonState();

              });

            </script>
            
          </div>
        </div>

      </div>
    
</form>
@include('template.footer')