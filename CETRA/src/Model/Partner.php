<?php

namespace App\Model;

class Partner {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $webSite;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $oldImage;
    
    /**
     * @var string
     */
    private $pendingUpload = false;

    /**
     * @var string
     */
    private $mapGoogle;
    
    /**
     * Get the value of id
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     * @param  int  $id
     * @return  self
     */ 
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of slug
     * @return  string
     */ 
    public function getSlug() : ?string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     * @param  string  $slug
     * @return  self
     */ 
    public function setSlug(string $slug) : self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of name
     * @return  string
     */ 
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     * @param  string  $name
     * @return  self
     */ 
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     * @return  string
     */ 
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     * @param  string  $description
     * @return  self
     */ 
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of street
     * @return  string
     */ 
    public function getStreet() : ?string
    {
        return $this->street;
    }

    /**
     * Set the value of street
     * @param  string  $street
     * @return  self
     */ 
    public function setStreet(string $street) : self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of city
     * @return  string
     */ 
    public function getCity() : ?string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     * @param  string  $city
     * @return  self
     */ 
    public function setCity(string $city)  : self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of postalCode
     * @return  string
     */ 
    public function getPostalCode() : ?string
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     * @param  string  $postalCode
     * @return  self
     */ 
    public function setPostalCode(string $postalCode) : self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get the value of webSite
     * @return  string
     */ 
    public function getWebSite() : ?string
    {
        return $this->webSite;
    }

    /**
     * Set the value of webSite
     * @param  string  $webSite
     * @return  self
     */ 
    public function setWebSite(string $webSite) : self
    {
        $this->webSite = $webSite;

        return $this;
    }

    public function getImage (): ?string 
    {
        return $this->image;
    }

    public function getImageURL (string $format): ?string 
    {
        if (empty($this->image)) {
            return null;
        }
        return '/uploads/partners/' . $this->image . '_' . $format . '.jpg';
    }

    public function setImage ($image): self 
    {
        if (is_array($image) && !empty($image['tmp_name'])) {
            if (!empty($this->image)) {
                $this->oldImage = $this->image;
            }
            $this->pendingUpload = true;
            $this->image = $image['tmp_name'];
        }
        if (is_string($image) && !empty($image)) {
            $this->image = $image;
        }

        return $this;
    }

    public function getOldImage (): ?string
    {
        return $this->oldImage;
    }

    public function shouldUpload (): bool
    {
        return $this->pendingUpload;
    }

    /**
     * Get the value of mapGoogle
     *
     * @return  string
     */ 
    public function getMapGoogle()
    {
        return $this->mapGoogle;
    }

    /**
     * Set the value of mapGoogle
     *
     * @param  string  $mapGoogle
     *
     * @return  self
     */ 
    public function setMapGoogle(string $mapGoogle)
    {
        $this->mapGoogle = $mapGoogle;

        return $this;
    }
}

?>