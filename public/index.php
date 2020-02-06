<?php
// Fait référence à une classe
use oFramework\Application;

// Autoload de Composer
// pour usage d'AltoRouter et VarDumper
require_once __DIR__."/../vendor/autoload.php";

// On démarre l'application
// grâce au use, pas besoin du FQCN pour instancier
// On précise dans le constructeur, le chemin vers la page 404
$application = new Application('oKanban\Controllers\ErrorController::error404');
$application->run();
