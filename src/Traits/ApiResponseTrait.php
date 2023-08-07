<?php

namespace App\Traits;

use App\Objects\StatusCode;
use \Cake\Http\Response;

trait ApiResponseTrait
{
    public static $STATUS_SUCCESS = true;
    public static $STATUS_FAILED = false;

    private $_status;
    private $_code = StatusCode::HTTP_OK;
    private $_message;
    private $_data;
    private $_errors = [];

    /**
     * @param int $code
     *
     * @return $this
     */
    protected function setCode(int $code)
    {
        $this->_code = $code;

        return $this;
    }

    public function setError($errors = [])
    {
        $this->_errors = $errors;

        return $this;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    protected function setStatus(bool $status)
    {
        $this->_status = $status;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    protected function setMessage(string $message)
    {
        $this->_message = $message;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    protected function setData($data)
    {
        $this->_data = $data;

        return $this;
    }

    // /**
    //  * @return \Psr\Log\LoggerInterface
    //  */
    // public function getLogger()
    // {
    //     return Log::getLogger('daily');
    // }

    /***
     * End point return data
     *
     * @return \Cake\Http\Response
     */
    public function response()
    {
        $data = [
            'success' => $this->_status,
            'status_code' => $this->_code,
            'message' => $this->_message,
            'data' => $this->_data,
            'errors' => $this->_errors,
        ];

        $response = new Response();
        $response = $response->withType('json');
        $response = $response->withStringBody(json_encode($data));

        return $response;
    }

    /**
     * sendSuccessData.
     *
     * @param mixed $data
     * @param string $message
     * @return \Cake\Http\Response
     */
    public function sendSuccess($data = null, $message = 'Success')
    {
        return $this->setStatus(self::$STATUS_SUCCESS)
            ->setMessage($message)
            ->setData($data)
            ->response();
    }

    /**
     * sendErrorData.
     *
     * @param int|null $statusCode
     * @return \Cake\Http\Response
     */
    public function sendError($statusCode = null)
    {
        $statusCode = !empty($statusCode) ? $statusCode : StatusCode::HTTP_BAD_REQUEST;
        $this->setCode($statusCode);

        return $this->setStatus(self::$STATUS_FAILED)
            ->response();
    }
}
