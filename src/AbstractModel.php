<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Basic abstract class for App Store objects.
 *
 * All properties of classes that inherit AbstractModel MUST be public.
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

    /**
     * Object as query string.
     *
     * @return string
     */
    public function toAppleQueryString(): string
    {
        $reflection = new \ReflectionObject($this);
        $props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $segments = [];

        foreach ($props as $prop) {

            $value = $prop->getValue($this);

            if (\is_null($value)) {
                continue;
            }

            if (\is_iterable($value)) {
                foreach ($value as $propValue) {
                    $segments[] = \urlencode($prop->getName()) . '=' . \urlencode($propValue);
                }
            } elseif (\is_bool($value)) {
                $segments[] = \urlencode($prop->getName()) . '=' . ($value ? 'true' : 'false');
            } else {
                $segments[] = \urlencode($prop->getName()) . '=' . \urlencode((string)$value);
            }

        }

        return \implode('&', $segments);
    }
}
