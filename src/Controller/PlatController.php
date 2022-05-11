<?php

namespace App\Controller;

use App\Service\ImageResizeService;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Resto;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use App\Form\PlatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Service\FileUploader;

class PlatController extends AbstractController {

    /**
     * @Route("/resto/plats/new/{idResto}/", name="new_plat")
     */
    public function newPlat(Request $request, $idResto, FileUploader $fileUploader) {

        $user = $this->getUser();
        if (!$user->estProprietaire($idResto)) {
            return $this->redirectToRoute('liste_restos_restaurateur');
        }
        
        $unPlat = new Plat();
        $entityManager = $this->getDoctrine()->getManager();
        $unResto = $entityManager->getRepository("App:Resto")->find($idResto);
        $unPlat->setLeResto($unResto);
        $unPlat->setPlatVisible(false);
        $unPlat->setPlatModere(false);
        $unPlat->setImageFilename("empty.png");
        $form = $this->createForm(PlatType::class, $unPlat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unPlat = $form->getData();
            $entityManager->persist($unPlat);
            $entityManager->flush();
            return $this->redirectToRoute('gestion_resto_restaurateur', ["idResto" => $unPlat->getLeResto()->getId()]);
        }
        return $this->render('plat/new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/resto/plats/edit/{id}", name="upd_plat")
     */
    public function editPlat(Request $request, $id, FileUploader $fileUploader, ImageResizeService $imageResize) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $unPlat = $entityManager->getRepository("App:Plat")->find($id);

        $user = $this->getUser();
        if (!$user->estProprietaire($unPlat->getLeResto()->getId())) {
            return $this->redirectToRoute('liste_restos_restaurateur');
        }

        $form = $this->createForm(PlatType::class, $unPlat);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $unPlat = $form->getData();
            
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $unPlat->setImageFilename($imageFileName);

                $fullSizeImgWebPath = $fileUploader->getTargetDirectory().'/'.$unPlat->getImageFilename();

                $imageResize->writeThumbnail($fullSizeImgWebPath, 300, 300);
            }
            $entityManager->persist($unPlat);
            $entityManager->flush();
            return $this->redirectToRoute('gestion_resto_restaurateur', ["idResto" => $unPlat->getLeResto()->getId()]);
        }
        
        return $this->render('plat/upd.html.twig', array(
                    'unPlat' => $unPlat,
                    'form' => $form->createView()
        ));
    }

}
