<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Doctrine\ORM\EntityManagerInterface;




class UserAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;
    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }
 /**
     * La méthode getCredentials est immédiatement appelée si supports a renvoyé true
     */
    public function getCredentials(Request $request)
    {
        //dump($request->request->all());die;
        $credentials = [
            'username' => $request->request->get('registration')['username'],
            'password' => $request->request->get('registration')['password'],
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );
        return $credentials;
    }
 /**
     * La méthode getUser est appelée tout de suite après getCredentials et avec le tableau renvoyé
     * par cette dernière en tant que premier argument.
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //dd($credentials);
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        // Load / create our user however you need.
        // You can do this by calling the user provider, or with custom logic here.
        //$user = $userProvider->loadUserByUsername($credentials['email']);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);

        // var_dump($user->getFirstName());
        // die;

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }
/**
     * La méthode checkCredentials est appelée après getUser(). Si cette dernière à renvoyé null, le processus
     * s'arrête. $user est la valeur retournée par getUser (null ou un objet User)
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // A decommenter pour voir si isPasswordValid renvoie true ou false
        // $test = $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        // dd($test);
        // A decommenter pour voir le mot de passe encodé
        // $encodedPassword = $this->passwordEncoder->encodePassword($user, $credentials['password']);
        // dd($encodedPassword );
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }
    /**
     * La méthode onAuthenticationSuccess est déclenchée automatiquement si checkCredentials return true
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

    return new RedirectResponse($this->urlGenerator->generate('home'));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('app_login');
    }
}
