<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage\Adapter;

use App\Admin\AdminLanguage\Domain\Language\Field\LanguageCodeField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageNameField;
use App\Admin\AdminLanguage\Domain\Language\Field\LanguageNativeField;
use App\Admin\AdminLanguage\Domain\Language\LanguageRepository;
use App\Admin\AdminLanguage\Infrastructure\Form\RequestObject\LanguageCreateRequestData;
use App\Core\Common\Adapter\Contract\HandlerInterface;
use App\Core\Common\Domain\Flusher;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Admin\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Core\Common\ValueObject\Contract\RequestObjectInterface;
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
     * @throws ValidatorException | NonUniqueResultException | NoResultException
     */
    public function handle(RequestObjectInterface $requestData): void
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
        } catch (NonUniqueResultException | NoResultException $exception) {
            $this->logger->error('Cannot add new language. Reason: ' . $exception->getMessage());

            throw $exception;
        }
    }
}
