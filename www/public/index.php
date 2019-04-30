<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.04.2019
 * Time: 20:50
 */

use App\Controllers\KesController;

define( '__ROOT_DIR__', dirname(__DIR__. '../') );
require '../vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->post('/kes/scan-file',function(){
    (new KesController)->scanFile();
});

$router->get('/kes/app-info',function(){
    (new KesController)->appInfo();
});

$router->run();