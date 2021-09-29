<?php


namespace App\Core\Domain\View;

trait FromArrayTrait
{
    public static function initialize(array $data): self
    {
        $object = new self();

        foreach (get_object_vars($object) as $property => $default) {
            $object->$property = $data[$property] ?? $default;
        }

        return $object;
    }
}
