<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function filtreetatCheque()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('v_lieuclient')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
        $conditions = [];
        $datepaiement = request('datepaiement');
        $idclient = request('idclient');
        $idinfoclient = request('idlieu');
        $annee = request("annee");
        $idmois = request("idmois");
        $etat = request("etat");
        
        if (!empty($datepaiement)) {
            $conditions[] = ["datepaiement", "=", $datepaiement];
        }
        if (!empty($etat)) {
            $conditions[] = ["etat", "=", $etat];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idinfoclient)) {
            $conditions[] = ["idinfoclient", "=", $idinfoclient];
        }
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }
        if (!empty($idmois)) {
            $conditions[] = ["idmois", "=", $idmois];
        }
        $cheques = Generic::select('v_etat_cheque', "*", $conditions, [], "datepaiement", "desc")->get();

        return view('pageadmin.etatCheque', ['annees' => $annees, 'mois' => $mois, "lieux" => $lieux, 'clients' => $clients, 'cheques' => $cheques, 'nomPage' => 'Liste des chèques']);
    }    

    public function etatCheque()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('v_lieuclient')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
        $cheques = Generic::select('v_etat_cheque', "*", [], [], "datepaiement", "desc")->get();

        return view('pageadmin.etatCheque', ['annees' => $annees, 'mois' => $mois, "lieux" => $lieux, 'clients' => $clients, 'cheques' => $cheques, 'nomPage' => 'Liste des chèques']);
    }

    public function etatechange(){
        $echanges = Generic::select('v_etatechange')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();        
        $total = Generic::select('v_etatechange', DB::raw('sum(total) as total'))->first()->total;

        return view('pageadmin.etatechange', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'echanges' => $echanges, 'nomPage' => 'Etat échange']);
    }

    public function filtreetatechange()  {        
        $conditions = [ ];
        $annee = request('annee');
        $idmois = request('idmois');
        
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }
        if (!empty($idmois)) {
            $conditions[] = ["idmois", "=", $idmois];
        }
        $echanges = Generic::select('v_etatechange', "*", $conditions)->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();        
        $total = Generic::select('v_etatechange', DB::raw('sum(total) as total'), $conditions)->first()->total;

        return view('pageadmin.etatechange', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'echanges' => $echanges, 'nomPage' => 'Etat échange']);
    }

    public function filtreetatVentePaye()  {        
        $conditions = [ ];
        $idclient = request('idclient');
        $annee = request('annee');
        $idmois = request('idmois');
        
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }
        if (!empty($idmois)) {
            $conditions[] = ["idmois", "=", $idmois];
        }
        $paiements = Generic::select('v_etat_vente_paye', "*", $conditions)->get();
        $total = Generic::select('v_etat_vente_paye', DB::raw('sum(total) as total'), $conditions)->first();
        $clients = Generic::select('client')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();

        return view('pageadmin.etatVentePaye', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'paiements' => $paiements, 'clients' => $clients, 'nomPage' => 'Etat de vente par mois']);
    }

    public function etatVentePaye()  {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $conditions = [ 
                        ["annee", "=", $year],
                        // ["idmois", "=", $month]
        ];
        $paiements = Generic::select('v_etat_vente_paye', "*", $conditions)->get();
        $total = Generic::select('v_etat_vente_paye', DB::raw('sum(total) as total'), $conditions)->first();
        $clients = Generic::select('client')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();     

        return view('pageadmin.etatVentePaye', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'paiements' => $paiements, 'clients' => $clients, 'nomPage' => 'Etat de vente par mois']);
    }

    public function filtreEtatLivraison(Request $request) {
        $datesortie = $request->query('datesortie');
        $ventes = Generic::select('v_etatlivraison', ['*'], [["datesortie", "=", $datesortie]])->get();

        return view('pageadmin.etatLivraison', ['datesortie' => $datesortie, 'ventes' => $ventes, 'nomPage' => 'Etat de livraison par date']);
    }

    public function etatLivraison()  {
        $datesortie = date('Y-m-d');
        $ventes = Generic::select('v_etatlivraison', ['*'], [["datesortie", "=", $datesortie]])->get();

        return view('pageadmin.etatLivraison', ['datesortie' => $datesortie, 'ventes' => $ventes, 'nomPage' => 'Etat de livraison par date']);
    }   

    public function filtretotalProduit(Request $request) {      
        $year = $request->query('annee');
        $idinfoproduit = $request->query('idinfoproduit');
        $idmois = $request->query('idmois');

        $produits = Generic::select('v_produit')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();

        $prod = Generic::select('v_total_produit_mensuel', '*', [ ["idinfoproduit", "=", $idinfoproduit], ["idmois", "=", $idmois], ["annee", "=", $year]])->get();

        return view('pageadmin.totalProduit', ['mois' => $mois, 'produits' => $produits, 'prod' => $prod, 'annees' => $annees, 'nomPage' => 'Liste total des produits par client']);
    }
    
    public function totalProduit()  {
        $produits = Generic::select('v_produit')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();

        $prod = Generic::select('v_total_produit_mensuel', '*', [ ["idinfoproduit", "=", $produits[0]->idinfoproduit], ["idmois", "=", $mois[0]->idmois], ["annee", "=", $annees[0]->annee]])->get();

        return view('pageadmin.totalProduit', ['mois' => $mois, 'produits' => $produits, 'prod' => $prod, 'annees' => $annees, 'nomPage' => 'Liste total des produits par client']);
    }    

    public function filtreventeProduitClient(Request $request) {        
        $year = $request->query('annee');
        $idclient = $request->query('idclient');
        $idmois = $request->query('idmois');

        $clients = Generic::select('client')->get();
        $lieux = Generic::select('v_lieuclient', ['*'], [ ["idclient", "=", $idclient]])->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        // $ventes = Generic::select('v_vente_client_mensuel', ['*'], [["annee", "=", $annees[0]->annee], ["idclient", "=", $clients[0]->idclient]])->get();

        return view('pageadmin.venteProduitClient', ['year' => $year, 'idclient' => $idclient, 'idmois' => $idmois, 'mois' => $mois, 'lieux' => $lieux, 'annees' => $annees, 'clients' => $clients, 'nomPage' => 'Liste des ventes par produit par client']);
    }
    
    public function venteProduitClient()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('v_lieuclient', ['*'], [ ["idclient", "=", $clients[0]->idclient]])->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        $ventes = Generic::select('v_vente_client_mensuel', ['*'], [["annee", "=", $annees[0]->annee], ["idclient", "=", $clients[0]->idclient]])->get();

        return view('pageadmin.venteProduitClient', ['mois' => $mois, 'lieux' => $lieux, 'annees' => $annees, 'clients' => $clients, 'nomPage' => 'Liste des ventes par produit par client']);
    }    
    
    public function etatVente()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $produits = Generic::select('v_produit')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();

        $ventes = Generic::select('v_etat_vente', ['idmois', DB::raw('SUM(total) AS total')], [], [], 'idmois', 'ASC', ['idmois', 'annee'])->get();

        $etat_produits = Generic::select('v_etat_vente_produit', ['idmois', DB::raw('SUM(total) AS total')], [ ["annee", "=", $annees[0]->annee], ["idinfoproduit", "=", $produits[0]->idinfoproduit] ], [], 'idmois', 'ASC', ['idinfoproduit', 'idmois', 'annee'])->get();

        $etat_entites = Generic::select('v_etat_vente_mensuel_entite', ['datevente', DB::raw('SUM(total) AS total')], [ ["annee", "=", $annees[0]->annee], ["idmois", "=", $mois[0]->idmois], ["idclient", "=", $clients[0]->idclient] ], [], 'datevente', 'ASC', ['datevente'])->get();
        
        $etats = Generic::select('v_etatentite_annuel', ['*'], [ ["annee", "=", $annees[0]->annee] ], [], 'idmois', 'ASC')->get();
        // $etats = Generic::select('v_etatproduit_annuel', ['*'], [ ["annee", "=", $annees[0]->annee] ], [], 'idmois', 'ASC')->get();

        $m = $mois[0]->idmois;
        $a = $annees[0]->annee;
        $jours = DB::select("SELECT * FROM get_dates_of_month($m, $a)");

        return view('pageadmin.etatvente', [
            'etat_produits' => $etat_produits,
            'etat_entites' => $etat_entites, 
            'etats' => $etats,
            'jours' => $jours, 
            'annees' => $annees, 
            'mois' => $mois, 
            'produits' => $produits, 
            'ventes' => $ventes, "lieux" => $lieux, 
            'clients' => $clients, 
            'nomPage' => 'Etat de vente'
        ]);
    }

    public function venteNonPaye()  {
        $conditions = [ ["reste", ">", 0] ];
        $ventes = Generic::select('v_paiement', "*", $conditions, [], "datevente", "desc")->get();
        $total = Generic::select('v_paiement', DB::raw('sum(total) as total'), $conditions)->first();

        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $responsables = Generic::select('responsable')->get();

        return view('pageadmin.venteNonPaye', ['total' => $total, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes non payés']);
    }

    public function filtreventeNonPaye()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $responsables = Generic::select('responsable')->get();
        
        $conditions = [["reste", ">", 0] ];
        $responsable = request('responsable');
        $idclient = request('idclient');
        $idlieu = request('idlieu');
        $datevente = request('datevente');
        // $annee = request('annee');
        // $idmois = request('idmois');
        
        if (!empty($responsable)) {
            $conditions[] = ["responsable", "=", $responsable];
        }
        if (!empty($datevente)) {
            $conditions[] = ["datevente", "=", $datevente];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        $ventes = Generic::select('v_paiement', "*", $conditions, [], "datevente", "desc")->get();
        $total = Generic::select('v_paiement', DB::raw('sum(total) as total'), $conditions)->first();

        return view('pageadmin.venteNonPaye', ['total' => $total, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes non payés']);
    }

    public function listePaiement()  {
        $paiements = Generic::select('v_liste_paiement')->get();
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $modepaiements = Generic::select('modepaiement')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        $total = Generic::select('v_liste_paiement', DB::raw('sum(montant) as total'))->first()->total;

        return view('pageadmin.listePaiement', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'modepaiements' => $modepaiements, 'paiements' => $paiements, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des paiements']);
    }

    public function filtrelistePaiement()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $modepaiements = Generic::select('modepaiement')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
        $conditions = [ ];
        $idmodepaiement = request('idmodepaiement');
        $idclient = request('idclient');
        $idlieu = request('idlieu');
        $datepaiement = request('datepaiement');
        $annee = request('annee');
        $idmois = request('idmois');
        
        if (!empty($idmodepaiement)) {
            $conditions[] = ["idmodepaiement", "=", $idmodepaiement];
        }
        if (!empty($datepaiement)) {
            $conditions[] = ["datepaiement", "=", $datepaiement];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }
        if (!empty($idmois)) {
            $conditions[] = ["idmois", "=", $idmois];
        }
        $paiements = Generic::select('v_liste_paiement', "*", $conditions)->get();
        $total = Generic::select('v_liste_paiement', DB::raw('sum(montant) as total'), $conditions)->first()->total;

        return view('pageadmin.listePaiement', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'modepaiements' => $modepaiements, 'paiements' => $paiements, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des paiements']);
    }

    // public function venteNonValide()  {
    //     $ventes = Generic::select('v_vente_non_valide')->get();
    //     $clients = Generic::select('client')->get();
    //     $lieux = Generic::select('lieu')->get();
    //     $responsables = Generic::select('responsable')->get();
    //     $mois = Generic::select('mois')->get();
    //     $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();

    //     $total = Generic::select('v_vente_non_valide', DB::raw('sum(total) as total'))->first()->total;

    //     return view('pageadmin.venteNonValide', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes non validés']);
    // }
    // public function filtreventeNonValide()  {
    //     $clients = Generic::select('client')->get();
    //     $lieux = Generic::select('lieu')->get();
    //     $responsables = Generic::select('responsable')->get();
    //     $mois = Generic::select('mois')->get();
    //     $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
    //     $conditions = [ ];
    //     $responsable = request('responsable');
    //     $idclient = request('idclient');
    //     $idlieu = request('idlieu');
    //     $datevente = request('datevente');
    //     $annee = request('annee');
    //     $idmois = request('idmois');
        
    //     if (!empty($responsable)) {
    //         $conditions[] = ["responsable", "=", $responsable];
    //     }
    //     if (!empty($datevente)) {
    //         $conditions[] = ["datevente", "=", $datevente];
    //     }
    //     if (!empty($idclient)) {
    //         $conditions[] = ["idclient", "=", $idclient];
    //     }
    //     if (!empty($idlieu)) {
    //         $conditions[] = ["idlieu", "=", $idlieu];
    //     }
    //     if (!empty($annee)) {
    //         $conditions[] = ["annee", "=", $annee];
    //     }
    //     if (!empty($idmois)) {
    //         $conditions[] = ["idmois", "=", $idmois];
    //     }
    //     $ventes = Generic::select('v_vente_non_valide', "*", $conditions, [], "datevente", "desc")->get();
    //     $total = Generic::select('v_vente_non_valide', DB::raw('sum(total) as total'), $conditions)->first()->total;

    //     return view('pageadmin.venteNonValide', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes non validés']);
    // }

    public function detailsvente($id)  {
        $vente = Generic::select('vente', '*', [ ['idvente' , '=', $id] ])->first();
        $details = Generic::select('v_detailvente', '*', [ ['idvente' , '=', $id] ])->get();
        $client = Generic::select('v_lieuclient', '*', [ ['idinfoclient' , '=', $vente->idinfoclient] ])->first(); 

        return view('pageadmin.detailsvente', ["client" => $client, "vente" => $vente, 'details' => $details, 'nomPage' => 'Modification vente']);
    }

    public function venteValide()  {
        $ventes = Generic::select('v_vente_valide')->get();
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $responsables = Generic::select('responsable')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
        $total = Generic::select('v_vente_valide', DB::raw('sum(total) as total'))->first()->total;

        return view('pageadmin.venteValide', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes validés']);
    }

    public function filtreventeValide()  {
        $clients = Generic::select('client')->get();
        $lieux = Generic::select('lieu')->get();
        $responsables = Generic::select('responsable')->get();
        $mois = Generic::select('mois')->get();
        $annees = Generic::select('vente', DB::raw('distinct extract(year from datevente) as annee'))->get();
        
        $conditions = [ ];
        $responsable = request('responsable');
        $idclient = request('idclient');
        $idlieu = request('idlieu');
        $datevente = request('datevente');
        $annee = request('annee');
        $idmois = request('idmois');
        
        if (!empty($responsable)) {
            $conditions[] = ["responsable", "=", $responsable];
        }
        if (!empty($datevente)) {
            $conditions[] = ["datevente", "=", $datevente];
        }
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }
        if (!empty($idmois)) {
            $conditions[] = ["idmois", "=", $idmois];
        }
        $ventes = Generic::select('v_vente_valide', "*", $conditions, [], "datevente", "desc")->get();
        $total = Generic::select('v_vente_valide', DB::raw('sum(total) as total'), $conditions)->first()->total;

        return view('pageadmin.venteValide', ['total' => $total, 'mois' => $mois, 'annees' => $annees, 'responsables' => $responsables, 'ventes' => $ventes, "lieux" => $lieux, 'clients' => $clients, 'nomPage' => 'Liste des ventes validés']);
    }

}