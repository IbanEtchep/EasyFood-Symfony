<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Resto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RestoController extends AbstractController {
    ###########################################################################
    # Liste des restos existants                                              #
    ###########################################################################

    /**
     * @Route("/resto/liste", name="liste_restos")
     */
    public function listeRestos() {
        $entityManager = $this->getDoctrine()->getManager();
        $lesRestos = $entityManager->getRepository("App:Resto")->findAll();

        return $this->render('resto/liste.html.twig', [
                    'lesRestos' => $lesRestos,
        ]);
    }

    ###########################################################################
    # Affichage des plats d'un resto (id passé en parametre de la fonction)   #
    # Affichage du panier du client                                           #
    ###########################################################################

    /**
     * @Route("/resto/plats/panier/{id}", name="liste_plats_resto")
     */
    public function liste_plats_resto(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $leResto = $entityManager->getRepository("App:Resto")->find($id);
        $lesPlats = array();
        if ($leResto->getLesPlats()) {
            $lesPlats = $leResto->getLesPlatsVisibles();
        }

        $user = $this->getUser();
        $lesPlatsPanier = array();
        if ($user->getLePanier()) {
            $lesPlatsPanier = $user->getComposers();
        }
        $forms2=array();
        if ($leResto->getLesPlats() && $user->getLePanier()) {
            foreach ($lesPlats as $plat) {
                $form = $this->createFormBuilder()
                        ->add('quantite',
                                IntegerType::class,
                                ['required' => true,
                                    'attr' => ['min' => 1, 'max' => 10]]
                        )->add('idPlat',
                                TextType::class,
                                ['required' => true]
                        )
                        ->getForm();
                $forms[$plat->getId()] = $form;
                $form->handleRequest($request);
            }


            
            foreach ($lesPlats as $plat) {
                if ($forms[$plat->getId()]->isSubmitted() && $forms[$plat->getId()]->isValid()) {
                    $qty = $forms[$plat->getId()]->get("quantite")->getData();
                    $idPlat = $forms[$plat->getId()]->get("idPlat")->getData();
                    return $this->redirectToRoute('add_panier', array('id' => $idPlat, 'qty' => $qty));
                }
            }

            foreach ($lesPlats as $plat) {
                $forms2[$plat->getId()] = $forms[$plat->getId()]->createView();
            }
        }
        return $this->render('resto/liste_plats.html.twig', [
                    'lesPlats' => $lesPlats,
                    'leResto' => $leResto,
                    'user' => $user,
                    'lesPlatsPanier' => $lesPlatsPanier,
                    'total' => 0,
                    'forms' => $forms2
        ]);
    }

    ###########################################################################
    # Affichage détail resto, récupération en fonction de son id              #
    ###########################################################################

    /**
     * @Route("/resto/detail/{id}", name="detail_resto")
     */
    public function detailResto($id) {
        $entityManager = $this->getDoctrine()->getManager();
        //recuperation du resto en fonction de son id passé en parametre
        $leResto = $entityManager->getRepository("App:Resto")->find($id);

        return $this->render('resto/detail.html.twig', [
                    'leResto' => $leResto
        ]);
    }

}
