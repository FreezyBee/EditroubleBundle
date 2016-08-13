<?php

namespace FreezyBee\EditroubleBundle\Model\Storage;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use FreezyBee\EditroubleBundle\Entity\EditroubleContent;

/**
 * Class Doctrine
 * @package FreezyBee\EditroubleBundle\Model\Storage
 */
class Doctrine implements IStorage
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Doctrine constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $namespace
     * @param $locale
     * @return array
     */
    public function getNamespaceContent($namespace, $locale)
    {
        /** @var EditroubleContent[] $result */
        $query = $this->entityManager->createQueryBuilder()
            ->select('c.content, c.name')
            ->from(EditroubleContent::class, 'c', 'c.name')
            ->where('c.namespace = :namespace AND c.locale = :locale')
            ->setParameters([
                'namespace' => $namespace,
                'locale' => $locale
            ])
            ->getQuery();

        return array_map(function ($row) {
            return reset($row);
        }, $query->getResult(AbstractQuery::HYDRATE_ARRAY));
    }

    /**
     * @param $namespace
     * @param $name
     * @param $locale
     * @param $content
     */
    public function saveContent($namespace, $name, $locale, $content)
    {
        /** @var EditroubleContent $entity */
        $entity = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(EditroubleContent::class, 'c')
            ->where('c.namespace = :namespace')
            ->andWhere('c.name = :name')
            ->andWhere('c.locale = :locale')
            ->setParameters([
                'namespace' => $namespace,
                'name' => $name,
                'locale' => $locale
            ])
            ->getQuery()
            ->getOneOrNullResult();

        $entity = $entity ? $entity->setContent($content) : new EditroubleContent($namespace, $name, $locale, $content);

        $em = $this->entityManager;
        $em->persist($entity);
        $em->flush($entity);
    }
}
