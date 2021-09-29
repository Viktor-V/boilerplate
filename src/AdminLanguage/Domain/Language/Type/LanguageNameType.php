<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Type;

use App\AdminLanguage\Domain\Language\Field\LanguageNameField;
use App\Core\Validator\Exception\ValidatorException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class LanguageNameType extends StringType
{
    public const NAME = 'language_name';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof LanguageNameField ? (string) $value : $value;
    }

    /**
     * @throws ValidatorException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LanguageNameField
    {
        return !empty($value) ? new LanguageNameField($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
