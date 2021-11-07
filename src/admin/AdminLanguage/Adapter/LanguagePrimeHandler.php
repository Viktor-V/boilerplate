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
use DomainException;

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

        try {
            $language->setPrime();
        } catch (DomainException $exception) {
            throw new ValidatorException($exception->getMessage());
        }

        $primeLanguage = $this->languageRepository->getPrime();

        try {
            $primeLanguage->unsetPrime();
        } catch (DomainException $exception) {
            throw new ValidatorException($exception->getMessage());
        }

        $this->languageRepository->add($primeLanguage);
        $this->languageRepository->add($language);

        $this->flusher->flush();
    }
}
