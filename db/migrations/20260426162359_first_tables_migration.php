<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FirstTablesMigration extends AbstractMigration
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
        $tableAutor = $this->table('autores');
        $tableAutor->addColumn('nombre', 'string', ['limit' => 60])
            ->addColumn('bio', 'string', ['limit' => 250])
            ->create();

        $tableAutor = $this->table('libros');
        $tableAutor->addColumn('titulo', 'string', ['limit' => 75])
            ->addColumn('isbn', 'string', ['limit' => 25])
            ->addColumn('desc_corta', 'string', ['limit' => 150])
            ->addColumn('descripcion', 'string', ['limit' => 300])
            ->addColumn('imagen_url', 'string', ['limit' => 200])
            ->addColumn('fecha_pub', 'date')
            ->addColumn('stock', 'integer')
            ->addColumn('created_at', 'timestamp')
            ->create();

        $tableAutorLibro = $this->table(
            'autor_libro',
            [
                'id' => false,
                'primary_key' => ['autor_id', 'libro_id'],
            ]
        );

        $tableAutorLibro
            ->addColumn('autor_id', 'integer')
            ->addColumn('libro_id', 'integer')
            ->addForeignKey('autor_id', 'autores', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION',
            ])
            ->addForeignKey('libro_id', 'libros', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION',
            ])
            ->create();
    }
}
