<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page

/**
 * Class AnnonceController
 * @package App\Controller
* @Route("/actualites", name="actualites_")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce")
     */
    public function index(Request $request, PaginatorInterface $paginator) // Nous ajoutons les paramètres requis
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Annonce::class)->findBy([],['created_at' => 'desc']);

        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    
    /**
     * @Route("/{slug}", name="annonce_article")
     */
    public function article($slug, Request $request, ContactNotification $notification, EntityManagerInterface $entityManager, Annonce $property){
        $repository = $this->getDoctrine()->getRepository(Annonce::class);
        $annonce = $repository->find($slug);
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
            if(!$annonce){
                throw $this->createNotFoundException("L'annonce recherché n'existe pas");
            }
        }
// ON instancie l'entité Commentaire
        $comment = new Comment();

//On créer l'objet formulaire
        $form = $this->createForm(CommentType::class, $comment);

        //on recupére les données saisies
        $form->handleRequest($request);

        // On verifie si le formulaire a été envoyé et si les données sont valides
        if($form->isSubmitted() && $form->isValid()){

            //ici le formulaire a été envoyé et les données sont valides
            $comment->setArticle($annonce);

            // on instencie entity
            $entityManager = $this->getDoctrine()->getManager();
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



    /**
     * @IsGranted("ROLE_USER")
     * @Route("/article/ajout", name="ajout_article")
     */
    public function ajout(Request $request,TranslatorInterface $translator)
    {
        $article = new Annonce();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsers($this->getUser());

			$image = $form->get('annoncePicture')->getData();
			if($image){
				$fichier = md5(uniqid()).'.'.$image->guessExtension();
				$image->move(
					$this->getParameter('app.path.home'),
					$fichier
				);
				$article->setAnnoncePicture($fichier);
			}

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $message = $translator->trans('Article publié avec succès');

            $this->addFlash('message', $message);
            return $this->redirectToRoute('accueil');
        }

        return $this->render('annonce/ajout.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}
