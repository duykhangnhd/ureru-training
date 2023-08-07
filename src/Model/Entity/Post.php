<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\FrozenTime;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $post_title
 * @property int $cate_id
 * @property \Cake\I18n\FrozenTime $post_created_at
 * @property \Cake\I18n\FrozenTime $post_updated_at
 *
 * @property \App\Model\Entity\Cate $cate
 */
class Post extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'post_title' => true,
        'post_text' => true,
        'cate_id' => true,
        'post_created_at' => true,
        'post_updated_at' => true,
        'cate' => true,
    ];

    /**
     * _getPostCreatedAt
     *
     * @param FrozenTime $postCreatedAt
     * @return void
     */
    protected function _getPostCreatedAt(FrozenTime $postCreatedAt) {
        return $postCreatedAt->format('Y-m-d');
    }
}
