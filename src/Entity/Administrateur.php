<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints as Assert;
//use AssoConnect\DoctrineValidatorBundle\Validator\Constraints as AssoConnectAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass=App\Repository\AdministrateurRepository::class)
 * 
 
 
 */
class Administrateur 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * * @Assert\NotBlank(message="Veuillez cocher envoi Email ")
     */
    private $authenvoiemails;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Veuillez cocher envoi SMS ")
     */
    private $authenvoisms;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="administrateur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthenvoiemails(): ?bool
    {
        return $this->authenvoiemails;
    }

    public function setAuthenvoiemails(bool $authenvoiemails): self
    {
        $this->authenvoiemails = $authenvoiemails;

        return $this;
    }

    public function getAuthenvoisms(): ?bool
    {
        return $this->authenvoisms;
    }

    public function setAuthenvoisms(bool $authenvoisms): self
    {
        $this->authenvoisms = $authenvoisms;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

}
