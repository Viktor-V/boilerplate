<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Domain\Entity;

use App\Admin\AdminLanguage\Domain\Language\Field\LanguageCodeField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageNameField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageNativeField;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageCodeType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageIdentifierType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageNameType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageNativeType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
#[ORM\UniqueConstraint(name: 'language_index', columns: ['code'])]
class LanguageEntity
{
    public const TABLE_NAME = 'language';

    #[ORM\Id]
    #[ORM\Column(type: LanguageIdentifierType::NAME, unique: true)]
    private LanguageIdentifierField $identifier;

    #[ORM\Column(type: LanguageCodeType::NAME)]
    private LanguageCodeField $code;

    #[ORM\Column(type: LanguageNameType::NAME)]
    private LanguageNameField $name;

    #[ORM\Column(type: LanguageNativeType::NAME)]
    private LanguageNativeField $native;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $prime = false;

    private function __construct(
        LanguageIdentifierField $identifier,
        LanguageCodeField $code,
        LanguageNameField $name,
        LanguageNativeField $native
    ) {
        $this->identifier = $identifier;
        $this->code = $code;
        $this->name = $name;
        $this->native = $native;
    }

    public static function create(
        LanguageIdentifierField $identifier,
        LanguageCodeField $code,
        LanguageNameField $name,
        LanguageNativeField $native
    ): self {
        return new self($identifier, $code, $name, $native);
    }

    public static function createPrime(
        LanguageIdentifierField $identifier,
        LanguageCodeField $code,
        LanguageNameField $name,
        LanguageNativeField $native
    ): self {
        $language = new self($identifier, $code, $name, $native);

        $language->prime = true;

        return $language;
    }

    public function edit(
        LanguageNameField $name,
        LanguageNativeField $native
    ): self {
        $this->name = $name;
        $this->native = $native;

        return $this;
    }

    public function setPrime(): void
    {
        $this->prime = true;
    }

    public function unsetPrime(): void
    {
        $this->prime = false;
    }

    public function getIdentifier(): LanguageIdentifierField
    {
        return $this->identifier;
    }

    public function getCode(): LanguageCodeField
    {
        return $this->code;
    }

    public function getName(): LanguageNameField
    {
        return $this->name;
    }

    public function getNative(): LanguageNativeField
    {
        return $this->native;
    }

    public function isPrime(): bool
    {
        return $this->prime;
    }
}
