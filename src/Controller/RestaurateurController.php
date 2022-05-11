<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Evaluer;
use App\Entity\Resto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RestaurateurController extends AbstractController {

    ###########################################################################
    # Affichage de la liste des évaluations d'un restaurateur                 #
    ###########################################################################
    /**
     * @Route("/restaurateur/evaluations", name="liste_evaluations_restaurateur")
     */
    public function listeEvaluationsRestaurateur() {
        $entityManager = $this->getDoctrine()->getManager();
        $leRestaurateur = $this->getUser();
        $restosRestaurateur = [];
        if ($leRestaurateur->getRestoRestaurateur()) {
            $restosRestaurateur = $leRestaurateur->getRestoRestaurateur();
        }

        return $this->render('evaluer/liste_evaluations_restaurateur.html.twig', [
                    'restosRestaurateur' => $restosRestaurateur,
                    'leRestaurateur' => $leRestaurateur,
        ]);
    }

    ###########################################################################
    # Affichage de la liste des restos d'un restaurateur                      #
    ###########################################################################
    /**
     * @Route("/restaurateur/restaurants", name="liste_restos_restaurateur")
     */
    public function liste_restos_restaurateur() {
        $entityManager = $this->getDoctrine()->getManager();
        $leRestaurateur = $this->getUser()->getId();
        $lesRestos = $entityManager->getRepository("App:Resto")->getRestosByUserID($leRestaurateur);

        return $this->render('resto/liste_restos_restaurateur.html.twig', [
            'lesRestos' => $lesRestos
        ]);
    }

    ##################################################################################
    # Gestion des restaurants d'un restaurateur : affichage des plats - bouton ajout #
    ##################################################################################
    /**
     * @Route("/restaurateur/restaurant/{idResto}", name="gestion_resto_restaurateur")
     */
    public function gestion_resto_restaurateur($idResto) {
        $user = $this->getUser();
        if (!$user->estProprietaire($idResto)) {
            return $this->redirectToRoute('liste_restos_restaurateur');
        }


        $entityManager = $this->getDoctrine()->getManager();

        $leResto = $entityManager->getRepository("App:Resto")->find($idResto);

        return $this->render('resto/gestion_resto_restaurateur.html.twig', [
            'leResto' => $leResto
        ]);
    }
}
