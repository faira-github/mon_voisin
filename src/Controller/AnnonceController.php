<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Form\CommentType;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce")
     */
    public function index()
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
    
    /**
     * @Route("/{id}", name="annonce_article")
     */
    public function article($id, Request $request, ContactNotification $notification, EntityManagerInterface $entityManager, Annonce $property){
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $annonce = $repository->find($id);
        $contact = new Contact();
        $contact->setProperty($property);
        $formulaire = $this->createForm(ContactType::class, $contact); 
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('annonce_article',[
                'id' =>  $property->getid(),
                
            ]);
        }

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setArticle($annonce);
            $entityManager->persist($comment);
            $entityManager->flush();
return $this->redirectToRoute('annonce_article', ['id' =>$annonce->getId()]);
        }
        return $this->render('annonce/article.html.twig', [
            'annonce' => $annonce,
            'commentForm' =>$form->createView(),
            'Contactform' =>$formulaire->createView()
        ]);
    }
}
