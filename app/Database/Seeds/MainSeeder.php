<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Seeder idempotent: ré-exécutable sans casser (évite les doublons / contraintes UNIQUE)

        // 1) Départements
        $departements = [
            ['nom' => 'Direction', 'description' => 'Direction générale'],
            ['nom' => 'Ressources Humaines', 'description' => 'Gestion du personnel'],
            ['nom' => 'Développement', 'description' => 'Équipe technique'],
        ];
        $departementIds = [];
        foreach ($departements as $dep) {
            $row = $this->db->table('departements')->where('nom', $dep['nom'])->get()->getRowArray();
            if (!$row) {
                $this->db->table('departements')->insert($dep);
                $row = $this->db->table('departements')->where('nom', $dep['nom'])->get()->getRowArray();
            }
            if ($row) {
                $departementIds[$dep['nom']] = (int) $row['id'];
            }
        }

        // 2) Types de congé
        $typesConge = [
            ['libelle' => 'Congé Payé', 'jours_annuels' => 30, 'deductible' => 1],
            ['libelle' => 'Permission', 'jours_annuels' => 5, 'deductible' => 0],
            ['libelle' => 'Maladie', 'jours_annuels' => 15, 'deductible' => 1],
        ];
        $typeCongeIds = [];
        foreach ($typesConge as $type) {
            $row = $this->db->table('types_conge')->where('libelle', $type['libelle'])->get()->getRowArray();
            if (!$row) {
                $this->db->table('types_conge')->insert($type);
                $row = $this->db->table('types_conge')->where('libelle', $type['libelle'])->get()->getRowArray();
            }
            if ($row) {
                $typeCongeIds[$type['libelle']] = (int) $row['id'];
            }
        }

        // 3) Employés (comptes de démonstration)
        $demoEmployes = [
            [
                'nom'            => 'Admin',
                'prenom'         => 'TechMada',
                'email'          => 'admin@techmada.mg',
                'password'       => 'admin123',
                'role'           => 'admin',
                'departement'    => 'Direction',
                'date_embauche'  => '2024-01-01',
                'actif'          => 1,
            ],
            [
                'nom'            => 'RH',
                'prenom'         => 'Responsable',
                'email'          => 'rh@techmada.mg',
                'password'       => 'rh123',
                'role'           => 'rh',
                'departement'    => 'Ressources Humaines',
                'date_embauche'  => '2024-02-15',
                'actif'          => 1,
            ],
            [
                'nom'            => 'Dupont',
                'prenom'         => 'Jean',
                'email'          => 'employe@techmada.mg',
                'password'       => 'emp123',
                'role'           => 'employe',
                'departement'    => 'Développement',
                'date_embauche'  => '2024-05-10',
                'actif'          => 1,
            ],
        ];

        foreach ($demoEmployes as $emp) {
            $exists = $this->db->table('employes')->where('email', $emp['email'])->get()->getRowArray();
            if ($exists) {
                continue;
            }

            $departementId = $departementIds[$emp['departement']] ?? null;
            $this->db->table('employes')->insert([
                'nom'            => $emp['nom'],
                'prenom'         => $emp['prenom'],
                'email'          => $emp['email'],
                'password'       => password_hash($emp['password'], PASSWORD_DEFAULT),
                'role'           => $emp['role'],
                'departement_id' => $departementId,
                'date_embauche'  => $emp['date_embauche'],
                'actif'          => $emp['actif'],
            ]);
        }

        // 4) Solde initial pour l'employé de démonstration
        $demoEmploye = $this->db->table('employes')->where('email', 'employe@techmada.mg')->get()->getRowArray();
        $typeCongeId = $typeCongeIds['Congé Payé'] ?? null;
        if ($demoEmploye && $typeCongeId) {
            $existsSolde = $this->db->table('soldes')
                ->where('employe_id', (int) $demoEmploye['id'])
                ->where('type_conge_id', (int) $typeCongeId)
                ->where('annee', 2026)
                ->get()
                ->getRowArray();

            if (!$existsSolde) {
                $this->db->table('soldes')->insert([
                    'employe_id'      => (int) $demoEmploye['id'],
                    'type_conge_id'   => (int) $typeCongeId,
                    'annee'           => 2026,
                    'jours_attribues' => 30.0,
                    'jours_pris'      => 0.0,
                ]);
            }
        }
    }
}
