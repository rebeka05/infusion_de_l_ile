<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;

class HomeController extends Controller
{

    public function accueil()  {
        $produits = Generic::select('v_produit')->get();

        return view('pages.accueil', ['produits' => $produits, 'nomPage' => 'Accueil']);
    }

}
