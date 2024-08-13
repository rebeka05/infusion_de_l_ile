@include('template.header')
<form action="{{ route('traitementLivraison') }}" method="post">
    @csrf

    <div class="container-fluid py-4 mt-5">

        <div class="row mt-5">
        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->

            <div class="col-md-10 mb-lg-0 mb-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-md-3">
                                <label class="form-control-label">Date de livraison</label>
                                <input type="date" class="form-control" name="date" value="{{ $date }}">
                            </div>

                        </div>          

                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="col-md-6 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Produit
                                    </th>
                                    <th class="col-md-2 text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Qte
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
                                        <input type="number" class="form-control" value="1" name="nombre[]">
                                    </td>
                                    <td class="align-middle text-sm">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
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
                        <div class="col-md-6 text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Entrer</button>
                        </div>
                    </div>

                </div>

            </div>

            <script>

                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelector('.add-row').addEventListener('click', () => {
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
                                <input type="number" class="form-control" value="1" name="nombre[]">
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

                    // Attach event listener to the form
                    document.querySelector('form').addEventListener('submit', validateForm);
                });

                function removeRow(targetRow) {
                    targetRow.closest('.ligne').remove();
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
