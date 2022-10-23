<?php

namespace alexshent\tbot\entities;

use Doctrine\ORM\Mapping\{Entity, Table, Id, Column, GeneratedValue};

/**
 * @Entity
 * @Table(name="users")
 */
class User {

    /**
     * @Id
     * @Column(type="string")
     */
    private $id;
    
    /**
     * @Column(type="string")
     */
    private $firstName;
    
    /**
     * @Column(type="string")
     */
    private $username;

    /**
     * @Column(type="string", nullable=true)
     */
    private $trelloUsername;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getTrelloUsername() {
        return $this->trelloUsername;
    }

    public function setTrelloUsername($trelloUsername) {
        $this->trelloUsername = $trelloUsername;
    }
}