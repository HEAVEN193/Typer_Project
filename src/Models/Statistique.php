<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;

class Statistique{
    public $statID;
    public $registrationDate;
    public $motDePasse;
    public $utilisateurID;
    

    public static function fetchAll() :array
    {
        $statement = Database::connection()->prepare("SELECT * FROM Statistiques");
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetchAll();
    }

    public static function fetchByUserId(int $id) : Statistique|false
    {
        $statement = Database::connection()
        ->prepare("SELECT * FROM Statistiques WHERE utilisateurID = :id");
        $statement->execute([':id' => $id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
        return $statement->fetch();
    }




    public static function create($registrationDate, $password, $utilisateurID){
        try{
            $pdo = Database::connection();
            $stmt = $pdo->prepare("INSERT INTO Statistiques (registrationDate, motDePasse, utilisateurID) VALUES (:registrationDate, :motDePasse, :utilisateurID)");

            // Créer une variable pour le mot de passe hashé
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Passer les variables à bindParam
            $stmt->bindParam(':registrationDate', $registrationDate);
            $stmt->bindParam(':motDePasse', $hashedPassword);
            $stmt->bindParam(':utilisateurID', $utilisateurID);

            // Exécuter la requête
            $stmt->execute();
        }catch(\Exception $e){
            throw new \Exception($e);
        }
    }

   

}
