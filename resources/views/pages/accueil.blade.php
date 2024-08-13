@include('template.header')  

<div class="container-fluid py-4 mt-5" style="">
    <div class="row mt-5">
    <div class="col-md-10 mb-lg-0 mb-4">
    <div class="row gx-3"> <!-- Ajout de la classe gx-3 pour ajuster l'espacement horizontal -->
        @foreach ($produits as $produit)
            <div class="card col-md-3 ms-5 me-auto mb-5">
                <img class="card-img-top" src="../assets/img/{{ $produit->photo }}" style="height: 264.67px;" alt="Admin Dashboards">
                <div class="card-body">
                    <h5 class="card-title">{{ $produit->nom ." ". number_format($produit->qte, 2, '.', ' ') ." ". $produit->unite }}</h5>
                    <p class="card-text">{{ $produit->type }}</p>
                    <p class="card-text">
                        <small class="text-muted">{{ number_format($produit->pu, 2, '.', ' ') }} Ar</small>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

    </div>
</div>

@include('template.footer')