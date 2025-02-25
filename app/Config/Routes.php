<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'EvalFormController::index');
$routes->get('/surveys', 'EvalFormController::surveys');

// Routes for admin
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'AdminController::admin');
    $routes->match(['get', 'post'], 'addedit', 'AdminController::addeditUser');
    $routes->match(['get', 'post'], 'addedit/(:num)', 'AdminController::addeditUser/$1');
    $routes->get('delete/(:num)', 'AdminController::deleteUser/$1');
});

// routes for surveys, survey creation/editing, survey results
$routes->group('surveys', ['filter' => 'login'], function($routes) {
    $routes->get('(:num)', 'SurveyController::surveys/$1'); // list of surveys belonging to a particular user
    $routes->get('(:num)/results/(:num)', 'ResultsController::results/$1/$2'); // overall survey results
    $routes->get('(:num)/results/(:num)/(:num)', 'ResultsController::freeTextResult/$1/$2/$3'); // full free text question responses
    $routes->get('(:num)/results/(:num)/(:num)/AIsummary', 'ResultsController::AISummary/$1/$2/$3');
    $routes->match(['get', 'post'], '(:num)/addeditSurvey', 'SurveyController::addeditSurvey/$1');
    $routes->match(['get', 'post'], '(:num)/addeditSurvey/(:num)', 'SurveyController::addeditSurvey/$1/$2');
    $routes->get('(:num)/delete/(:num)', 'SurveyController::deleteSurvey/$1/$2');
});


// routes for google login
$routes->get('/login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/login/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/logout', 'Auth::logout');

// routes for survey responses
$routes->match(['get', 'post'], '/surveyResponse/(:num)', 'SurveyController::surveyResponse/$1');

