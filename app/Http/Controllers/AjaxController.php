<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;
// use App\Models\Generic2;

class AjaxController extends Controller
{
    public function getEtatVenteProduit(Request $request)
    {
        $annee = $request->query('annee');
        $idproduit = $request->query('produit');

        $mois = Generic::select('mois')->get();
        $moisArray = $mois->toArray();
        $etat_produits = Generic::select('v_etat_vente_produit', ['idmois', DB::raw('SUM(total) AS total')], [ ["annee", "=", $annee], ["idinfoproduit", "=", $idproduit] ], [], 'idmois', 'ASC', ['idinfoproduit', 'idmois', 'annee'])->get();

        $produitsArray = $etat_produits->toArray();
        $produitsAssoc = [];
        foreach ($produitsArray as $produit) {
            $produitsAssoc[$produit['idmois']] = $produit['total'];
        }

        $datas2 = [];
        foreach ($moisArray as $moisItem) {
            $datas2[] = isset($produitsAssoc[$moisItem['idmois']]) ? $produitsAssoc[$moisItem['idmois']] : 0;
        }

        return response()->json([
            'datas' => $datas2 // Remplacement de $datas par $datas2
        ]);
    }

    public function getEtatVenteEntite(Request $request)
    {
        $annee = $request->query('annee');
        $idmois = $request->query('mois');
        $idclient = $request->query('client');
        $idlieu = $request->query('lieu');   

        $jours = DB::select("SELECT * FROM get_dates_of_month($idmois, $annee)");

        $conditions = [ ["annee", "=", $annee], ["idmois", "=", $idmois], ["idclient", "=", $idclient] ];
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        $etat_entites = Generic::select('v_etat_vente_mensuel_entite', ['datevente', DB::raw('SUM(total) AS total')], $conditions, [], 'datevente', 'ASC', ['datevente'])->get();

        $entitesArray = $etat_entites->toArray();

        $joursArray = json_decode(json_encode($jours), true);
        $labels3 = [];
        $datas3 =[];
        $entitesAssoc = [];
        foreach ($entitesArray as $entite) {
            $entitesAssoc[$entite['datevente']] = $entite['total'];
        }
        foreach ($joursArray as $jour) {
            $labels3[] = $jour['date'];
            $datas3[] = isset($entitesAssoc[$jour['date']]) ? $entitesAssoc[$jour['date']] : 0;
        }

        return response()->json([
            'labels' => $labels3,
            'datas' => $datas3
        ]);
    }

