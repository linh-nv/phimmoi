<?php

namespace App\Singletons;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceSingleton
{
    private static $instance = null;
    private $resources = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getResource(string $resourceClass, $data): JsonResource
    {
        if (!isset($this->resources[$resourceClass])) {
            $this->resources[$resourceClass] = new $resourceClass($data);
        }

        return $this->resources[$resourceClass];
    }

    public function reset(string $resourceClass = null): void
    {
        if ($resourceClass) {
            unset($this->resources[$resourceClass]);
        } else {
            $this->resources = [];
        }
    }
}
