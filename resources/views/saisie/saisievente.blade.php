@include('template.header')
<form action="{{ route('traitementVente') }}" method="post">
    @csrf

    <div class="container-fluid py-4 mt-5" style="">

        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->
        <div class="row mt-5">

            <div class="col-md-10 mb-lg-0 mb-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-control-label">Date de livraison</label>
                                <input type="date" class="form-control" name="date" value="{{ $date }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Numéro de bon de commande</label>
                                <input type="text" class="form-control" name="nbdc">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Facture</label>
                                <input type="text" class="form-control" name="ref" value="{{ old('ref') }}">

                                @error('ref')
                                <p class="text-s text-primary mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Client</label>
                                <select class="form-control" name="idclient" id="idclient">
                                    @foreach ($clients as $client)
                                        <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Lieu</label>
                                <select class="form-control" name="idlieu" id="idlieu">
                                    @foreach ($lieux as $lieu)
                                        <option value="{{$lieu->idinfoclient}}"> {{$lieu->entite}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Responsable</label>
                                <select class="form-control" name="responsable" id="responsableSelect">
                                    @foreach ($responsables as $responsable)
                                        <option value="{{$responsable->nom}}"> {{$responsable->nom}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Contact</label>
                                <select class="form-control" name="contact" id="contactSelect">
                                    @foreach ($responsables as $responsable)
                                        <option
                                            value="{{$responsable->contact}}"> {{$responsable->contact}} </option>
                                    @endforeach
                                </select>
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
                                <tr>
                                    <td class="align-middle text-sm">
                                        <select class="form-control" name="idinfoproduit[]"
                                                onchange="updatePrice(this)">
                                            @foreach ($produits as $produit)
                                                <option value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="date" class="form-control" value="{{ $expiration }}" name="expiration[]">
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="nombre[]"
                                               value="1" min="1" oninput="updateTotal(this)">
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="pu[]"
                                               value="{{ $produits[0]->pu?? '' }}" oninput="updateTotal(this)" disabled>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" name="total[]" disabled>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
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
                                    <input type="number" class="form-control" name="totals" id="totalSum" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                        <div class="col-md-6 text-center">
                            <button type="submit" id="submitBtn" class="btn bg-gradient-primary w-100 mt-4 mb-0">Entrer</button>
                        </div>
                    </div>

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
                        const lieuId = data.lieux[0].idlieu;
                        // updateResponsablesSelect(clientId, lieuId);
                    })
                    .catch(error => console.error('Erreur:', error));
            });

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

            function updateLieuxSelect(lieux) {
                const lieuSelect = document.querySelector('.form-control[name="idlieu"]');
                lieuSelect.innerHTML = '';
                lieux.forEach(function (lieu) {
                    const option = new Option(lieu.entite, lieu.idinfoclient);
                    lieuSelect.add(option);
                });
            }

            // function updateResponsablesSelect(clientId, lieuId) {
            //     const responsableSelect = document.querySelector('.form-control[name="responsable"]');
            //     responsableSelect.innerHTML = '';
            //     const contactSelect = document.querySelector('.form-control[name="contact"]');
            //     contactSelect.innerHTML = '';
            //             const aucunOption = new Option("Aucun", "");
            //             responsableSelect.add(aucunOption);
            //             const aucunOption1 = new Option("Aucun", "");
            //             contactSelect.add(aucunOption1);
            //     const url = '/getresponsable?clientId=' + encodeURIComponent(clientId) + '&lieuId=' + encodeURIComponent(lieuId);
            //     fetch(url)
            //         .then(response => response.json())
            //         .then(data => {
            //             data.responsables.forEach(function (responsable) {
            //                 const option = new Option(responsable.nom, responsable.nom);
            //                 responsableSelect.add(option);
            //                 const option1 = new Option(responsable.contact, responsable.contact);
            //                 contactSelect.add(option1);
            //             });
            //         })
            //         .catch(error => console.error('Erreur:', error));
            // }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.add-row').addEventListener('click', () => {
                    const lastExpirationValue = document.querySelector('#contentArea tr:last-child input[name="expiration[]"]').value;
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
                            <a class="nav-link" onclick="removeRow(this); updateTotal(this)">
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

            function removeRow(targetRow) {
                targetRow.closest('tr').remove();
            }

            // $(document).ready(function(){
            //     $('input[name="ref"]').on('input', function(){
            //         var ref = $(this).val();

            //         if(ref.length > 0) {
            //             $.ajax({
            //                 url: '{{ route("checkRef") }}',
            //                 method: 'GET',
            //                 data: { ref: ref },
            //                 success: function(response) {
            //                     if(response.exists) {
            //                         $('input[name="ref"]').addClass('is-invalid');
            //                         $('.ref-error').remove();
            //                         $('input[name="ref"]').after('<p class="text-s text-primary mb-0 ref-error">Cette référence existe déjà.</p>');
            //                         $('#submitBtn').prop('disabled', true); // Désactiver le bouton
            //                     } else {
            //                         $('input[name="ref"]').removeClass('is-invalid');
            //                         $('.ref-error').remove();
            //                         $('#submitBtn').prop('disabled', false); // Réactiver le bouton
            //                     }
            //                 }
            //             });
            //         } else {
            //             $('input[name="ref"]').removeClass('is-invalid');
            //             $('.ref-error').remove();
            //             $('#submitBtn').prop('disabled', false); // Réactiver le bouton si le champ est vide
            //         }
            //     });
            // });

            $(document).ready(function(){
                // Fonction pour vérifier si tous les champs sont valides
                function checkFieldsValidity() {
                    let isValid = true;

                    // Vérifier le champ de référence
                    if($('input[name="ref"]').val().trim() === '') {
                        isValid = false;
                    }

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

                // Écouteur d'événement pour le champ de référence existant
                $('input[name="ref"]').on('input', function(){
                    var ref = $(this).val();

                    if(ref.length > 0) {
                        $.ajax({
                            url: '{{ route("checkRef") }}',
                            method: 'GET',
                            data: { ref: ref },
                            success: function(response) {
                                if(response.exists) {
                                    $('input[name="ref"]').addClass('is-invalid');
                                    $('.ref-error').remove();
                                    $('input[name="ref"]').after('<p class="text-s text-primary mb-0 ref-error">Cette référence existe déjà.</p>');
                                    $('#submitBtn').prop('disabled', true);
                                } else {
                                    $('input[name="ref"]').removeClass('is-invalid');
                                    $('.ref-error').remove();
                                    checkFieldsValidity(); // Vérifier la validité des champs après avoir vérifié la référence
                                }
                            }
                        });
                    } else {
                        $('input[name="ref"]').removeClass('is-invalid');
                        $('.ref-error').remove();
                        checkFieldsValidity(); // Vérifier la validité des champs si le champ de référence est vide
                    }
                });

                // // Initialiser l'état du bouton au chargement de la page
                checkFieldsValidity();
            });
            
        </script>
    </div>
</form>
@include('template.footer')