<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Product extends AbstractMigration
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
        $table = $this->table('product');
        $table->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('category', 'string', ['limit' => 255])
            ->addColumn('price', 'float')
            ->addColumn('discount_percentage', 'float')
            ->addColumn('rating', 'float')
            ->addColumn('stock', 'integer')
            ->addColumn('brand', 'string', ['limit' => 255])
            ->addColumn('sku', 'string', ['limit' => 255])
            ->addColumn('weight', 'integer')
            ->addColumn('warranty_information', 'string', ['limit' => 255])
            ->addColumn('shipping_information', 'string', ['limit' => 255])
            ->addColumn('availability_status', 'string', ['limit' => 255])
            ->addColumn('returnPolicy', 'string', ['limit' => 255])
            ->addColumn('minimumOrderQuantity', 'integer')
            ->addColumn('thumbnail', 'string', ['limit' => 255])
            ->addColumn('updated_at',  'datetime', ['null' => true])
            ->addColumn('created_at',  'datetime', ['null' => true])
            ->create();
    }
}
