<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCompras extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {

        $tableCompras = $this->table('compras');
        $tableCompras->addColumn('id_libro', 'integer')
            ->addColumn('nombre', 'string', ['limit' => 50])
            ->addColumn('apellido', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('pais', 'string', ['limit' => 50])
            ->addColumn('provincia', 'string', ['limit' => 100])
            ->addColumn('ciudad', 'string', ['limit' => 100])
            ->addColumn('calle', 'string', ['limit' => 100])
            ->addColumn('nro_calle', 'integer')
            ->addColumn('created_at', 'timestamp')
            ->create();
    }
}