    public function getEtatProduitEntite(Request $request)
    {
        $annee = $request->query('annee');
        $type = $request->query('type');  

        // $mois = Generic::select('mois')->get();
        // $moisArray = $mois->toArray();

        if($type == 1){            
            $etats = Generic::select('v_etatentite_annuel', ['*'], [ ["annee", "=", $annee] ], [], 'idmois', 'ASC')->get();
            $etatArray = $etats->toArray();
            $clientsData = [];
            foreach ($etatArray as $etat) {
                // Assurez-vous que l'ID du client est présent dans le tableau
                if (!isset($clientsData[$etat['idclient']])) {
                    $clientsData[$etat['idclient']] = ['label' => $etat['nom'], 'data' => []];
                }
                // Ajoutez la valeur total pour le mois correspondant
                $clientsData[$etat['idclient']]['data'][$etat['mois']] = $etat['total'];
            }
            $colors = [
              'rgba(255, 99, 132, 0.2)', //rouge
              'rgba(54, 162, 235, 0.2)', //bleu
              'rgba(255, 206, 86, 0.2)', //jaune
              'rgba(255, 0, 255, 0.2)',   // Magenta
              'rgba(75, 192, 192, 0.2)', //turquoise
              'rgba(153, 102, 255, 0.2)' //violet
            ];
            $colorIndex = 0; // Index pour parcourir les couleurs disponibles
            foreach ($clientsData as $clientData) {
              $datas4[] = [
                  'label' => $clientData['label'],
                  'data' => $clientData['data'],
                  'backgroundColor' => $colors[$colorIndex % count($colors)], // Utilisez une couleur unique par client
                  'borderColor' => str_replace('0.2', '1', $colors[$colorIndex % count($colors)]), // Version opaque de la couleur
                  'borderWidth' => 1,
              ];
              $colorIndex++; // Incrémentez l'index pour le prochain client
            }
        }
        else if($type == 2){            
            $etats = Generic::select('v_etatproduit_annuel', ['*'], [ ["annee", "=", $annee] ], [], 'idmois', 'ASC')->get();
            $etatArray = $etats->toArray();
            $produitsData = [];
            foreach ($etatArray as $etat) {
                // Assurez-vous que l'ID du produit est présent dans le tableau
                if (!isset($produitsData[$etat['idinfoproduit']])) {
                    $produitsData[$etat['idinfoproduit']] = ['label' => $etat['nom'].' '.$etat['qte'].' '.$etat['unite'], 'data' => []];
                }
                // Ajoutez la valeur total pour le mois correspondant
                $produitsData[$etat['idinfoproduit']]['data'][$etat['mois']] = $etat['total'];
            }
            $colors = [
              'rgba(255, 99, 132, 0.2)', //rouge
              'rgba(54, 162, 235, 0.2)', //bleu
              'rgba(255, 206, 86, 0.2)', //jaune
              'rgba(255, 0, 255, 0.2)',   // Magenta
              'rgba(75, 192, 192, 0.2)', //turquoise
              'rgba(153, 102, 255, 0.2)', //violet
              'rgba(220, 20, 60, 0.2)',     // Tomato
              'rgba(0, 191, 255, 0.2)',     // Deep Sky Blue
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 105, 180, 0.2)',  // Rose vif
              'rgba(0, 128, 128, 0.2)',   // Vert printemps
              'rgba(218, 112, 214, 0.2)',
              'rgba(255, 255, 0, 0.2)',
            ];
            $colorIndex = 0; // Index pour parcourir les couleurs disponibles
            foreach ($produitsData as $produitData) {
              $datas4[] = [
                  'label' => $produitData['label'],
                  'data' => $produitData['data'],
                  'backgroundColor' => $colors[$colorIndex % count($colors)], // Utilisez une couleur unique par client
                  'borderColor' => str_replace('0.2', '1', $colors[$colorIndex % count($colors)]), // Version opaque de la couleur
                  'borderWidth' => 1,
              ];
              $colorIndex++; // Incrémentez l'index pour le prochain client
            }
        }

        return response()->json([
            'datas' => $datas4 // Remplacement de $datas par $datas2
        ]);
    }
    
    public function getEtatVente(Request $request)
    {
        $annee = $request->query('annee');
        $idclient = $request->query('client');
        $idlieu = $request->query('lieu');

        $conditions = [];
        if (!empty($idclient)) {
            $conditions[] = ["idclient", "=", $idclient];
        }
        if (!empty($idlieu)) {
            $conditions[] = ["idlieu", "=", $idlieu];
        }
        if (!empty($annee)) {
            $conditions[] = ["annee", "=", $annee];
        }

        $ventes = Generic::select('v_etat_vente', ['idmois', DB::raw('SUM(total) AS total')], $conditions, [], 'idmois', 'ASC', ['idmois', 'annee'])->get();
        $mois = Generic::select('mois')->get();

        $moisArray = $mois->toArray();
        $ventesArray = $ventes->toArray();

        $ventesAssoc = [];
        foreach ($ventesArray as $vente) {
            $ventesAssoc[$vente['idmois']] = $vente['total'];
        }

        $datas = [];
        foreach ($moisArray as $moisItem) {
            $datas[] = isset($ventesAssoc[$moisItem['idmois']]) ? $ventesAssoc[$moisItem['idmois']] : 0;
        }

        return response()->json([
            'datas' => $datas
        ]);
    }
    
    public function getpu(Request $request) {
        $produitId = $request->query('produitId');
        $produit = Generic::select('v_produit', "*", [ ["idinfoproduit", "=", $produitId] ])->first();
        return response()->json($produit);
    }  

    public function getlieuxbyidclient(Request $request) {
        $clientId = $request->query('clientId');
        $lieux = Generic::select('v_lieuclient', "*", [ ["idclient", "=", $clientId] ])->get();
        return response()->json(['lieux' => $lieux]);
    }  

    public function getLieux() {
        $lieux = Generic::select('v_lieuclient')->get();
        return response()->json(['lieux' => $lieux]);
    }    
    
    public function getresponsable(Request $request) {
        $clientId = $request->query('clientId');
        $lieuId = $request->query('lieuId');
        $responsables = Generic::select('v_responsable', "*", [ ["idclient", "=", $clientId], ["idlieu", "=", $lieuId] ])->get();
        return response()->json(['responsables' => $responsables]);
    }  

}