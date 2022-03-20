<?php

declare(strict_types=1);

namespace UI\Common\Payload;

use ReflectionClass;
use ReflectionProperty;
use ReflectionAttribute;

abstract class AbstractPayload implements PayloadInterface
{
    public function fromArray(array $params): self
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $defaultAttributes = $property->getAttributes(DefaultValue::class);
            /** @var ReflectionAttribute $defaultAttribute */
            $defaultAttribute = end($defaultAttributes);

            $arguments = $defaultAttribute->getArguments();
            $defaultValue = end($arguments);

            $value = $params[$property->getName()] ?? $defaultValue;

            if ($property instanceof ReflectionProperty) {
                $type = $property->getType()?->getName();

                if ($value !== null) {
                    $value = match ($type) {
                        'string' => (string) $value,
                        'int' => (int) $value,
                        'float' => (float) $value,
                        'bool' => (bool) $value,
                        'default' => $value
                    };
                }

                $property->setValue($this, $value);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
