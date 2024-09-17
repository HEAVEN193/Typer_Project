<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AuthController {
    public function showHomePage(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'home-page.php');
    }
}