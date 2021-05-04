<?php 

namespace App\Model;

class Category {

    private $id;
    private $name;
    private $slug;
    private $color;

    private int $post_id;
    private $posts = [];

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string 
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function getPosts() : array
    {
        return $this->posts;
    }

    public function getColor() : ?string 
    {
        
        return $this->color;
    }

    public function setColor(string $color) : self
    {
        $this->color = '#' . $color;

        return $this;
    }
    
    public function addPost(Post $post) : void 
    {
        if(get_class($post) === Post::class) {
            $this->posts[] = $post;
        }
    }
}