<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;

class Test{
    public $testID;
    public $language;
    public $duration;
    public $wpm;
    public $statID;

    

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

    public static function NumberOfTypingTestByStatId(int $id) : int|false
    {
        $statement = Database::connection()
        ->prepare("SELECT statID, COUNT(*) AS nombre_de_resultats FROM Tests WHERE statID = :id GROUP BY statID");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        // Si un résultat est trouvé, retourne le nombre de résultats
        return $result ? (int) $result['nombre_de_resultats'] : false;
    }

    public static function getHighestWpmByStatId(int $id) : int|false
    {
        $statement = Database::connection()
        ->prepare("SELECT statID, MAX(WPM) AS max_wpm FROM Tests WHERE statID = :id GROUP BY statID");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        // Si un résultat est trouvé, retourne le nombre de résultats
        return $result ? (int) $result['max_wpm'] : false;
    }

    public static function getLastScoreByStatId(int $id) : int|false
    {
        $statement = Database::connection()
        ->prepare("SELECT wpm FROM Tests WHERE statID = :id ORDER BY testID DESC LIMIT 1");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        // Si un résultat est trouvé, retourne le nombre de résultats
        return $result ? (int) $result['wpm'] : false;
    }




    public static function create($language, $duration, $wpm, $statID){
        try{
            $pdo = Database::connection();
            $stmt = $pdo->prepare("INSERT INTO Tests (language, duration, wpm, statID) VALUES (:language, :duration, :wpm, :statID)");

            // Passer les variables à bindParam
            $stmt->bindParam(':language', $language);
            $stmt->bindParam(':duration', $duration);
            $stmt->bindParam(':wpm', $wpm);
            $stmt->bindParam(':statID', $statID);

            // Exécuter la requête
            $stmt->execute();
        }catch(\Exception $e){
            throw new \Exception($e);
        }
    }

   

}
