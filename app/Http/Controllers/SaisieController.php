<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;
// use App\Models\Generic2;

class SaisieController extends Controller
{    
    public function pageDegustation()  {
        $clients = Generic::select('client')->get();
        $produits = Generic::select('v_produit')->get();
        $lieux = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $clients[0]->idclient] ])->get();
        $date = date('Y-m-d');
        $date_exp = Generic::select('detailvente', "*", [], [], 'iddetailvente', 'desc')->first();
        $expiration = isset($date_exp->expiration) ? $date_exp->expiration : date('Y-m-d');

        return view('saisie.saisieDegustation', ['expiration' => $expiration, 'date' => $date, 'clients' => $clients, "lieux" => $lieux, "produits" => $produits, 'nomPage' => 'Dégustation']);
    }

    public function traitementDegustation(Request $request){
        $datedegustation = request('date');
        $idinfoclient = request('idlieu');
        $idclient = request('idclient');
        $idlieu = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $idclient], ["idinfoclient", "=", $idinfoclient] ])->first()->idlieu;
        // $etat = 0;    

        $idinfoproduit = request('idinfoproduit');
        foreach ($idinfoproduit as $index => $id) {
            $data = [
                'idinfoclient' => $idinfoclient,
                'idclient' => $idclient,
                'idlieu' => $idlieu,
                'idinfoproduit' => $id,
                'nombre' => request('nombre')[$index],
                'datedegustation' => $datedegustation,
                'expiration' => request('expiration')[$index],
                // 'etat' => $etat,
                'datesaisie' => date('Y-m-d')
            ];
            Generic::insert('degustation', $data);
        }

        return redirect()->action([SaisieController::class, 'pageDegustation']);
    }

    public function saisieLivraison()  {
        $produits = Generic::select('v_produit')->get();
        $date = date('Y-m-d');

        return view('saisie.saisieLivraison', ["date" => $date, "produits" => $produits, 'nomPage' => 'Saisie livraison']);
    }
    
    public function traitementLivraison(Request $request){
        $datesortie = request('date'); 

        $idinfoproduit = request('idinfoproduit');
        foreach ($idinfoproduit as $index => $id) {
            $data = [
                'idinfoproduit' => $id,
                'nombre' => request('nombre')[$index],
                'datesortie' => $datesortie,
                'datesaisie' => date('Y-m-d')
            ];
            Generic::insert('sortie', $data);
        }

        return redirect()->action([SaisieController::class, 'saisieLivraison']);
    }

    public function saisie()  {
        $clients = Generic::select('client', ['*'], [], [], 'nom')->get();
        $lieux = Generic::select('lieu', ['*'], [], [], 'nom')->get();

        return view('saisie.saisieGeneral', ['clients' => $clients, "lieux" => $lieux, 'nomPage' => 'Saisie']);
    }
    
    public function saisieInfoClient(Request $request)  {
        $idclient = request("idclient");
        $idlieu = request("idlieu");
        $entite = request("entite");
        $data = [
            'idclient' => $idclient,
            'idlieu' => $idlieu,
            'entite' => $entite
        ];
        Generic::insert('infoclient', $data);

        return redirect()->action([SaisieController::class, 'saisie']);
    }

    public function saisieClient(Request $request)  {
        $nom = request("nom");
        $nif = request("nif");
        $stat = request("stat");
        $data = [
            'nom' => $nom,
            'nif' => $nif,
            'stat' => $stat
        ];
        Generic::insert('client', $data);

        return redirect()->action([SaisieController::class, 'saisie']);
    }
    
    public function saisieLieu(Request $request)  {
        $nom = request("nom");
        $data = [
            'nom' => $nom
        ];
        Generic::insert('lieu', $data);

        return redirect()->action([SaisieController::class, 'saisie']);
    }

    public function pageEchange()  {
        $clients = Generic::select('client')->get();
        $produits = Generic::select('v_produit')->get();
        $lieux = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $clients[0]->idclient] ])->get();

        return view('saisie.saisieechange', ['clients' => $clients, "lieux" => $lieux, "produits" => $produits, 'nomPage' => 'Echange']);
    }

    public function traitementEchange(Request $request){
        $dateechange = request('date');
        $idclient = request('idclient');
        $idinfoclient = request('idlieu');
        $idlieu = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $idclient], ["idinfoclient", "=", $idinfoclient] ])->first()->idlieu;
        $etat = 0;    

        $idinfoproduit = request('idinfoproduit');
        foreach ($idinfoproduit as $index => $id) {
            $data = [
                'idinfoclient' => $idinfoclient,
                'idclient' => $idclient,
                'idlieu' => $idlieu,
                'idinfoproduit' => $id,
                'nombre' => request('nombre')[$index],
                'dateechange' => $dateechange,
                'expiration' => request('expiration')[$index],
                'etat' => $etat,
                'datesaisie' => date('Y-m-d')
            ];
            Generic::insert('echange', $data);
        }

        return redirect()->action([SaisieController::class, 'pageEchange']);
    }
    
    public function pageVente()  {
        $clients = Generic::select('client')->get();
        $produits = Generic::select('v_produit')->get();
        $lieux = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $clients[0]->idclient] ])->get();
        $responsables = Generic::select('responsable')->get();
        $date_exp = Generic::select('detailvente', "*", [], [], 'iddetailvente', 'desc')->first();
        $expiration = isset($date_exp->expiration) ? $date_exp->expiration : date('Y-m-d');

        return view('saisie.saisievente', ['expiration' => $expiration, 'clients' => $clients, "lieux" => $lieux, "responsables" => $responsables, 'produits' => $produits, 'nomPage' => 'Saisie Vente']);
    }

    public function traitementVente(Request $request){        
        $validatedData = $request->validate([
            'idclient' => ['required'],
            'idlieu' => ['required'],
            'date' => ['required'],
            'ref' => ['required'],
            // 'idinfoproduit' => ['required'],
            // 'expiration[]' => ['required'],
            // 'nombre[]' => ['required', 'gt:0'],
        ]);

        $idclient = request('idclient');
        $idinfoclient = request('idlieu');
        $idlieu = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $idclient], ["idinfoclient", "=", $idinfoclient] ])->first()->idlieu;
        $datevente = request('date');
        $ref = request('ref');
        $nbdc = request('nbdc');
        $responsable = request('responsable');
        $contact = request('contact');
        $etat = 0;
        
        $data = [
            'idclient' => $idclient,
            'idinfoclient' => $idinfoclient,
            'idlieu' => $idlieu,
            'datevente' => $datevente,
            'ref' => $ref,
            'nbdc' => $nbdc,
            'responsable' => $responsable,
            'contact' => $contact,
            'etat' => $etat,
            'datesaisie' => date('Y-m-d')
        ];
        // dd($data);

        Generic::insert('vente', $data);
        $lastVente = DB::table('vente')->orderBy('idvente', 'desc')->first();        
        // dd($lastVente);

        $idvente = $lastVente->idvente;
        $idinfoproduit = request('idinfoproduit');
        foreach ($idinfoproduit as $index => $id) {
            $pu = Generic::select('v_produit', "*", [ ["idinfoproduit", "=", $id] ])->first();
            $data = [
                'idvente' => $idvente,
                'idinfoproduit' => $id,
                'expiration' => request('expiration')[$index],
                'nombre' => request('nombre')[$index],
                'pu' => $pu->pu,
            ];
            Generic::insert('detailvente', $data);
        }

        return redirect()->action([SaisieController::class, 'pageVente']);
    }

    public function checkRef()
    {
        $ref = request('ref');
        // $exists = Facture::where('ref', $ref)->exists();
        $exists = Generic::select('vente', "*", [ ["ref", "=", $ref] ])->exists();

        return response()->json(['exists' => $exists]);
    }
}
