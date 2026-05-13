<?php

namespace App\Controllers\Employe;

use App\Controllers\BaseController;
use App\Models\CongeModel;
use App\Models\SoldeModel;

class CongeController extends BaseController
{
    // Affiche la liste des demandes de l'employé (index.php)
    public function index()
    {
        $congeModel = new CongeModel();
        $data['conges'] = $congeModel->where('employe_id', session()->get('user_id'))
                                    ->orderBy('created_at', 'DESC')
                                    ->findAll();
        return view('employe/index', $data);
    }

    // Traite la soumission du formulaire (store)
    public function store()
    {
        $congeModel = new CongeModel();
        $soldeModel = new SoldeModel();

        // 1. Récupération et calcul de la durée [cite: 67, 71]
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin   = $this->request->getPost('date_fin');
        
        $diff = strtotime($dateFin) - strtotime($dateDebut);
        $nbJours = ($diff / (60 * 60 * 24)) + 1; // Jours calendaires 

        $typeId = $this->request->getPost('type_conge_id');
        $annee  = date('Y', strtotime($dateDebut));

        // 2. Vérification du solde avant insertion 
        $restant = $soldeModel->getSoldeRestant(session()->get('user_id'), $typeId, $annee);

        if ($nbJours > $restant) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour cette demande.');
        }

        // 3. Insertion
        $congeModel->insert([
            'employe_id'    => session()->get('user_id'),
            'type_conge_id' => $typeId,
            'date_debut'    => $dateDebut,
            'date_fin'      => $dateFin,
            'nb_jours'      => $nbJours,
            'motif'         => $this->request->getPost('motif'),
            'statut'        => 'en_attente' // Statut par défaut [cite: 36, 43]
        ]);

        return redirect()->to('/employe/conges')->with('success', 'Demande soumise avec succès.');
    }
}