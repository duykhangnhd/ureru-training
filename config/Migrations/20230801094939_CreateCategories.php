<?php

use Migrations\AbstractMigration;

class CreateCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('categories', [
            'comment' => 'Categories',
            'collation' => 'utf8mb4_bin',
            'id' => false,
            'primary_key' => ['id'],
        ])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'comment' => 'PRIMARY KEY',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('cate_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cate_created_at', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('cate_updated_at', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->create();
    }
}
