<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Field;

use App\AdminLanguage\Validator\Rule\Language\LanguageNameRule;
use App\Core\Validator\Exception\ValidatorException;
use App\Core\Validator\Validator;

final class LanguageNameField
{
    private string $name;

    /** @throws ValidatorException */
    public function __construct(
        string $name
    ) {
        Validator::validate($name, LanguageNameRule::rules());

        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
