<?php

use Matteomcr\TyperProject\Controllers\HomeController;



$app->get('/', [HomeController::class, 'showHomePage']);
