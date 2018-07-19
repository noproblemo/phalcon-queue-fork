<?php

class List extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $tel;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $roadAddress;

    /**
     *
     * @var string
     */
    public $display;

    /**
     *
     * @var string
     */
    public $thumUrl;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("naver");
        $this->setSource("list");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'list';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return List[]|List|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return List|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
