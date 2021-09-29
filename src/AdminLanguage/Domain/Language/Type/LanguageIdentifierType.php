<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language\Type;

use App\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\Core\Validator\Exception\ValidatorException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class LanguageIdentifierType extends GuidType
{
    public const NAME = 'language_identifier';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof LanguageIdentifierField ? (string) $value : $value;
    }

    /**
     * @throws ValidatorException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LanguageIdentifierField
    {
        return !empty($value) ? new LanguageIdentifierField($value) : null;
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
