<?php

namespace App\Core\Common\Domain\View;

trait FromArrayTrait
{
    /**
     * @param array<int|string, mixed> $data
     */
    public static function initialize(array $data): self
    {
        $object = new self();

        foreach (get_object_vars($object) as $property => $default) {
            $object->$property = $data[$property] ?? $default;
        }

        return $object;
    }
}
