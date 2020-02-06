<?php

namespace oFramework;

// On peut faire référence aux classes du namespace global
// dans ce cas pas besoin de backslash
use AltoRouter;
use Dispatcher;

class Application
{
    /**
     * @var string $error404Target Router target for the 404 page
     */
    private $error404Target;

    /**
     * @param string $default404Target Router target for the 404 page
     */
    public function __construct(string $default404Target)
    {
        $this->error404Target = $default404Target;
    }

    /**
     * Run application
     */
    public function run()
    {
        // 1. j'instancie mon routeur

        // /!\ A NOTER
        // Ici, on utilise le backslash pour indiquer qu'AltoRouter est dans "l'espace de noms global"
        // cf : https://www.php.net/manual/fr/language.namespaces.global.php
        // dit autrement : une classe sans namespace se situe à cet endroit
        $router = new AltoRouter();
        // j'éduque mon routeur
        // url de la requête = base path + route
        // ex : http://localhost/oclock/titan/s05/oshop/public/ma-page = http://localhost/oclock/titan/s05/oshop/public + /ma-page
        // rappel : BASE_URI vient du .htaccess du dossier public/

        // Attention si on arrive du domaine local BASE_URI est vide et cela génère une erreur
        // On va donc conditionner la valeur du basePath

        // En ternaire
        // isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
        // Opérateur "null coalescent"
        // cf : https://php.net/manual/fr/migration70.new-features.php
        $router->setBasePath($_SERVER['BASE_URI'] ?? '');

        // 2. les routes de l'application
        // Une route HTML
        // Nos routes doivent maintenant faire référence au FQCN (nom complet de la classe) pour fonctionner !
        include __DIR__.'/../app/routes.php';

        // 3. je demande à mon routeur éduqué si l'url demandée correspond à une route qu'il connaî
        // $match sera un tableau assoc si correspondance
        // false si pas de correspondance
        $match = $router->match();
        
        // 4. On dispatch au bon endroit
        // Note : le second paramètre permet de configurer le Dispatcher en cas de 404
        $dispatcher = new Dispatcher($match, $this->error404Target);
        $dispatcher->dispatch();
    }
}
