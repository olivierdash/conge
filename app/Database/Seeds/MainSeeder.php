<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
<<<<<<< HEAD
        // 1. Données pour les Départements
=======
        // Seeder idempotent: ré-exécutable sans casser (évite les doublons / contraintes UNIQUE)

        // 1) Départements
>>>>>>> 5e94279
        $departements = [
            ['nom' => 'Direction', 'description' => 'Direction générale'],
            ['nom' => 'Ressources Humaines', 'description' => 'Gestion du personnel'],
            ['nom' => 'Développement', 'description' => 'Équipe technique'],
        ];
<<<<<<< HEAD
        $this->db->table('departements')->insertBatch($departements);

        // 2. Données pour les Types de Congé
=======
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
>>>>>>> 5e94279
        $typesConge = [
            ['libelle' => 'Congé Payé', 'jours_annuels' => 30, 'deductible' => 1],
            ['libelle' => 'Permission', 'jours_annuels' => 5, 'deductible' => 0],
            ['libelle' => 'Maladie', 'jours_annuels' => 15, 'deductible' => 1],
        ];
<<<<<<< HEAD
        $this->db->table('types_conge')->insertBatch($typesConge);

        // 3. Données pour les Employés (Identifiants de la maquette)
        $employes = [
=======
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
>>>>>>> 5e94279
            [
                'nom'            => 'Admin',
                'prenom'         => 'TechMada',
                'email'          => 'admin@techmada.mg',
<<<<<<< HEAD
                'password'       => password_hash('admin123', PASSWORD_DEFAULT),
                'role'           => 'admin',
                'departement_id' => 1,
                'date_embauche'  => '2024-01-01',
                'actif'          => 1
=======
                'password'       => 'admin123',
                'role'           => 'admin',
                'departement'    => 'Direction',
                'date_embauche'  => '2024-01-01',
                'actif'          => 1,
>>>>>>> 5e94279
            ],
            [
                'nom'            => 'RH',
                'prenom'         => 'Responsable',
                'email'          => 'rh@techmada.mg',
<<<<<<< HEAD
                'password'       => password_hash('rh123', PASSWORD_DEFAULT),
                'role'           => 'rh',
                'departement_id' => 2,
                'date_embauche'  => '2024-02-15',
                'actif'          => 1
=======
                'password'       => 'rh123',
                'role'           => 'rh',
                'departement'    => 'Ressources Humaines',
                'date_embauche'  => '2024-02-15',
                'actif'          => 1,
>>>>>>> 5e94279
            ],
            [
                'nom'            => 'Dupont',
                'prenom'         => 'Jean',
                'email'          => 'employe@techmada.mg',
<<<<<<< HEAD
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
=======
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
>>>>>>> 5e94279
