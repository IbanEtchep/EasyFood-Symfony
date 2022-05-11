<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evaluer;
use App\Entity\Resto;
use App\Entity\Utilisateur;
use App\Form\EvaluerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EvaluerController extends AbstractController {

    
    ##############################################################################
    # Modification évaluation d'un resto, id passé en paramètre                  #
    ##############################################################################
    /**
     * @Route("/upd/eval/resto/{idR}", name="upd_eval_resto")
     */
    public function updEvalResto($idR, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $leClient = $this->getUser();
        //récupération de l'évaluation en fonction de l'Utilisateur et du Resto (id passé en parametre)
        $uneEval = $entityManager->getRepository("App:Evaluer")->findOneBy([
            'leUtilisateur' => $entityManager->getRepository("App:Utilisateur")->find($leClient->getId()),
            'unResto' => $entityManager->getRepository("App:Resto")->find($idR)]);

        $form = $this->createForm(EvaluerType::class, $uneEval);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uneEval = $form->getData();
            $entityManager->persist($uneEval);
            $entityManager->flush();
            return $this->redirectToRoute('profil');
        }

        return $this->render('evaluer/upd.html.twig', [
                    'form' => $form->createView(),
                    'uneEval' => $uneEval
        ]);
    }

    ##############################################################################
    # Nouvelle évaluation d'un resto (id passé en parametre)                     #
    ##############################################################################
    /**
     * @Route("/new/eval/resto/{idR}", name="new_eval_resto")
     */
    public function newEvalResto($idR, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $leClient = $this->getUser();
        //si le client n'a pas déjà noté ce resto et qu'il a passé commande chez ce resto
        if (!($leClient->hasEvaluation($idR)) && $leClient->hasCommandeResto($idR)) {
            //nouvelle évaluation
            $uneEval = new Evaluer();
            $unResto = $entityManager->getRepository("App:Resto")->find($idR);
            //affectation du resto à l'évaluation (quel resto est évalué ?)
            $uneEval->setUnResto($unResto);
            //affectation de l'utilisateur à l'évaluation (qui a évalué le resto ?)
            $uneEval->setLeUtilisateur($leClient);

            $form = $this->createForm(EvaluerType::class, $uneEval);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $uneEval = $form->getData();
                $entityManager->persist($uneEval);
                $entityManager->flush();
                return $this->redirectToRoute('profil');
            }
            return $this->render('evaluer/new.html.twig', [
                        'form' => $form->createView(),
                        'uneEval' => $uneEval
            ]);
        } 
        //si le client a déjà noté ce resto et qu'il a passé commande chez ce resto
        elseif($leClient->hasEvaluation($idR) && $leClient->hasCommandeResto($idR)) {
            //redirection vers le controller de modification de l'évaluation
            return $this->redirectToRoute('upd_eval_resto', array('idR' => $idR));
        } 
        //sinon redirection vers le profil de l'utilisateur connecté
        else{
            return $this->redirectToRoute('profil');
        }
    }

}
