<?php
namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 * @ORM\Table(name="plat")
 */
class Plat {

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
    protected $nomP;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $prixFournisseurP;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $prixClientP;


    /**
     * @ORM\Column(type="text")
     */
    protected $descriptionP;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $platVisible;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $platModere;

    /**
     * @ORM\Column(type="string")
     */
    private $imageFilename;

    /**
     * @ORM\ManyToOne(targetEntity="TypePlat", inversedBy="lesPlats")
     */
    protected $leTypePlat;

    /**
     * @ORM\ManyToOne(targetEntity="Resto", inversedBy="lesPlats")
     */
    protected $leResto;

    /**
     * @ORM\OneToMany(targetEntity="Contenir", mappedBy="unPlat")
     */
    protected $lesContenirs;

    /**
     * @ORM\OneToMany(targetEntity="Composer", mappedBy="lePlat")
     */
    protected $lesComposers;

    public function __construct() {
        $this->lesContenirs = new ArrayCollection();
        $this->lesComposers = new ArrayCollection();
        $this->imageName = "image".$this->id;
    }


    public function getId(): int {
        return $this->id;
    }

    public function getNomP(): string {
        return $this->nomP;
    }

    public function getPrixFournisseurP(): float {
        return $this->prixFournisseurP;
    }

    public function getPrixClientP(): float {
        return $this->prixClientP;
    }

    public function getDescriptionP() {
        return $this->descriptionP;
    }

    public function getPlatVisible() {
        return $this->platVisible;
    }
    public function getPlatModere() {
        return $this->platModere;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNomP(string $nomP): void {
        $this->nomP = $nomP;
    }

    public function setPrixFournisseurP(float $prixFournisseurP): void {
        $this->prixFournisseurP = $prixFournisseurP;
    }

    public function setPrixClientP(float $prixClientP): void {
        $this->prixClientP = $prixClientP;
    }

    public function setDescriptionP($descriptionP): void {
        $this->descriptionP = $descriptionP;
    }

    public function setPlatVisible($platVisible): void {
        $this->platVisible = $platVisible;
    }

    public function setPlatModere($platModere): void {
        $this->platModere = $platModere;
    }

    public function getLeTypePlat() {
        return $this->leTypePlat;
    }

    public function setLeTypePlat($leTypePlat): void {
        $this->leTypePlat = $leTypePlat;
    }

    public function getLeResto() {
        return $this->leResto;
    }

    public function getLesContenirs() {
        return $this->lesContenirs;
    }

    public function setLeResto($leResto): void {
        $this->leResto = $leResto;
    }

    public function setLesContenirs($lesContenirs): void {
        $this->lesContenirs = $lesContenirs;
    }

    public function addContenir(?Contenir $unContenir){
        $this->lesContenir[]=$unContenir;
    }

    public function getLesComposers() {
        return $this->lesComposers;
    }

    public function setLesComposers($lesComposers): void {
        $this->lesComposers = $lesComposers;
    }

    public function addComposer(?Composer $unComposer){
        $this->lesComposers[]=$unComposer;
    }

    public function getImageFilename() {
        return $this->imageFilename;
    }

    public function setImageFilename($imageFilename): void {
        $this->imageFilename = $imageFilename;
    }

    public function __toString() {
        return $this->nomP;
    }


}
