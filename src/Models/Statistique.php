<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;
use Matteomcr\TyperProject\Models\Test;

/**
 * Classe représentant les statistiques d'un utilisateur.
 * 
 * Cette classe gère les informations liées aux statistiques d'un utilisateur, 
 * telles que le nombre de tests de dactylographie effectués, le WPM le plus élevé, 
 * et le dernier score enregistré. Elle permet également de créer de nouvelles entrées 
 * dans la base de données pour un utilisateur donné.
 */
class Statistique
{
    /**
     * Identifiant unique de la statistique.
     * @var int
     */
    public $statID;

    /**
     * Date d'enregistrement de la statistique.
     * @var string
     */
    public $registrationDate;

    /**
     * Mot de passe de l'utilisateur (stocké sous forme hachée).
     * @var string
     */
    public $motDePasse;

    /**
     * Identifiant de l'utilisateur auquel cette statistique est liée.
     * @var int
     */
    public $utilisateurID;

    /**
     * Récupère le nombre total de tests de dactylographie effectués par l'utilisateur.
     * 
     * Cette méthode utilise la classe Test pour compter le nombre de tests associés à ce statID.
     * 
     * @return int|null Retourne le nombre de tests effectués par l'utilisateur, ou null si aucune statistique n'est trouvée.
     */
    public function getNumberOfTypingTest(): int|null
    {
        return Test::NumberOfTypingTestByStatId($this->statID);
    }

    /**
     * Récupère le WPM le plus élevé pour l'utilisateur.
     * 
     * Cette méthode interroge la classe Test pour récupérer le score WPM maximum pour cet utilisateur.
     * 
     * @return int|null Retourne le score WPM le plus élevé, ou null si aucune statistique n'est trouvée.
     */
    public function getHighestScore(): int|null
    {
        return Test::getHighestWpmByStatId($this->statID);
    }

    /**
     * Récupère le dernier score WPM enregistré pour l'utilisateur.
     * 
     * Cette méthode utilise la classe Test pour récupérer le dernier score WPM pour cet utilisateur.
     * 
     * @return int|null Retourne le dernier score WPM, ou null si aucune statistique n'est trouvée.
     */
    public function getLastScore(): int|null
    {
        return Test::getLastScoreByStatId($this->statID);
    }

    /**
     * Crée une nouvelle statistique pour un utilisateur.
     * 
     * Cette méthode insère une nouvelle entrée dans la table des statistiques pour un utilisateur donné.
     * Le mot de passe est haché avant d'être inséré dans la base de données.
     * 
     * @param string $registrationDate La date d'enregistrement de la statistique.
     * @param string $password Le mot de passe de l'utilisateur (sera haché avant l'insertion).
     * @param int $utilisateurID L'identifiant de l'utilisateur auquel cette statistique est liée.
     * 
     * @throws \Exception Si une erreur survient lors de la création de la statistique.
     * 
     * @return void
     */
    public static function create($registrationDate, $password, $utilisateurID)
    {
        try {
            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Connexion à la base de données et insertion
            $pdo = Database::connection();
            $stmt = $pdo->prepare("
                INSERT INTO Statistiques (registrationDate, motDePasse, utilisateurID) 
                VALUES (:registrationDate, :motDePasse, :utilisateurID)
            ");
            $stmt->bindParam(':registrationDate', $registrationDate);
            $stmt->bindParam(':motDePasse', $hashedPassword);
            $stmt->bindParam(':utilisateurID', $utilisateurID);
            $stmt->execute();

        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }



    /* ------------ NON UTILISE -------------*/

    public static function fetchAll() :array
    {
        $statement = Database::connection()->prepare("SELECT * FROM Statistiques");
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetchAll();
    }

    public static function fetchByUserId(int $id) : Statistique|false
    {
        $statement = Database::connection()->prepare("SELECT * FROM Statistiques WHERE utilisateurID = :id");
        $statement->execute([':id' => $id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetch();
    }



   

}
