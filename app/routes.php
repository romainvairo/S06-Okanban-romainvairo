<?php

$router->map(
    'GET',
    '/',
    'oKanban\Controllers\MainController::home'
);
// endpoint API /lists
$router->map(
    'GET',
    '/lists',
    'oKanban\Controllers\ApiController::lists'
);
// endpoint API /lists/add
$router->map(
    'POST',
    '/lists/add',
    'oKanban\Controllers\ApiController::listAdd'
);
// Un endpoint /lists/[id]
$router->map(
    'GET',
    '/lists/[i:id]',
    'oKanban\Controllers\ApiController::list'
);
// Un endpoint /lists/[id]/update
$router->map(
    'POST',
    '/lists/[i:id]/update',
    'oKanban\Controllers\ApiController::listUpdate'
);
// Un endpoint /cards
$router->map(
    'GET',
    '/cards',
    'oKanban\Controllers\ApiController::cards'
);
// Un endpoint /cards/[id]/delete
$router->map(
    'POST',
    '/cards/[i:id]/delete',
    'oKanban\Controllers\ApiController::cardDelete'
);
// Une route pour nos tests sur les modèles
$router->map(
    'GET',
    '/test',
    'oKanban\Controllers\MainController::test'
);