<?php
    require_once 'config.php';
    require_once 'libs/router.php';

    require_once 'app/controllers/vinoteca.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';

    $router = new Router();

    #                 endpoint        verbo     controller               método
    $router->addRoute('vinoteca',     'GET',    'VinotecaApiController', 'get'   );
    $router->addRoute('vinoteca',     'POST',   'VinotecaApiController', 'create');
    $router->addRoute('vinoteca/:ID', 'GET',    'VinotecaApiController', 'get'   );
    $router->addRoute('vinoteca/:ID', 'PUT',    'VinotecaApiController', 'update');
    $router->addRoute('vinoteca/:ID', 'DELETE', 'VinotecaApiController', 'delete');
    $router->addRoute('user/token',   'GET',    'UserApiController',     'getToken');
    
    $router->addRoute('vinoteca/:ID/:subrecurso', 'GET',    'VinotecaApiController', 'get'   );
    

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);