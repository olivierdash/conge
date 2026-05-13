<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table            = 'conges';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'employe_id', 
        'type_conge_id', 
        'date_debut', 
        'date_fin', 
        'nb_jours', 
        'motif', 
        'statut', 
        'commentaire_rh', 
        'traite_par'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Règles de validation strictes [cite: 43, 59]
    protected $validationRules = [
        'employe_id'    => 'required|is_natural_no_zero',
        'type_conge_id' => 'required|is_natural_no_zero',
        'date_debut'    => 'required|valid_date',
        'date_fin'      => 'required|valid_date',
        'nb_jours'      => 'required|decimal',
        'statut'        => 'required|in_list[en_attente,approuvee,refusee,annulee]',
    ];

    public function getCongesWithTypes(int $employeId)
    {
        return $this->select('conges.*, types_conge.libelle as type_nom')
                    ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                    ->where('employe_id', $employeId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}