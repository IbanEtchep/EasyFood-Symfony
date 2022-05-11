<?php

namespace App\Controller;

use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController{

  /**
  * @Route("/role/new/{id}/", name="new_role_id")
  */
  public function newid($id, Request $request) {

    $form = $this->createFormBuilder()
    ->add('libelleRole',
    TextType::class,
    ['required' => true]
    )
    ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $unRole = new Role();
      $unRole->setLibelleRole($form->get("libelleRole")->getData());
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($unRole);
      $entityManager->flush();
      $unUtilisateur = $entityManager->getRepository("App:Utilisateur")->find($id);
      $unUtilisateur->setLeRole($unRole);
      $entityManager->persist($unUtilisateur);
      $entityManager->flush();
      return $this->redirectToRoute('liste_user');
    }
    return $this->render('role/new.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
  * @Route("/role/new/", name="new_role")
  */
  public function new(Request $request) {

    $form = $this->createFormBuilder()
    ->add('libelleRole',
    TextType::class,
    ['required' => true]
    )
    ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $unRole = new Role();
      $unRole->setLibelleRole($form->get("libelleRole")->getData());
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($unRole);
      $entityManager->flush();
      return $this->redirectToRoute('liste_user');
    }
    return $this->render('role/new.html.twig', array(
      'form' => $form->createView(),
    ));
  }
}
