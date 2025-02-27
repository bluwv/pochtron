<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/functions.php';

use Bramus\Router\Router;

$router = new Router();

// Front
$router->get('/', function() { loadView('home'); });
$router->get('/catalogue', function() { loadView('shop'); });
$router->get('/wines/{id}/{name}', function($id, $name) {
	if (!is_numeric($id)) {
        header("HTTP/1.1 400 Bad Request");
        echo "ID utilisateur invalide.";
        return;
    }

    // Passe l'ID à la page
    $wine_id = htmlspecialchars($id);
    $wine_name = htmlspecialchars($name);
	loadView('single', ['wine_id' => $wine_id, 'wine_name' => $wine_name]);
});

// Admin
$router->get('/admin/login', function() { loadAdminView('login'); });
$router->post('/admin/login', function() { loadAdminView('login'); });
$router->get('/admin/wines/list', function() { loadAdminView('list'); });
$router->get('/admin/wines/edit', function() { loadAdminView('edit'); });
$router->post('/admin/wines/edit', function() { loadAdminView('edit'); });
$router->get('/admin/domains/list', function() { loadAdminView('domain'); });
$router->get('/admin/domains/edit', function() { loadAdminView('edit'); });
$router->post('/admin/domains/edit', function() { loadAdminView('edit'); });
$router->get('/admin/grapes/list', function() { loadAdminView('list'); });
$router->get('/admin/grapes/edit', function() { loadAdminView('edit'); });
$router->post('/admin/grapes/edit', function() { loadAdminView('edit'); });
$router->get('/admin/users/list', function() { loadAdminView('users'); });
$router->get('/admin/user/edit', function() { loadAdminView('user'); });
$router->post('/admin/user/edit', function() { loadAdminView('user'); });
$router->get('/admin/logout', function() { include_once  __DIR__ . '/views/admin/logout.php'; });

// Redirect
$router->get('/contact', function() { header('Location: /'); });
$router->get('/blog', function() { header('Location: /'); });

// 404
$router->set404(function() {
    header("HTTP/1.1 404 Not Found");
    echo "Erreur 404 : Page non trouvée";
});

$router->run();
