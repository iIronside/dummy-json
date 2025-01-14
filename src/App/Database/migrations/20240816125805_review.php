<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Review extends AbstractMigration
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
        $table = $this->table('review');
        $table->addColumn('product_id', 'integer', ['signed' => false])
            ->addForeignKey('product_id', 'product', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addColumn('rating', 'integer')
            ->addColumn('comment', 'string', ['limit' => 255])
            ->addColumn('date', 'datetime')
            ->addColumn('reviewer_name', 'string', ['limit' => 250])
            ->addColumn('reviewer_email', 'string', ['limit' => 250])
            ->addColumn('updated_at',  'datetime', ['null' => true])
            ->addColumn('created_at',  'datetime', ['null' => true])
            ->create();
    }
}
