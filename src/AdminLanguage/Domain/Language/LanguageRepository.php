<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\AdminLanguage\Domain\Language\Field\LanguageCodeField;
use App\AdminLanguage\Domain\Language\Field\LanguageIdentifierField;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class LanguageRepository
{
    private ObjectRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(LanguageEntity::class);
    }

    public function getByIdentifier(LanguageIdentifierField $identifier): LanguageEntity
    {
        return $this->repository->find((string) $identifier);
    }

    public function getPrime(): LanguageEntity
    {
        return $this->repository->findOneBy(['prime' => true]);
    }

    /**
     * @throws NonUniqueResultException|NoResultException
     */
    public function hasByCode(LanguageCodeField $code): bool
    {
        return $this->repository->createQueryBuilder('language')
                ->select('COUNT(language.identifier)')
                ->where('language.code = :code')
                ->setParameter(':code', (string) $code)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    /**
     * @throws NonUniqueResultException|NoResultException
     */
    public function hasPrimeLanguage(): bool
    {
        return $this->repository->createQueryBuilder('language')
            ->select('COUNT(language.identifier)')
            ->where('language.prime = :prime')
            ->setParameter(':prime', true)
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }

    public function add(LanguageEntity $language): void
    {
        $this->entityManager->persist($language);
    }

    public function delete(LanguageEntity $language): void
    {
        $this->entityManager->remove($language);
    }
}
