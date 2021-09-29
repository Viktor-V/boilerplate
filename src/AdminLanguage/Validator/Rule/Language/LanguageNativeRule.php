<?php

declare(strict_types=1);

namespace App\AdminLanguage\Validator\Rule\Language;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class LanguageNativeRule implements RuleInterface
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 36;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __a('%s is a required value.', _a('Native'))
            ]),
            new Length([
                'min' => self::MIN_LENGTH,
                'max' => self::MAX_LENGTH,
                'minMessage' => __a(
                    '%s is too short. It should have %s characters or more.',
                    _a('Native'),
                    self::MIN_LENGTH
                ),
                'maxMessage' => __a(
                    '%s is too long. It should have %s characters or less.',
                    _a('Native'),
                    self::MAX_LENGTH
                )
            ])
        ];
    }
}
