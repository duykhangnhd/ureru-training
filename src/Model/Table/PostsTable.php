<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \App\Model\Table\CatesTable&\Cake\ORM\Association\BelongsTo $Cates
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 */
class PostsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'post_created_at' => 'new',
                    'post_updated_at' => 'always',
                ],
            ],
        ]);

        $this->belongsTo('Categories', [
            'foreignKey' => 'cate_id',
            'joinType' => 'INNER',
        ]);
    }


    /**
     * validationDefault
     *
     *
     * @param Validator $validator
     * @return void
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmptyString('post_title', 'Please enter title')
            ->notEmptyString('post_text', 'Please enter text.')
            ->integer('cate_id')
            ->notEmptyString('cate_id', 'Please enter category.')
            // ->add('cate_id', 'valid_category', [
            //     'rule' => function ($value) {
            //         return !$this->exists(['id' => $value]);
            //     },
            //     'message' =>  __('The refcode already exists.'),
            // ])
            ->add('cate_id', 'validCategory', [
                'rule' => function ($value, $context) {
                    $categoriesTable = $this->getAssociation('Categories')->getTarget();
                    return $categoriesTable->exists(['id' => $value]);
                },
                'message' => 'Invalid category.',
            ]);


        return $validator;
    }
}
