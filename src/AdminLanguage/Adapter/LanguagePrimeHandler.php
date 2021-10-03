<?php

declare(strict_types=1);

namespace App\AdminLanguage\Adapter;

use App\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\AdminLanguage\Domain\Language\LanguageRepository;
use App\AdminLanguage\ValueObject\LanguageEditRequestData;
use App\Core\Common\Adapter\Contract\HandlerInterface;
use App\Core\Common\Domain\Flusher;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\ValueObject\Contract\RequestDataInterface;

final class LanguagePrimeHandler implements HandlerInterface
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
        /** @var LanguageEditRequestData $requestData */
        $language = $this->languageRepository->getByIdentifier(new LanguageIdentifierField($requestData->identifier));
        if ($language->isPrime()) {
            throw new ValidatorException(_('Language is already set as prime!'));
        }
        $language->setPrime();

        $primeLanguage = $this->languageRepository->getPrime();
        $primeLanguage->unsetPrime();

        $this->languageRepository->add($primeLanguage);
        $this->languageRepository->add($language);

        $this->flusher->flush();
    }
}
