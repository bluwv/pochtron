<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/functions.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() { loadView('home'); });
$router->get('/catalogue', function() { loadView('shop'); });
$router->get('/contact', function() { header('Location: /'); });
$router->get('/blog', function() { header('Location: /'); });
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

$router->set404(function() {
    header("HTTP/1.1 404 Not Found");
    echo "Erreur 404 : Page non trouvée";
});

$router->run();
