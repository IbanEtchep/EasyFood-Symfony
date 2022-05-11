<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="composer")
 */
class Composer {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue

     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quantite;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plat", inversedBy="lesComposers")
     */
    protected $lePlat;
    
    /**
     * @ORM\ManyToOne(targetEntity="Panier", inversedBy="lesComposers")
     */
    protected $lePanier;
    
    public function getId() {
        return $this->id;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function getLePlat() {
        return $this->lePlat;
    }

    public function getLePanier() {
        return $this->lePanier;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setQuantite(int $quantite): void {
        $this->quantite = $quantite;
    }

    public function setLePlat($lePlat): void {
        $this->lePlat = $lePlat;
    }

    public function setLePanier($lePanier): void {
        $this->lePanier = $lePanier;
    }

}