<?php declare(strict_types = 1);

namespace Libs\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"ico"})})
 */
class SearchResults
{

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private string $ico;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $companyName;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTime $date;

    /**
     * @var \Libs\Entity\Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="address_id")
     * })
     */
    private $address;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): SearchResults
    {
        $this->id = $id;
        return $this;
    }

    public function getIco(): string
    {
        return $this->ico;
    }

    public function setIco(string $ico): SearchResults
    {
        $this->ico = $ico;
        return $this;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): SearchResults
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): SearchResults
    {
        $this->date = $date;
        return $this;
    }

    public function getAddress(): \Libs\Entity\Address
    {
        return $this->address;
    }

    public function setAddress(\Libs\Entity\Address $address): SearchResults
    {
        $this->address = $address;

        return $this;
    }

}
