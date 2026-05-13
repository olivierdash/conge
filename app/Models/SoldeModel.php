<?php

namespace App\Models;
use CodeIgniter\Model;

class SoldeModel extends Model {
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employe_id', 'type_conge_id', 'annee', 'jours_attribues', 'jours_pris'];

    public function getSoldeRestant(int $employeId, int $typeId, int $annee) {
        $solde = $this->where(['employe_id' => $employeId, 'type_conge_id' => $typeId, 'annee' => $annee])->first();
        if (!$solde) return 0;
        return $solde['jours_attribues'] - $solde['jours_pris'];
    }
}