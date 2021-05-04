<?php 
namespace App\Model;

use DateTime;

class Ticket {

    private int $id;
    private string $slug;
    private string $object;
    private string $content;
    private string $dateRequest;
    private ?string $contentAnswer;
    private ?string $dateAnswer;
    private bool $resolved;
    
    private int $id_user;

    /**
     * Get the value of id
     */ 
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug() : ?string
    {
        return isset($this->slug) ? e($this->slug) : null;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of object
     */ 
    public function getObject() : ?string
    {
        return isset($this->object) ? e($this->object) : null;
    }

    /**
     * Set the value of object
     *
     * @return  self
     */ 
    public function setObject(string $object) : self
    {
        $this->object = $object;

        return $this;
    }
    

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return isset($this->content) ? e($this->content) : null;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * Get the value of dateRequest
     * @return DateTime $dateRequest
     */ 
    public function getDateRequest() : DateTime
    {
        return new DateTime($this->dateRequest);
    }

    public function getDateRequestFormated() : string 
    {
        return $this->getDateRequest()->format('d/m/Y'); 
    }

    /**
     * Set the value of dateRequest
     *
     * @return  self
     */ 
    public function setDateRequest($dateRequest) : self
    {
        $this->dateRequest = $dateRequest;

        return $this;
    }

    /**
     * Get the value of contentAnswer
     */ 
    public function getContentAnswer() : ?string
    {
        return e($this->contentAnswer);
    }

    /**
     * Set the value of contentAnswer
     * @var string $contentAnswer
     * @return self
     */ 
    public function setContentAnswer($contentAnswer) : self
    {
        $this->contentAnswer = $contentAnswer;

        return $this;
    }

    /**
     * Get the value of dateAnswer
     */ 
    public function getDateAnswer() : ?DateTime
    {
        return new DateTime($this->dateAnswer);
    }

    public function getDateAnswerFormated() : string 
    {
        return $this->getDateAnswer()->format('d/m/Y'); 
    }

    /**
     * Set the value of dateAnswer
     *
     * @return  self
     */ 
    public function setDateAnswer($dateAnswer) : self
    {
        $this->dateAnswer = $dateAnswer;

        return $this;
    }

    /**
     * Get the value of resolved
     */ 
    public function getResolved()
    {
        return $this->resolved;
    }

    /**
     * Set the value of resolved
     *
     * @return  self
     */ 
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;

        return $this;
    }

    /**
     * Get the value of id_user
     */ 
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */ 
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }
}

?>