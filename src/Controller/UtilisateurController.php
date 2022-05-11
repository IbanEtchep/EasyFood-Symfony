<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypePlat;
use App\Form\TypePlatType;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UtilisateurController extends AbstractController {
    
    ###########################################################################
    # Affichage du profil de l'utilisateur connecté                           #
    ###########################################################################
    /**
     * @Route("/profil", name="profil")
     */
    public function profil() {
        $entityManager = $this->getDoctrine()->getManager();

        return $this->render('utilisateur/profil.html.twig',[
            'total'=>0
        ]);
    }
    
    ###########################################################################
    # Modification du profil de l'utilisateur connecté                        #
    ###########################################################################
    /**
    * @Route("/profil/upd_user", name="upd_profil")
    */
    public function updProfil(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface) {
      $entityManager = $this->getDoctrine()->getManager();
      $userCo=$this->getUser();
      $form = $this->createForm(UtilisateurType::class, $userCo);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userCo = $form->getData();
        $userCo->setMdpU(
        $userPasswordHasherInterface->hashPassword(
                $userCo,
                $form->get('mdpU')->getData()
            )
        );
        $entityManager->persist($userCo);
        $entityManager->flush();
        return $this->redirectToRoute('profil');
      }
      return $this->render('utilisateur/upd_profil.html.twig', [
                  'form' => $form->createView(),
      ]);
    }
    
    
    ###########################################################################
    # Suppresion du profil de l'utilisateur connecté                          #
    ###########################################################################
    /**
    * @Route("/profil/del_user", name="del_profil")
    */
    public function delProfil() {
      $entityManager = $this->getDoctrine()->getManager();
      $userCo=$this->getUser();
      $unPanier = $entityManager->getRepository("App:Panier")->find($userCo->getLePanier()->getId());
      //suppression du panier de l'utilisateur
      $entityManager->remove($unPanier);
      $entityManager->remove($userCo);
      $entityManager->flush();
      return $this->redirectToRoute('index');
    }
    
    
    ###########################################################################
    # Modification de l'adresse postale de l'utilisateur connecté             #
    ###########################################################################
    /**
     * @Route("/upd/adr", name="upd_adr_client")
     */
    public function updAdr(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $client=$this->getUser();

        $form = $this->createFormBuilder()
                ->add('numAdrC',
                        TextType::class,
                        ['required' => true]
                )->add('rueC',
                        TextType::class,
                        ['required' => true]
                )->add('cpC',
                        TextType::class,
                        ['required' => true]
                )->add('villeC',
                        TextType::class,
                        ['required' => true]
                )
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setNumAdrC($form->get("numAdrC")->getData());
            $client->setRueC($form->get("rueC")->getData());
            $client->setCpC($form->get("cpC")->getData());
            $client->setVilleC($form->get("villeC")->getData());
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('profil');
        }
        return $this->render('utilisateur/upd_adr.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    
    
    ###############################################################################
    # Modification de la note et du commentaire EasyFood de l'utilisateur connecté#
    ###############################################################################
    /**
     * @Route("/upd/notecomm", name="add_note_comm_EF")
     */
    public function updNoteCommEF(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $client=$this->getUser();

        $form = $this->createFormBuilder()
                ->add('noteEasyFood',
                        IntegerType::class,
                        ['required' => true,
                        'attr' => ['min' => 0,'max' => 5, 'value'=>$client->getNoteEasyFood()]]
                )->add('commentaireEasyFood',
                        TextType::class,
                        ['required' => true,
                        'attr' => ['value'=>$client->getCommentaireEasyFood()]]
                )
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setNoteEasyFood($form->get("noteEasyFood")->getData());
            $client->setCommentaireEasyFood($form->get("commentaireEasyFood")->getData());
            $client->setCommentaireVisible(false);
            $client->setCommentaireModere(false);
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('profil');
        }
        return $this->render('utilisateur/upd_note_commEF.html.twig', [
                    'form' => $form->createView(),
        ]);
    }
}
