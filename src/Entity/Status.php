<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $detail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $wholesale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enenchere;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vendu;

    public function getId(): ?int
    {
        return $this->id;
    }

  

    public function getDetail(): ?bool
    {
        return $this->detail;
    }

    public function setDetail(?bool $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getWholesale(): ?bool
    {
        return $this->wholesale;
    }

    public function setWholesale(?bool $wholesale): self
    {
        $this->wholesale = $wholesale;

        return $this;
    }

    public function getEnenchere(): ?bool
    {
        return $this->enenchere;
    }

    public function setEnenchere(?bool $enenchere): self
    {
        $this->enenchere = $enenchere;

        return $this;
    }

    public function getVendu(): ?bool
    {
        return $this->vendu;
    }

    public function setVendu(?bool $vendu): self
    {
        $this->vendu = $vendu;

        return $this;
    }
}
