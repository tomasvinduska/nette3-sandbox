<?php declare(strict_types = 1);

namespace Libs\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
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
     * @ORM\Column(name="district", type="string", length=50, nullable=false)
     */
    private $district;

    /**
     * @var string|null
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="last_update", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdate;

    /**
     * @var \Libs\Entity\City
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_id", referencedColumnName="city_id")
     * })
     */
    private $city;

    public function __construct()
    {
        $this->lastUpdate = new \DateTime();
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }

    public function setAddressId(int $addressId): Address
    {
        $this->addressId = $addressId;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Address
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): Address
    {
        $this->address2 = $address2;
        return $this;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function setDistrict(string $district): Address
    {
        $this->district = $district;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): Address
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Address
    {
        $this->phone = $phone;
        return $this;
    }

    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTime $lastUpdate): Address
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    public function getCity(): \Libs\Entity\City
    {
        return $this->city;
    }

    public function setCity(\Libs\Entity\City $city): Address
    {
        $this->city = $city;
        return $this;
    }

}
