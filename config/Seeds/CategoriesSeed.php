<?php

use Migrations\AbstractSeed;
use Faker\Factory as FakerFactory;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * CategoriesSeeder seed.
 * php bin/cake migrations seed -s CategoriesSeed
 */
class CategoriesSeed extends AbstractSeed
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

        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'id' => $i,
                'cate_name' => $faker->word,
                'cate_created_at' => Time::now()->format('Y-m-d H:i:s'),
                'cate_updated_at'  => Time::now()->format('Y-m-d H:i:s'),
            ];
        }

        $this->table('categories')->insert($data)->save();
    }
}
