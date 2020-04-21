<?php declare(strict_types = 1);

namespace Libs\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Libs\Entity\SearchResults;

class SearchResult extends EntityRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(SearchResults::class));
    }

    public function save(SearchResults $searchResult): void
    {
        $this->getEntityManager()->persist($searchResult);
        $this->getEntityManager()->flush();
    }

}
