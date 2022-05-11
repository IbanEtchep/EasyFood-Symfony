<?php
namespace App\Entity;

use App\Repository\RestoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestoRepository::class)
 * @ORM\Table(name="resto")
 */
class Resto {

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
    protected $nomR;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $numAdrR;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $rueAdrR;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $cpR;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $villeR;

    /**
     * @ORM\Column(type="time")
     */
    protected $heureOuverture;

    /**
     * @ORM\Column(type="time")
     */
    protected $heureFermeture;

    /**
     * @ORM\OneToMany(targetEntity="Plat", mappedBy="leResto")
     */
    protected $lesPlats;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="lesRestos")
     */
    protected $unRestaurateur;

    /**
     * @ORM\OneToMany(targetEntity="Evaluer", mappedBy="unResto")
     */
    protected $lesEvaluers;

    public function __construct() {
        $this->lesEvaluers = new ArrayCollection();
        $this->lesPlats = new ArrayCollection();
    }


    public function getId(): int {
        return $this->id;
    }

    public function getNomR(): string {
        return $this->nomR;
    }

    public function getNumAdrR(): string {
        return $this->numAdrR;
    }

    public function getRueAdrR(): string {
        return $this->rueAdrR;
    }

    public function getCpR(): string {
        return $this->cpR;
    }

    public function getVilleR(): string {
        return $this->villeR;
    }

    public function getHeureOuverture(){
        return $this->heureOuverture;
    }

    public function getHeureFermeture(){
        return $this->heureFermeture;
    }

    public function isHeureOuverture(?\DateTime $date) : bool{
        $heureOuverture = $this->getHeureOuverture()->format("H");
        $minOuverture = $this->getHeureOuverture()->format("m");
        $datetimeOuverture = clone $date;
        $datetimeOuverture->setTime($heureOuverture, $minOuverture);

        $heureFermeture = $this->getHeureFermeture()->format("H");
        $minFermeture = $this->getHeureFermeture()->format("m");
        $datetimeFermeture = clone $date;
        $datetimeFermeture->setTime($heureFermeture, $minFermeture);

        return $date > $datetimeOuverture && $date < $datetimeFermeture;
    }

    public function estOuvert(){

        return false;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNomR(string $nomR): void {
        $this->nomR = $nomR;
    }

    public function setNumAdrR(string $numAdrR): void {
        $this->numAdrR = $numAdrR;
    }

    public function setRueAdrR(string $rueAdrR): void {
        $this->rueAdrR = $rueAdrR;
    }

    public function setCpR(string $cpR): void {
        $this->cpR = $cpR;
    }

    public function setVilleR(string $villeR): void {
        $this->villeR = $villeR;
    }

   public function setHeureOuverture(?\Datetime $heureOuverture): void {
       $this->heureOuverture = $heureOuverture;
   }

   public function setHeureFermeture(?\Datetime $heureFermeture): void {
       $this->heureFermeture = $heureFermeture;
   }

    public function getLesPlats() {
        return $this->lesPlats;
    }

    public function getUnRestaurateur() {
        return $this->unRestaurateur;
    }

    public function getLesEvaluers() {
        return $this->lesEvaluers;
    }

    public function setLesPlats($lesPlats): void {
        $this->lesPlats = $lesPlats;
    }

    public function setUnRestaurateur($unRestaurateur): void {
        $this->unRestaurateur = $unRestaurateur;
    }

    public function setLesEvaluers($lesEvaluers): void {
        $this->lesEvaluers = $lesEvaluers;
    }


    public function addEvaluer(?Evaluer $uneEvaluer){
        $this->lesEvaluers[]=$uneEvaluer;
    }

    public function addPlat(?Plat $unPlat){
        $this->lesPlats[]=$unPlat;
    }

    public function __toString() {
        return $this->nomR;
    }
    public function getLesPlatsVisibles(){
        $platsVisibles=array();
        for($i=0;$i<count($this->getLesPlats());$i++){
            if($this->getLesPlats()[$i]->getPlatVisible()){
                $platsVisibles[]=$this->getLesPlats()[$i];
            }
        }
        return $platsVisibles;
    }

}
