<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table            = 'types_conge';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['libelle', 'jours_annuels', 'deductible'];

    // Règles de validation 
    protected $validationRules = [
        'libelle'       => 'required|min_length[3]|max_length[100]',
        'jours_annuels' => 'required|is_natural',
        'deductible'    => 'required|in_list[0,1]',
    ];
}