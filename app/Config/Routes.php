<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->setAutoRoute(true);

$routes->get('/', 'ProductController::index');
$routes->get('/products', 'ProductController::index');
$routes->get('/products/create', 'ProductController::create');
$routes->post('/products/store', 'ProductController::store');
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1');
$routes->post('/products/update/(:num)', 'ProductController::update/$1');
$routes->post('/products/delete/(:num)', 'ProductController::delete/$1');
$routes->get('/products/search', 'ProductController::search');
$routes->get('/products/export', 'ProductController::export');
$routes->get('/products/dataTable', 'ProductController::dataTable');
$routes->post('products/import', 'ProductController::import');
$routes->post('/products/update', 'ProductController::update');
$routes->get('/products/search', 'ProductController::search');
$routes->get('products/count', 'ProductController::count');
$routes->get('products/loadProducts', 'ProductController::loadProducts');

$routes->get('/register', 'AuthController::register', ['filter' => 'not_auth']);
$routes->post('/process-register', 'AuthController::processRegister', ['filter' => 'not_auth']);
$routes->get('/login', 'AuthController::login', ['filter' => 'not_auth']);
$routes->post('/process-login', 'AuthController::processLogin', ['filter' => 'not_auth']);
$routes->get('/logout', 'AuthController::logout');

$routes->get('login', 'Auth::index', ['filter' => 'not_auth']);
$routes->post('Auth/Login', 'Auth::login', ['filter' => 'not_auth']);
$routes->get('auth/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'UserController::index');
    $routes->get('usercontroller', 'UserController::index');
    $routes->get('usercontroller/getUsers', 'UserController::getUsers');
    $routes->post('usercontroller/addUser', 'UserController::addUser');
    $routes->post('usercontroller/updateUser', 'UserController::updateUser');
    $routes->post('usercontroller/deleteUser', 'UserController::deleteUser');
});

//DELETE MULTIPLE
$routes->get('/products/deleteMultiple', 'ProductController::deleteMultiple');
$routes->POST('/products/deleteMultiple', 'ProductController::deleteMultiple');

$routes->get('products/exportChunk/(:num)/(:num)', 'ProductController::exportChunk/$1/$2');
$routes->post('/Crud_CodeIgniter4/products/importChunk', 'ProductController::importChunk');
$routes->post('products/importChunk', 'ProductController::importChunk');

$routes->get('products/loadProducts', 'ProductController::loadProducts');

//Chart
$routes->get('products/chart', 'ProductController::genderChart');

//Gender datatable
$routes->get('gender/loadGender', 'ProductController::loadGender');
$routes->POST('gender/addGender', 'ProductController::addGender');
$routes->get('gender/genderChartData', 'ProductController::genderChartData');
$routes->post('gender/genderEdit', 'ProductController::editGender');
$routes->post('gender/bulkDelete', 'ProductController::bulkDelete');
$routes->post('gender/deleteGender/(:num)', 'ProductController::deleteGender/$1');

//Marketplace
$routes->get('marketplace', 'MarketplaceController::index');
