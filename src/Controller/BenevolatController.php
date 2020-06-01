<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BenevolatController extends AbstractController
{
    /**
     * @Route("/benevolat", name="benevolat")
     */
    public function index()
    {
        return $this->render('benevolat/index.html.twig', [
            'controller_name' => 'BenevolatController',
        ]);
    }
}
