<?php

/**
 * Allow to load view correctly w Bramus Router
 */
function loadView(string $path, array $args = []): void {
    $file = __DIR__ . "/views/pages/$path.php";

    if (file_exists($file)) {
        $body_class = $path;
        // include $file;
        include __DIR__ . "/views/layouts/default.php";
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "Erreur 404 : Page non trouvée";
    }
}

function loadAdminView(string $path, array $args = []): void {
    $file = __DIR__ . "/views/admin/$path.php";

    if (file_exists($file)) {
        $body_class = $path;
        // include $file;
        include __DIR__ . "/views/layouts/admin.php";
    } else {
        header("HTTP/1.1 404 Not Found");
        echo "Erreur 404 : Page non trouvée";
    }
}

/**
 * Make URL as smooth as possible for French speaker
 */
function urlify(string $string): string {
    $search = ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ÿ', 'ç'];
    $replace = ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'y', 'c'];
    $string = str_replace($search, $replace, $string);
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-');

    return $string;
}
