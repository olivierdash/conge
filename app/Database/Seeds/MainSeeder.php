<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Données pour les Départements
        $departements = [
            ['nom' => 'Direction', 'description' => 'Direction générale'],
            ['nom' => 'Ressources Humaines', 'description' => 'Gestion du personnel'],
            ['nom' => 'Développement', 'description' => 'Équipe technique'],
        ];
        $this->db->table('departements')->insertBatch($departements);

        // 2. Données pour les Types de Congé
        $typesConge = [
            ['libelle' => 'Congé Payé', 'jours_annuels' => 30, 'deductible' => 1],
            ['libelle' => 'Permission', 'jours_annuels' => 5, 'deductible' => 0],
            ['libelle' => 'Maladie', 'jours_annuels' => 15, 'deductible' => 1],
        ];
        $this->db->table('types_conge')->insertBatch($typesConge);

        // 3. Données pour les Employés (Identifiants de la maquette)
        $employes = [
            [
                'nom'            => 'Admin',
                'prenom'         => 'TechMada',
                'email'          => 'admin@techmada.mg',
                'password'       => password_hash('admin123', PASSWORD_DEFAULT),
                'role'           => 'admin',
                'departement_id' => 1,
                'date_embauche'  => '2024-01-01',
                'actif'          => 1
            ],
            [
                'nom'            => 'RH',
                'prenom'         => 'Responsable',
                'email'          => 'rh@techmada.mg',
                'password'       => password_hash('rh123', PASSWORD_DEFAULT),
                'role'           => 'rh',
                'departement_id' => 2,
                'date_embauche'  => '2024-02-15',
                'actif'          => 1
            ],
            [
                'nom'            => 'Dupont',
                'prenom'         => 'Jean',
                'email'          => 'employe@techmada.mg',
                'password'       => password_hash('emp123', PASSWORD_DEFAULT),
                'role'           => 'employe',
                'departement_id' => 3,
                'date_embauche'  => '2024-05-10',
                'actif'          => 1
            ],
        ];
        $this->db->table('employes')->insertBatch($employes);

        // 4. Initialisation d'un solde pour Jean Dupont (id=3)
        $soldes = [
            [
                'employe_id'     => 3,
                'type_conge_id'  => 1,
                'annee'          => 2026,
                'jours_attribues'=> 30.0,
                'jours_pris'     => 0.0
            ]
        ];
        $this->db->table('soldes')->insertBatch($soldes);
    }
}