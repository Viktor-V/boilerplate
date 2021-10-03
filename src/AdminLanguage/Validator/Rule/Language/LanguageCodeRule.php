<?php

declare(strict_types=1);

namespace App\AdminLanguage\Validator\Rule\Language;

use App\Core\Common\Validator\Contract\RuleInterface;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints\Language;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

final class LanguageCodeRule implements RuleInterface
{
    private const MIN_LENGTH = 2;
    private const MAX_LENGTH = 3;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __a('%s is a required value.', _a('Code'))
            ]),
            new Language([
                'message' => _a('This value is not a valid language.')
            ]),
            new Length([
                'min' => self::MIN_LENGTH,
                'max' => self::MAX_LENGTH,
                'minMessage' => __a('This value is too short. It should have %s characters or more.', self::MIN_LENGTH),
                'maxMessage' => __a('This value is too long. It should have %s characters or less.', self::MAX_LENGTH)
            ])
        ];
    }
}
