<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
    public function accountInfo()
{
    // allow any authenticated user - we don't care if they just
    // logged in, or are logged in via a remember me cookie
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

    // ...
}

public function resetPassword()
{
    // require the user to log in during *this* session
    // if they were only logged in via a remember me cookie, they
    // will be redirected to the login page
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // ...
}
}
