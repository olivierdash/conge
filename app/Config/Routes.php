<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes publiques (Connexion)
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Espace Administrateur
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
    // Ajouter ici : CRUD employés, départements
});

// Espace Responsable RH
$routes->group('rh', ['filter' => 'role:rh'], function($routes) {
    $routes->get('dashboard', 'RhController::index');
    // Ajouter ici : validation des congés
});

// Espace Employé (par défaut)
$routes->group('employe', ['filter' => 'role:employe'], function($routes) {
    $routes->get('dashboard', 'EmployeController::index');
    // Ajouter ici : soumettre un congé
});