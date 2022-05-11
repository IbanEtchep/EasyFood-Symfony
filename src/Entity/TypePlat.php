<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="typePlat")
 */
class TypePlat {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $libelleType;
    
    /**
     * @ORM\OneToMany(targetEntity="Plat", mappedBy="leTypePlat")
     */
    protected $lesPlats;
    
    public function __construct() {
        $this->lesPlats = new ArrayCollection();
    }

        public function getId(): int {
        return $this->id;
    }

    public function getLibelleType(): string {
        return $this->libelleType;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setLibelleType(string $libelleType): void {
        $this->libelleType = $libelleType;
    }

    public function getLesPlats() {
        return $this->lesPlats;
    }

    public function setLesPlats($lesPlats): void {
        $this->lesPlats = $lesPlats;
    }
    
    public function addPlat(?Plat $unPlat){
        $this->lesPlats[]=$unPlat;
    }

    public function __toString() {
        return $this->libelleType;
    }


}
