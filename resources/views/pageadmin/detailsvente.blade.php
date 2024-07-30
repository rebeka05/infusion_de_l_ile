@include('template.header')

    <div class="container-fluid py-4" style="">

        <!-- <div class="row mt-2 d-flex justify-content-center align-items-center"> -->
        <div class="row mt-5">

            <div class="col-lg-10 mb-lg-0 mb-4">
                <div class="card">

                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-lg-3 mb-3">
                                <label class="form-control-label">Date de livraison</label>
                                <input type="date" class="form-control" value="{{ $vente->datevente }}" disabled>
                                <input type="hidden" name="idvente" value="{{ $vente->idvente }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Numéro de bon de commande</label>
                                <input type="text" class="form-control" value="{{ $vente->nbdc }}" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Facture</label>
                                <input type="text" class="form-control" value="{{ $vente->ref }}" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Client</label>
                                <input type="text" class="form-control" value="{{ $client->entite }}" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Lieu</label>
                                <input type="text" class="form-control" value="{{ $client->nom }}" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-control-label">Responsable</label>
                                <input type="text" class="form-control" value="{{ $vente->responsable }}" disabled>
                            </div>

                            <div class="col-lg-6 mb-3">
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
                                    <th class="col-lg-4 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Produit
                                    </th>
                                    <th class="col-lg-2 text-start text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                        Date d'éxpiration
                                    </th>
                                    <th class="col-lg-1 text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7 pe-2">
                                        qte
                                    </th>
                                    <th class="col-lg-2 text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7 pe-2">
                                        pu
                                    </th>
                                    <th class="col-lg-2 text-end text-uppercase text-secondary text-xs font-weight-bolder opacity-7 pe-2">
                                        montant
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="contentArea">
                                @php $totals = 0.00; @endphp
                                @foreach ($details as $detail)
                                @php $totals = $totals + ($detail->nombre*$detail->pu); @endphp
                                <tr>
                                    <td class="text-start text-sm">
                                        <span class="text-secondary">{{$detail->nom}} {{$detail->qte}} {{$detail->unite}}</span>
                                    </td>
                                    <td class="text-start text-sm">
                                        <span class="text-secondary">{{ $detail->expiration }}</span>
                                    </td>
                                    <td class="text-end text-sm">
                                        <span class="text-secondary">{{ number_format($detail->nombre, 2, '.', ' ') }}</span>
                                    </td>
                                    <td class="text-end text-sm">
                                        <span class="text-secondary">{{ number_format($detail->pu, 2, '.', ' ') }}</span>
                                    </td>
                                    <td class="text-end text-sm">
                                        <span class="text-secondary">{{ number_format($detail->nombre*$detail->pu, 2, '.', ' ') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end text-sm">
                                        <span class="text-secondary text-uppercase font-weight-bolder">Total</span>
                                    </td>
                                    <td class="text-end text-sm">
                                        <span class="text-secondary font-weight-bolder">{{ number_format($totals, 2, '.', ' ') }}</span>
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