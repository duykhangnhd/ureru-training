<?php
use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
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
        $this->table('posts',[
            'comment' => 'Posts',
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
        ->addColumn('post_title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('post_text', 'text', [
            'default' => null,
            'limit' => null,
            'null' => false,
        ])
        ->addColumn('cate_id', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('post_created_at', 'datetime', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('post_updated_at', 'datetime', [
            'default' => null,
            'null' => false,
        ])
        ->create();
    }
}
