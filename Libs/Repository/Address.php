<?php declare(strict_types = 1);

namespace Libs\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Address extends EntityRepository
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(\Libs\Entity\Address::class));
    }

    public function create(string $street, string $postal,string $district, \Libs\Entity\City $city)
    {
        $address = new \Libs\Entity\Address();
        $address->setAddress($street)->setPostalCode($postal)->setCity($city)->setDistrict($district);
        $this->getEntityManager()->persist($address);
        $this->getEntityManager()->flush();
        return $address;
    }
}
