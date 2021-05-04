<?php 

namespace App\Repository;

use \PDO;
use App\Model\Category;

final class CategoryRepository extends Repository
{
    protected $table = 'category';
    protected $class = Category::class;
    /**
     * Ajoute aux articles les catégories associées.
     * @param App\Model\Post[] $posts
     */
    public function addPostsCategories(array $posts) : void
    {
        $postByID = [];
        foreach($posts as $post) {
            $post->setCategories([]);
            $postByID[$post->getID()] = $post;
        }

        $categories = $this->pdo->query('SELECT c.*, pc.post_id
        FROM post_category pc
        JOIN category c ON c.id = pc.category_id
        WHERE pc.post_id IN ('. implode(',', array_keys($postByID)) .')
        ')->fetchAll(PDO::FETCH_CLASS, Category::class);

        // Ajout des catégories aux posts
        foreach($categories as $category) {
            $postByID[$category->getPostId()]->addCategory($category);
        }
    }

    public function findAll() : array 
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function list() : array
    {
        $categories = $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY name ASC");
        $list = [];
        foreach($categories as $category) {
            $list[$category->getID()] = $category->getName();
        }
        return $list;
    }
}