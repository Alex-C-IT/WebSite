<?php 

namespace App\Repository;

use App\Model\Post;
use App\PaginatedQuery;
use App\Repository\CategoryRepository;
use App\Repository\Exception\{InsertException, UpdateException};

final class PostRepository extends Repository
{
    protected $table = 'post';
    protected $class = Post::class;

    public function insertPost(Post $post) : void
    {
        $id = $this->insert([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'image' => $post->getImage(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setID($id);
    }

    public function updatePost(Post $post) : void
    {
        $this->update([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'image' => $post->getImage(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getID());
    }

    public function attachCategories(int $id, array $categories) : void 
    {
        $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO post_category VALUES (?, ?)');
        foreach($categories as $category) {
            $query->execute([$id, $category]);
        }
    }

    public function findPaginated() : array 
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            NB_ARTICLES_PER_PAGE,
            [],
             $this->pdo
         );
         
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryRepository($this->pdo))->addPostsCategories($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedforCategory(int $categoryID) : array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
                FROM post p
                JOIN post_category pc ON pc.post_id = p.id 
                WHERE category_id = :id
                ORDER BY created_at DESC", 
            "SELECT COUNT(post_id) 
                FROM post_category 
                WHERE category_id = :id",
            NB_ARTICLES_PER_PAGE,
            ['id' => $categoryID]
        );
        
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryRepository($this->pdo))->addPostsCategories($posts);
        return [$posts, $paginatedQuery];;
    }
}
