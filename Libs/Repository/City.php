<?php declare(strict_types = 1);

namespace Libs\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class City extends EntityRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(\Libs\Entity\City::class));
    }

    public function create(string $name, \Libs\Entity\Country $country): \Libs\Entity\City
    {
        $city = new \Libs\Entity\City();
        $city->setCity($name)->setCountry($country);
        $this->getEntityManager()->persist($city);
        $this->getEntityManager()->flush();
        return $city;
    }

}
