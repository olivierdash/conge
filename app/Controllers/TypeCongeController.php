<?php

namespace App\Controllers;

use App\Models\TypeCongeModel;

class TypeCongeController extends BaseController
{
    // Utilisé pour afficher le formulaire de création avec les types disponibles
    public function create()
    {
        $typeModel = new TypeCongeModel();
        
        // On récupère tous les types pour le menu déroulant de create.php
        $data['types'] = $typeModel->findAll();

        return view('employe/create', $data);
    }
}