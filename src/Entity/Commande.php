<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @var date
     */
    protected $dateC;

    /**
     * @ORM\Column(type="text")
     */
    protected $commentaireClientC;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateLivrC;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $modeReglementC;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="lesCommandes")
     */
    protected $leUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity="Contenir", mappedBy="laCommande")
     */
    protected $lesContenirs;

    public function __construct() {
        $this->lesContenirs = new ArrayCollection();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDateC() {
        return $this->dateC;
    }

    public function getCommentaireClientC(): ?string {
        return $this->commentaireClientC;
    }

    public function getDateLivrC() {
        return $this->dateLivrC;
    }

    public function getModeReglementC(): ?string {
        return $this->modeReglementC;
    }

    public function getLeUtilisateur() {
        return $this->leUtilisateur;
    }

    public function getLesContenirs() {
        return $this->lesContenirs;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setDateC($dateC): void {
        $this->dateC = $dateC;
    }

    public function setCommentaireClientC(?string $commentaireClientC): void {
        $this->commentaireClientC = $commentaireClientC;
    }

    public function setDateLivrC($dateLivrC): void {
        $this->dateLivrC = $dateLivrC;
    }

    public function setModeReglementC(?string $modeReglementC): void {
        $this->modeReglementC = $modeReglementC;
    }

    public function setLeUtilisateur($leUtilisateur): void {
        $this->leUtilisateur = $leUtilisateur;
    }

    public function setLesContenirs($lesContenirs): void {
        $this->lesContenirs = $lesContenirs;
    }

    public function addContenir(?Contenir $unContenir) {
        $this->lesContenirs[] = $unContenir;
    }

    public function __toString() {
        return $this->dateC;
    }

    public function getPrixTotalCommande() {
        $prix = 0;
        for ($i = 0; $i < count($this->lesContenirs); $i++) {
            $prix += $this->lesContenirs[$i]->getUnPlat()->getPrixClientP() * $this->lesContenirs[$i]->getQuantite();
        }
        return $prix;
    }

    public function getRestoCommande() {
        if ($this->lesContenirs[0]->getUnPlat()->getLeResto()) {
            return $this->lesContenirs[0]->getUnPlat()->getLeResto();
        }
        return null;
        
    }

}
