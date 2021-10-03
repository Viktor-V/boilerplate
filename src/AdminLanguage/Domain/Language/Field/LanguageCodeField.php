<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Field;

use App\AdminLanguage\Validator\Rule\Language\LanguageCodeRule;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\Validator\Validator;

final class LanguageCodeField
{
    private string $code;

    /** @throws ValidatorException */
    public function __construct(
        string $code
    ) {
        Validator::validate($code, LanguageCodeRule::rules());

        $this->code = $code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
