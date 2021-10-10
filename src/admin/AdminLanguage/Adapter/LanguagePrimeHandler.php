<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Adapter;

use App\Admin\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\Admin\AdminLanguage\Domain\Language\LanguageRepository;
use App\Admin\AdminLanguage\Infrastructure\Form\RequestObject\LanguageEditRequestData;
use App\Core\Common\Adapter\Contract\HandlerInterface;
use App\Core\Common\Domain\Flusher;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\ValueObject\Contract\RequestObjectInterface;

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
    public function handle(RequestObjectInterface $requestData): void
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
