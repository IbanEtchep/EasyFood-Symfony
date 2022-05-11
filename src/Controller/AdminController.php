<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Entity\Resto;
use App\Entity\Panier;
use App\Form\UtilisateurAdminType;
use App\Form\RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController{


  ##############################################################################
  # Gestion des Utilisateurs                                                   #
  ##############################################################################

  /**
  * @Route("/admin/listeuser", name="liste_user")
  */
  public function listeUtilisateur(){

    $entityManager = $this->getDoctrine()->getManager();
    $lesUsers = $entityManager->getRepository("App:Utilisateur")->findAll();
    $lesRoles = $entityManager->getRepository("App:Role")->findAll();
    $form = $this->createForm(UtilisateurAdminType::class);
    return $this->render('admin/liste_user.html.twig', [
      'lesUsers' => $lesUsers,
      'lesRoles' => $lesRoles,
    ]);
  }
  /**
  * @Route("/admin/upd_role/{id}/{idrole}", name="upd_role_user")
  */
  public function upd_role_user($id, $idrole, Request $request) {
    $entityManager = $this->getDoctrine()->getManager();
    $leUser = $entityManager->getRepository("App:Utilisateur")->find($id);
    $leRole = $entityManager->getRepository("App:Role")->find($idrole);
    $leUser->setLeRole($leRole);
    $entityManager->persist($leUser);
    $entityManager->flush();
    return $this->redirectToRoute('liste_user');
  }

  /**
  * @Route("/admin/del_user/{id}", name="del_user")
  */
  public function delUser($id) {
    $entityManager = $this->getDoctrine()->getManager();
    $unUtilisateur = $entityManager->getRepository("App:Utilisateur")->find($id);
    $unPanier = $entityManager->getRepository("App:Panier")->find($unUtilisateur->getLePanier()->getId());
    $entityManager->remove($unPanier);
    $entityManager->remove($unUtilisateur);
    $entityManager->flush();
    return $this->redirectToRoute('liste_user');
  }

  /**
  * @Route("/admin/upd_user/{id}", name="upd_user")
  */
  public function upd_user($id, Request $request) {
    $entityManager = $this->getDoctrine()->getManager();
    $unUtilisateur = $entityManager->getRepository("App:Utilisateur")->find($id);
    $form = $this->createForm(UtilisateurAdminType::class, $unUtilisateur);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $unUtilisateur = $form->getData();
      $entityManager->persist($unUtilisateur);
      $entityManager->flush();
      return $this->redirectToRoute('liste_user');
    }
    return $this->render('admin/upd_user.html.twig', [
      'form' => $form->createView(),
    ]);
  }


  ##############################################################################
  # Gestion des Restaurateurs                                                  #
  ##############################################################################

  /**
  * @Route("/admin/liste_restorateur", name="liste_restaurateur")
  */
  public function listeRestaurateur(){

    $entityManager = $this->getDoctrine()->getManager();
    $lesRestaurateurs = $entityManager->getRepository("App:Utilisateur")->getUsersByRole("ROLE_Restaurateur");
    return $this->render('admin/liste_restaurateur.html.twig', [
      'lesRestaurateurs' => $lesRestaurateurs,
    ]);
  }

  /**
  * @Route("/admin/new_restaurant/{id}", name="new_restaurant")
  */
  public function newRestaurant($id, Request $request){

    $entityManager = $this->getDoctrine()->getManager();
    $leRestaurateur = $entityManager->getRepository("App:Utilisateur")->find($id);

    $unResto= new Resto();
    $unResto->setUnRestaurateur($leRestaurateur);
    $form = $this->createForm(RestaurantType::class, $unResto);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $unResto = $form->getData();
      $entityManager->persist($unResto);
      $entityManager->flush();
    }

    return $this->render('admin/new_restaurant.html.twig', [
      'form' => $form->createView(),
      'leRestaurateur' =>$leRestaurateur
    ]);
  }


}
