<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AideController extends AbstractController
{
    /**
     * @Route("/aide", name="aide")
     */
    public function aide()
    {
        return $this->render('aide/index.html.twig');
    }
}