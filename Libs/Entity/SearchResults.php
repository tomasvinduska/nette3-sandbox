<?php declare(strict_types = 1);

namespace Libs\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     */
    private int $ico;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $companyName;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private \DateTime $date;
}
