<?php

namespace App\Service;

use App\Entity\HashCode;

class HashCodeService
{
    const HASH_CODE_LIFE_TIME = 3600; // One hour

    public function clearCodes($entityManager): void
    {
        $entities = $entityManager->getRepository(HashCode::class)->findAll();
        foreach ($entities as $entity) {
            $entityManager->remove($entity);
        }
        $entityManager->flush();
    }

    public function getCode($entityManager): ?string
    {
        $hashCode = $entityManager->getRepository(HashCode::class)->findOneBy([]);
        if (
            $hashCode->getCreatedAt()->getTimestamp() + self::HASH_CODE_LIFE_TIME < time()
            || !$hashCode->getCode()
        ) {
            return null;
        }

        return $hashCode->getCode();
    }
}
