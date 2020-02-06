<?php

namespace oKanban\Models;

use PDO;
use oFramework\Utils\Database;
use oFramework\Models\CoreModel;

/**
 * Active Record (concept)
 *
 * // Create
 * $model = new Model();
 * $model->setName('Julien');
 * $model->insert();
 *
 * // Update
 * $model = new Model();
 * $julien = $model->find(5); // Julien id = 5
 * $julien->setName('Jules');
 * $julien->update();
 *
 * // Delete = trouve puis supprime
 * $model = $model->find(5);
 * $model->delete();
 *
 * // Read
 * $model = new Model();
 * $model = $model->find(3); // ou findById(5)
 */
class CardModel extends CoreModel
{
    private $title;
    private $listOrder;
    private $listId;

    /**
     * Cette méthode attend un tableau qui contient les valeurs à encoder
     * pour la fonction json_encode(). C'est json_encode qui appelle cette méthode et reçoit en retour un tableau qu'il saura encoder.
     * 
     * Cela permet de "convertir notre object en tableau"
     * 
     * cf : https://www.php.net/manual/fr/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'list_order' => $this->listOrder,
            'list_id' => $this->listId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * Create
     */
    public function insert()
    {
        // On a besoin d'une connexion, on l'a via Database::getPDO()
        $pdo = Database::getPDO();
        // On a besoin d'une requête SQL
        // dans laquelle on précise les paramètres nommés
        // 'ce qui p
        $sql = "INSERT INTO `card` (`title`, `list_order`, `list_id`, `created_at`) VALUES (:title, :list_order, :list_id, :created_at)";

        // On prepare la requête
        $pdoStatement = $pdo->prepare($sql);
        // On associe les valeurs aux paramètres
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':list_order', $this->listOrder, PDO::PARAM_INT);
        $pdoStatement->bindValue(':list_id', $this->listId, PDO::PARAM_INT);
        // Pas de risque particulier ici car ce n'est pas un paramètre utilisateur
        // mais pour plus de cohérence, on le fait tout de même
        $pdoStatement->bindValue(':created_at', $this->createdAt, PDO::PARAM_STR);

        // On exécute la requête
        $result = $pdoStatement->execute();

        // On récupère l'id généré par MySQL sur le dernier insert
        $id = $pdo->lastInsertId();
        // On met à jour l'id dans notre objet
        // intval convertit une chaine en entier
        $this->id = intval($id); // équivaut (int) $id

        return $result;
    }

    /**
     * Get object of type CardModel from the database
     *
     * @param int $id Record primary key
     */
    public static function find($id)
    {
        // On a besoin d'une connexion, on l'a via Database::getPDO()
        $pdo = Database::getPDO();
        // On a besoin d'une requête SQL
        $query = 'SELECT id, title, list_order AS listOrder, list_id AS listId, created_at AS createdAt, updated_at AS updatedAt FROM card WHERE id=:card_id';
        // On prépare la requête via PDO
        $pdoStatement = $pdo->prepare($query);
        // On associe (bind) les valeurs sur les placeholders
        $pdoStatement->bindValue(':card_id', $id, PDO::PARAM_INT);
        // On exécute la requête
        $pdoStatement->execute();
        // On récupère la donnée sous forme d'objet CardModel
        // fetchObject demande le FQCN du modèle
        $model = $pdoStatement->fetchObject('oKanban\Models\CardModel');

        // On retourne l'objet récupéré
        return $model;
    }

    /**
     * Find all (Read all)
     * Get an array
     */
    public static function findAll()
    {
        // Appel à la connexion SQL
        $pdo = Database::getPDO();
        // La requête SQL
        // A noter que les AS sont optionnels
        $query = 'SELECT id, title, list_order AS listOrder, list_id AS listId, created_at AS createdAt, updated_at AS updatedAt FROM card';
        // On exécute la requête
        $pdoStatement = $pdo->query($query);
        // On récupère les données sous forme de liste (tableau) d'objets CardModel
        $listsModels = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'oKanban\Models\CardModel');

        return $listsModels;
    }

    /**
     * Update
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `card` SET
        `title` = :title,
        `list_order` = :list_order,
        `list_id` = :list_id,
        `updated_at` = :updated_at
        WHERE `id` = :id;";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':list_order', $this->listOrder, PDO::PARAM_INT);
        $pdoStatement->bindValue(':list_id', $this->listId, PDO::PARAM_INT);
        $pdoStatement->bindValue(':updated_at', $this->updatedAt, PDO::PARAM_STR);
        
        $result = $pdoStatement->execute();

        return $result;
    }

    /**
     * Delete
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        // On part du principe que l'id vient de la database
        // et n'est pas ici un paramètre utilisateur
        $query = 'DELETE FROM card WHERE id='.$this->id;
        $result = $pdo->exec($query);

        return $result;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of listOrder
     */ 
    public function getListOrder()
    {
        return $this->listOrder;
    }

    /**
     * Set the value of listOrder
     *
     * @return  self
     */ 
    public function setListOrder($listOrder)
    {
        $this->listOrder = $listOrder;

        return $this;
    }

    /**
     * Get the value of listId
     */ 
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set the value of listId
     *
     * @return  self
     */ 
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }
}
