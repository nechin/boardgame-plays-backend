<?php

namespace App\Service;

use App\Entity\HashCode;
use Doctrine\Persistence\ObjectManager;

class HashCodeService
{
    const HASH_CODE_LIFE_TIME = 3600; // One hour

    private ObjectManager $em;

    /**
     * HashCodeService constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function clearCodes(): void
    {
        $entities = $this->em->getRepository(HashCode::class)->findAll();
        foreach ($entities as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();
    }

    public function getCode(): string
    {
        $hashCode = $this->em->getRepository(HashCode::class)->findOneBy([]);
        if (
            $hashCode->getCreatedAt()->getTimestamp() + self::HASH_CODE_LIFE_TIME < time()
            || !$hashCode->getCode()
        ) {
            return '';
        }

        return $hashCode->getCode();
    }
}
