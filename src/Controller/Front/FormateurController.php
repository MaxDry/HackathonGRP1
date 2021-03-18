<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="formateur")
     */
    public function formateur()
    {
        return $this->render('formateur/index.html.twig');
    }
}