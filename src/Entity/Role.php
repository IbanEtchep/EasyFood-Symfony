<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $libelleRole;

    /**
     * @ORM\OneToMany(targetEntity="Utilisateur", mappedBy="leRole")
     */
    protected $lesUtilisateurs;

    public function __construct() {
        $this->lesUtilisateurs = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibelleRole(): ?string {
        return $this->libelleRole;
    }

    public function setLibelleRole(string $libelleRole): self {
        $this->libelleRole = $libelleRole;

        return $this;
    }

    public function addUtilisateur(?Utilisateur $unUtilisateur) {
        $this->lesUtilisateurs[] = $unUtilisateur;
    }

    public function __toString() {
        return $this->libelleRole;
    }

    public function getLibelleRoleAffichable() {
        $role = str_replace("ROLE_", "", $this->getLibelleRole());
        return $role;
    }

}
