<?php

declare(strict_types=1);

namespace App\AdminLanguage\Adapter;

use App\AdminLanguage\Domain\Language\Field\LanguageCodeField;
use App\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\AdminLanguage\Domain\Language\Field\LanguageNameField;
use App\AdminLanguage\Domain\Language\Field\LanguageNativeField;
use App\AdminLanguage\Domain\Language\LanguageRepository;
use App\AdminLanguage\ValueObject\LanguageCreateRequestData;
use App\Core\Adapter\Contract\HandlerInterface;
use App\Core\Domain\Flusher;
use App\Core\Validator\Exception\ValidatorException;
use App\Core\ValueObject\Contract\RequestDataInterface;
use App\AdminLanguage\Domain\Entity\LanguageEntity;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Intl\Languages;

final class LanguageCreateHandler implements HandlerInterface
{
    public function __construct(
        private LanguageRepository $languageRepository,
        private Flusher $flusher,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws ValidatorException|NonUniqueResultException|NoResultException
     */
    public function handle(RequestDataInterface $requestData): void
    {
        /** @var LanguageCreateRequestData $requestData */
        $code = new LanguageCodeField($requestData->code);
        $name = new LanguageNameField(
            ucwords($requestData->name ?? Languages::getName($requestData->code))
        );
        $native = new LanguageNativeField(
            ucwords($requestData->native ?? Languages::getName($requestData->code, $requestData->code))
        );

        try {
            if ($this->languageRepository->hasByCode($code)) {
                throw new ValidatorException(_a('Code already exists!'));
            }

            $language = $this->languageRepository->hasPrimeLanguage()
                ? LanguageEntity::create(LanguageIdentifierField::next(), $code, $name, $native)
                : LanguageEntity::createPrime(LanguageIdentifierField::next(), $code, $name, $native);
            $this->languageRepository->add($language);

            $this->flusher->flush();
        } catch (NonUniqueResultException|NoResultException $exception) {
            $this->logger->error('Cannot add new language. Reason: ' . $exception->getMessage());

            throw $exception;
        }
    }
}
