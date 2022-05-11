<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Composer;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PanierController extends AbstractController {

    ##############################################################################
    # Ajout d'un plat (id passé en parametre) dans le panier                     #
    ##############################################################################
    /**
     * @Route("/panier/ajout/{id}/{qty}", name="add_panier")
     */
     public function ajoutPanier($id,$qty) {
         $entityManager = $this->getDoctrine()->getManager();
         $userConnecte = $this->getUser();
         $lePanier = $userConnecte->getLePanier();
         $lePlat = $entityManager->getRepository("App:Plat")->find($id);
         $idR = $lePlat->getLeResto()->getId();
         if (!($userConnecte->hasPanierAutreResto($lePlat->getLeResto()->getId()))) {
             if ($entityManager->getRepository('App:Composer')->findOneBy(['lePanier' => $lePanier, 'lePlat' => $lePlat]) == null) {
                 $leComposer = new Composer();
                 $leComposer->setLePanier($lePanier);
                 $leComposer->setLePlat($lePlat);
                 $leComposer->setQuantite($leComposer->getQuantite() + $qty);
             } elseif ($lePanier->getLesComposers() && $lePlat->getLesComposers()) {
                 $leComposer = $entityManager->getRepository('App:Composer')->findOneBy(['lePanier' => $lePanier, 'lePlat' => $lePlat]);
                 //var_dump($leComposer);
                 $leComposer->setLePanier($lePanier);
                 $leComposer->setLePlat($lePlat);
                 $leComposer->setQuantite($leComposer->getQuantite() + $qty);
             }
             $entityManager->persist($lePanier);
             $entityManager->persist($userConnecte);
             $entityManager->persist($leComposer);
             $entityManager->flush();

             return $this->redirectToRoute('liste_plats_resto', array('id' => $idR));
         }else{
             $resto=$userConnecte->getRestoPanierEnCours();
             return $this->redirectToRoute('liste_plats_resto', array('id' => $resto->getId()));
         }
     }

    ######################################################################################################
    # Suppresion d'un plat (id passé en parametre) du panier (sur la page de la liste des plats du resto)#
    ######################################################################################################
    /**
     * @Route("/panier/supp/{id}", name="supp_panier_plat")
     */
    public function suppPlat($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $userConnecte = $this->getUser();
        $lePanier = $userConnecte->getLePanier();
        $lePlat = $entityManager->getRepository("App:Plat")->find($id);
        $leResto = $lePlat->getLeResto();
        $unComposer = $entityManager->getRepository("App:Composer")->findOneBy([
            'lePlat' => $entityManager->getRepository("App:Plat")->find($lePlat),
            'lePanier' => $entityManager->getRepository("App:Panier")->find($lePanier)]);

        //si la quantité du plat du panier est égale à 1
        if ($unComposer->getQuantite() == 1) {
            //suppression de l'occurence du plat dans le panier (un composer)
            $entityManager->remove($unComposer);
            $entityManager->flush();
        }
        //si la quantité du plat du panier est différente de 1
        else {
            //décrémentation de la quantité
            $quantite = $unComposer->getQuantite();
            $unComposer->setQuantite($quantite - 1);
            $entityManager->flush();
        }
        //redirection sur la liste des plats du resto
        return $this->redirectToRoute('liste_plats_resto', array('id' => $leResto->getId()));
    }


    ##########################################################################################
    # Suppresion d'un plat (id passé en parametre) du panier (sur le profil de l'utilisateur)#
    ##########################################################################################
    /**
     * @Route("/panier/supp2/{id}", name="supp_panier_plat_2")
     */
    public function suppPlat2($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $userConnecte = $this->getUser();
        $lePanier = $userConnecte->getLePanier();
        $lePlat = $entityManager->getRepository("App:Plat")->find($id);
        $leResto = $lePlat->getLeResto();
        $unComposer = $entityManager->getRepository("App:Composer")->findOneBy([
            'lePlat' => $entityManager->getRepository("App:Plat")->find($lePlat),
            'lePanier' => $entityManager->getRepository("App:Panier")->find($lePanier)]);

        //si la quantité du plat du panier est égale à 1
        if ($unComposer->getQuantite() == 1) {
            //suppression de l'occurence du plat dans le panier (un composer)
            $entityManager->remove($unComposer);
            $entityManager->flush();
        }
        //si la quantité du plat du panier est différente de 1
        else {
            //décrémentation de la quantité
            $quantite = $unComposer->getQuantite();
            $unComposer->setQuantite($quantite - 1);
            $entityManager->flush();
        }

        //redirection vers le profil de l'utilisateur
        return $this->redirectToRoute('profil');
    }

}
