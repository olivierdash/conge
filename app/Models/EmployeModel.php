<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model
{
    protected $table            = 'employes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    // Champs que l'on autorise à l'insertion/mise à jour
    protected $allowedFields    = [
        'nom', 'prenom', 'email', 'password', 
        'role', 'departement_id', 'date_embauche', 'actif'
    ];

    // Dates
    protected $useTimestamps = false; // SQLite gère souvent les dates manuellement ou via défaut

    // Validation
    protected $validationRules = [
        'nom'            => 'required|min_length[2]',
        'prenom'         => 'required|min_length[2]',
        'email'          => 'required|valid_email|is_unique[employes.email,id,{id}]',
        'password'       => 'required|min_length[8]',
        'departement_id' => 'permit_empty|is_not_unique[departements.id]',
    ];

    // Callbacks pour hacher le mot de passe avant la sauvegarde
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    /**
     * Méthode personnalisée pour récupérer l'employé avec son département
     */
    public function getEmployesAvecDepartement()
    {
        return $this->select('employes.*, departements.nom as nom_departement')
                    ->join('departements', 'departements.id = employes.departement_id', 'left')
                    ->findAll();
    }
}