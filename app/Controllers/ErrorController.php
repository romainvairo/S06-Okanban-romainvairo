<?php

namespace oKanban\Controllers;

use oFramework\Controllers\CoreController;

class ErrorController extends CoreController
{
    /**
     * 404 page
     */
    public function error404()
    {
        // On envoie le status code 404 dans la réponse
        //header('HTTP/1.1 404 Not Found');

        // Alternative plus directe
        http_response_code(404);

        // On affiche une page d'erreur en HTML
        $this->show('error404', [
            'title' => 'Page non trouvée'
        ]);
    }
}
