<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('/', 'HomeController::index');
$routes->get('research/(:segment)', 'HomeController::detail/$1');
$routes->get('search', 'HomeController::search', ['filter' => 'throttle']);
$routes->post('api/research/view/(:num)', 'HomeController::incrementView/$1');
$routes->post('api/bookmark/toggle/(:num)', 'BookmarkController::toggle/$1');

// Auth Routes
$routes->get('login', 'AuthController::login', ['filter' => 'throttle']);
$routes->post('login', 'AuthController::process', ['filter' => 'throttle']);
$routes->get('register', 'AuthController::register', ['filter' => 'throttle']);
$routes->post('register', 'AuthController::processRegister', ['filter' => 'throttle']);
$routes->get('logout', 'AuthController::logout');

// Dashboard Routes (Requires Auth)
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'DashboardController::index');
    
    // Research Management
    $routes->get('research', 'ResearchController::index');
    $routes->get('research/create', 'ResearchController::create');
    $routes->post('research/store', 'ResearchController::store', ['filter' => 'throttle']);
    $routes->get('research/edit/(:num)', 'ResearchController::edit/$1');
    $routes->post('research/update/(:num)', 'ResearchController::update/$1', ['filter' => 'throttle']);
    $routes->get('research/delete/(:num)', 'ResearchController::delete/$1');
    $routes->post('research/moderate/(:num)', 'ResearchController::moderate/$1', ['filter' => 'role:superadmin,admin']);

    // Section Management
    $routes->get('section/(:num)', 'SectionController::index/$1');
    $routes->post('section/store/(:num)', 'SectionController::store/$1', ['filter' => 'throttle']);
    $routes->post('section/update/(:num)', 'SectionController::update/$1', ['filter' => 'throttle']);
    $routes->get('section/delete/(:num)', 'SectionController::delete/$1');

    // User Management (Superadmin only)
    $routes->group('users', ['filter' => 'role:superadmin'], function($routes) {
        $routes->get('/', 'UserManagementController::index');
        $routes->post('store', 'UserManagementController::store');
        $routes->post('update/(:num)', 'UserManagementController::update/$1');
        $routes->get('delete/(:num)', 'UserManagementController::delete/$1');
        $routes->get('backup', 'BackupController::index');
        $routes->get('settings', 'SettingsController::index');
        $routes->post('settings/update', 'SettingsController::update');
    });

    // Bookmark Action
    $routes->post('bookmark/toggle/(:num)', 'BookmarkController::toggle/$1');
});
