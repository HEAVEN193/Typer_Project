<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;




class UtilisateurController extends BaseController {

    public function updateUsername(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $newUsername = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING) ?? null;

        Utilisateur::current()->changePseudo($newUsername);
        
        return $this->view->render($response, 'home-page.php');

    }

  
}
