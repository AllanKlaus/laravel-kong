<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;
use DouglasDC3\Kong\Model\Plugin\AclConsumer;

class Acl extends KongApi
{
    /**
     * @var \DouglasDC3\Kong\Model\Consumer
     */
    private $consumer;

    /**
     * Jwt constructor.
     *
     * @param \DouglasDC3\Kong\Kong $kong
     * @param \DouglasDC3\Kong\Model\Consumer  $consumer
     */
    public function __construct($kong, $consumer)
    {
        parent::__construct($kong);
        $this->consumer = $consumer;
    }

    /**
     * List all JWT tokens
     *
     * @return AclConsumer[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return $this->listCall("consumers/{$this->consumer->id}/acls", AclConsumer::class, []);
    }

    /**
     * Find a ACL.
     *
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Plugin\AclConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new AclConsumer($this->kong->getClient()->get("consumers/{$this->consumer->id}/acls/$id"), $this->kong);
    }

    /**
     * Create a new ACL.
     *
     * @param $acl
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($acl)
    {
        if (!($acl instanceof AclConsumer)) {
            $acl = new AclConsumer([
                'group' => $acl,
                'consumer_id' => $this->consumer->id,
            ]);
        }

        return new AclConsumer($this->kong->getClient()->post("consumers/{$this->consumer->id}/acls", $acl->toArray()), $this->kong);
    }
}