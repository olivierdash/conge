<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementModel;

class AdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data = [
            'titre' => 'Tableau de Bord Admin',
            'total_employes' => $db->table('employes')->countAll(),
            'total_conges'   => $db->table('conges')->countAll(),
        ];
        return view('admin/dashboard', $data);
    }

    // Exemple pour le CRUD Employés
    public function liste_employes()
    {
        $model = new EmployeModel();
        $data['employes'] = $model->findAll();
        return view('admin/employes/liste', $data);
    }
}