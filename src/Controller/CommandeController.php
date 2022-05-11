<?php

namespace App\Controller;

use DateInterval;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Entity\Composer;
use App\Entity\Contenir;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\FormError;

class CommandeController extends AbstractController {

    
    ##############################################################################
    # Affichage du détail d'une commande en fonction de son id passé en parametre#
    ##############################################################################
    /**
     * @Route("/commande/detail/{id}", name="detail_commande")
     */
    public function detailCommande($id) {
        $entityManager = $this->getDoctrine()->getManager();
        //recuperation du resto en fonction de son id passé en parametre
        $uneCommande = $entityManager->getRepository("App:Commande")->find($id);

        //si l'utilisateur connecté est l'utilisateur qui a passé cette commande
        //affichage du détail
        if ($this->getUser() == $uneCommande->getLeUtilisateur()) {
            $lesContenirs = $uneCommande->getLesContenirs();
            $prixTotal = $uneCommande->getPrixTotalCommande();
            

            return $this->render('commande/detail.html.twig', [
                        'uneCommande' => $uneCommande,
                        'lesContenirs' => $lesContenirs,
                        'prixTotal' => $prixTotal,
            ]);
        } 
        //sinon affichage du profil de l'utilisateur connecté
        else {
            return $this->redirectToRoute('profil');
        }
    }
    
    
    ##############################################################################
    # Création d'une nouvelle commande                                           #
    ##############################################################################
    /**
     * @Route("/commande/new", name="new_commande")
     */
    public function newCommande(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        //récupération du panier de l'utilisateur connecté
        $lePanier=$this->getUser()->getLePanier();
        //date et heure actuelle
        $dt = new \DateTime();
        //ajout de 15 min à la date et l'heure actuelle
        $dt->add(new DateInterval('PT15M'));
        //création du formulaire
        //date minimum saisie par l'utilisateur:date et heure actuelle+15 min(le temps de préparer la commande)
        $form = $this->createFormBuilder()
                ->add('commentaireClient',
                        TextType::class
                )
                ->add('dateLivr',
                        DateTimeType::class,
                        ['required' => true, 'data' => $dt,'widget' => 'single_text',
                            'attr' => ['min' => $dt->format('Y-m-d\TH:i:s')], ]
                )
                ->add('modeReglement', ChoiceType::class, array(
                    'choices' => array(
                        'Carte bleu' => "Carte bleu",
                        'Liquide' => "Liquide",
                    ),
                    'expanded' => true,
                    'multiple' => false, 'required' => true
                ))
                ->getForm();
        $form->handleRequest($request);
        //si l'utilisateur a cliqué sur le bouton submit
        if($form->isSubmitted()) {
            $dateLivr = $form->get("dateLivr")->getData();
            $leResto = $lePanier->getLesComposers()->first()->getLePlat()->getLeResto();
            //si le resto n'est pas ouvert à l'heure de livraison saisie
            if (!$leResto->isHeureOuverture($dateLivr)) {
                //affichage d'une erreur
                $form->get("dateLivr")->addError(new FormError("Le restaurant n'est pas ouvert à cette heure là."));
            }
            
            //si le formulaire est valide
            if($form->isValid()) {
                //création de la commande
                $laCommande = new Commande();
                //date de commande = date aujourd'hui
                $laCommande->setDateC(new \DateTime());
                //utilisateur qui a commandé : utilisateur (client) connecté
                $laCommande->setLeUtilisateur($this->getUser());
                //récupération des données saisies par l'utilisateur
                $laCommande->setCommentaireClientC($form->get("commentaireClient")->getData());
                $laCommande->setDateLivrC($form->get("dateLivr")->getData());
                $laCommande->setModeReglementC($form->get("modeReglement")->getData());
                $leContenir=array();
                for($i=0;$i<count($lePanier->getLesComposers());$i++){
                    //mettre le plat et quantite de compose (plats dans le panier) dans contenir (plats de la commande)
                    //supprimer le composer
                    //autant de contenir que de composer donc que de plat qu'il y a dans le panier
                    $leContenir[$i]=new Contenir;
                    //récupération de chaque plat du panier
                    $leContenir[$i]->setUnPlat($lePanier->getLesComposers()[$i]->getLePlat());
                    //récupération de chaque quantité du plat du panier
                    $leContenir[$i]->setQuantite($lePanier->getLesComposers()[$i]->getQuantite());
                    $leContenir[$i]->setLaCommande($laCommande);
                    $entityManager->persist(($leContenir[$i]));
                    //suppression de chaque occurence de composer du panier de l'utilisateur
                    $entityManager->remove($lePanier->getLesComposers()[$i]);
                }
                $entityManager->persist($laCommande);
                $entityManager->flush();
                return $this->redirectToRoute('detail_commande', array('id' => $laCommande->getId()));
            }
        }
        return $this->render('commande/new.html.twig', [
                    'form' => $form->createView(),
                    'lesComposers'=> $lesComposers=$lePanier->getLesComposers(),
                    'total'=>0
        ]);
    }

}
