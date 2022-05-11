<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypePlat;
use App\Form\TypePlatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TypePlatController extends AbstractController {
    
    ###########################################################################
    # Ajout d'un nouveau type de plat                                         #
    ###########################################################################
    /**
     * @Route("/typeplat/new", name="new_typeplat")
     */
    public function new(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $leTypePlat = new TypePlat();
        $form = $this->createForm(TypePlatType::class, $leTypePlat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $leTypePlat = $form->getData();
            $entityManager->persist($leTypePlat);
            $entityManager->flush();
            return $this->redirectToRoute('liste_typeplat');
        }
        return $this->render('typeplat/new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }
  
    ###########################################################################
    # Liste de tous les types de plat existants                               #
    ###########################################################################
    /**
     * @Route("/typeplat/liste", name="liste_typeplat")
     */
    public function liste() {
        $entityManager = $this->getDoctrine()->getManager();
        $lesTypePlat = $entityManager->getRepository("App:TypePlat")->findAll();

        return $this->render('typeplat/liste.html.twig', [
                    'lesTypePlat' => $lesTypePlat,
        ]);
    }
    
    ###########################################################################
    # Modification d'un type de plat (id passé en parametre)                  #
    ###########################################################################
    /**
     * @Route("/typeplat/upd/{id}", name="upd_typeplat")
     */
    public function upd($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $leTypePlat = $entityManager->getRepository("App:TypePlat")->find($id);

        $form = $this->createForm(TypePlatType::class, $leTypePlat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $leTypePlat = $form->getData();
            $entityManager->persist($leTypePlat);
            $entityManager->flush();
            return $this->redirectToRoute('liste_typeplat');
        }

        return $this->render('typeplat/upd.html.twig', [
                    'form' => $form->createView()
        ]);
    }
    
    ###########################################################################
    # Suppression d'un type de plat (id passé en parametre)                   #
    ###########################################################################
    /**
     * @Route("/typeplat/del/{id}", name="del_typeplat")
     */
    public function delTypePlat($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $leTypePlat = $entityManager->getRepository("App:TypePlat")->find($id);
        $entityManager->remove($leTypePlat);
        $entityManager->flush();

        return $this->redirectToRoute('liste_typeplat');
    }
}