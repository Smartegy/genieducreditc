<?php

namespace App\Entity;

use App\Repository\ConcessionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcessionnaireRepository::class)
 */
class Concessionnaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Concessionnairemarchand::class, inversedBy="concessionnaire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Concessionnairemarchand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcessionnairemarchand(): ?Concessionnairemarchand
    {
        return $this->Concessionnairemarchand;
    }

    public function setConcessionnairemarchand(Concessionnairemarchand $Concessionnairemarchand): self
    {
        $this->Concessionnairemarchand = $Concessionnairemarchand;

        return $this;
    }
}
