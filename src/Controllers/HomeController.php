<?php
namespace Matteomcr\TyperProject\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HomeController {
    public function showHomePage(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        return $this->view->render($response, 'home-page.php');
    }
}
