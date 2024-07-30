<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generic;

class AuthController extends Controller
{
    public function authentification(Request $request)  {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'mdp' => ['required'],
        ]);

        $email = request('email');
        $mdp = request('mdp');

        $personnel = Generic::select('personnel', '*', [['login' , '=', $email], ['password' , '=', $mdp]])->first();
        if(!$personnel) {
            return redirect()->back()->with('erreur', 'Vérifiez votre email ou mot de passe');
        }
        $request->session()->put('role', $personnel->role);

        // return view("pages.accueil", ['nomPage' => 'Vente']);   
        return redirect()->action([HomeController::class, 'accueil']);   
    }

    public function deconnexion(Request $request)
    {
        $request->session()->forget('role');
        return view("pages.login");
    }
}
