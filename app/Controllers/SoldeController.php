<?php

namespace App\Controllers\Employe;

use App\Controllers\BaseController;
use App\Models\SoldeModel;

class SoldeController extends BaseController
{
    /**
     * Affiche le tableau de bord de l'employé avec ses soldes calculés
     */
    public function index()
    {
        // 1. Vérification de la session et du rôle (Sécurité obligatoire) 
        if (!session()->get('isLoggedIn') || session()->get('user_role') !== 'employe') {
            return redirect()->to('/login')->with('error', 'Accès non autorisé.');
        }

        $soldeModel = new SoldeModel();
        $idEmploye = session()->get('user_id');
        $anneeActuelle = date('Y');

        // 2. Récupération des soldes de l'employé pour l'année en cours via Query Builder [cite: 62]
        $soldesBruts = $soldeModel->where([
            'employe_id' => $idEmploye,
            'annee'      => $anneeActuelle
        ])->findAll();

        // 3. Logique métier : Calcul du solde restant (ne jamais stocker le restant en BDD) [cite: 45, 46]
        foreach ($soldesBruts as &$s) {
            // jours_restant = jours_attribues - jours_pris [cite: 46]
            $s['restant'] = $s['jours_attribues'] - $s['jours_pris']; 
        }

        // 4. Retourne la vue liée avec les données [cite: 66]
        return view('employe/dashboard', [
            'titre'  => 'Mon Solde de Congés',
            'soldes' => $soldesBruts
        ]);
    }
}