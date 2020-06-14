<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    /**
     * @Route("/admin", name="admin_")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * Liste des utilisateurs du site
     * 
     * @route("/utilisateurs", name="utilisateurs")
     */
    public function usersLIste(UserRepository $users){
    
        return $this->render("admin/users.html.twig", [
            'user' =>$users->findAll()
        ]);
    }

    /**
     * Modofier un utlisateur
     * @Route("ulisateur/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(User $user, Request $request){

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'message',
                'Utilisateur modifié avec succès'
            );
            return $this->redirectToRoute('admin_utilisateurs');
        }
        return $this->render('admin/edituser.html.twig', [
            'userForm' =>$form->createView()
        ]);
    }
}
