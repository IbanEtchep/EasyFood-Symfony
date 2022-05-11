<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="evaluer")
 */
class Evaluer {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $noteQualiteNourriture;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $noteRespectRecette;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $noteEsthetique;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $noteCout;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $evaluationModere=false;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $evaluationVisible=false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $commentaireEvaluation;

    /**
     * @ORM\ManyToOne(targetEntity="Resto", inversedBy="lesEvaluers")
     */
    protected $unResto;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="lesEvaluers")
     */
    protected $leUtilisateur;

    public function getId(): int {
        return $this->id;
    }

    public function getCommentaireEvaluation(): ?string
    {
        return $this->commentaireEvaluation;
    }

    public function setCommentaireEvaluation(?string $commentaireEvaluation): self
    {
        $this->commentaireEvaluation = $commentaireEvaluation;
        return $this;
    }

    public function getNoteQualiteNourriture(): float {
        return $this->noteQualiteNourriture;
    }

    public function getNoteRespectRecette(): float {
        return $this->noteRespectRecette;
    }

    public function getNoteEsthetique(): float {
        return $this->noteEsthetique;
    }

    public function getNoteCout(): float {
        return $this->noteCout;
    }

    public function getEvaluationVisible() {
        return $this->evaluationVisible;
    }

    public function getEvaluationModere() {
        return $this->evaluationModere;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNoteQualiteNourriture(float $noteQualiteNourriture): void {
        $this->noteQualiteNourriture = $noteQualiteNourriture;
    }

    public function setNoteRespectRecette(float $noteRespectRecette): void {
        $this->noteRespectRecette = $noteRespectRecette;
    }

    public function setNoteEsthetique(float $noteEsthetique): void {
        $this->noteEsthetique = $noteEsthetique;
    }

    public function setNoteCout(float $noteCout): void {
        $this->noteCout = $noteCout;
    }

    public function setEvaluationVisible(bool $evaluationVisible): self {
        $this->evaluationVisible = $evaluationVisible;
        return $this;
    }

    public function setEvaluationModere(bool $evaluationModere): self {
        $this->evaluationModere = $evaluationModere;
        return $this;
    }

    public function getUnResto() {
        return $this->unResto;
    }

    public function getLeUtilisateur() {
        return $this->leUtilisateur;
    }

    public function setUnResto($unResto): void {
        $this->unResto = $unResto;
    }

    public function setLeUtilisateur($leUtilisateur): void {
        $this->leUtilisateur = $leUtilisateur;
    }



}
