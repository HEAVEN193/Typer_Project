<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;


class AuthController extends BaseController{

    public function createAccount(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $pseudo = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        Utilisateur::create($pseudo, $email, $password);

        return $this->view->render($response, 'home-page.php');
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?? null;
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?? null;


        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return $this->view->render($response, 'login-page.php');
        }

        // $user = Utilisateur::fetchByEmail($email);

        // if ($user && password_verify($password, $user->motDePasse)) {
                
        //     $_SESSION['user'] = $user->email; // Stocke l'utilisateur dans la session
        //     header('Location: /profile');
        //     exit;
        // } 
        // else {
        //     $_SESSION['error'] = "Identifiants incorrects. Veuillez réessayer.";
        //     return $this->view->render($response, 'login_form.php');
        // }


        // tentative d'authentification
        try {
            $user = Utilisateur::login($email, $password);
            if($user){
                $_SESSION['user'] = $user['addressMail'];
                return $this->view->render($response, 'home-page.php');

            }


        } catch (\Exception $e) {
            $_SESSION['error'] =  $e->getMessage();
            return $this->view->render($response, 'login-page.php');
        }

    }

}