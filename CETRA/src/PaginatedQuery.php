<?php 

namespace App;

use PDO;
use Exception;
use App\URL;
use App\Connection;

class PaginatedQuery 
{
    private string $query;
    private string $queryCount;
    private $pdo;
    private int $perPage;
    private $paramsPreparedQuery;
    private $count = null;
    private $items = null;

    public function __construct(string $query, string $queryCount, int $perPage = 12, $paramsPreparedQuery = [], PDO $pdo = null) 
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
        $this->paramsPreparedQuery = $paramsPreparedQuery;
    }
    
    private function getCurrentPage() : int 
    {
        return URL::getPositiveInt('page', 1);
    }
    
    private function getNbPages() : int
    {
        if($this->count === null) {
            $query = $this->pdo->prepare($this->queryCount);
            $query->execute($this->paramsPreparedQuery);
            $this->count = $query->fetch(PDO::FETCH_NUM)[0];    
        }

        return ceil($this->count / $this->perPage);
    }

    public function getItems(string $classMapping) : array
    {
        if($this->items === null) {
            $currentPage = $this->getCurrentPage();

            if($currentPage <= 0) {
                throw new Exception("Numéro de page invalide");
            }
    
            $nbPages = $this->getNbPages();
    
            if ($currentPage > $nbPages) {
                throw new Exception('Cette page n\'existe pas');
            }
    
            $offset = $this->perPage * ($currentPage - 1);
    
            $this->query .= " LIMIT {$this->perPage} OFFSET {$offset}";
    
            $query = $this->pdo->prepare($this->query);
            $query->execute($this->paramsPreparedQuery);
            $query->setFetchMode(PDO::FETCH_CLASS, $classMapping);
            $this->items = $query->fetchAll();
    
            /** Tableau de $classMapping à retoruner
             * @var $this->classMapping[] */
            return $this->items;
        }
    }

    public function previousLink(string $link) : ?string
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage <= 1) return null;
        if($currentPage > 2) $link .= '?page=' . ($currentPage - 1);

        return <<<HTML
            <a href="{$link}" class="btn btn-outline-primary">&laquo; Page précédente</a>
        HTML;
    }

    public function nextLink(string $link) : ?string
    {
        $currentPage = $this->getCurrentPage();
        $nbPages = $this->getNbPages();

        if ($currentPage >= $nbPages) return null;

        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-outline-primary ml-auto">Page suivante &raquo;</a>
        HTML;
        
        
    }
}