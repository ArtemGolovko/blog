<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class SecurityController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * SecurityController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return new Response($this->twig->render("security/login.html.twig", [
                'last_username' => $lastUsername,
                'error' => $error
            ])
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public  function logout()
    {
    }
}