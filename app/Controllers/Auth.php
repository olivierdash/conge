<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class Auth extends BaseController
{
<<<<<<< HEAD
    public function index()
    {
=======
    private function ensureDemoDataSeeded(): void
    {
        if ((defined('ENVIRONMENT') ? ENVIRONMENT : null) !== 'development') {
            return;
        }

        try {
            $db = db_connect();
            if (!$db->tableExists('employes')) {
                return;
            }

            $count = (int) $db->table('employes')->countAllResults();
            if ($count > 0) {
                return;
            }

            $seeder = \Config\Database::seeder();
            $seeder->call('MainSeeder');
        } catch (\Throwable $e) {
            // Ne bloque pas la page de login si le seed échoue
        }
    }

    public function index()
    {
        $this->ensureDemoDataSeeded();
>>>>>>> 5e94279
        return view('auth/login'); // Le nom de votre fichier HTML fourni
    }

    public function login()
    {
        $session = session();
        $model = new EmployeModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
<<<<<<< HEAD
=======

        $this->ensureDemoDataSeeded();
>>>>>>> 5e94279
        
        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // On stocke les infos clés en session
                $session->set([
                    'id'       => $user['id'],
                    'nom'      => $user['nom'],
                    'role'     => $user['role'], // 'admin', 'rh', ou 'employe'
                    'isLogged' => true,
                ]);

                // Redirection selon le rôle
                switch ($user['role']) {
                    case 'admin': return redirect()->to('/admin/dashboard');
                    case 'rh':    return redirect()->to('/rh/dashboard');
                    default:      return redirect()->to('/employe/dashboard');
                }
            }
        }

        $session->setFlashdata('error', 'Identifiants incorrects.');
        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 5e94279
