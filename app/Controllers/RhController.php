<?php

namespace App\Controllers;

use App\Models\CongeModel;

class RhController extends BaseController
{
    public function index()
    {
        $model = new CongeModel();
        // Récupère les congés en attente pour validation
        $data = [
            'titre' => 'Espace RH',
            'demandes_en_attente' => $model->where('statut', 'en_attente')->findAll()
        ];
        return view('rh/dashboard', $data);
    }

    public function valider($id)
    {
        $model = new CongeModel();
        $model->update($id, [
            'statut' => 'approuvee',
            'traite_par' => session()->get('user_id') // ID du RH connecté
        ]);
        return redirect()->back()->with('msg', 'Congé approuvé');
    }
}