<?php
namespace App\Security;

use App\Entity\Participant;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ParticipantChecker implements UserCheckerInterface
{
    private $requestStack;
    private $router;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

    }

    public function checkPreAuth(UserInterface $participant): void
    {
        if (!$participant instanceof Participant) {
            return;
        }

        if (!$participant->isActif()) {
            // Stocker un message personnalisé dans la session
            $currentRequest = $this->requestStack->getCurrentRequest();
            if ($currentRequest) {
                $currentRequest->getSession()->set('compte_inactif_message',
                    'Votre compte est désactivé. Veuillez contacter l\'administrateur manu@manu.fr.'
                );
            }

            throw new CustomUserMessageAuthenticationException(
                'Votre compte est désactivé. Veuillez contacter l\'administrateur manu@manu.fr.'
            );
        }
    }

    public function checkPostAuth(UserInterface $participant): void
    {
        // Méthode optionnelle pour des vérifications supplémentaires
    }
}