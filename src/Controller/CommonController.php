<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommonController extends AbstractController
{

        /** Méthode qui prend en charge le rendu du menu des réseaux sociaux dans le footer
     * Cette méthode ne répond à aucune route et sera appelée depuis le twig global (index.html.twig)
     * 
     */
    public function socialNetworkMenu(){
        $repository = $this->getDoctrine()->getManager()->getRepository('App:SocialNetwork');
        $datas = $repository->findAll();
        return $this->render('common/social.html.twig', [
            'social'=>$datas
        ]);
    }
}


