<?php

namespace DouglasDC3\Kong\Model\Plugin;

use DouglasDC3\Kong\Model\Route;
use DouglasDC3\Kong\Model\Service;
use Illuminate\Contracts\Support\Arrayable;

abstract class Plugin implements Arrayable
{
    public $id;
    public $name;
    public $service_id;
    public $route_id;

    /**
     * Plugin constructor.
     *
     * @param $name
     * @param $data
     */
    public function __construct($name, $data)
    {
        $this->name = $name;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }


    protected abstract function configArray();

    public function setParent($parent)
    {
        if ($parent instanceof Route) {
            $this->route_id = $parent->id;
        }

        if ($parent instanceof Service) {
            $this->service_id = $parent->id;
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'service_id' => $this->service_id,
            'route_id' => $this->route_id,
            'config' => $this->configArray(),
        ];
    }
}