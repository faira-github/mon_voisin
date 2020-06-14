<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $annonces = $repository->findAll('Titre de l\'article');
        // Récupération des données de la home
        // $repository = $this->getDoctrine()->getManager()->getRepository('App:Annonce');
        // $datas = $repository->findOneBy(["active"=>1, "deleted"=>0]);
        // SELECT * FROM home WHERE active=1 AND deleted=0

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'annonces' => $annonces,
            // 'datas' => $datas,
    
        ]);
    }
    /**
     * @Route("/", name="accueil")
     */
    public function accueil() {
            // Récupération des données du slider
        $repository = $this->getDoctrine()->getManager()->getRepository('App:Slider');
        $datas3 = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $annonces = $repository->findAll('Titre de l\'article');
        // Rendu de la page
        
        return $this->render('home/accueil.html.twig',[
            'slider'=> $datas3,
            'annonces' => $annonces,
        ]);
        
    }

}
