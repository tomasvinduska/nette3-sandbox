<?php declare(strict_types = 1);

namespace Libs\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 * @ORM\Table(name="address", indexes={@ORM\Index(name="idx_fk_city_id", columns={"city_id"})})
 * @ORM\Entity
 */
class Address
{

    /**
     * @var int
     * @ORM\Column(name="address_id", type="smallint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $addressId;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string|null
     * @ORM\Column(name="address2", type="string", length=50, nullable=true)
     */
    private $address2;

    /**
     * @var string
     * @ORM\Column(name="district", type="string", length=20, nullable=false)
     */
    private $district;

    /**
     * @var string|null
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=20, nullable=false)
     */
    private $phone;

    /**
     * @var \DateTime
     * @ORM\Column(name="last_update", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \City
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_id", referencedColumnName="city_id")
     * })
     */
    private $city;

}
