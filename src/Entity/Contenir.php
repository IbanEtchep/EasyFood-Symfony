<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contenir")
 */
class Contenir {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quantite;
    
    /**
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="lesContenirs")
     */
    protected $laCommande;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plat", inversedBy="lesContenirs")
     */
    protected $unPlat;
    
    public function getId(): int {
        return $this->id;
    }

    public function getQuantite(): int {
        return $this->quantite;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setQuantite(int $quantite): void {
        $this->quantite = $quantite;
    }
    public function getLaCommande() {
        return $this->laCommande;
    }

    public function getUnPlat() {
        return $this->unPlat;
    }

    public function setLaCommande($laCommande): void {
        $this->laCommande = $laCommande;
    }

    public function setUnPlat($unPlat): void {
        $this->unPlat = $unPlat;
    }



    
}