<?php

namespace Matteomcr\TyperProject\Models;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Database;
/**
 * Classe représentant un test de dactylographie.
 * 
 * Cette classe gère les informations relatives aux tests de dactylographie effectués par les utilisateurs.
 * Elle permet de créer un nouveau test, de récupérer des statistiques telles que le nombre de tests, 
 * le WPM le plus élevé, et le dernier score pour un utilisateur spécifique.
 */
class Test
{
    /**
     * Identifiant unique du test.
     * @var int
     */
    public $testID;

    /**
     * Langue utilisée pour le test.
     * @var string
     */
    public $language;

    /**
     * Durée du test en secondes.
     * @var int
     */
    public $duration;

    /**
     * Words Per Minute (WPM) atteint lors du test.
     * @var int
     */
    public $wpm;

    /**
     * Identifiant de l'utilisateur lié à ce test.
     * @var int
     */
    public $statID;

    /**
     * Récupère le nombre de tests de dactylographie effectués par un utilisateur donné.
     * 
     * @param int $id L'identifiant de l'utilisateur (statID).
     * 
     * @return int|false Retourne le nombre de tests de dactylographie ou false en cas d'échec.
     */
    public static function NumberOfTypingTestByStatId(int $id) : int|false
    {
        $statement = Database::connection()->prepare("
            SELECT statID, COUNT(*) AS nombre_de_resultats 
            FROM Tests 
            WHERE statID = :id 
            GROUP BY statID
        ");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ? (int) $result['nombre_de_resultats'] : false;
    }

    /**
     * Récupère le WPM le plus élevé pour un utilisateur donné.
     * 
     * @param int $id L'identifiant de l'utilisateur (statID).
     * 
     * @return int|false Retourne le WPM le plus élevé ou false en cas d'échec.
     */
    public static function getHighestWpmByStatId(int $id) : int|false
    {
        $statement = Database::connection()->prepare("
            SELECT statID, MAX(WPM) AS max_wpm 
            FROM Tests 
            WHERE statID = :id 
            GROUP BY statID
        ");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ? (int) $result['max_wpm'] : false;
    }

    /**
     * Récupère le dernier score de WPM pour un utilisateur donné.
     * 
     * @param int $id L'identifiant de l'utilisateur (statID).
     * 
     * @return int|false Retourne le dernier score de WPM ou false en cas d'échec.
     */
    public static function getLastScoreByStatId(int $id) : int|false
    {
        $statement = Database::connection()->prepare("
            SELECT wpm 
            FROM Tests 
            WHERE statID = :id 
            ORDER BY testID DESC 
            LIMIT 1
        ");
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ? (int) $result['wpm'] : false;
    }

    /**
     * Crée un nouveau test de dactylographie pour un utilisateur donné.
     * 
     * @param string $language La langue utilisée pour le test.
     * @param int $duration La durée du test en secondes.
     * @param int $wpm Le score WPM (Words Per Minute) atteint lors du test.
     * @param int $statID L'identifiant de l'utilisateur associé à ce test.
     * 
     * @throws \Exception Si une erreur survient lors de l'insertion du test.
     * 
     * @return void
     */
    public static function create($language, $duration, $wpm, $statID)
    {
        try {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("
                INSERT INTO Tests (language, duration, wpm, statID) 
                VALUES (:language, :duration, :wpm, :statID)
            ");

            $stmt->bindParam(':language', $language);
            $stmt->bindParam(':duration', $duration);
            $stmt->bindParam(':wpm', $wpm);
            $stmt->bindParam(':statID', $statID);

            $stmt->execute();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}
