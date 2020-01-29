<?php

namespace Src\Core\DI;

use src\Exceptions\DIContainerException;

class DI
{
    /**
     * @var array
     */
    private array $container = [];

    /**
     * @param string $key
     * @param $value
     * @return DI
     * @throws DIContainerException
     */
    public function set(string $key, $value): self
    {
        if (array_key_exists($key, $this->container)) {
            throw new DIContainerException('Service is already initialized and exists by provided service name');
        }

        $this->container[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws DIContainerException
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new DIContainerException('Service you are trying to get have not been initialized');
        }

        return $this->container[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    private function has(string $key): bool
    {
        return isset($this->container[$key]);
    }
}