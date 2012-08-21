<?php

// Controller para o dominio das VMs

$name = 'index';

$app->get('/', function () use ($app, $name) {
        return $app['twig']->render($name . '/index.twig');
    });

$app->get('/dashboard', function () use ($app, $name) {
        return $app['twig']->render($name . '/dashboard.twig');
    });

$app->get('/sobre', function () use ($app, $name) {
        return $app['twig']->render($name . '/sobre.twig');
    });