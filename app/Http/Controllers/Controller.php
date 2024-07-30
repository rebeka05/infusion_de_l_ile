<?php

namespace App\Http\Controllers;

use App\Traits\ChecksUserSession;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use ChecksUserSession;

    // protected function checkSession()
    // {
    //     if (!session('role')) {
    //         // abort(403, 'Unauthorized action.'); // Ou rediriger vers la page de connexion
    //         // return redirect()->route('/'); // Assurez-vous que 'login' est défini dans vos routes
    //         return view("pages.login");
    //     }
    // }
}
