<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;
// use App\Models\Generic2;

class ValidationController extends Controller
{

    public function pagePaiement($id)  {
        $modes = Generic::select('modepaiement')->get();
        $banques = Generic::select('banque')->get();
        $impaye = Generic::select('v_paiement', "*", [ ["idvente", "=", $id] ], [], "datevente", "desc")->first();

        return view('validation.saisiepaiement', ["banques" => $banques, 'modes' => $modes, "impaye" => $impaye, 'nomPage' => 'Vente']);
    }

    public function filtreImpaye()  {
        $clients = Generic::select('client')->get();
        $modes = Generic::select('modepaiement')->get();
        $lieux = Generic::select('lieu')->get();
        $banques = Generic::select('banque')->get();
        
        $conditions = [ ["reste", ">", 0] ];
        $datevente = request('datevente');
        $idclient = request('idclient');
        $idlieu = request('idlieu');
        
        if (!empty($datevente)) {
            $conditions[] = ["datevente", "=", $datevente];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        $impayes = Generic::select('v_paiement', "*", $conditions, [], "datevente", "desc")->get();

        return view('validation.listFactureImpaye', ["banques" => $banques, "lieux" => $lieux, 'clients' => $clients, 'modes' => $modes, 'impayes' => $impayes, 'nomPage' => 'Liste des factures non payées']);
    }

    public function listFactureImpaye()  {
        $clients = Generic::select('client')->get();
        $modes = Generic::select('modepaiement')->get();
        $lieux = Generic::select('lieu')->get();
        $banques = Generic::select('banque')->get();
        
        $impayes = Generic::select('v_paiement', "*", [ ["reste", ">", 0] ], [], "datevente", "desc")->get();

        return view('validation.listFactureImpaye', ["banques" => $banques, "lieux" => $lieux, 'clients' => $clients, 'modes' => $modes, 'impayes' => $impayes, 'nomPage' => 'Liste des factures non payées']);
    }

    public function traitementPaiement(){
        $datepaiement = request('date');
        $idmodepaiement = request('idmodepaiement');
        $montant = request('montant');
        $idvente = request('idvente');
        
        if(request('idbanque') == "2"){ // cheque
            $data['idbanque'] = request('idbanque');
            $data['nom'] = request('nom');
            $data['numero'] = request('numero');
            $data['datecreation'] = request('datecreation');
        }
        else if(request('idbanque') == "3"){  //virement
            $data['idbanque'] = request('idbanque');
        }
        
        $data = [
            'idvente' => $idvente,
            'idmodepaiement' => $idmodepaiement,
            'datepaiement' => $datepaiement,
            'montant' => $montant,
            'datesaisie' => date('Y-m-d')
        ];
        Generic::insert('paiement', $data);

        // var_dump($data);

        return redirect()->action([ValidationController::class, 'listFactureImpaye']);
    }

    public function multiPaiement(){
        $datepaiement = request('date');
        $idmodepaiement = request('idmodepaiement');
        $idvente = request('idvente');

        foreach ($idvente as $index => $id) {
            $montant = Generic::select('v_paiement', "*", [ ["idvente", "=", $id] ])->first()->reste;

            $data = [
                'idvente' => $id,
                'idmodepaiement' => $idmodepaiement,
                'datepaiement' => $datepaiement,
                'montant' => $montant,
                'datesaisie' => date('Y-m-d')
            ];        
            if(request('idbanque') == "2"){ // cheque
                $data['idbanque'] = request('idbanque');
                $data['nom'] = request('nom');
                $data['numero'] = request('numero');
                $data['datecreation'] = request('datecreation');
            }
            else if(request('idbanque') == "3"){  //virement
                $data['idbanque'] = request('idbanque');
            }
            Generic::insert('paiement', $data);
        }

        return redirect()->action([ValidationController::class, 'listFactureImpaye']);
    }

    public function validationEchange()  {
        $echanges = Generic::select('v_echange_non_valide', "*", [], [], "dateechange", "desc")->get();
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();

        return view('validation.validationEchange', ["lieux" => $lieux, 'clients' => $clients, 'echanges' => $echanges, 'nomPage' => 'Validation échange']);
    }

    public function filtrevalidationEchange()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        
        $conditions = [];
        $dateechange = request('dateechange');
        $idclient = request('idclient');
        $idlieu = request('idlieu');
        
        if (!empty($dateechange)) {
            $conditions[] = ["dateechange", "=", $dateechange];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        $echanges = Generic::select('v_echange_non_valide', "*", $conditions, [], "dateechange", "desc")->get();
        
        return view('validation.validationEchange', ["lieux" => $lieux, 'clients' => $clients, 'echanges' => $echanges, 'nomPage' => 'Validation échange']);
    }

    public function traitementvalidationEchange(){
        $etat = 1;    

        $idechange = request('idechange');
        foreach ($idechange as $index => $id) { 
            $data = [
                'etat' => $etat,
                'datesaisie' => date('Y-m-d')
            ];
            $idech["name"] = "idechange";
            $idech["value"] = $id;
            Generic::updatin("echange", $idech, $data);
            // var_dump($data);
        }

        return redirect()->action([ValidationController::class, 'validationEchange']);
    }

    public function modifierVente($id)  {
        $vente = Generic::select('vente', '*', [ ['idvente' , '=', $id] ])->first();
        $details = Generic::select('detailvente', '*', [ ['idvente' , '=', $id] ])->get();
        $client = Generic::select('v_lieuclient', '*', [ ['idinfoclient' , '=', $vente->idinfoclient] ])->first();
        
        $produits = Generic::select('v_produit')->get();
        $date_exp = Generic::select('detailvente', "*", [], [], 'iddetailvente', 'desc')->first();
        $expiration = isset($date_exp->expiration) ? $date_exp->expiration : date('Y-m-d');

        return view('validation.modifVente', ['expiration' => $expiration, 'produits' => $produits, "client" => $client, "vente" => $vente, 'details' => $details, 'nomPage' => 'Modification vente']);
    }

    public function updateVente(Request $request){     
        $idvente = request('idvente');
        
        $id["idvente"] = $idvente;
        Generic::deletin("detailvente", $id);

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

        return redirect()->action([ValidationController::class, 'validationVente']);
    }

    public function validationVente()  {
        $ventes = Generic::select('v_vente_non_valide', "*", [], [], "datevente", "desc")->get();
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('v_lieuclient')->get();

        return view('validation.validationVente', ["lieux" => $lieux, 'clients' => $clients, 'ventes' => $ventes, 'nomPage' => 'Validation vente']);
    }

    public function filtrevalidationVente()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        
        $conditions = [];
        $datevente = request('datevente');
        $idclient = request('idclient');
        $idinfoclient = request('idlieu');
        
        if (!empty($datevente)) {
            $conditions[] = ["datevente", "=", $datevente];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idinfoclient)) {
            $conditions[] = ["idinfoclient", "=", $idinfoclient];
        }
        $ventes = Generic::select('v_vente_non_valide', "*", $conditions, [], "datevente", "desc")->get();
        
        return view('validation.validationVente', ["lieux" => $lieux, 'clients' => $clients, 'ventes' => $ventes, 'nomPage' => 'Validation vente']);
    }

    public function traitementvalidationVente(){
        $etat = 1;    

        $idvente = request('idvente');
        foreach ($idvente as $index => $id) { 
            $data = [
                'etat' => $etat,
                'datesaisie' => date('Y-m-d')
            ];
            $idech["name"] = "idvente";
            $idech["value"] = $id;
            Generic::updatin("vente", $idech, $data);
            // var_dump($data);
        }

        return redirect()->action([ValidationController::class, 'validationVente']);
    }

}
