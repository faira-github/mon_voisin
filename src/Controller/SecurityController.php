<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash =$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé ! Vous pouvez maintenant vous connecter'
            );
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authentificationUtils){
        //connexion 
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUsername = $authentificationUtils->getLastUsername();
    

        //Mise en place du formulair
        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        
        
        return $this->render('security/login.html.twig', [
            'formLogin' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error !== null,
            
        ]);
    }
        /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(){}
}

