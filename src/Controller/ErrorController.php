<?php



namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ErrorController extends AbstractController
{
    public function show404(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
    }

    public function show403(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error403.html.twig');
    }

    public function showUserNotFound(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/user_not_found.html.twig');
    }

    // Modifiez cette méthode pour accepter n'importe quel type d'exception
    public function showException(Throwable $exception): Response
    {
        // Pour les exceptions HTTP, continuez à utiliser la logique existante
        if ($exception instanceof HttpExceptionInterface) {
            if ($exception->getStatusCode() === 404) {
                return $this->show404();
            } elseif ($exception->getStatusCode() === 403) {
                return $this->show403();
            }

            // Retourner la réponse avec le code HTTP approprié
            return new Response('An error occurred', $exception->getStatusCode());
        }

        // Pour toutes les autres exceptions (comme TypeError)
        return $this->render('bundles/TwigBundle/Exception/error.html.twig', [
            'exception' => $exception,
        ]);
    }
}
