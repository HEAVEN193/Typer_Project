<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Matteomcr\TyperProject\Models\Utilisateur;
use Matteomcr\TyperProject\Models\Test;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

class TestController extends BaseController{

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
          // Récupérer les données envoyées dans le corps de la requête
          $body = json_decode($request->getBody(), true);
        

          $language = $body['language'] ?? null;
          $duration = $body['duration'] ?? null;
          $wpm = $body['wpm'] ?? null;
          if(Utilisateur::current())
            $statID = Utilisateur::current()->getIdStatistique();
          else
            $statID = 0;

        //   var_dump($language);

  
          // Vérification basique des données
          if (!$language || !$duration || !$wpm) {
            return $response->withStatus(400)->withJson(['error' => 'Des informations sont manquantes', "statID" => $statID]);

          }
  
          try {
              // Appel à la méthode create du modèle
              Test::create($language, $duration, $wpm, $statID);
              return $response->withStatus(201)->withJson(['message' => 'test créée avec succès']);

          } catch (\Exception $e) {
            return $response->withStatus(500)->withJson(['error' => $e->getMessage()]);

          }
    }

   

    


}