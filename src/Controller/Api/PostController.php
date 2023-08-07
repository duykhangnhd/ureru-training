<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Objects\StatusCode;
use App\Traits\ApiResponseTrait;
use Cake\ORM\Exception\InvalidEntityException;

/**
 * PostController
 */
class PostController extends AppController
{
    use ApiResponseTrait;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->RequestHandler->renderAs($this, 'json');
        $this->RequestHandler->prefers('json');
        $this->viewBuilder()->setClassName('Json');

        $this->loadModel("Posts");
    }

    /**
     * getPosts
     *
     * @return void
     */
    public function getPosts()
    {
        try {
            $cateID = $this->request->getQuery('cate_id');

            if (!empty($cateID)) {
                $query = $this->Posts->find('all', [
                    'conditions' => ['cate_id' => $cateID],
                ]);
            } else {
                $query = $this->Posts->find('all');
            }

            ['data' => $posts, 'total_page' => $totalPage] = $this->getPagination($query);

            return $this->sendSuccess([
                'data' => $posts,
                'total_page' => $totalPage
            ]);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }

    /**
     * getPost
     *
     * @param [type] $postID
     * @return void
     */
    public function getPost($postID)
    {
        try {
            $post = $this->Posts->get($postID);

            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }

    /**
     *
     *
     * @param [type] $model
     * @return void
     */
    public function getValidateErrors($model)
    {
        $validateErrors = $model->getErrors();
        $errors = [];

        foreach ($validateErrors as $field => $fieldErrors) {
            foreach ($fieldErrors as $error) {
                // $errors[] = [
                //     'field' => $field,
                //     'message' => $error,
                // ];

                $errors[$field] = $error;
            }
        }

        return $errors;
    }

    /**
     * storePost
     *
     * @return void
     */
    public function storePost()
    {
        try {
            $postData = $this->request->getData();
            $post = $this->Posts->newEntity($postData);

            if ($post->hasErrors()) {
                $errors = $this->getValidateErrors($post);

                return $this->setError($errors)
                    ->setMessage('Invalid data')
                    ->sendError(StatusCode::INVALID_FORM_DATA);
            }

            if (!$this->Posts->save($post)) {
                throw new \Exception('Store failed');
            }

            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }

    /**
     * updatePost
     *
     * @param [type] $postID
     * @return void
     */
    public function updatePost($postID)
    {
        try {
            $post = $this->Posts->get($postID);
            $postData = $this->request->getData();

            $post = $this->Posts->patchEntity($post, $postData);

            if ($post->hasErrors()) {
                $errors = $this->getValidateErrors($post);

                return $this->setError($errors)
                    ->setMessage('Invalid data')
                    ->sendError(StatusCode::INVALID_FORM_DATA);
            }

            if (!$this->Posts->save($post)) {
                throw new \Exception('Update failed');
            }

            return $this->sendSuccess($post);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }

    /**
     * searchPost
     *
     * @return void
     */
    public function searchPost()
    {
        try {
            $searchData = $this->request->getData();

            $conditions = [];

            if (!empty($searchData['post_title'])) {
                $conditions['Posts.post_title LIKE'] = '%' . $searchData['post_title'] . '%';
            }

            if (!empty($searchData['post_text'])) {
                $conditions['Posts.post_text LIKE'] = '%' . $searchData['post_text'] . '%';
            }

            if (!empty($searchData['cate_id'])) {
                $conditions['Posts.cate_id'] = $searchData['cate_id'];
            }

            if (!empty($searchData['post_created_at'])) {
                $conditions['DATE(Posts.post_created_at)'] = $searchData['post_created_at'];
            }

            $query = $this->Posts->find('all', [
                'conditions' => $conditions
            ]);

            ['data' => $posts, 'total_page' => $totalPage] = $this->getPagination($query);

            return $this->sendSuccess([
                'data' => $posts,
                'total_page' => $totalPage
            ]);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }

    /**
     * getPagination
     *
     * @param [type] $query
     * @param integer $limit
     * @return void
     */
    public function getPagination($query, $limit = 10)
    {
        $this->paginate = [
            'limit' => $limit,
            'order' => ['post_title' => 'asc'],
        ];

        $posts = $this->paginate($query);
        $pagingParams = $this->Paginator->getPagingParams()['Posts'];

        return [
            'data' => $posts,
            'total_page' => $pagingParams['pageCount']
        ];
    }

    /**
     * deletePost
     * @param [type] $postID
     * @return void
     */
    public function deletePost($postID)
    {
        try {
            $post = $this->Posts->get($postID);

            $this->Posts->delete($post);

            return $this->sendSuccess('Delete success');
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }
}
