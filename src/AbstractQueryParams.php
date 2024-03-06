<?php

namespace Nullform\AppStoreServerApiClient;

/**
 * Basic abstract class for App Store query parameters.
 */
abstract class AbstractQueryParams
{
    /**
     * @return string
     */
    public function toQueryString(): string
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
