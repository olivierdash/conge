<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLogged')) {
            return redirect()->to('/auth');
        }

        // Vérification du rôle requis (passé en argument dans les routes)
        $roleRequis = $arguments[0] ?? null;
        if ($roleRequis && session()->get('role') !== $roleRequis) {
            return redirect()->to('/auth')->with('error', "Accès refusé : zone $roleRequis");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}