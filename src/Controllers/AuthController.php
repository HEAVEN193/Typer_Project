<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;
use Matteomcr\TyperProject\Models\Statistique;
use Exception;


class AuthController extends BaseController{

    public function createAccount(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Récupère les données entrées par l'utilisateur
        $data = $request->getParsedBody();
        $pseudo = filter_var($data['username'] ?? null, FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'] ?? null, FILTER_SANITIZE_EMAIL);
        $password = filter_var($data['password'] ?? null, FILTER_SANITIZE_STRING);
        $passwordConfirm = filter_var($data['passwordConfirm'] ?? null, FILTER_SANITIZE_STRING);
        $todayDate = date("Y-m-d");

        // Si les informations ne sont pas complètes
        if (empty($email) || empty($password) || empty($pseudo) || empty($passwordConfirm)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return $this->view->render($response, 'register-page.php');
        }

        // Si l'email est déjà associé à un compte 
        if (Utilisateur::emailAlreadyExist($email)) {
            $_SESSION['error'] = "Un compte est déjà associé à cet email !";
            return $this->view->render($response, 'register-page.php', [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'passwordConfirm' => $passwordConfirm
            ]);
        }

        // Si les mots de passe ne sont pas les mêmes
        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas !";
            return $this->view->render($response, 'register-page.php', [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'passwordConfirm' => $passwordConfirm
            ]);
        }

        // Crée utilisateur et ses statistiques
        try {
            $userId = Utilisateur::create($pseudo, $email, $password);
            Statistique::create($todayDate, $password, $userId);
            return $this->view->render($response, 'login-page.php');
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la création du compte : " . $e->getMessage();
            return $this->view->render($response, 'register-page.php', [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'passwordConfirm' => $passwordConfirm
            ]);
        }
    }

    /**
     * Connecte un utilisateur.
     * 
     * @param ServerRequestInterface $request La requête HTTP.
     * @param ResponseInterface $response La réponse HTTP.
     * @param array $args Les arguments de la route.
     * 
     * @return ResponseInterface La réponse HTTP.
     */

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
         // Récupère les données entrées par l'utilisateur
         $data = $request->getParsedBody();
         $email = filter_var($data['username'] ?? null, FILTER_SANITIZE_EMAIL);
         $password = filter_var($data['password'] ?? null, FILTER_SANITIZE_STRING);
 
         // Si les informations ne sont pas complètes
         if (empty($email) || empty($password)) {
             $_SESSION['error'] = "Veuillez remplir tous les champs.";
             return $this->view->render($response, 'login-page.php');
         }
 
         // Tentative d'authentification
         try {
             $user = Utilisateur::login($email, $password);
             if ($user) {
                 $_SESSION['user'] = $user['addressMail'];
                 return $this->view->render($response, 'home-page.php');
             }
         } catch (Exception $e) {
             $_SESSION['error'] = $e->getMessage();
             return $this->view->render($response, 'login-page.php');
         }

    }

    /**
     * Déconnecte un utilisateur.
     * 
     * @return void
     */
    public function logout(): void
    {
        if (isset($_SESSION['user'])) {
            $_SESSION = [];

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
        }
        header('Location: /');
        exit;
    }

    


}