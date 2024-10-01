<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;
use Matteomcr\TyperProject\Models\Statistique;

/**
 * Classe représentant un utilisateur de l'application.
 * 
 * Cette classe gère les informations relatives à un utilisateur, telles que son pseudo, son email,
 * et son mot de passe. Elle permet également de récupérer les statistiques de l'utilisateur,
 * vérifier si un email existe déjà, et gérer les connexions et créations de comptes.
 */
class Utilisateur
{
    /**
     * Identifiant unique de l'utilisateur.
     * 
     * @var int
     */
    public $utilisateurID;

    /**
     * Pseudo de l'utilisateur.
     * 
     * @var string
     */
    public $pseudo;

    /**
     * Adresse email de l'utilisateur.
     * 
     * @var string
     */
    public $addressMail;

    /**
     * Mot de passe de l'utilisateur (stocké sous forme hachée).
     * 
     * @var string
     */
    public $motdePasse;


    /**
     * Récupère un utilisateur en fonction de son adresse email.
     * 
     * @param string $email L'adresse email de l'utilisateur à rechercher.
     * 
     * @return Utilisateur|false Retourne un objet Utilisateur si l'email est trouvé, ou false sinon.
     */
    public static function fetchByEmail(string $email) : Utilisateur|false
    {
        $statement = Database::connection()->prepare("SELECT * FROM Utilisateurs WHERE addressMail = :email");
        $statement->execute([':email' => $email]);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetch();
    }

    /**
     * Récupère l'utilisateur actuellement connecté.
     * 
     * Cette méthode utilise la session pour déterminer si un utilisateur est connecté.
     * Si un utilisateur est trouvé via son adresse email, il est retourné.
     * 
     * @return Utilisateur|null Retourne l'utilisateur actuel ou null s'il n'est pas connecté.
     */
    public static function current(): Utilisateur|null
    {
        static $current = null;

        if (!$current) {
            $email = $_SESSION['user'] ?? null;

            if ($email != null) {
                $current = $email ? static::fetchByEmail($email) : new static;
            }
        }

        return $current;
    }

    /**
     * Récupère les statistiques de l'utilisateur.
     * 
     * @return Statistique|null Les statistiques associées à l'utilisateur ou null si aucune statistique n'existe.
     */
    public function getStatistique(): Statistique|null
    {
        return Statistique::fetchByUserId($this->utilisateurID);
    }

    /**
     * Récupère le nombre total de tests de dactylographie effectués par l'utilisateur.
     * 
     * @return int|null Le nombre de tests effectués ou null si aucune statistique n'est trouvée.
     */
    public function getNumberOfTypingTest(): int|null
    {
        return $this->getStatistique()->getNumberOfTypingTest();
    }

    /**
     * Récupère le meilleur score (WPM le plus élevé) de l'utilisateur.
     * 
     * @return int|null Le meilleur score ou null si aucune statistique n'est trouvée.
     */
    public function getHighestScore(): int|null
    {
        return $this->getStatistique()->getHighestScore();
    }

    /**
     * Récupère le dernier score de dactylographie de l'utilisateur.
     * 
     * @return int|null Le dernier score ou null si aucune statistique n'est trouvée.
     */
    public function getLastScore(): int|null
    {
        return $this->getStatistique()->getLastScore();
    }

    /**
     * Vérifie si une adresse email existe déjà dans la base de données.
     * 
     * @param string $email L'adresse email à vérifier.
     * 
     * @return bool Retourne true si l'email existe, false sinon.
     */
    public static function emailAlreadyExist($email): bool
    {
        $statement = Database::connection()->prepare("SELECT * FROM Utilisateurs WHERE addressMail = :email");
        $statement->execute([':email' => $email]);
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        return $user ? true : false;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     * 
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $mail L'adresse email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur (sera haché avant insertion).
     * 
     * @return int L'ID du nouvel utilisateur créé.
     * @throws \Exception Si un problème survient lors de la création (par exemple, email vide).
     */
    public static function create($pseudo, $mail, $password)
    {
        try {
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
        } catch (\Exception $e) {
            throw new \Exception("Email vide !");
        }
    }

    /**
     * Connecte un utilisateur en vérifiant son email et mot de passe.
     * 
     * @param string $email L'adresse email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * 
     * @return array Les informations de l'utilisateur connecté.
     * @throws \Exception Si l'email ou le mot de passe est incorrect.
     */
    public static function login($email, $password)
    {
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



    /* ------------ NON UTILISE -------------*/

    public static function fetchAll() :array
    {
        $statement = Database::connection()->prepare("SELECT * FROM Utilisateurs");
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetchAll();
    }

    public static function updateUserPassword($idUser, $newPass){
        $pdo = Database::connection();
        $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE UTILISATEUR SET motDePasse = ? WHERE idUtilisateur = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hashedPassword, $idUser]);
        $_SESSION['user']['motDePasse'] = $newPass;
    }

    public function getIdStatistique(): int|null
    {
        return Statistique::fetchByUserId($this->utilisateurID)->statID;
    }

}
