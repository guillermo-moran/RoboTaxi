<?php


/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 27-Feb-17
 * Time: 05:52 PM
 */

class Response
{
    /**
     * @var array
     */
    private $response = array();

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->response['errorCount'] = 0;
        $this->response['messages'] = array();
        $this->response['status'] = 'SUCCESS';
        $this->response['data'] = array();
    }

    /**
     * @return int
     */
    public function getErrorCount()
    {
        return $this->response['errorCount'];
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->response['messages'];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->response['status'];
    }

    public function getData()
    {
        return $this->response['data'];
    }

    /**
     *
     */
    public function echoJSONString()
    {
        header('Content-Type: application/json');
        echo $this->getJSONString();
    }

    /**
     * @return string
     */
    public function getJSONString()
    {
        return json_encode($this->response);
    }

    /**
     * @param $errorMessage
     */
    public function pushError($errorMessage)
    {
        $this->response['status'] = "FAIL";
        $this->response['errorCount'] += 1;
        $this->pushMessage($errorMessage);
    }

    /**
     * @param $message
     */
    public function pushMessage($message)
    {
        array_push($this->response['messages'], $message);
    }

    public function pushData($datum)
    {
        array_push($this->response['data'], $datum);
    }

}

