<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Evaluer;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class ModController extends AbstractController{


  ///////////////////////
  //GESTION COMMENTAIRE//
  ///////////////////////

  /**
  * @Route("/mod/listecom", name="liste_com")
  */
  public function listeCommentaire(){

    $entityManager = $this->getDoctrine()->getManager();
    $lesClients = $entityManager->getRepository("App:Utilisateur")->getUsersByRole("ROLE_Client");
    return $this->render('mod/liste_com.html.twig', [
      'lesClients' => $lesClients,
    ]);
  }

  /**
  * @Route("/mod/accept_com/{id}", name="accept_com")
  */
  public function acceptCommentaire($id){
    $entityManager = $this->getDoctrine()->getManager();
    $unUtilisateur = $entityManager->getRepository("App:Utilisateur")->find($id);
    $unUtilisateur->setCommentaireVisible(true);
    $unUtilisateur->setCommentaireModere(true);
    $entityManager->persist($unUtilisateur);
    $entityManager->flush();
    return $this->redirectToRoute('liste_com');
  }

  /**
  * @Route("/mod/deny_com/{id}", name="deny_com")
  */
  public function denyCommentaire($id){
    $entityManager = $this->getDoctrine()->getManager();
    $unUtilisateur = $entityManager->getRepository("App:Utilisateur")->find($id);
    $unUtilisateur->setCommentaireVisible(false);
    $unUtilisateur->setCommentaireModere(true);
    $entityManager->persist($unUtilisateur);
    $entityManager->flush();
    return $this->redirectToRoute('liste_com');
  }

  //////////////////////
  //GESTION EVALUATION//
  //////////////////////

  /**
  * @Route("/mod/listeeval", name="liste_eval")
  */
  public function listeEvaluation(){

    $entityManager = $this->getDoctrine()->getManager();
    $lesClients = $entityManager->getRepository("App:Utilisateur")->getUsersByRole("ROLE_Client");
    $lesEvals = $entityManager->getRepository("App:Evaluer")->findAll();
    return $this->render('mod/liste_eval.html.twig', [
      'lesClients' => $lesClients,
      'lesEvals' =>$lesEvals
    ]);
  }

  /**
  * @Route("/mod/accept_eval/{idu}/{idr}", name="accept_eval")
  */
  public function acceptEval($idu,$idr){
    $entityManager = $this->getDoctrine()->getManager();
    $uneEval = $entityManager->getRepository("App:Evaluer")->findOneBy([
      'leUtilisateur' => $entityManager->getRepository("App:Utilisateur")->find($idu),
      'unResto' => $entityManager->getRepository("App:Resto")->find($idr)]);
    $uneEval->setEvaluationVisible(true);
    $uneEval->setEvaluationModere(true);
    $entityManager->persist($uneEval);
    $entityManager->flush();
    return $this->redirectToRoute('liste_eval');
  }

  /**
  * @Route("/mod/deny_eval/{idu}/{idr}", name="deny_eval")
  */
  public function denyEval($idu,$idr){
    $entityManager = $this->getDoctrine()->getManager();
    $uneEval = $entityManager->getRepository("App:Evaluer")->findOneBy([
    'leUtilisateur' => $entityManager->getRepository("App:Utilisateur")->find($idu),
    'unResto' => $entityManager->getRepository("App:Resto")->find($idr)]);
    $uneEval->setEvaluationVisible(false);
    $uneEval->setEvaluationModere(true);
    $entityManager->persist($uneEval);
    $entityManager->flush();
    return $this->redirectToRoute('liste_eval');
  }

  ///////////////////////
  //////GESTION PLAT/////
  ///////////////////////

  /**
  * @Route("/mod/listeplat", name="liste_plat")
  */
  public function listePlats(){
    $entityManager = $this->getDoctrine()->getManager();
    $lesPlats = $entityManager->getRepository("App:Plat")->findAll();
    return $this->render('mod/liste_plat.html.twig', [
      'lesPlats' => $lesPlats,
    ]);
  }
  /**
  * @Route("/mod/accept_plat/{id}", name="accept_plat")
  */
  public function acceptPlat($id){
    $entityManager = $this->getDoctrine()->getManager();
    $unPlat = $entityManager->getRepository("App:Plat")->find($id);
    $unPlat->setPlatVisible(true);
    $unPlat->setPlatModere(true);
    $entityManager->persist($unPlat);
    $entityManager->flush();
    return $this->redirectToRoute('liste_plat');
  }

  /**
  * @Route("/mod/deny_plat/{id}", name="deny_plat")
  */
  public function denyPlat($id){
    $entityManager = $this->getDoctrine()->getManager();
    $unPlat = $entityManager->getRepository("App:Plat")->find($id);
    $unPlat->setPlatVisible(false);
    $unPlat->setPlatModere(true);
    $entityManager->persist($unPlat);
    $entityManager->flush();
    return $this->redirectToRoute('liste_plat');
 }
}
