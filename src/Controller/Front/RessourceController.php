<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RessourceController extends AbstractController
{
    /**
     * @Route("/ressource", name="ressource")
     */
    public function Ressource()
    {
        return $this->render('formation/ressources.html.twig');
    }
}