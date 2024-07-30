@include('template.header')
<form action="{{ route('traitementEchange') }}" method="post">
    @csrf

    <div class="container-fluid py-4">

        <div class="row mt-5">
        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->

            <div class="col-lg-10 mb-lg-0 mb-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-lg-3 mb-3">
                                <label class="form-control-label">Date d'échange</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                                @error('date')
                                <p class="text-s text-primary mb-0">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Client</label>
                                <select class="form-control" name="idclient" id="idclient">
                                    @foreach ($clients as $client)
                                        <option value="{{$client->idclient}}"> {{$client->nom}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Lieu</label>
                                <select class="form-control" name="idlieu">
                                    @foreach ($lieux as $lieu)
                                        <option value="{{$lieu->idinfoclient}}"> {{$lieu->entite}} </option>
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
                                    <th class="col-lg-6 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Produit
                                    </th>
                                    <th class="col-lg-2 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Qte
                                    </th>
                                    <th class="col-lg-3 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        date d'éxpiration
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="contentArea">
                                <tr>
                                    <td class="align-middle text-sm">
                                        <select class="form-control" name="idinfoproduit[]">
                                            @foreach ($produits as $produit)
                                                @php
                                                    $format = Number::format($produit->qte, precision: 2);
                                                @endphp
                                                <option
                                                    value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="number" class="form-control" value="1" name="nombre[]" oninput="verifyQuantity(this)">
                                        @error('nombre[]')
                                        <p class="text-s text-primary mb-0">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="align-middle text-sm">
                                        <input type="date" class="form-control" name="expiration[]"
                                            value="{{ old('expiration[]') }}">
                                        @error('expiration[]')
                                        <p class="text-s text-primary mb-0">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td class="align-middle text-sm">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <div class="nav-link add-row">
                                    <div
                                        class="icon icon-shape icon-sm shadow border-radius-md bg-gradient-primary text-center ms-2">
                                        <span>
                                            <i class="fas fa-plus text-white text-center"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center align-items-center ps-4 pb-4 pe-4">
                        <div class="col-lg-6 text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Entrer</button>
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
                        })
                        .catch(error => console.error('Erreur:', error));
                });

                function updateLieuxSelect(lieux) {
                    const lieuSelect = document.querySelector('.form-control[name="idlieu"]');
                    lieuSelect.innerHTML = '';
                    lieux.forEach(function (lieu) {
                        const option = new Option(lieu.entite, lieu.idinfoclient);
                        lieuSelect.add(option);
                    });
                }

                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelector('.add-row').addEventListener('click', () => {
                        const lastExpirationValue = document.querySelector('#contentArea tr:last-child input[name="expiration[]"]').value;
                        const contentHtml = `            
                        <tr class="ligne">
                            <td class="align-middle text-sm">
                                <select class="form-control" name="idinfoproduit[]">
                                    @foreach ($produits as $produit)
                                        @php
                                            $format = Number::format($produit->qte, precision: 2);
                                        @endphp
                                        <option
                                            value="{{$produit->idinfoproduit}}"> {{$produit->nom}} {{$produit->qte}} {{$produit->unite}} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="align-middle text-sm">
                                <input type="number" class="form-control" value="1" name="nombre[]" oninput="verifyQuantity(this)">
                            </td>
                            <td class="align-middle text-sm">
                                <input type="date" class="form-control" name="expiration[]"
                                 value="${lastExpirationValue}">
                            </td>
                            <td class="align-middle text-sm">
                                <a class="nav-link" onclick="removeRow(this)">
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

                    document.querySelectorAll('input[name="nombre[]"]').forEach(item => {
                        item.addEventListener('input', verifyQuantity);
                    });

                    // Attach event listener to the form
                    document.querySelector('form').addEventListener('submit', validateForm);
                });

                function removeRow(targetRow) {
                    targetRow.closest('.ligne').remove();
                }

                // function verifyQuantity(inputElement) {
                //     const qte = parseFloat(inputElement.value);
                //     const errorMessage = inputElement.nextElementSibling;

                //     if (qte <= 0 || isNaN(qte)) {
                //         errorMessage.style.display = 'block';
                //     } else {
                //         errorMessage.style.display = 'none';
                //     }
                // }

                function verifyQuantity(inputElement) {
                    const qte = parseFloat(inputElement.value);
                    if (qte < 1 || isNaN(qte)) {
                        inputElement.setCustomValidity('La quantité minimum est égale à 1');
                    } else {
                        inputElement.setCustomValidity('');
                    }
                }

                function validateForm(event) {
                    const quantities = document.querySelectorAll('input[name="nombre[]"]');
                    let isValid = true;

                    quantities.forEach(input => {
                        const qte = parseFloat(input.value);
                        if (qte < 1 || isNaN(qte)) {
                            isValid = false;
                            input.setCustomValidity('La quantité doit être strictement supérieure à 0.');
                            input.reportValidity();
                        } else {
                            input.setCustomValidity('');
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                        alert('Veuillez corriger les erreurs dans le formulaire avant de soumettre.');
                    }
                }
            </script>
        </div>
    </div>
</form>
@include('template.footer')
