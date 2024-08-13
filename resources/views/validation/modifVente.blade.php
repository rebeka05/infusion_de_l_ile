@include('template.header')
<form action="{{ route('updateVente') }}" method="post">
    @csrf

    <div class="container-fluid py-4 mt-5">

        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->
        <div class="row mt-5">

            <div class="col-md-10 mb-lg-0 mb-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-control-label">Date de livraison</label>
                                <input type="date" class="form-control" value="{{ $vente->datevente }}" disabled>
                                <input type="hidden" name="idvente" value="{{ $vente->idvente }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Numéro de bon de commande</label>
                                <input type="text" class="form-control" value="{{ $vente->nbdc }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Facture</label>
                                <input type="text" class="form-control" value="{{ $vente->ref }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Client</label>
                                <input type="text" class="form-control" value="{{ $client->entite }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Lieu</label>
                                <input type="text" class="form-control" value="{{ $client->nom }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Responsable</label>
                                <input type="text" class="form-control" value="{{ $vente->responsable }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Contact</label>
                                <input type="text" class="form-control" value="{{ $vente->contact }}" disabled>
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="col-md-4 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Produit
                                    </th>
                                    <th class="col-md-2 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Date d'éxpiration
                                    </th>
                                    <th class="col-md-1 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        qte
                                    </th>
                                    <th class="col-md-2 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        pu
                                    </th>
                                    <th class="col-md-2 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        montant
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="contentArea">
                                @php $totals = 0.00; @endphp
                                @foreach ($details as $detail)
                                @php $totals = $totals + ($detail->nombre*$detail->pu); @endphp
                                <tr>
                                    <td class="align-middle text-sm">
                                        <select class="form-control" name="idinfoproduit[]"
                                                onchange="updatePrice(this)">
                                            @foreach ($produits as $produit)
                                                <option value="{{$produit->idinfoproduit}}" @php if($produit->idinfoproduit == $detail->idinfoproduit) { echo "selected"; } @endphp> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="date" class="form-control" value="{{ $detail->expiration }}" name="expiration[]">
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="nombre[]"
                                               value="{{ $detail->nombre }}" min="1" oninput="updateTotal(this)">
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="pu[]"
                                               value="{{ $detail->pu }}" oninput="updateTotal(this)" disabled>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="total[]" value="{{ $detail->nombre*$detail->pu }}" disabled>
                                    </td>
                                    <td>
                                        <a class="nav-link" onclick="removeRow(this); updateTotal(this); checkTbodyContent();">
                                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-gradient-primary text-center ms-2">
                                                <span>
                                                    <i class="fas fa-minus text-white text-center"></i>
                                                </span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-1 ps-4 pt-2">
                                <a class="nav-link add-row">
                                    <div
                                        class="icon icon-shape icon-sm shadow border-radius-md bg-gradient-primary text-center me-2">
                                        <span>
                                            <i class="fas fa-plus text-white text-center"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-7">
                            </div>
                            <div class="col-md-2 pt-2 ms-7">
                                <div>
                                    <input type="number" class="form-control" value="{{ $totals }}" name="totals" id="totalSum" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                        <div class="col-md-6 text-center">
                            <button type="submit" id="submitBtn" class="btn bg-gradient-primary w-100 mt-4 mb-0">Modifier</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <script>

            function updateTotalSum() {
                const totalInputs = document.querySelectorAll('input[name="total[]"]');
                let sum = 0;
                totalInputs.forEach(function(input) {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        sum += value;
                    }
                });
                document.getElementById('totalSum').value = sum.toFixed(2);
            }

            function updatePrice(targetProduct) {
                fetch(`/getpu?produitId=${targetProduct.value}`)
                    .then(response => response.json())
                    .then(data => {
                        const row = targetProduct.closest('tr');
                        const price = data.pu;
                        const qte = row.querySelector('.form-control[name="nombre[]"]').value;

                        // Vérifier si la quantité est inférieure à 1
                        if (qte < 1) {
                            // Désactiver le bouton de soumission
                            document.getElementById('submitBtn').disabled = true;
                            return; // Arrêter l'exécution de la fonction
                        }
                        // Réactiver le bouton de soumission si la quantité est valide
                        document.getElementById('submitBtn').disabled = false;

                        row.querySelector('.form-control[name="pu[]"]').value = price;
                        row.querySelector('.form-control[name="total[]"]').value = qte * price;
                        updateTotalSum(); 
                    })
                    .catch(error => console.error('Erreur:', error));
            }

            function updateTotal(targetProduct) {
                const row = targetProduct.closest('tr');
                const montant = row.querySelector('.form-control[name="total[]"]');
                const price = parseFloat(row.querySelector('.form-control[name="pu[]"]').value);
                const qte = parseFloat(row.querySelector('.form-control[name="nombre[]"]').value);

                // Vérifier si la quantité est inférieure à 1
                if (qte < 1) {
                    // Désactiver le bouton de soumission
                    document.getElementById('submitBtn').disabled = true;
                    return; // Arrêter l'exécution de la fonction
                }
                // Réactiver le bouton de soumission si la quantité est valide
                document.getElementById('submitBtn').disabled = false;

                montant.value = qte * price;
                updateTotalSum(); 
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.add-row').addEventListener('click', () => {
                    var expirationValue = "<?php echo $expiration; ?>";
                    let lastExpirationInput = document.querySelector('#contentArea tr:last-child input[name="expiration[]"]');
    
                    if (lastExpirationInput == null) { 
                        var newInput = document.createElement('input');
                        newInput.type = 'text'; // Ou 'number', 'date', etc., selon vos besoins
                        newInput.name = 'expiration[]';
                        newInput.value = expirationValue;

                        lastExpirationInput = newInput;
                    }
                    const lastExpirationValue = lastExpirationInput.value;
                    const contentHtml = `
                    <tr>
                        <td class="align-middle text-sm">
                            <select class="form-control" name="idinfoproduit[]" onchange="updatePrice(this)">
                                @foreach ($produits as $produit)
                        <option value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}} </option>
                                @endforeach
                        </select>
                        </td>
                        <td class="align-middle text-sm">
                            <input type="date" class="form-control" name="expiration[]" value="${lastExpirationValue}">
                        </td>
                        <td class="align-middle text-sm">
                            <input type="number" class="form-control" name="nombre[]" value="1" min="1" oninput="updateTotal(this)">
                        </td>
                        <td class="align-middle text-sm">
                            <input type="number" class="form-control" name="pu[]" value="{{ $produits[0]->pu?? '' }}" oninput="updateTotal(this)" disabled>
                        </td>
                        <td class="align-middle text-sm">
                            <input type="number" class="form-control" name="total[]" disabled>
                        </td>
                        <td>
                            <a class="nav-link" onclick="removeRow(this); updateTotal(this); checkTbodyContent();">
                                <div class="icon icon-shape icon-sm shadow border-radius-md bg-gradient-primary text-center ms-2">
                                    <span>
                                        <i class="fas fa-minus text-white text-center"></i>
                                    </span>
                                </div>
                            </a>
                        </td>
                    </tr>`;
                    document.querySelector('#contentArea').insertAdjacentHTML('beforeend', contentHtml);
                });
            });

            
            function checkTbodyContent() {
                var tbodyContentArea = document.querySelector('#contentArea');
                var submitBtn = document.getElementById('submitBtn');

                // Vérifie si le tbody contient des éléments tr
                if (tbodyContentArea.children.length === 0) {
                    submitBtn.disabled = true; // Désactive le bouton si aucun tr n'est présent
                } else {
                    submitBtn.disabled = false; // Active le bouton si au moins un tr est présent
                }
            }
                

            function removeRow(targetRow) {
                targetRow.closest('tr').remove();
            }

            $(document).ready(function(){

                // Fonction pour vérifier si tous les champs sont valides
                function checkFieldsValidity() {
                    let isValid = true;


                    // Vérifier les champs de date d'expiration
                    $('input[name="expiration[]"]').each(function() {
                        if ($(this).val().trim() === '') {
                            isValid = false;
                            return false; // Sortir de la boucle si un champ est invalide
                        }
                    });

                    // Vérifier les champs de nombre
                    $('input[name="nombre[]"]').each(function() {
                        if ($(this).val().trim() === '' || parseInt($(this).val(), 10) < 1) {
                            isValid = false;
                            return false; // Sortir de la boucle si un champ est invalide
                        }
                    });

                    // Activer/désactiver le bouton selon la validité des champs
                    $('#submitBtn').prop('disabled', !isValid);
                }

                // // Écouteurs d'événements pour les champs de date d'expiration et de nombre
                $('input[name="expiration[]"], input[name="nombre[]"]').on('input', checkFieldsValidity);

                // // Initialiser l'état du bouton au chargement de la page
                checkFieldsValidity();
            });
            
        </script>
    </div>
</form>
@include('template.footer')