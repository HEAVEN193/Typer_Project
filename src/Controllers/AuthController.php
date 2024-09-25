<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;
use Matteomcr\TyperProject\Models\Statistique;


class AuthController extends BaseController{

    public function createAccount(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $pseudo = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?? null;
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) ?? null;
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?? null;
        $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_STRING) ?? null;
        $todayDate = date("Y-m-d");

        if (empty($email) || empty($password) || empty($pseudo) || empty($passwordConfirm)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return $this->view->render($response, 'register-page.php');
        }

        if(Utilisateur::emailAlreadyExist($email)){
            $_SESSION['error'] = "Un compte est déjà associé à cette email !";
            return $this->view->render($response, 'register-page.php', [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'passwordConfirm' => $passwordConfirm
            ]);
        }

        if($password !== $passwordConfirm){
            $_SESSION['error'] =  "Les mots de passes ne correspondent pas !";
            return $this->view->render($response, 'register-page.php', [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password,
                'passwordConfirm' => $passwordConfirm
            ]);
        }


        $userId = Utilisateur::create($pseudo, $email, $password);
        Statistique::create($todayDate, $password, $userId);

        return $this->view->render($response, 'login-page.php');
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) ?? null;
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?? null;


        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            return $this->view->render($response, 'login-page.php');
        }


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