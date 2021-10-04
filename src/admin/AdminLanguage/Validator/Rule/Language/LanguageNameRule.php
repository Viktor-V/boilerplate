<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Validator\Rule\Language;

use App\Core\Common\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class LanguageNameRule implements RuleInterface
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 36;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __a('%s is a required value.', _a('Name'))
            ]),
            new Length([
                'min' => self::MIN_LENGTH,
                'max' => self::MAX_LENGTH,
                'minMessage' => __a(
                    '%s is too short. It should have %s characters or more.',
                    _a('Name'),
                    self::MIN_LENGTH
                ),
                'maxMessage' => __a(
                    '%s is too long. It should have %s characters or less.',
                    _a('Name'),
                    self::MAX_LENGTH
                )
            ])
        ];
    }
}
