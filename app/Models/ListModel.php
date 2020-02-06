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
class ListModel extends CoreModel
{
    private $name;
    private $pageOrder;

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
            'name' => $this->name,
            'page_order' => $this->pageOrder,
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
        $sql = "INSERT INTO `list` (`name`, `page_order`, `created_at`) VALUES (:name, :page_order, :created_at)";

        // On prepare la requête
        $pdoStatement = $pdo->prepare($sql);
        // On associe les valeurs aux paramètres
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':page_order', $this->pageOrder, PDO::PARAM_INT);
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
     * Get object of type ListModel from the database
     *
     * @param int $id Record primary key
     */
    public static function find($id)
    {
        // On a besoin d'une connexion, on l'a via Database::getPDO()
        $pdo = Database::getPDO();
        // On a besoin d'une requête SQL
        $query = 'SELECT id, name, page_order AS pageOrder, created_at AS createdAt, updated_at AS updatedAt FROM list WHERE id=:list_id';
        // On prépare la requête via PDO
        $pdoStatement = $pdo->prepare($query);
        // On associe (bind) les valeurs sur les placeholders
        $pdoStatement->bindValue(':list_id', $id, PDO::PARAM_INT);
        // On exécute la requête
        $pdoStatement->execute();
        // On récupère la donnée sous forme d'objet ListModel
        // fetchObject demande le FQCN du modèle
        $model = $pdoStatement->fetchObject('oKanban\Models\ListModel');

        // fetchObject va faire un truc du genre
        // $resultSql = array['id', 'name' etc.]
        // $list = new 'oKanban\Models\ListModel';
        // on boucle sur le tableau reçu et on associe chaque clé du tableau
        // à la propriété de l'objet correspond
        // => résultat notre objet $list contient bien les valeurs de l'enregistrement reçu

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
        $query = 'SELECT id, name, page_order AS pageOrder, created_at AS createdAt, updated_at AS updatedAt 
        FROM list ORDER BY pageOrder ASC';
        // On exécute la requête
        $pdoStatement = $pdo->query($query);
        // On récupère les données sous forme de liste (tableau) d'objets ListModel
        $listsModels = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'oKanban\Models\ListModel');

        return $listsModels;
    }

    /**
     * Update
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `list` SET
        `name` = :name,
        `page_order` = :page_order,
        `updated_at` = :updated_at
        WHERE `list`.`id` = :id;";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':page_order', $this->pageOrder, PDO::PARAM_INT);
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
        $query = 'DELETE FROM list WHERE id='.$this->id;
        $result = $pdo->exec($query);

        return $result;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of pageOrder
     */
    public function getPageOrder()
    {
        return $this->pageOrder;
    }

    /**
     * Set the value of pageOrder
     * chainage cf : https://www.pierre-giraud.com/php-mysql/cours-complet/php-poo-chainage-methodes.php
     *
     * @return  self
     */
    public function setPageOrder($pageOrder)
    {
        $this->pageOrder = $pageOrder;

        return $this;
    }
}
