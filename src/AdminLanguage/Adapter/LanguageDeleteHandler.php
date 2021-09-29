<?php

declare(strict_types=1);

namespace App\AdminLanguage\Adapter;

use App\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\AdminLanguage\Domain\Language\LanguageRepository;
use App\AdminLanguage\ValueObject\LanguageDeleteRequestData;
use App\Core\Adapter\Contract\HandlerInterface;
use App\Core\Domain\Flusher;
use App\Core\Validator\Exception\ValidatorException;
use App\Core\ValueObject\Contract\RequestDataInterface;

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
