<?php

declare(strict_types=1);

namespace App\Core\Domain\Field;

use App\Core\Validator\Exception\ValidatorException;
use App\Core\Validator\Rule\Core\CoreIdentifierRule;
use App\Core\Validator\Validator;
use Symfony\Component\Uid\Uuid;

trait IdentifierTrait
{
    /** @throws ValidatorException */
    public function __construct(
        private string $id
    ) {
        $this->validate($this->id);
    }

    /** @throws ValidatorException */
    public static function next(): self
    {
        return new self((string) Uuid::v4());
    }

    /** @throws ValidatorException */
    protected function validate(string $id): void
    {
        Validator::validate($id, CoreIdentifierRule::rules());
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
