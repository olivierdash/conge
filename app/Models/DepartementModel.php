<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table            = 'departements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // ou 'object'
    protected $protectFields    = true;
    protected $allowedFields    = ['nom', 'description'];

    // Validation simple
    protected $validationRules = [
        'nom' => 'required|min_length[3]|max_length[255]',
    ];
}