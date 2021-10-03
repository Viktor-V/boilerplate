<?php

declare(strict_types=1);

namespace App\AdminLanguage\ValueObject;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Core\Common\ValueObject\Contract\RequestDataInterface;

final class LanguageEditRequestData implements RequestDataInterface
{
    public string $identifier;
    public string $code;
    public string $name;
    public string $native;

    public function __construct(
        LanguageEntity $language
    ) {
        $this->identifier = (string) $language->getIdentifier();
        $this->code = (string) $language->getCode();
        $this->name = (string) $language->getName();
        $this->native = (string) $language->getNative();
    }
}
