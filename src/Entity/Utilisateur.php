<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Role;
use App\Entity\Panier;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @ORM\Table(name="utilisateurs")
 * @UniqueEntity(fields={"mailU"}, message="Il y a déjà un compte avec cet email !")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue

     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nomU;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $prenomU;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mailU;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $numAdrC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $rueC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cpC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $villeC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $noteEasyFood;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $commentaireEasyFood;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $commentaireVisible = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $commentaireModere = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mdpU;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="lesUtilisateurs")
     */
    protected $leRole;

    /**
     * @ORM\OneToMany(targetEntity="Evaluer", mappedBy="leUtilisateur")
     */
    protected $lesEvaluers;

    /**
     * @ORM\OneToMany(targetEntity="Resto", mappedBy="unRestaurateur")
     */
    protected $lesRestos;

    /**
     * @ORM\OneToOne(targetEntity="Panier", inversedBy="leClient",cascade={"persist"})
     */
    protected $lePanier;

    /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="leUtilisateur")
     */
    protected $lesCommandes;

    public function __construct() {
        $this->lesEvaluers = new ArrayCollection();
        $this->lesRestos = new ArrayCollection();
        $this->lesCommandes = new ArrayCollection();
        $lePanier = new Panier();
        $this->lePanier = $lePanier;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNomU(): ?string {
        return $this->nomU;
    }

    public function setNomU(string $nomU): self {
        $this->nomU = $nomU;

        return $this;
    }

    public function getPrenomU(): ?string {
        return $this->prenomU;
    }

    public function setPrenomU(string $prenomU): self {
        $this->prenomU = $prenomU;

        return $this;
    }

    public function getMailU(): ?string {
        return $this->mailU;
    }

    public function setMailU(string $mailU): self {
        $this->mailU = $mailU;

        return $this;
    }

    public function getNumAdrC(): ?string {
        return $this->numAdrC;
    }

    public function setNumAdrC(string $numAdrC): self {
        $this->numAdrC = $numAdrC;

        return $this;
    }

    public function getRueC(): ?string {
        return $this->rueC;
    }

    public function setRueC(?string $rueC): self {
        $this->rueC = $rueC;

        return $this;
    }

    public function getCpC(): ?string {
        return $this->cpC;
    }

    public function setCpC(?string $cpC): self {
        $this->cpC = $cpC;

        return $this;
    }

    public function getVilleC(): ?string {
        return $this->villeC;
    }

    public function setVilleC(?string $villeC): self {
        $this->villeC = $villeC;

        return $this;
    }

    public function getNoteEasyFood(): ?string {
        return $this->noteEasyFood;
    }

    public function setNoteEasyFood(?string $noteEasyFood): self {
        $this->noteEasyFood = $noteEasyFood;

        return $this;
    }

    public function getCommentaireEasyFood(): ?string {
        return $this->commentaireEasyFood;
    }

    public function setCommentaireEasyFood(?string $commentaireEasyFood): self {
        $this->commentaireEasyFood = $commentaireEasyFood;
        return $this;
    }

    public function getCommentaireVisible(): ?bool {
        return $this->commentaireVisible;
    }

    public function getCommentaireModere(): ?bool {
        return $this->commentaireModere;
    }

    public function setCommentaireVisible(bool $commentaireVisible): self {
        $this->commentaireVisible = $commentaireVisible;

        return $this;
    }

    public function setCommentaireModere(bool $commentaireModere): self {
        $this->commentaireModere = $commentaireModere;

        return $this;
    }

    public function getMdpU(): ?string {
        return $this->mdpU;
    }

    public function setMdpU(string $mdpU): self {
        $this->mdpU = $mdpU;

        return $this;
    }

    public function getLeRole() {
        return $this->leRole;
    }

    public function getLesEvaluers() {
        return $this->lesEvaluers;
    }

    public function hasEvaluation(int $idResto) {
        if (!$this->lesEvaluers->isEmpty()) {
            foreach ($this->lesEvaluers as $eval) {
                ;
                if ($eval->getUnResto()->getId() == $idResto) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     * @param $idResto - restaurant à vérifier
     * @return boolean - renvoi vrai si l'utilisateur est propriétaire du restaurant, sinon faux.
     */
    public function estProprietaire($idResto) {
        foreach ($this->lesRestos as $resto) {
            if ($resto->getId() == $idResto) {
                return true;
            }
        }
        return false;
    }

    public function hasPanierAutreResto($idResto) {
        if (!$this->lePanier->getLesComposers()->isEmpty()) {
            for ($i = 0; $i < count($this->lePanier->getLesComposers()); $i++) {
                if ($this->lePanier->getLesComposers()[$i]->getLePlat()->getLeResto()->getId() != $idResto) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getRestoPanierEnCours() {
        if ($this->lePanier->getLesComposers()[0]->getLePlat()->getLeResto()) {
            return $this->lePanier->getLesComposers()[0]->getLePlat()->getLeResto();
        }
        return null;
    }

    public function hasCommandeResto($idR) {
        if (!$this->lesCommandes->isEmpty()) {
            for ($i = 0; $i < count($this->lesCommandes); $i++) {
                for ($j = 0; $j < count($this->lesCommandes[$i]->getLesContenirs()); $j++) {
                    if ($this->lesCommandes[$i]->getLesContenirs()[$j]->getUnPlat()->getLeResto()->getId() == $idR) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getLesRestos() {
        return $this->lesRestos;
    }

    public function setLeRole($leRole): void {
        $this->leRole = $leRole;
    }

    public function setLesEvaluers($lesEvaluers): void {
        $this->lesEvaluers = $lesEvaluers;
    }

    public function setLesRestos($lesRestos): void {
        $this->lesRestos = $lesRestos;
    }

    public function addEvaluer(?Evaluer $unEvaluer) {
        $this->lesEvaluers[] = $unEvaluer;
    }

    public function getLePanier() {
        return $this->lePanier;
    }

    public function setLePanier($lePanier): void {
        $this->lePanier = $lePanier;
    }

    public function getLesCommandes() {
        return $this->lesCommandes;
    }

    public function setLesCommandes($lesCommandes): void {
        $this->lesCommandes = $lesCommandes;
    }

    public function addCommande(?Commande $uneCommande) {
        $this->lesCommandes[] = $uneCommande;
    }

    public function getPlatsPanier() {
        $lesPlats = array();
        for ($i = 0; $i < count($this->lePanier->getLesComposers()); $i++) {
            $lesPlats[] = $this->lePanier->getLesComposers()[$i]->getLePlat();
        }
        return $lesPlats;
    }

    public function getComposers() {
        return $this->lePanier->getLesComposers();
    }

    /*
     * Méthodes implémentées de UserInterface
     */

    public function eraseCredentials() {
        
    }

    public function getPassword(): ?string {
        return $this->mdpU;
    }


    public function getRoles(): array {
        /* $nomsRoles = array();
          foreach ($this->lesRoles as $role){
          $nomsRoles[] = $role->getLibelleRole();
          }
          return $nomsRoles; */
        $roles = array();
        $roles[] = $this->leRole->getLibelleRole();
        return $roles;
    }

    public function getSalt() {
        
    }

    public function getUsername(): string {
        return $this->mailU;
    }

    public function __toString() {
        return $this->getMailU();
    }

    public function getRestoRestaurateur() {
        $mesRestos = array();
        for ($i = 0; $i < count($this->lesRestos); $i++) {
            $mesRestos[] = $this->lesRestos[$i];
        }
        return $mesRestos;
    }

}
