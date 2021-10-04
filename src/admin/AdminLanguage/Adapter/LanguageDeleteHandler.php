<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Adapter;

use App\Admin\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\Admin\AdminLanguage\Domain\Language\LanguageRepository;
use App\Admin\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Common\Adapter\Contract\HandlerInterface;
use App\Core\Common\Domain\Flusher;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\ValueObject\Contract\RequestDataInterface;

final class LanguageDeleteHandler implements HandlerInterface
{
    public function __construct(
        private LanguageRepository $languageRepository,
        private Flusher $flusher
    ) {
    }

    /**
     * @throws ValidatorException
     */
    public function handle(RequestDataInterface $requestData): void
    {
        /** @var LanguageDeleteRequestData $requestData */
        $language = $this->languageRepository->getByIdentifier(new LanguageIdentifierField($requestData->identifier));

        if ($language->isPrime()) {
            throw new ValidatorException(__a(
                'Language cannot be deleted if it is prime. Set another language as prime and delete %s.',
                $language->getName()
            ));
        }

        $this->languageRepository->delete($language);

        $this->flusher->flush();
    }
}
