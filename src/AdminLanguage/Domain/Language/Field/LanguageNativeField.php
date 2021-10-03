<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Field;

use App\AdminLanguage\Validator\Rule\Language\LanguageNativeRule;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\Validator\Validator;

final class LanguageNativeField
{
    private string $native;

    /** @throws ValidatorException */
    public function __construct(
        string $native
    ) {
        Validator::validate($native, LanguageNativeRule::rules());

        $this->native = $native;
    }

    public function __toString()
    {
        return $this->native;
    }
}
