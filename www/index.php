<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => 'alumico.ru',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
    ),
));

$app->get('{url}', function ($url) use ($app) {
    
    $url = '/' . ltrim($url, '/');
    
    $page_obj = $app['db']->fetchAssoc('SELECT * FROM content WHERE url = ?', array($url));
    
    if (!$page_obj) {
        $app->abort(404, 'Страница не найдена');
    }
    
    return $app['twig']->render('article.twig.php', $page_obj);
    
})->assert('url', '.{0,}');

$app->run();