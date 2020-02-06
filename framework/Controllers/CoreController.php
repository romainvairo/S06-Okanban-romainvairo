<?php

namespace oFramework\Controllers;

/**
 * Classe qui définit les méthodes génériques
 * de notre application
 */
class CoreController
{
    // cette méthode se charge d'afficher les vues
    // et donc de constituer les différentes pages de notre site
    // viewVars est un fourre-tout pour passer une, deux, trois ou même quatorze variables à la méthode qui se charge d'afficher les vues
    // comme ça, dans les vues, on pourra faire référence à ces variables
    // et l'info circule maintenant de bout en bout
    protected function show($viewName, $viewVars = [])
    {
        // extract transforme les clés d'un tableau en autant de variables portant le même nom
        // ce qui évite de faire référence aux variables de vues à travers le tableau $viewVars (parce que c'est moche)
        // ex : $viewVars['monObjet']->maMethode() => moche !!!
        // ex : $monObjet->maMethode() => beau !!!
        // ex : echo $viewVars['title']; devient => echo $title;
        extract($viewVars);

        require_once __DIR__."/../../app/views/header.tpl.php";
        require_once __DIR__."/../../app/views/$viewName.tpl.php";
        require_once __DIR__."/../../app/views/footer.tpl.php";
    }

    /**
     * Return data converted to JSON
     * 
     * @param mixed $data Date to encode and send to response
     */
    protected function showJson($data)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        // Envoyer les entêtes HTTP permettant de définir le type de contenu comme étant du JSON
        header('Content-Type: application/json');
        // On renvoie la donnée encodée
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
