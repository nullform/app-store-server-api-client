<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Basic abstract class for App Store objects.
 */
abstract class AbstractModel
{
    /**
     * @param string|array|\stdClass $data JSON string, associative array or \stdClass instance for immediately overwrite object properties.
     * @uses AbstractModel::map()
     */
    public function __construct($data = null)
    {
        if (\is_string($data)) {
            $data = \json_decode($data, true);
        } else {
            $data = (array)$data;
        }

        if (\is_array($data)) {
            $this->map($data);
        }
    }

    /**
     * Overwrite object properties.
     *
     * @param array $data Associative array with new values.
     * @return $this
     */
    public function map(array $data): self
    {
        $reflection = new \ReflectionObject($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if (\array_key_exists($property->getName(), $data)) {
                $property->setValue($this, $data[$property->getName()]);
            }
        }
        return $this;
    }

    /**
     * Object as JSON string.
     *
     * @return string
     */
    public function toJson(): string
    {
        return \json_encode($this);
    }
}
