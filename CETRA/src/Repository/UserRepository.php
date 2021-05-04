<?php 

namespace App\Repository;

use PDO;
use App\Model\User;
use App\Repository\Exception\UserNotFoundException;

final class UserRepository extends Repository
{
    protected $table = 'user';
    protected $class = User::class;

    public function findByUsername(string $username) 
    {
        $query = $this->pdo->prepare('SELECT * FROM '. $this->table .' WHERE username = :username');
        $query->execute(['username' => $username]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $item = $query->fetch();
        
        if($item === false) {
            throw new UserNotFoundException($this->table, $username);
        }

        /**
         * @return object $item
         */
        return $item;
    }
}
