<?php

namespace App\Controller;

use App\Event\RegisteredUserEvent;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\CodeGenerator;
use App\Service\Mailer;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @param CodeGenerator $codeGenerator
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        UserPasswordEncoderInterface $passwordEncoder,
        Request $request,
        CodeGenerator $codeGenerator,
        EventDispatcherInterface $eventDispatcher
    ) {
        $user = new User();
        $form = $this->createForm(
            UserType::class,
            $user
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );

            $user->setPassword($password);
            $user->setConfirmationCode($codeGenerator->getConfirmationCode());

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $userRegisteredEvent = new RegisteredUserEvent($user);
            $eventDispatcher->dispatch(RegisteredUserEvent::NAME, $userRegisteredEvent);

        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirm/{code}", name="email_confirmation")
     */
    public function confirmEmail(UserRepository $userRepository, string $code)
    {
        /** @var User $user */
        $user = $userRepository->findOneBy(['confirmationCode' => $code]);

        if ($user === null) {
            return new Response('404');
        }

        $user->setEnable(true);
        $user->setConfirmationCode('');

        $em = $this->getDoctrine()->getManager();

        $em->flush();

        return $this->render('security/account_confirm.html.twig', [
            'user' => $user,
        ]);
    }
}
