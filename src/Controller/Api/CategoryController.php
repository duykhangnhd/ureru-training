<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Traits\ApiResponseTrait;

/**
 * CategoryController
 */
class CategoryController extends AppController
{
    use ApiResponseTrait;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        $this->RequestHandler->prefers('json');
        $this->viewBuilder()->setClassName('Json');
    }

    /**
     * getCates
     *
     * @return void
     */
    public function getCates()
    {
        try {
            $this->loadModel('Categories');

            $categories = $this->Categories->find('all')->toArray();

            return $this->sendSuccess($categories);
        } catch (\Exception $e) {
            return $this->setMessage($e->getMessage())->sendError($e->getCode());
        }
    }
}
