<?php declare(strict_types = 1);

namespace Libs\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Country extends EntityRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(\Libs\Entity\Country::class));
    }

    public function create(string $name): \Libs\Entity\Country
    {
        $country = new \Libs\Entity\Country();
        $country->setCountry($name)->setLastUpdate(new \DateTime());
        $this->getEntityManager()->persist($country);
        $this->getEntityManager()->flush();
        return $country;
    }

}
