<?php


namespace App\Core\Domain\Request;

use App\Core\ValueObject\Contract\RequestDataInterface;

trait FromObjectTrait
{
    public static function initialize(RequestDataInterface $data): self
    {
        $object = new self();

        foreach (get_object_vars($object) as $property => $default) {
            $object->$property = $data[$property] ?? $default;
        }

        return $object;
    }
}
