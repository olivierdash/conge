<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\SoldeModel;

class EmployeController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

        $data = [
            'titre'  => 'Mon Espace',
            'mes_conges' => $congeModel->where('employe_id', $userId)->findAll(),
            'mes_soldes' => $soldeModel->where('employe_id', $userId)->findAll()
        ];
        return view('employe/dashboard', $data);
    }

    public function soumettre_conge()
    {
        // Logique d'insertion d'une nouvelle demande
        // (Vérification des dates et nb_jours ici)
    }
}