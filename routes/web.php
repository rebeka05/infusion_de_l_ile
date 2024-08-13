<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaisieController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('pages/login');
});

Route::post('/authentification', [AuthController::class,'authentification'])->name("authentification");
Route::get('/deconnexion', [AuthController::class,'deconnexion'])->name("deconnexion");

Route::get('/accueil', [HomeController::class,'accueil'])->name("accueil");

// SAISIE
Route::get('/saisie', [SaisieController::class,'saisie'])->name("saisie");
Route::get('/saisieLivraison', [SaisieController::class,'saisieLivraison'])->name("saisieLivraison");
Route::post('/traitementLivraison', [SaisieController::class,'traitementLivraison'])->name("traitementLivraison");
Route::post('/saisieInfoClient', [SaisieController::class,'saisieInfoClient'])->name("saisieInfoClient");
Route::post('/saisieClient', [SaisieController::class,'saisieClient'])->name("saisieClient");
Route::post('/saisieQuartier', [SaisieController::class,'saisieQuartier'])->name("saisieQuartier");
Route::post('/saisieLieu', [SaisieController::class,'saisieLieu'])->name("saisieLieu");

Route::get('/pageVente', [SaisieController::class,'pageVente'])->name("pageVente");
Route::post('/traitementVente', [SaisieController::class,'traitementVente'])->name("traitementVente");
Route::get('/checkRef', [SaisieController::class, 'checkRef'])->name('checkRef');

Route::get('/pageEchange', [SaisieController::class,'pageEchange'])->name("pageEchange");
Route::post('/traitementEchange', [SaisieController::class,'traitementEchange'])->name("traitementEchange");

Route::get('/pageDegustation', [SaisieController::class,'pageDegustation'])->name("pageDegustation");
Route::post('/traitementDegustation', [SaisieController::class,'traitementDegustation'])->name("traitementDegustation");

// AJAX
Route::get('/getlieuxbyidclient', [AjaxController::class,'getlieuxbyidclient'])->name("getlieuxbyidclient");
Route::get('/getresponsable', [AjaxController::class,'getresponsable'])->name("getresponsable");
Route::get('/getpu', [AjaxController::class,'getpu'])->name("getpu");
Route::get('/getLieux', [AjaxController::class,'getLieux'])->name("getLieux");
Route::get('/getEtatVente', [AjaxController::class,'getEtatVente'])->name("getEtatVente");
Route::get('/getEtatVenteProduit', [AjaxController::class,'getEtatVenteProduit'])->name("getEtatVenteProduit");
Route::get('/getEtatVenteEntite', [AjaxController::class,'getEtatVenteEntite'])->name("getEtatVenteEntite");
Route::get('/getEtatProduitEntite', [AjaxController::class,'getEtatProduitEntite'])->name("getEtatProduitEntite");

// VALIDATION
Route::get('/filtreImpaye', [ValidationController::class,'filtreImpaye'])->name("filtreImpaye");
Route::get('/listFactureImpaye', [ValidationController::class,'listFactureImpaye'])->name("listFactureImpaye");
Route::post('/multiPaiement', [ValidationController::class,'multiPaiement'])->name("multiPaiement");
Route::get('/pagePaiement/{id}', [ValidationController::class,'pagePaiement'])->name("pagePaiement");
Route::post('/traitementPaiement', [ValidationController::class,'traitementPaiement'])->name("traitementPaiement");

Route::get('/filtreCheque', [ValidationController::class,'filtreCheque'])->name("filtreCheque");
Route::get('/listCheque', [ValidationController::class,'listCheque'])->name("listCheque");
Route::post('/traitementCheque', [ValidationController::class,'traitementCheque'])->name("traitementCheque");
Route::get('/modifCheque/{id}', [ValidationController::class,'modifCheque'])->name("modifCheque");

Route::get('/validationEchange', [ValidationController::class,'validationEchange'])->name("validationEchange");
Route::post('/traitementvalidationEchange', [ValidationController::class,'traitementvalidationEchange'])->name("traitementvalidationEchange");
Route::get('/filtrevalidationEchange', [ValidationController::class,'filtrevalidationEchange'])->name("filtrevalidationEchange");

Route::get('/validationVente', [ValidationController::class,'validationVente'])->name("validationVente");
Route::get('/modifierVente/{id}', [ValidationController::class,'modifierVente'])->name("modifierVente");
Route::post('/updateVente', [ValidationController::class,'updateVente'])->name("updateVente");
Route::post('/traitementvalidationVente', [ValidationController::class,'traitementvalidationVente'])->name("traitementvalidationVente");
Route::get('/filtrevalidationVente', [ValidationController::class,'filtrevalidationVente'])->name("filtrevalidationVente");

// ADMIN
Route::get('/venteValide', [AdminController::class,'venteValide'])->name("venteValide");
Route::get('/filtreventeValide', [AdminController::class,'filtreventeValide'])->name("filtreventeValide");
Route::get('/detailsvente/{id}', [AdminController::class,'detailsvente'])->name("detailsvente");

// Route::get('/venteNonValide', [AdminController::class,'venteNonValide'])->name("venteNonValide");
// Route::get('/filtreventeNonValide', [AdminController::class,'filtreventeNonValide'])->name("filtreventeNonValide");

Route::get('/listePaiement', [AdminController::class,'listePaiement'])->name("listePaiement");
Route::get('/filtrelistePaiement', [AdminController::class,'filtrelistePaiement'])->name("filtrelistePaiement");

Route::get('/etatCheque', [AdminController::class,'etatCheque'])->name("etatCheque");
Route::get('/filtreetatCheque', [AdminController::class,'filtreetatCheque'])->name("filtreetatCheque");

Route::get('/venteNonPaye', [AdminController::class,'venteNonPaye'])->name("venteNonPaye");
Route::get('/filtreventeNonPaye', [AdminController::class,'filtreventeNonPaye'])->name("filtreventeNonPaye");

Route::get('/etatLivraison', [AdminController::class,'etatLivraison'])->name("etatLivraison");
Route::get('/filtreEtatLivraison', [AdminController::class,'filtreEtatLivraison'])->name("filtreEtatLivraison");

Route::get('/etatVente', [AdminController::class,'etatVente'])->name("etatVente");

Route::get('/venteProduitClient', [AdminController::class,'venteProduitClient'])->name("venteProduitClient");
Route::get('/filtreventeProduitClient', [AdminController::class,'filtreventeProduitClient'])->name("filtreventeProduitClient");

Route::get('/totalProduit', [AdminController::class,'totalProduit'])->name("totalProduit");
Route::get('/filtretotalProduit', [AdminController::class,'filtretotalProduit'])->name("filtretotalProduit");

Route::get('/etatVentePaye', [AdminController::class,'etatVentePaye'])->name("etatVentePaye");
Route::get('/filtreetatVentePaye', [AdminController::class,'filtreetatVentePaye'])->name("filtreetatVentePaye");

Route::get('/etatechange', [AdminController::class,'etatechange'])->name("etatechange");
Route::get('/filtreetatechange', [AdminController::class,'filtreetatechange'])->name("filtreetatechange");