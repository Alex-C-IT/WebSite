<?php 
namespace App\Model;

use DateTime;
use App\Router;
use App\Helpers\TextHelper;

class Post {

    private $id;
    private $name;
    private $slug;
    private $content;
    private $created_at;

    private $image;
    private $oldImage;
    private $pendingUpload = false;
    
    private $namePostViewDirectory = "post";
    private $categories = [];

    public function getId() : ?int 
    { 
        return $this->id; 
    }

    public function setID(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function getName() : ?string 
    { 
        return e($this->name); 
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getSlug() : ?string 
    { 
        return e($this->slug); 
    }

    public function setSlug(string $slug) : self
    {   
        $this->slug = $slug;

        return $this;
    }

    public function getContent() : ?string 
    { 
        return e($this->content); 
    }

    public function setContent(string $content) : self 
    { 
        $this->content = trim($content);

        return $this;
    }

    public function getFormatedContent() : ?string 
    { 
        return nl2br($this->getContent()); 
    }

    public function getCreatedAt() : DateTime 
    {
        return new DateTime($this->created_at); 
    }

    public function setCreatedAt(string $date) : self
    {
        $this->created_at = $date;

        return $this;
    }

    public function getCreatedAtFormated() : string 
    {
        return (new DateTime($this->created_at))->format('d F Y'); 
    }
    
    public function getExcerpt(int $limit = 60) : ?string
    {
        if ($this->content === null) return null;

        return nl2br(htmlentities(TextHelper::excerpt($this->content, $limit)));
    }

    public function getPostURL(Router $router) : ?string
    {
        return $router->url($this->namePostViewDirectory, ['id' => $this->id, 'slug' => $this->slug]);
    }

    /**
     * @return Category[]
     */
    public function getCategories() : array
    {
        return $this->categories;
    }

    public function setCategories(array $categories) : self
    {
        $this->categories = $categories;

        return $this;
    }

    public function addCategory(Category $category) : void
    {
        if(get_class($category) === Category::class){
            $this->categories[] = $category;
            $category->addPost($this);
        }
    }

    public function getCategoriesIds(): array
    {
        $ids = [];
        foreach($this->categories as $c) {
            $ids[] = $c->getID();
        }
        return $ids;
    }

    public function getImage(): ?string 
    {
        return $this->image;
    }

    public function getImageURL (string $format): ?string {
        if (empty($this->image)) {
            return null;
        }
        return '/uploads/posts/' . $this->image . '_' . $format . '.jpg';
    }

    public function setImage($image): self 
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

    public function getOldImage(): ?string
    {
        return $this->oldImage;
    }

    public function shouldUpload(): bool
    {
        return $this->pendingUpload;
    }
}

?>