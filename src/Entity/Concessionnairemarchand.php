<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcessionnairemarchandRepository::class)
 */
class Concessionnairemarchand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * @ORM\Column(type="boolean")
     */
    private $actif;

   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siteweb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liendealertrack;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Fabriquant::class, mappedBy="concessionnairesmarchand")
     */
    private $fabriquants;

    /**
     * @ORM\ManyToMany(targetEntity=Agent::class, inversedBy="concessionnairemarchand")
     */
    private $agents;

    /**
     * @ORM\OneToOne(targetEntity=Medias::class, cascade={"persist", "remove"})
     */
    private $media;

    /**
     * @ORM\OneToOne(targetEntity=Concessionnaire::class, mappedBy="Concessionnairemarchand", cascade={"persist", "remove"})
     */
    private $concessionnaire;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="concessionnairemarchand", cascade={"persist", "remove"})
     */
    private $Utilisateur;

    /**
     * @ORM\OneToOne(targetEntity=Marchand::class, mappedBy="Concessionnairemarchand", cascade={"persist", "remove"})
     */
    private $marchand;

    public function __construct()
    {
        $this->fabriquants = new ArrayCollection();
        $this->agents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

   /* public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }*/

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getLiendealertrack(): ?string
    {
        return $this->liendealertrack;
    }

    public function setLiendealertrack(string $liendealertrack): self
    {
        $this->liendealertrack = $liendealertrack;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection|Fabriquant[]
     */
    public function getFabriquants(): Collection
    {
        return $this->fabriquants;
    }

    public function addFabriquant(Fabriquant $fabriquant): self
    {
        if (!$this->fabriquants->contains($fabriquant)) {
            $this->fabriquants[] = $fabriquant;
            $fabriquant->addConcessionnairesmarchand($this);
        }

        return $this;
    }

    public function removeFabriquant(Fabriquant $fabriquant): self
    {
        if ($this->fabriquants->removeElement($fabriquant)) {
            $fabriquant->removeConcessionnairesmarchand($this);
        }

        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        $this->agents->removeElement($agent);

        return $this;
    }

    public function getMedia(): ?Medias
    {
        return $this->media;
    }

    public function setMedia(?Medias $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getConcessionnaire(): ?Concessionnaire
    {
        return $this->concessionnaire;
    }

    public function setConcessionnaire(Concessionnaire $concessionnaire): self
    {
        // set the owning side of the relation if necessary
        if ($concessionnaire->getConcessionnairemarchand() !== $this) {
            $concessionnaire->setConcessionnairemarchand($this);
        }

        $this->concessionnaire = $concessionnaire;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getMarchand(): ?Marchand
    {
        return $this->marchand;
    }

    public function setMarchand(Marchand $marchand): self
    {
        // set the owning side of the relation if necessary
        if ($marchand->getConcessionnairemarchand() !== $this) {
            $marchand->setConcessionnairemarchand($this);
        }

        $this->marchand = $marchand;

        return $this;
    }
}
