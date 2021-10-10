<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Infrastructure\Form\RequestObject;

use App\Admin\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Core\Common\ValueObject\Contract\RequestObjectInterface;

final class LanguageEditRequestData implements RequestObjectInterface
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
