<?php

declare(strict_types=1);

namespace App\EventSubscriber;


use App\Event\RegisteredUserEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * UserSubscriber constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RegisteredUserEvent::NAME => "onUserRegister"
        ];
    }

    /**
     * @param RegisteredUserEvent $registeredUserEvent
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserRegister(RegisteredUserEvent $registeredUserEvent)
    {
        $this->mailer->sendConfirmationMessage($registeredUserEvent->getRegisteredUser());
    }
}