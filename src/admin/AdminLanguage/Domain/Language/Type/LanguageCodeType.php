<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Domain\Language\Type;

use App\Admin\AdminLanguage\Domain\Language\Field\LanguageCodeField;
use App\Core\Common\Validator\Exception\ValidatorException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class LanguageCodeType extends StringType
{
    public const NAME = 'language_code';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof LanguageCodeField ? (string) $value : $value;
    }

    /**
     * @throws ValidatorException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LanguageCodeField
    {
        return $value != null ? new LanguageCodeField($value) : null;
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
