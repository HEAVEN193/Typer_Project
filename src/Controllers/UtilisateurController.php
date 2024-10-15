<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;




class UtilisateurController extends BaseController {

    public function updateUsername(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $newUsername = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING) ?? null;

        Utilisateur::current()->updateUserPseudo($newUsername);
        
        return $response->withHeader('Location', '/')->withStatus(302);

    }

    public function updateEmail(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $newEmail = filter_var($data['email'] ?? null, FILTER_SANITIZE_EMAIL);

        if (empty($newEmail)) {
            $_SESSION['error'] = "Veuillez fournir un email valide.";
            return $this->view->render($response, 'user-page.php');
        }

        if (Utilisateur::emailAlreadyExist($newEmail)) {
            $_SESSION['error'] = "Cet email est déjà utilisé.";
            return $this->view->render($response, 'user-page.php');
        }

        try {
            $user = Utilisateur::current();
            if ($user) {
                $user->updateUserEmail($newEmail);
                $_SESSION['success'] = "Email mis à jour avec succès.";
                return $this->view->render($response, 'user-page.php');
            } else {
                $_SESSION['error'] = "Utilisateur non connecté.";
                return $this->view->render($response, 'login-page.php');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la mise à jour de l'email";
            return $this->view->render($response, 'user-page.php');
        }
    }

    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $newPseudo = filter_var($data['pseudo'] ?? null, FILTER_SANITIZE_STRING);
        $newEmail = filter_var($data['email'] ?? null, FILTER_SANITIZE_EMAIL);

        // Vérifier si l'utilisateur est connecté
        $user = Utilisateur::current();
        if (!$user) {
            $_SESSION['error'] = "Utilisateur non connecté.";
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        // Valider le pseudo
        if (!empty($newPseudo)) {
            $user->updateUserPseudo($newPseudo);
        }

        // Valider l'email
        if (!empty($newEmail)) {
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                return $response->withHeader('Location', '/user')->withStatus(302);
            }
            if (Utilisateur::emailAlreadyExist($newEmail)) {
                $_SESSION['error'] = "Cet email est déjà utilisé.";
                return $response->withHeader('Location', '/user')->withStatus(302);
            }
            $user->updateUserEmail($newEmail);
        }

        // Message de succès
        $_SESSION['success'] = "Informations mises à jour avec succès.";
        return $response->withHeader('Location', '/')->withStatus(302);
    }

  
}
