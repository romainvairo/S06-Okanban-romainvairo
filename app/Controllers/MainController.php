<?php

namespace oKanban\Controllers;

use oKanban\Models\CardModel;
use oKanban\Models\CoreModel;
use oKanban\Models\ListModel;
use oFramework\Controllers\CoreController;

class MainController extends CoreController
{
    /**
     * Page d'accueil
     */
    public function home()
    {
        $this->show('home', [
            'title' => 'Bienvenue !'
        ]);
    }

    /**
     * Tests pour nos modèles
     */
    public function test()
    {
        // find()
        // On va chercher la liste dont l'id est transmis via GET ou 2 par défaut
        $id = $_GET['id'] ?? 2;
        $list = ListModel::find($id);

        dump($list);

        // insert()
        $list = new ListModel();
        // On définit les propriétés de ce modèle
        $list->setName('Sprint 3');
        $list->setPageOrder(3);
        $list->setCreatedAt(date('Y-m-d H:i:s')); // cf PHP Date
        // On sauvegarde en database
        $list->save();

        dump($list);

        // findAll()
        $lists = ListModel::findAll();
        dump($lists);
        
        // Delete = trouve puis supprime
        // Si on cherche à supprimer la liste dont l'id est 4
        $list = ListModel::find(7);
        // Si find renvoie false, l'enregistrement n'est pas trouvé
        if ($list == false) {
            dump('Delete : Liste non trouvée');
        } else {
            $list->delete();
            dump('Delete : Liste 7 supprimée');
        }
        
        // Update
        // On va chercher la liste à modifier
        $list = ListModel::find(18);
        // Existe ou pas ?
        if ($list == false) {
            dump('Update : Liste non trouvée');
        } else {
            // On met à jour la liste
            $list->setName('E06');
            $list->setPageOrder(19);
            $list->setUpdatedAt(date('Y-m-d H:i:s'));
            // update
            $list->save();
            dump($list);
        }

        // Cards
        // Les données à transmettre
        $card = CardModel::find(1);
        dump($card);

        // Instanciation classe abstraite pas possible
        // $coreModel = new CoreModel();
    }
}