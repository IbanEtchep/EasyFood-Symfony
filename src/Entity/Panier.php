<?php
namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="panier")
 */
class Panier {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Composer", mappedBy="lePanier")
     */
    protected $lesComposers;
    
    /**
     * @ORM\OneToOne(targetEntity="Utilisateur", mappedBy="lePanier")
     */
    protected $leClient;
    
    public function __construct() {
        $this->lesComposers = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getLesComposers() {
        return $this->lesComposers;
    }

    public function getLeClient() {
        return $this->leClient;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setLesComposers($lesComposers): void {
        $this->lesComposers = $lesComposers;
    }

    public function setLeClient($leClient): void {
        $this->leClient = $leClient;
    }
    
    public function addComposer(?Composer $unComposer){
        $this->lesComposers[]=$unComposer;
    } 
    public function getRestoPanier() {
        if ($this->lesComposers[0]->getLePlat()->getLeResto()) {
            return $this->lesComposers[0]->getLePlat()->getLeResto();
        }
        return null;
        
    }
}
