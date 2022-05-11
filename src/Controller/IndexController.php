<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
 {
     /**
      * @Route("/", name="index")
      */
     public function index()
     {
        date_default_timezone_set('Europe/Paris');
        return $this->render('default/index.html.twig'); // $this->render() retourne un objet Response
     }
}
