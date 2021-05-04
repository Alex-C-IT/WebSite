<?php 
namespace App\Repository;

use PDO;
use App\Model\Ticket;
use App\Repository\Exception\TicketUserNotFoundException;

final class TicketRepository extends Repository 
{
    protected $table = 'ticket';
    protected $class = Ticket::class;

    public function findAll() : array 
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table}");
    }

    public function findAllByAccountId(int $id) : array
    {
        return $this->queryAndFetchAll("SELECT * FROM ". $this->table ." WHERE id_user = {$id}");
    }
}

?>