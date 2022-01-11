<?php

use Slim\App;
use Respect\Validation\Validator as v;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container['db'] = function ($c){
        $settings = $c->get('settings')['db'];
        $server = $settings['driver'].":host=".$settings['host'].";dbname=".$settings['dbname'];
        $conn = new PDO($server, $settings["user"], $settings["pass"]);  
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    };

    $container['LoanController'] = function ($c) {
        require __DIR__. '/../Tests/Controllers/LoanController.php';

        return new Tests\Controllers\LoanControllers;
    };

    $container['validator'] = function ($c) {
        require __DIR__. '../Http/Validator.php';

        return new Src\Http\Validator;
    };

    
};
