<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;




class HomeController extends BaseController {
    public function showHomePage(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        return $this->view->render($response, 'home-page.php');
    }

    public function showRegisterPage(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        return $this->view->render($response, 'register-page.php');
    }

    public function showLoginPage(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        return $this->view->render($response, 'login-page.php');
    }
    public function showUserPage(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        // Si l'utilisateur n'est pas connécté -> renvoie page login
        if(Utilisateur::current())
            return $this->view->render($response, 'user-page.php');
        else    
            return $response->withHeader('Location', '/login')->withStatus(302);

    }
}
