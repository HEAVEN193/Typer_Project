<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AuthController {
    public function showForm(Request $request, Response $response): Response
    {
        $response->getBody()->write('<p>Ajouter un produit</p>');
        return $response;
    }
}