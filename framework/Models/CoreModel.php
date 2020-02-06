<?php

namespace oFramework\Models;

use JsonSerializable;

/**
 * Classe représentant la structure commune des tables SQL
 * Les objets créés à partir de cette classe seront
 * une représentation des enregistrements de la table en question
 * 
 * Cette classe sera la base de tous les modèles de l'application
 */
abstract class CoreModel implements JsonSerializable
{
    protected $id;
    protected $createdAt;
    protected $updatedAt;

    /**
     * Le fait de définir des méthodes abstraites (sans corps)
     * oblige l'enfant qui hérite de cette classe
     * à implémenter (coder) la méthode en question
     * 
     * En clair ; ces méthodes doivent exister dans les enfants
     */
    public static abstract function find($id);
    public static abstract function findAll();
    public abstract function insert();
    public abstract function update();
    public abstract function delete();

    /**
     * Ajoute ou modifie selon si nouvel objet ou non
     * l'id de l'objet nous renseigne sur son état en BDD
     */
    public function save()
    {
        // Si nouvel objet, insert
        if ($this->id == null) {
            $this->insert();
        } else {
            // Si existant, update
            $this->update();
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
