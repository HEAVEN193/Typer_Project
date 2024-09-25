<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;
use Matteomcr\TyperProject\Models\Statistique;


class Utilisateur{
    public $utilisateurID;
    public $pseudo;
    public $addressMail;
    public $motdePasse;
    

    public static function fetchAll() :array
    {
        $statement = Database::connection()->prepare("SELECT * FROM Utilisateurs");
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetchAll();
    }

    public static function fetchByEmail(string $email) : Utilisateur|false
    {
        $statement = Database::connection()
        ->prepare("SELECT * FROM Utilisateurs WHERE addressMail = :email");
        $statement->execute([':email' => $email]);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetch();
    }

    public static function current(): Utilisateur|null
    {
        // if (!isset($_SESSION)) {
        //     session_start();
        // }
        static $current = null;

        if(!$current){
            $email = $_SESSION['user'] ?? null;

            if($email != null){
                $current = $email ? static::fetchByEmail($email) : new static;
            }
        }

        return $current;
    }

    public function getStatistique(): Statistique|null
    {
        return Statistique::fetchByUserId($this->utilisateurID);
    }

    public static function emailAlreadyExist($email) :bool{
        $statement = Database::connection()->prepare("SELECT * FROM Utilisateurs WHERE addressMail = :email");;
        $statement->execute([':email' => $email]);
        $user = $statement->fetch(\PDO::FETCH_ASSOC);
        if($user){
            return true;
        }
        return false;
    }


    

    public static function updateUserPassword($idUser, $newPass){
        $pdo = Database::connection();
        $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE UTILISATEUR SET motDePasse = ? WHERE idUtilisateur = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hashedPassword, $idUser]);
        $_SESSION['user']['motDePasse'] = $newPass;
    }


    public static function create($pseudo, $mail, $password){
        try{
            $pdo = Database::connection();
            $stmt = $pdo->prepare("INSERT INTO Utilisateurs (pseudo, addressMail, motDePasse) VALUES (:pseudo, :addressMail, :motDePasse)");

            // Créer une variable pour le mot de passe hashé
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Passer les variables à bindParam
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':addressMail', $mail);
            $stmt->bindParam(':motDePasse', $hashedPassword);

            // Exécuter la requête
            $stmt->execute();

            return $pdo->lastInsertId();
        }catch(\Exception $e){
            throw new \Exception("Email vide !");
        }
    }

    public static function login($email, $password) {

        $pdo = Database::connection();

        $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE addressMail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            // Vérifie si le mot de passe correspond
            if (password_verify($password, $user['motDePasse'])) {
                return $user;
            } else {
                throw new \Exception("Mot de passe incorrect !");
            }
        } else {
            // Email n'existe pas
            throw new \Exception("Email inexistant !");
        }
    }

}
