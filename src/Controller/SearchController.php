<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/rechercher", name="search")
     */
    public function search(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        
        $lesTypesDePlat = $entityManager->getRepository("App:TypePlat")->findAll();
        
        $choicesTypePlat = array();
        
        foreach ($lesTypesDePlat as $type){
            $choicesTypePlat[$type->getLibelleType()] = $type;
        }
        
        $form = $this->createFormBuilder()
                ->add("ville", TextType::class, ["label" => "Ville", "required" => false])
                ->add("plat", TextType::class, ["label" => "Plat", "required" => false])
                ->add("typePlat", ChoiceType::class, ["label" => "Type de plat", "choices" => $choicesTypePlat, "required" => false])
                ->add("min", NumberType::class, ["label" => "Prix min", "required" => false])
                ->add("max", NumberType::class, ["label" => "Prix max", "required" => false])
                ->getForm();
        
        $ville = null;
        $typePlat = null;
        $plat = null;
        $min = 0;
        $max = 1000000;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $form->getData()["ville"];
            $typePlat = $form->getData()["typePlat"];
            $plat = $form->getData()["plat"];
            $min = $form->getData()["min"];
            $max = $form->getData()["max"];
        }
                
        $lesPlats = $entityManager->getRepository("App:Plat")->search($plat, $ville, $typePlat, $min, $max);
                        
        return $this->render('recherche/recherche.html.twig', [
            "form" => $form->createView(), 
            "ville" => $ville,
            "typePlat" => $typePlat,
            "plat" => $plat,
            "max" => $max,
            "min" => $min,
            "lesPlats" => $lesPlats
            ]);
    }
}
