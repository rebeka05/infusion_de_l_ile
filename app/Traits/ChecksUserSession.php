<?php

namespace App\Traits;

trait ChecksUserSession
{
    public function checkSession()
    {
        if (!session('role')) {
            abort(403, 'Unauthorized action.'); // Ou rediriger vers la page de connexion
            // return redirect()->route('login'); // Assurez-vous que 'login' est défini dans vos routes
        }
    }
}
