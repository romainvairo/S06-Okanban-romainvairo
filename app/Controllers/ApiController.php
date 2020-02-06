<?php

namespace oKanban\Controllers;

use oKanban\Models\CardModel;
use oKanban\Models\ListModel;
use oFramework\Controllers\CoreController;

class ApiController extends CoreController
{
    /**
     * Renvoyer les listes en JSON
     */
    public function lists()
    {
        // Les données à transmettre
        $lists = ListModel::findAll();
        // On fait appel à notre méthode générique
        $this->showJson($lists);
    }

    /**
     * Renvoyer une liste en JSON
     */
    public function list($id)
    {
        // Le donnée à transmettre
        $list = ListModel::find($id);
        // On fait appel à notre méthode générique
        $this->showJson($list);
    }

    /**
     * Ajoute une liste
     * 
     * @todo Gérer l'ordre de la liste automatiquement
     */
    public function listAdd()
    {
        // On récupère la donnée du POST
        $listName = $_POST['listName'];
        // On crée un nouveau modèle
        $list = new ListModel();
        $list->setName($listName);
        $list->setPageOrder(99); // cf @todo
        $list->setCreatedAt(date('Y-m-d H:i:s')); // cf PHP Date
        // On sauvegarde en database
        $list->save();
        // On informe le front que la sauvegarde est OK
        $this->showJson($list);
    }

    /**
     * Update d'une liste
     * 
     * @todo Gérer le page order de la liste dynamiquement
     */
    public function listUpdate($id)
    {
        $list = ListModel::find($id);
        $list->setName($_POST['listName']);
        $list->setPageOrder(99); // cf @todo
        $list->save();

        $this->showJson($list);
    }

    /**
     * Renvoyer les cartes en JSON
     */
    public function cards()
    {
        // Les données à transmettre
        $cards = CardModel::findAll();
        // On fait appel à notre méthode générique
        $this->showJson($cards);
    }

    /**
     * Suppression de la carte
     */
    public function cardDelete($id)
    {
        // Suppression de la BDD
        // Rappel : Active Record nous impose d'aller lire la ressource
        $cardToDelete = CardModel::find($id);
        // pour la supprimer ensuite
        $cardToDelete->delete();
        // On DOIT retourner une réponse, et de plus en JSON car AJAX
        $this->showJson($cardToDelete);
    }
}