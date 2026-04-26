<?php

namespace App\Core\Database;

use PDO;
use App\Core\Traits\Loggable;


class QueryBuilder
{

    use Loggable;

    public PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select()
    {
        //
    }

    public function insert()
    {
        //
    }

    public function update()
    {
        //
    }
}
