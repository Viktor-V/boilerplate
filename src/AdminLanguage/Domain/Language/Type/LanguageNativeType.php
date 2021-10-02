<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Type;

use App\AdminLanguage\Domain\Language\Field\LanguageNativeField;
use App\Core\Validator\Exception\ValidatorException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class LanguageNativeType extends StringType
{
    public const NAME = 'language_native';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof LanguageNativeField ? (string) $value : $value;
    }

    /**
     * @throws ValidatorException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LanguageNativeField
    {
        return $value != null ? new LanguageNativeField($value) : null;
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
