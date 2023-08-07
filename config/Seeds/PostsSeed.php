<?php

use Migrations\AbstractSeed;
use Cake\I18n\Time;
use Faker\Factory as FakerFactory;
use Cake\ORM\TableRegistry;

/**
 * PostsSeed
 * php bin/cake migrations seed --seed PostsSeed
 *
 */
class PostsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        $categoriesTable = TableRegistry::getTableLocator()->get('Categories');
        $categoryIds = $categoriesTable->find('list', ['valueField' => 'id'])->toArray();

        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $data[] =
                [
                    'id' => $i,
                    'post_title' => $faker->sentence,
                    'post_text' => $faker->paragraphs(3, true),
                    'cate_id' => $faker->randomElement($categoryIds),
                    'post_created_at' => Time::now()->format('Y-m-d H:i:s'),
                    'post_updated_at' => Time::now()->format('Y-m-d H:i:s')
                ];
        }

        $this->table('posts')->insert($data)->save();
    }
}
