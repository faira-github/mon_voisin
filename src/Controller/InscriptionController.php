<?php

namespace App\Controller;
use App\Form\ArticleType;
use App\Entity\Annonce;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class InscriptionController extends AbstractController
{

    /**
     * @Route("/creation", name="article_create")
      * @route("/creation/{id}/edit", name="article_edit")
     */
    public function form(Annonce $article = null ,Request $request,EntityManagerInterface $entityManager)
    { 
        if(!$article){
            $article = new Annonce();
        }


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                if(!$article->getId()){
                    $article->setCreatedAt(new \DateTime());
                }
                
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('annonce_article', ['id'=> $article->getId()]);
            }
        
        return $this->render('inscription/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

}
