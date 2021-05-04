<?php

namespace App\Model;

class User {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $type_user;

    /**
     * Get the value of id
     * @return  int|null
     */ 
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get the value of username
     * @return  string|null
     */ 
    public function getUsername() : ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     * @param  string  $username
     * @return  self
     */ 
    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     * @return  string|null
     */ 
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     * @param  string  $password
     * @return  self
     */ 
    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Get the value of type_user
     *
     * @return  string
     */ 
    public function getTypeUser() : ?string
    {
        return $this->type_user;
    }

    /**
     * Set the value of type_user
     *
     * @param  string  $type_user
     *
     * @return  self
     */ 
    public function setTypeUser(string $type_user) : self
    {
        $this->type_user = $type_user;

        return $this;
    }
}

?>